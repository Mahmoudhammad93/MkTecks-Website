<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $categories = Category::get();
        // foreach($categories as $category){
        //     Category::where('id',$category->id)->update([
        //         'slug'=>$this->generateSlug(Str::slug($category->name_en))
        //     ]);
        // }

        return view('admin.categories.index', [
            'title' => trans('admin.All Categories'),
            'categories' => Category::withCount('products')->with('image')->orderBy('order', 'asc')->paginate(50)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create', [
            'title' => trans('admin.Add New Category'),
            'categories' => Category::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar'          => 'required',
            'name_en'          => 'required',
        ], [], [
            'name_ar'          => trans('admin.Name Ar'),
            'name_en'          => trans('admin.Name En'),
        ]);

        $category = new Category();
        $category->name_ar = $request->name_ar;
        $category->name_en = $request->name_en;
        $category->status = $request->status;
        $category->order = $request->order;
        $category->slug = $this->generateSlug(Str::slug($request->name_en));
        $category->save();

        if ($request->hasFile('image')) {
            ini_set('memory_limit', '-1');
            $file = $request->file('image');
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            $image_path = date("Y-m-d") . '/';
            File::makeDirectory(public_path('storage/categories/' . $image_path), $mode = 0777, true, true);
            Image::make($file)
                ->resize(450, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('storage/categories/' . $image_path) . $image_imageName, 80);
            $image = new Media();
            $image->filename = $image_imageName;
            $image->mime = $file->getClientMimeType();
            $image->type = 'image';
            $image->mediaable_id = $category->id;
            $image->mediaable_type = 'App\Models\Category';
            $image->url = url('') . '/storage/categories/' . $image_path . $image_imageName;
            $image->save();
        }

        userLogs([
            'model' => 'App\Models\Category',
            'model_id' => $category->id,
            'description_ar' => 'اضافة قسم جديد',
            'description_en' => 'Add New Category',
            'status' => 'create'
        ]);

        return redirect(aurl('categories'))->with('success', 'operation success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::where('id', $id)->with('image')->first();
        return view('admin.categories.edit', [
            'title' => $category->name,
            'category' => $category,
            'categories' => Category::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar'          => 'required',
            'name_en'          => 'required',
        ], [], [
            'name_ar'          => trans('admin.Name Ar'),
            'name_en'          => trans('admin.Name En'),
        ]);

        $category = Category::where('id', $id)->with('image')->first();
        $category->name_ar = $request->name_ar;
        $category->name_en = $request->name_en;
        $category->status = $request->status;
        $category->order = $request->order;
        $category->slug = $this->generateSlug(Str::slug($request->name_en));
        $category->save();

        if ($request->hasFile('image')) {
            if ($category->image()->exists()) {
                $data = Media::where('id', $category->image->id)->first();
                if ($data) {
                    File::delete(public_path(str_replace(url(""), "", $data->url)));
                    $data->delete();
                }
            }
            ini_set('memory_limit', '-1');
            $file = $request->file('image');
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            $image_path = date("Y-m-d") . '/';
            File::makeDirectory(public_path('storage/categories/' . $image_path), $mode = 0777, true, true);
            Image::make($file)
                ->resize(450, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('storage/categories/' . $image_path) . $image_imageName, 80);
            $image = new Media();
            $image->filename = $image_imageName;
            $image->mime = $file->getClientMimeType();
            $image->type = 'image';
            $image->mediaable_id = $category->id;
            $image->mediaable_type = 'App\Models\Category';
            $image->url = url('') . '/storage/categories/' . $image_path . $image_imageName;
            $image->save();
        }

        userLogs([
            'model' => 'App\Models\Category',
            'model_id' => $category->id,
            'description_ar' => 'تعديل بيانات القسم',
            'description_en' => 'Edit Category',
            'status' => 'update'
        ]);
        return redirect(aurl('categories'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category = Category::find($request->category_id);
        if ($category) {
            $category->delete();
            Product::where('category_id', $request->category_id)->delete();
        }
        userLogs([
            'model' => '\App\Models\Category',
            'model_id' => $request->category_id,
            'description_ar' => 'مسح القسم',
            'description_en' => 'Delete Category',
            'status' => 'delete'
        ]);
        return back()->with('success', 'operation success');
    }

    public function generateSlug($slug)
    {
        $data = Category::where('slug', $slug)->first();
        if ($data) {
            return $slug . "." . $data->id;
        } else {
            return $slug;
        }
    }
}

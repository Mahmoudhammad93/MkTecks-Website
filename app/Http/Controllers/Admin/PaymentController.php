<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.payments.index', [
            'title' => trans('admin.All Payments'),
            'payments' => PaymentMethod::with('icon')->select([
                'id',
                'name_'.app()->getLocale().' as name',
                'token',
                'method_number',
                'status',
                'created_at'
            ])->paginate(30)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payments.form', [
            'title' => trans('admin.Create Payment')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'icon' => 'required',
            'status' => 'required'
        ]);

        $row = new PaymentMethod();
        $row->name_ar = $request->name_ar;
        $row->name_en = $request->name_en;
        $row->method_number = $request->method_number;
        $row->token = $request->token;
        $row->status = $request->status;
        $row->save();

        if($request->hasFile('icon')){
            ini_set('memory_limit', '-1');
            $file = $request->file('icon');
            $image_path = date("Y-m-d") . '/';
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            File::makeDirectory(public_path('storage/payments/' . $image_path), $mode = 0777, true, true);
            Image::make($file)
                ->resize(650, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('storage/payments/' . $image_path) . $image_imageName, 90);
            $image = new Media();
            $image->filename = $image_imageName;
            $image->mime = $file->getClientMimeType();
            $image->mediaable_id = $row->id;
            $image->mediaable_type = 'App\Models\PaymentMethod';
            $image->url = url('') . '/storage/payments/' . $image_path . $image_imageName;
            $image->save();
        }

        return redirect(aurl('payments'))->with('success', 'operation success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.payments.form', [
            'title' => trans('admin.Edit'),
            'payment' => PaymentMethod::with('icon')->find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $row = PaymentMethod::find($id);
        $row->name_ar = $request->name_ar;
        $row->name_en = $request->name_en;
        $row->method_number = $request->method_number;
        $row->token = $request->token;
        $row->status = $request->status;
        $row->save();

        if($request->hasFile('icon')){
            ini_set('memory_limit', '-1');
            $file = $request->file('icon');
            $image_path = date("Y-m-d") . '/';
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            File::makeDirectory(public_path('storage/payments/' . $image_path), $mode = 0777, true, true);
            Image::make($file)
                ->resize(650, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('storage/payments/' . $image_path) . $image_imageName, 90);
            $image = Media::where('mediaable_id', $row->id)->first();
            $image->filename = $image_imageName;
            $image->mime = $file->getClientMimeType();
            $image->mediaable_id = $row->id;
            $image->mediaable_type = 'App\Models\PaymentMethod';
            $image->url = url('') . '/storage/payments/' . $image_path . $image_imageName;
            $image->save();
        }

        return redirect(aurl('payments'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = PaymentMethod::find($id);
        if ($payment) {
            $payment->delete();
        }
        userLogs([
            'model' => '\App\Models\Product',
            'model_id' => $id,
            'description_ar' => 'حذف المنتج',
            'description_en' => 'Delete Product',
            'status' => 'delete'
        ]);
        return back()->with('success', 'operation success');
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Project;
use App\Models\Service;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('image')->whereStatus(1)->orderBy('order', 'asc')->get();
        $team = Team::with('avatar')->whereStatus(1)->get();
        return view('welcome', [
            'services' => $services,
            'team' => $team
        ]);
    }

    public function projects(){
        return view('projects', [
            'title' => trans('admin.Projects'),
            'projects' => Project::with('image')->whereStatus(1)->orderBy('order', 'asc')->get()
        ]);
    }

    public function contact_us(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if($validation->fails()){
            return response()->json([
                'status' => 'Fail',
                'data' => $validation->messages()
            ]);
        }

        $message = ContactUs::create($request->all());

        $msg = trans('admin.Message Sent Success');

        return response()->json($msg);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

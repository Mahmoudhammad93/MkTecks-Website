<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Contacts;
use App\Models\ContactUs;
use App\Models\ContactUsReplay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contact_us.index', [
            'title' => trans('admin.Contact Us'),
            'messages' => ContactUs::latest()->paginate(30)
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
            'message'    => 'required|min:10',
            'title'      => 'required|min:6',
        ], [], [
            'message'    => trans('admin.Message'),
            'title'      => trans('admin.Title'),
        ]);

        $replay = new ContactUsReplay();
        $replay->contact_id = $request->contact_id;
        $replay->user_id =  Auth::user()->id;
        $replay->title = $request->title;
        $replay->message = $request->message;
        $replay->save();

        $data = ContactUsReplay::where('id',$replay->id)->with('contact')->first();

        Mail::to($data->contact->email)->send(new Contacts($data));
        return back()->with('success', 'Message Sent Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        ContactUs::where('id', $id)->update(['seen' => '1']);
        $message = ContactUs::where('id',$id)->first();
        return view('admin.contact_us.view', [
            'title' => $message->name,
            'message' => $message
        ]);
    }
}

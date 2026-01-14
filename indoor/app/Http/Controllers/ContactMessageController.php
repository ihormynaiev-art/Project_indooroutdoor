<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Jobs\SendAdminContactMessages;
use App\Mail\ContactMessageReply;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(ContactMessage::query())
                ->editColumn('created_at', function ($message) {
                    return $message->created_at->format('m/d/Y');
                })
                ->order(function ($query) {
                    $query->orderBy('created_at', 'desc');
                })
                ->make();
        }

        return view('admin.contactMessages.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactMessageRequest $request)
    {
        $contactMessage = ContactMessage::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'message' => $request->input('message'),
        ]);

        if ($contactMessage) {
            SendAdminContactMessages::dispatch(
                $contactMessage->message,
                $contactMessage->name,
                $contactMessage->email,
            );

            return back()->with('status', 'Message sent');
        }

        return back()->with('status', 'Message not sent');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return response()->json(['status' => 'success']);
    }

    public function reply(Request $request)
    {
        Mail::to($request->input('email'))->queue(new ContactMessageReply(
            $request->input('text')
        ));

        return response()->json(['status' => 'success']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class SmsMessageController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return DataTables::of(
                SmsMessage::query()
                    ->with('smsTemplate')
                    ->latest('id')
            )->editColumn('sent_at', function ($message) {
                return $message->sent_at?->format('d M Y');
            })->make();
        }

        return view('admin.sms-messages.index');
    }

    public function show(SmsMessage $smsMessage): View
    {
        $smsMessage->load('smsTemplate', 'providerDetail');

        return view('admin.sms-messages.show', compact('smsMessage'));
    }
}

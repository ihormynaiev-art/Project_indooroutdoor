<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SmsTemplate\UpdateSmsTemplateRequest;
use App\Models\SmsTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class SmsTemplateController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return DataTables::of(SmsTemplate::query())->make();
        }

        return view('admin.sms-templates.index');
    }

    public function edit(SmsTemplate $smsTemplate): View
    {
        return view('admin.sms-templates.edit', compact('smsTemplate'));
    }

    public function update(SmsTemplate $smsTemplate, UpdateSmsTemplateRequest $request)
    {
        $smsTemplate->update($request->validated());

        return to_route('admin.sms-templates.edit', ['sms_template' => $smsTemplate])
            ->with('status', "Sms template '{$smsTemplate->label}' has been updated successfully.");
    }
}

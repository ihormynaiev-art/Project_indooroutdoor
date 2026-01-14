<?php

namespace App\Http\Controllers;

use App\Enums\Sms\SmsTemplateEnum;
use App\Http\Requests\ProviderMessage\StoreMessageRequest;
use App\Http\Requests\ProviderMessage\UpdateMessageRequest;
use App\Jobs\SendSmsJob;
use App\Mail\ProviderMessageMail;
use App\Models\ProviderDetail;
use App\Models\ProviderMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $providerDetail = $request->user()->providerDetail;

        if ($request->ajax()) {
            return DataTables::of(
                ProviderMessage::query()
                    ->where('provider_detail_id', $providerDetail->id)
                    ->latest()
            )->editColumn('created_at', function ($message) {
                return $message->created_at->format('d M Y');
            })->make();
        }

        return view('provider.messages.index', ['providerDetail' => $providerDetail]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request): JsonResponse
    {
        /** @var ProviderMessage $message */
        $message = ProviderMessage::query()
            ->create([
                'provider_detail_id' => $request->input('provider_id'),
                'contact' => $request->input('contact'),
                'message' => $request->input('message'),
                'user_id' => $request->input('user_id'),
            ]);

        $files = $request->file('documents');

        if ($files && $message) {
            foreach ($files as $file) {
                $filePath = $file->store('message_images', 'public');
                $message->images()->create([
                    'name' => $file->getClientOriginalName(),
                    'path' => $filePath,
                ]);
            }
        }

        Mail::to($message->providerDetail->user->email)
            ->queue(new ProviderMessageMail($message));

        if ($request->input('provider_id')) {
            /** @var ProviderDetail $provider */
            $provider = ProviderDetail::query()->find($request->input('provider_id'));
            if ($provider?->isSmsEnabled()) {
                dispatch(new SendSmsJob(
                    phone: $provider->phone,
                    templateKey: SmsTemplateEnum::NEW_MESSAGE->value,
                    providerId: $request->input('provider_id')
                ));
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function show(ProviderMessage $providerMessage, Request $request)
    {
        if ($request->user()->cannot('view', $providerMessage)) {
            abort(403);
        }

        $providerMessage->load('images', 'user');

        if (! $providerMessage->is_read) {
            $providerMessage->update(['is_read' => true]);
        }

        return view('provider.messages.show', compact('providerMessage'));
    }

    public function update(ProviderMessage $providerMessage, UpdateMessageRequest $request)
    {
        if ($request->user()->cannot('view', $providerMessage)) {
            abort(403);
        }

        if ($request->comment) {
            $providerMessage->update($request->validated());
        }

        return to_route('provider.provider-messages.show', ['provider_message' => $providerMessage])
            ->with('status', 'Message updated successfully.');
    }
}

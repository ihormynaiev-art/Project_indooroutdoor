<?php

namespace App\Http\Controllers;

use App\Enums\License\LicenseStatusEnum;
use App\Jobs\FetchFacebookReviewsByProvider;
use App\Jobs\FetchGoogleReviewsByProvider;
use App\Mail\NewCertificateUploaded;
use App\Models\File;
use App\Models\ProviderDetail;
use App\Models\User;
use App\Services\CategoryLicenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProviderController extends Controller
{
    public function verification(Request $request, CategoryLicenseService $service)
    {
        $providerDetail = $request->user()->providerDetail;

        $categories = $service->getByProvider($providerDetail);

        return view('provider.verification', [
            'files' => $request->user()->providerDetail?->certificates,
            'user' => $request->user(),
            'categories' => $categories,
        ]);
    }

    public function fileUpload(Request $request, User $user)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,jpeg,png,jpg'],
        ]);

        $file = $request->file('file');
        $fileName = $request->input('name') ?? $file->getClientOriginalName();

        $filePath = $file->store('certificates', 'public');
        $fileModel = $user->providerDetail->certificates()->create([
            'name' => $fileName,
            'path' => $filePath,
            'type' => 'certificate',
            'status' => LicenseStatusEnum::IN_REVIEW->value,
        ]);

        $adminRoles = ['admin', 'super admin'];
        $adminUsers = User::role($adminRoles)->get();

        foreach ($adminUsers as $admin) {
            Mail::to($admin->email)->queue(new NewCertificateUploaded($user, $fileModel));
        }

        return response()->json([
            'status' => 'success',
            'name' => $fileName,
            'url' => url('storage/'.$filePath),
            'id' => $fileModel->id,
            'type' => 'certificate',
        ]);
    }

    public function updateDocumentType(Request $request, File $file)
    {
        $request->validate([
            'document_type' => ['required', 'in:certificate,insurance'],
        ]);

        if ($file->fileable_type !== 'App\\Models\\ProviderDetail' ||
            $file->fileable->user_id !== auth()->id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $file->type = $request->input('document_type');
        $file->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Document type updated successfully',
        ]);
    }

    public function syncGoogleReviews(ProviderDetail $providerDetail)
    {
        $providerDetail->google_last_request_at = now();
        $providerDetail->save();

        FetchGoogleReviewsByProvider::dispatch($providerDetail);

        return to_route('provider.reviews.settings.edit', compact('providerDetail'))
            ->with('status', 'Google reviews synchronized');
    }

    public function syncFacebookReviews(ProviderDetail $providerDetail)
    {
        $providerDetail->facebook_last_request_at = now();
        $providerDetail->save();

        FetchFacebookReviewsByProvider::dispatch($providerDetail);

        return to_route('provider.reviews.settings.edit', compact('providerDetail'))
            ->with('status', 'Facebook reviews synchronized');
    }

    public function updateIsSmsEnabled(Request $request, string $id)
    {
        /** @var ProviderDetail $provider */
        $provider = ProviderDetail::query()->find($id);

        $provider->is_sms_enabled = filter_var($request->input('is_sms_enabled'), FILTER_VALIDATE_BOOLEAN);

        if ($provider->save()) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}

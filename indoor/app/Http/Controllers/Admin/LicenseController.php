<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Licenses\UpdateLicenseRequest;
use App\Models\File;
use App\Models\ProviderDetail;
use App\Models\User;
use App\Services\CategoryLicenseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class LicenseController extends Controller
{
    public function index(Request $request)
    {
        $lastFileSub = File::query()
            ->select('files.created_at')
            ->whereColumn('fileable_id', 'provider_details.id')
            ->where('fileable_type', ProviderDetail::class)
            ->whereIn('type', ['certificate', 'insurance'])
            ->orderByDesc('created_at')
            ->limit(1);

        $lastStatusSub = File::query()
            ->select('files.status')
            ->whereColumn('fileable_id', 'provider_details.id')
            ->where('fileable_type', ProviderDetail::class)
            ->whereIn('type', ['certificate', 'insurance'])
            ->orderByDesc('created_at')
            ->limit(1);

        if ($request->ajax()) {
            return DataTables::of(
                User::query()
                    ->role('provider')
                    ->with('providerDetail')
                    ->leftJoin('provider_details', 'provider_details.user_id', '=', 'users.id')
                    ->select('users.*')
                    ->selectSub($lastFileSub, 'last_cert')
                    ->selectSub($lastStatusSub, 'last_cert_status')
                    ->orderByDesc('last_cert')
            )->editColumn('last_cert', function ($message) {
                return $message->last_cert
                    ? Carbon::create($message->last_cert)->format('m/d/Y')
                    : '-';
            })->make();
        }

        return view('admin.licenses.index');
    }

    public function edit(string $id, CategoryLicenseService $service): View
    {
        /** @var User $user */
        $user = User::query()->with('providerDetail')->find($id);
        $providerDetail = $user->providerDetail;

        $categories = $service->getByProvider($providerDetail);

        return view('admin.licenses.edit', [
            'files' => $providerDetail?->certificates->sortByDesc('created_at'),
            'providerDetail' => $providerDetail,
            'user' => $user,
            'categories' => $categories,
        ]);
    }

    public function update(UpdateLicenseRequest $request)
    {
        if ($request->file_id) {
            File::query()->where('id', $request->file_id)->update([
                'status' => $request->status,
            ]);
        }

        foreach ($request->licenses ?? [] as $value) {
            $verifiedAt = $value['license_verified_at'] ? new Carbon($value['license_verified_at']) : null;
            $expiredAt = $value['license_expires_on'] ? new Carbon($value['license_expires_on']) : null;

            DB::table('provider_detail_sub_category')
                ->where('id', $value['id'])
                ->update([
                    'license_verified_at' => $verifiedAt,
                    'license_expires_on' => $expiredAt,
                ]);
        }

        return back()
            ->with('status', 'Licenses has been updated successfully.');
    }
}

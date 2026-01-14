<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Sms\SmsTemplateEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contractor\UpdateContractorRequest;
use App\Jobs\OptimizeImageJob;
use App\Jobs\ProviderActivated;
use App\Jobs\ProviderInactivated;
use App\Jobs\SendSmsJob;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class ContractorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(
                User::query()
                    ->with(['roles', 'providerDetail.plan'])
                    ->role('provider')
                    ->orderBy('created_at', 'desc')
            )->editColumn('created_at', function ($message) {
                return $message->created_at?->format('m/d/Y');
            })->make();
        }
        $roles = Role::all()->pluck('name');

        return view('admin.contractors.index', ['roles' => $roles]);
    }

    public function edit(string $id)
    {
        /** @var User $user */
        $user = User::query()
            ->with('providerDetail')
            ->find($id);

        $imagesIdsJson = $user->providerDetail->adImages()->pluck('id')->toJson();

        return view('admin.contractors.edit', compact(['user', 'imagesIdsJson']));
    }

    public function update(string $id, UpdateContractorRequest $request)
    {
        /** @var User $user */
        $user = User::query()
            ->with('providerDetail.adImages')
            ->find($id);

        $imagesIds = json_decode($request->input('images')) ?? [];

        $user->providerDetail->adImages()->whereNotIn('id', $imagesIds)->delete();

        $uploadedFiles = $request->file('files') ?? [];

        if ($request->input('order')) {
            $prio = explode(',', $request->input('order'));
            $fileIndex = 0;

            foreach ($prio as $index => $id) {
                if (strpos($id, 'new-') === false) {
                    $image = $user->providerDetail->adImages->find($id);
                    if ($image) {
                        $image->prio = $index;
                        $image->save();
                    }
                } else {
                    if (isset($uploadedFiles[$fileIndex])) {
                        $newImageFile = $uploadedFiles[$fileIndex];
                        $filePath = $newImageFile->store('ad/' . $user->id, 'public');
                        $user->providerDetail->adImages()->create([
                            'name' => $newImageFile->getClientOriginalName(),
                            'path' => $filePath,
                            'type' => 'ad',
                            'prio' => $index,
                        ]);
                        $fileIndex++;
                    }
                }
            }
        } else {
            $maxPrio = $user->providerDetail->adImages()->max('prio') ?? -1;

            foreach ($uploadedFiles as $index => $file) {
                $filePath = $file->store('ad/' . $user->id, 'public');
                $user->providerDetail->adImages()->create([
                    'name' => $file->getClientOriginalName(),
                    'path' => $filePath,
                    'type' => 'ad',
                    'prio' => $maxPrio + $index + 1,
                ]);
            }
        }

        if (count($uploadedFiles) > 0 || $request->input('order')) {
            OptimizeImageJob::dispatch($user->providerDetail);
        }

        return to_route('admin.contractors.edit', ['contractor' => $user->id])
            ->with('status', 'Advertisement photos have been updated successfully.');
    }

    public function updateIsVerified(Request $request, string $id)
    {
        /** @var User $user */
        $user = User::query()
            ->with('providerDetail')
            ->find($id);

        $user->is_verified = filter_var($request->input('is_verified'), FILTER_VALIDATE_BOOLEAN);

        if ($user->save()) {
            if ($user->is_verified) {
                ProviderActivated::dispatch($user);

                if ($user->providerDetail?->isSmsEnabled()) {
                    dispatch(new SendSmsJob(
                        phone: $user->providerDetail->phone,
                        templateKey: SmsTemplateEnum::PROFILE_PUBLISHED->value,
                        providerId: $user->providerDetail->id
                    ));
                }
            } else {
                ProviderInactivated::dispatch($user);

                if ($user->providerDetail?->isSmsEnabled()) {
                    dispatch(new SendSmsJob(
                        phone: $user->providerDetail->phone,
                        templateKey: SmsTemplateEnum::PROFILE_INACTIVE->value,
                        providerId: $user->providerDetail->id
                    ));
                }
            }

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }

    public function changeRole(Request $request, User $user)
    {
        $user->syncRoles($request->input('role'));

        if ($request->input('role') == 'provider') {
            $user->providerDetail()->createOrFirst();
        }

        return response()->json(['status' => 'success']);
    }

    public function destroy(int $id)
    {
        $user = User::query()->findOrFail($id);

        $user->delete();

        return response()->json(['status' => 'success']);
    }
}

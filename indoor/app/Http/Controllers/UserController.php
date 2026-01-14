<?php

namespace App\Http\Controllers;

use App\Enums\Sms\SmsTemplateEnum;
use App\Jobs\ProviderActivated;
use App\Jobs\ProviderInactivated;
use App\Jobs\SendSmsJob;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(User::query()->with(['roles', 'providerDetail.plan'])->orderBy('is_verified'))->make();
        }
        $roles = Role::all()->pluck('name');

        return view('admin.users.index', ['roles' => $roles]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', [
            'user' => $user,
            'files' => $user->providerDetail?->certificates,
        ]);
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

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['status' => 'success']);
    }
}

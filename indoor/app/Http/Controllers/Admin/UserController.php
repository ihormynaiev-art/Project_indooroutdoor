<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            return DataTables::of(
                User::query()
                    ->with(['roles', 'providerDetail.plan'])
                    ->role(['admin', 'super admin'])
                    ->orderBy('is_verified')
            )->make();
        }
        $roles = Role::all()->pluck('name');

        return view('admin.admins.index', ['roles' => $roles]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = User::query()->role(['admin', 'super admin'])->findOrFail($id);

        return view('admin.admins.show', compact('user'));
    }

    public function updateIsVerified(Request $request, string $id)
    {
        /** @var User $user */
        $user = User::query()
            ->with('providerDetail')
            ->find($id);

        $user->is_verified = filter_var($request->input('is_verified'), FILTER_VALIDATE_BOOLEAN);

        if ($user->save()) {
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

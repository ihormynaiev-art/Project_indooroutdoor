<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Homeowners\UpdateHomeownerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class HomeownerController extends Controller
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
                    ->doesntHave('roles')
                    ->orderBy('created_at', 'desc')
            )->editColumn('created_at', function ($message) {
                return $message->created_at?->format('m/d/Y');
            })->make();
        }
        $roles = Role::all()->pluck('name');

        return view('admin.homeowners.index', ['roles' => $roles]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = User::query()->findOrFail($id);

        return view('admin.homeowners.show', compact('user'));
    }

    public function edit(int $id)
    {
        $user = User::query()->findOrFail($id);

        return view('admin.homeowners.edit', compact('user'));
    }

    public function update(int $id, UpdateHomeownerRequest $request)
    {
        $user = User::query()->findOrFail($id);

        $user->update($request->validated());

        return to_route('admin.homeowners.edit', $user)
            ->with('status', 'Homeowner updated successfully.');
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

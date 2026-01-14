<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InviteCode\StoreInviteCodeRequest;
use App\Models\InviteCode;
use App\Models\Plan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InviteCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(
                InviteCode::query()
                    ->with(['plan', 'usedByProvider.user', 'createdByUser'])
                    ->orderBy('created_at', 'desc')
            )
                ->editColumn('created_at', function ($inviteCode) {
                    return $inviteCode->created_at?->format('m/d/Y');
                })
                ->editColumn('expires_at', function ($inviteCode) {
                    return $inviteCode->expires_at?->format('m/d/Y') ?? 'Never';
                })
                ->editColumn('used_at', function ($inviteCode) {
                    return $inviteCode->used_at?->format('m/d/Y') ?? '-';
                })
                ->addColumn('status', function ($inviteCode) {
                    if ($inviteCode->is_used) {
                        return '<span class="badge bg-secondary">Used</span>';
                    }
                    if ($inviteCode->expires_at && $inviteCode->expires_at->isPast()) {
                        return '<span class="badge bg-danger">Expired</span>';
                    }

                    return '<span class="badge bg-success">Active</span>';
                })
                ->rawColumns(['status'])
                ->make();
        }

        $plans = Plan::query()->active()->get();

        return view('admin.invite-codes.index', ['plans' => $plans]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInviteCodeRequest $request)
    {
        $expiresAt = $request->input('expires_at');

        // Convert date from m/d/Y format to Y-m-d format for database
        if ($expiresAt) {
            $expiresAt = \Carbon\Carbon::createFromFormat('m/d/Y', $expiresAt)->format('Y-m-d');
        }

        $inviteCode = InviteCode::create([
            'code' => strtoupper($request->input('code')),
            'plan_id' => $request->input('plan_id'),
            'expires_at' => $expiresAt,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Invite code created successfully.',
            'code' => $inviteCode->code,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InviteCode $inviteCode)
    {
        $inviteCode->delete();

        return response()->json(['status' => 'success']);
    }
}

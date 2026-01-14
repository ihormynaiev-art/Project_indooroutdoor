<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\SendNewRegisteredContractorMail;
use App\Models\InviteCode;
use App\Models\Plan;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $inviteCode = null;
        $isVerified = false;
        $planId = null;

        if ($request->filled('code')) {
            /** @var InviteCode $inviteCode */
            $inviteCode = InviteCode::query()
                ->where('code', $request->input('code'))
                ->valid()
                ->first();

            if ($inviteCode) {
                $planId = $inviteCode->plan_id;

                /** @var Plan $plan */
                $plan = Plan::query()->findOrFail($planId);

                if($plan->getAdminSetting('auto_publish')) {
                    $isVerified = true;
                }
            }
        }

        if (! $planId && $request->input('is_provider')) {
            $litePlan = Plan::query()
                ->where('name', 'lite')
                ->first();
            $planId = $litePlan?->id;
        }

        $user = User::query()
            ->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_verified' => $isVerified,
            ]);

        if ($request->input('is_provider')) {
            $user->assignRole('provider');
            $providerDetails = $user->providerDetail()->create([
                'business_name' => $request->input('business_name'),
                'plan_id' => $planId,
            ]);

            if ($inviteCode) {
                $inviteCode->markAsUsed($providerDetails);
            }

            $files = $request->file('files');
            if ($files) {
                foreach ($files as $file) {
                    $filePath = $file->store('certificates', 'public');
                    $providerDetails->certificates()->create([
                        'name' => $file->getClientOriginalName(),
                        'path' => $filePath,
                        'type' => 'certificate',
                    ]);
                }
            }
            SendNewRegisteredContractorMail::dispatch($user);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::getExplanationPage());
    }
}

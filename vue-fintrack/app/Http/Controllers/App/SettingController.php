<?php

namespace App\Http\Controllers\App;

use App\Enums\Currency;
use App\Helpers\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\TwoFactorAuthenticationRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Features;

class SettingController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function profileEdit(Request $request)
    {
        return inertia('app/settings/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function profileUpdate(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
        ];

        if ($request->hasFile('avatar')) {
            $oldAvatarPath = $user->getRawOriginal('avatar');
            if ($oldAvatarPath && ! str_starts_with($oldAvatarPath, 'http')) {
                Storage::public()->delete($oldAvatarPath);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->back()->with('success', 'app.settings.profile.updated successfully.');
    }

    /**
     * Delete the user's profile.
     */
    public function profileDestroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show the user's preferences settings page.
     */
    public function preferencesEdit()
    {
        return inertia('app/settings/Preferences');
    }

    /**
     * Update the user's preferences information.
     */
    public function preferencesUpdate(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'currency' => ['required', 'string', Rule::in(Currency::values())],
            'push_notifications' => ['required', 'boolean'],
            'email_notifications' => ['required', 'boolean'],
            'budget_alerts' => ['required', 'boolean'],
            'weekly_reports' => ['required', 'boolean'],
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Preferences updated successfully.');
    }

    /**
     * Show the user's password settings page.
     */
    public function passwordEdit()
    {
        return inertia('app/settings/Password');
    }

    /**
     * Update the user's password.
     */
    public function passwordUpdate(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back();
    }

    /**
     * Show the user's two-factor authentication settings page.
     */
    public function twoFactorShow(TwoFactorAuthenticationRequest $request)
    {
        $request->ensureStateIsValid();

        return inertia('app/settings/TwoFactor', [
            'twoFactorEnabled' => $request->user()->hasEnabledTwoFactorAuthentication(),
            'requiresConfirmation' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
        ]);
    }

    /**
     * Show the appearance settings page.
     */
    public function appearanceShow()
    {
        return inertia('app/settings/Appearance');
    }
}

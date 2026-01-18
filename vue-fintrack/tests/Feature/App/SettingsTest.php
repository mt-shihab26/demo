<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Fortify\Features;

describe('Settings Profile', function () {
    it('displays profile page', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('app.settings.profile.edit'));

        $response->assertOk();
    });

    it('updates profile information successfully', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('app.settings.profile.edit'))
            ->patch(route('app.settings.profile.update'), [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('app.settings.profile.edit'));

        $user->refresh();

        expect($user->name)->toBe('Test User');
        expect($user->email)->toBe('test@example.com');
        expect($user->email_verified_at)->toBeNull();
    });

    it('preserves email verification when email unchanged', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('app.settings.profile.edit'))
            ->patch(route('app.settings.profile.update'), [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('app.settings.profile.edit'));

        expect($user->refresh()->email_verified_at)->not->toBeNull();
    });

    it('deletes account successfully', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('app.settings.profile.destroy'), [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('home'));

        $this->assertGuest();
        expect($user->fresh())->toBeNull();
    });

    it('requires correct password to delete account', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('app.settings.profile.edit'))
            ->delete(route('app.settings.profile.destroy'), [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect(route('app.settings.profile.edit'));

        expect($user->fresh())->not->toBeNull();
    });
});

describe('Settings Preferences', function () {
    it('displays preferences page', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('app.settings.preferences.edit'));

        $response->assertOk();
    });

    it('updates user preferences successfully', function () {
        $user = User::factory()->create([
            'currency' => 'USD',
            'email_notifications' => false,
            'push_notifications' => false,
            'budget_alerts' => false,
            'weekly_reports' => false,
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(route('app.settings.preferences.update'), [
                'currency' => 'BDT',
                'email_notifications' => true,
                'push_notifications' => true,
                'budget_alerts' => true,
                'weekly_reports' => true,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $user->refresh();

        expect($user->currency->value)->toBe('BDT');
        expect($user->email_notifications)->toBeTrue();
        expect($user->push_notifications)->toBeTrue();
        expect($user->budget_alerts)->toBeTrue();
        expect($user->weekly_reports)->toBeTrue();
    });

    it('validates currency field', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch(route('app.settings.preferences.update'), [
                'currency' => 'INVALID',
                'email_notifications' => true,
                'push_notifications' => true,
                'budget_alerts' => true,
                'weekly_reports' => true,
            ]);

        $response->assertSessionHasErrors('currency');
    });

    it('requires authentication for viewing preferences', function () {
        $response = $this
            ->get(route('app.settings.preferences.edit'));

        $response->assertRedirect(route('login'));
    });

    it('requires authentication for updating preferences', function () {
        $response = $this
            ->patch(route('app.settings.preferences.update'), [
                'currency' => 'USD',
                'email_notifications' => true,
            ]);

        $response->assertRedirect(route('login'));
    });

    it('can set boolean preferences to false', function () {
        $user = User::factory()->create([
            'email_notifications' => true,
            'push_notifications' => true,
            'budget_alerts' => true,
            'weekly_reports' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(route('app.settings.preferences.update'), [
                'currency' => 'USD',
                'email_notifications' => false,
                'push_notifications' => false,
                'budget_alerts' => false,
                'weekly_reports' => false,
            ]);

        $response->assertSessionHasNoErrors();

        $user->refresh();

        expect($user->email_notifications)->toBeFalse();
        expect($user->push_notifications)->toBeFalse();
        expect($user->budget_alerts)->toBeFalse();
        expect($user->weekly_reports)->toBeFalse();
    });
});

describe('Settings Password', function () {
    it('displays password update page', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('app.settings.password.edit'));

        $response->assertStatus(200);
    });

    it('updates password successfully', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('app.settings.password.edit'))
            ->put(route('app.settings.password.update'), [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('app.settings.password.edit'));

        expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
    });

    it('requires correct current password', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('app.settings.password.edit'))
            ->put(route('app.settings.password.update'), [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasErrors('current_password')
            ->assertRedirect(route('app.settings.password.edit'));
    });
});

describe('Settings Two Factor Authentication', function () {
    it('displays two factor settings page when enabled', function () {
        if (! Features::canManageTwoFactorAuthentication()) {
            $this->markTestSkipped('Two-factor authentication is not enabled.');
        }

        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
        ]);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->withSession(['auth.password_confirmed_at' => time()])
            ->get(route('app.settings.two-factor.show'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('app/settings/TwoFactor')
                ->where('twoFactorEnabled', false)
            );
    });

    it('requires password confirmation when enabled', function () {
        if (! Features::canManageTwoFactorAuthentication()) {
            $this->markTestSkipped('Two-factor authentication is not enabled.');
        }

        $user = User::factory()->create();

        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
        ]);

        $response = $this->actingAs($user)
            ->get(route('app.settings.two-factor.show'));

        $response->assertRedirect(route('password.confirm'));
    });

    it('does not require password confirmation when disabled', function () {
        if (! Features::canManageTwoFactorAuthentication()) {
            $this->markTestSkipped('Two-factor authentication is not enabled.');
        }

        $user = User::factory()->create();

        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => false,
        ]);

        $this->actingAs($user)
            ->get(route('app.settings.two-factor.show'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('app/settings/TwoFactor')
            );
    });

    it('returns forbidden when two factor is disabled', function () {
        if (! Features::canManageTwoFactorAuthentication()) {
            $this->markTestSkipped('Two-factor authentication is not enabled.');
        }

        config(['fortify.features' => []]);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->withSession(['auth.password_confirmed_at' => time()])
            ->get(route('app.settings.two-factor.show'))
            ->assertForbidden();
    });
});

describe('Settings Appearance', function () {
    it('displays appearance page', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('app.settings.appearance.edit'));

        $response->assertOk();
    });

    it('requires authentication', function () {
        $response = $this
            ->get(route('app.settings.appearance.edit'));

        $response->assertRedirect(route('login'));
    });
});

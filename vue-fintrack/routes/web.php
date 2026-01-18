<?php

use App\Http\Controllers\App\BudgetController;
use App\Http\Controllers\App\CategoryController;
use App\Http\Controllers\App\SettingController;
use App\Http\Controllers\App\TransactionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Middleware\TwoFactorAuthentication;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => inertia('Welcome'))->name('home');

// auth routes

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// app routes

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => inertia('app/Dashboard'))->name('dashboard');

    Route::prefix('/transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('app.transactions.index');
        Route::post('/', [TransactionController::class, 'store'])->name('app.transactions.store');
        Route::patch('/{transaction}', [TransactionController::class, 'update'])->name('app.transactions.update');
        Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('app.transactions.destroy');
    });

    Route::prefix('/budgets')->group(function () {
        Route::get('/', [BudgetController::class, 'index'])->name('app.budgets.index');
        Route::post('/', [BudgetController::class, 'store'])->name('app.budgets.store');
        Route::patch('/{budget}', [BudgetController::class, 'update'])->name('app.budgets.update');
        Route::delete('/{budget}', [BudgetController::class, 'destroy'])->name('app.budgets.destroy');
    });

    Route::prefix('/categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('app.categories.index');
        Route::post('/', [CategoryController::class, 'store'])->name('app.categories.store');
        Route::patch('/{category}', [CategoryController::class, 'update'])->name('app.categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('app.categories.destroy');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('/settings')->group(function () {
        Route::redirect('/', '/settings/profile')->name('app.settings.index');
        Route::get('/profile', [SettingController::class, 'profileEdit'])->name('app.settings.profile.edit');
        Route::patch('/profile', [SettingController::class, 'profileUpdate'])->name('app.settings.profile.update');
        Route::post('/profile/export', [SettingController::class, 'profileExport'])->name('app.settings.profile.export');
        Route::delete('/profile', [SettingController::class, 'profileDestroy'])->name('app.settings.profile.destroy');
        Route::get('/preferences', [SettingController::class, 'preferencesEdit'])->name('app.settings.preferences.edit');
        Route::patch('/preferences', [SettingController::class, 'preferencesUpdate'])->name('app.settings.preferences.update');
        Route::get('/password', [SettingController::class, 'passwordEdit'])->name('app.settings.password.edit');
        Route::put('/password', [SettingController::class, 'passwordUpdate'])->middleware('throttle:6,1')->name('app.settings.password.update');
        Route::get('/two-factor', [SettingController::class, 'twoFactorShow'])->middleware(TwoFactorAuthentication::class)->name('app.settings.two-factor.show');
        Route::get('/appearance', [SettingController::class, 'appearanceShow'])->name('app.settings.appearance.edit');
    });
});

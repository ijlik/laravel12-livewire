<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Otp;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Auth\ConfirmPassword;
use App\Livewire\Home;
use App\Livewire\Admin\Users\Index as UsersIndex;
use App\Livewire\Admin\Users\Create as UsersCreate;
use App\Livewire\Admin\Users\Edit as UsersEdit;
use App\Livewire\Admin\Rbac\ManageRoles;
use App\Livewire\Admin\Rbac\ManagePermissions;
use App\Livewire\Admin\Rbac\RolePermissionMatrix;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// Guest routes (Livewire)
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/password/reset', ForgotPassword::class)->name('password.request');
    Route::get('/password/reset/{token}', ResetPassword::class)->name('password.reset');
});

// OTP route
Route::get('/login/otp', Otp::class)->name('login.otp');

// Auth routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    // Email Verification
    Route::get('/email/verify', VerifyEmail::class)->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/home');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/resend', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('resent', true);
    })->middleware('throttle:6,1')->name('verification.resend');

    // Password Confirm
    Route::get('/password/confirm', ConfirmPassword::class)->name('password.confirm');

    // Protected routes
    Route::middleware('verified')->group(function () {
        Route::get('/home', Home::class)->name('home');

        // Admin routes - Users Management
        Route::middleware('role:superadmin')->prefix('admin')->name('admin.')->group(function () {
            Route::get('/users', UsersIndex::class)->name('users.index');
            Route::get('/users/create', UsersCreate::class)->name('users.create');
            Route::get('/users/{user}/edit', UsersEdit::class)->name('users.edit');

            // RBAC Management
            Route::prefix('rbac')->name('rbac.')->group(function () {
                Route::get('/roles', ManageRoles::class)->name('roles');
                Route::get('/permissions', ManagePermissions::class)->name('permissions');
                Route::get('/matrix', RolePermissionMatrix::class)->name('matrix');
            });
        });
    });
});


<?php


use App\Http\Controllers\App\Auth\AuthenticatedSessionController;
use App\Http\Controllers\App\Auth\ConfirmablePasswordController;
use App\Http\Controllers\App\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\App\Auth\EmailVerificationPromptController;
use App\Http\Controllers\App\Auth\NewPasswordController;
use App\Http\Controllers\App\Auth\PasswordController;
use App\Http\Controllers\App\Auth\PasswordResetLinkController;
use App\Http\Controllers\App\Auth\RegisteredUserController;
use App\Http\Controllers\App\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('aregister');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('alogin', [AuthenticatedSessionController::class, 'create'])
                ->name('alogin');

    Route::post('alogin', [AuthenticatedSessionController::class, 'store'])->name('sd');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('app.password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('app.password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('app.password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('app.password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('app.verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('app.verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('app.verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('app.password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('app.password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('app.logout');
});

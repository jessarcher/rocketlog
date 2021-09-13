<?php

use App\Http\Controllers\CollectionBulletController;
use App\Http\Controllers\CollectionBulletDoneController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CollectionUserController;
use App\Http\Controllers\DailyLogController;
use App\Http\Controllers\UserPreferenceController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    if ($request->user()) {
        return redirect()->to(route('daily-log.index'));
    }

    return view('welcome');
});

Route::get('/email/verify', function () {
    return Inertia::render('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/daily-log');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::patch('user/preferences', [UserPreferenceController::class, 'update'])->name('user-preferences.update');

    // Daily Log

    Route::put('daily-log', [DailyLogController::class, 'move'])
        ->name('daily-log.move');

    Route::resource('daily-log', DailyLogController::class)
        ->parameters(['daily-log' => 'bullet'])
        ->only('index', 'store', 'update', 'destroy');

    // Collections

    Route::resource('c', CollectionController::class)
        ->parameters(['c' => 'collection'])
        ->only('show', 'store', 'update', 'destroy');

    Route::delete('c/{collection}/bullets/done', [CollectionBulletDoneController::class, 'destroy'])
        ->name('c.bullets.done.destroy');

    Route::put('c/{collection}/bullets', [CollectionBulletController::class, 'move'])
        ->name('c.bullets.move');

    Route::resource('c.bullets', CollectionBulletController::class)
        ->parameters(['c' => 'collection'])
        ->only('store', 'update', 'destroy');

    Route::resource('c.users', CollectionUserController::class)
        ->parameters(['c' => 'collection'])
        ->only('store', 'destroy');
});

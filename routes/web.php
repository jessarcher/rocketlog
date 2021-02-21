<?php

use App\Http\Controllers\CollectionBulletController;
use App\Http\Controllers\CollectionBulletDoneController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CollectionUserController;
use App\Http\Controllers\DailyLogController;
use Illuminate\Foundation\Application;
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

    //     return Inertia::render('Welcome', [
    //         'canLogin' => Route::has('login'),
    //         'canRegister' => Route::has('register'),
    //         'laravelVersion' => Application::VERSION,
    //         'phpVersion' => PHP_VERSION,
    //     ]);
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
    Route::resource('daily-log', DailyLogController::class)
        ->only('index', 'store', 'update', 'destroy')
        ->parameters(['daily-log' => 'bullet']);

    Route::resource('c', CollectionController::class)
        ->only('show', 'store', 'update', 'destroy')
        ->parameters(['c' => 'collection']);

    Route::delete('c/{collection}/bullets/done', [CollectionBulletDoneController::class, 'destroy'])->name('c.destroy-done');

    Route::resource('c.bullets', CollectionBulletController::class)
        ->only('store', 'update', 'destroy')
        ->parameters(['c' => 'collection']);

    Route::resource('c.users', CollectionUserController::class)
        ->only('store', 'destroy')
        ->parameters(['c' => 'collection']);
});

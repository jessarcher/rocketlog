<?php

use App\Http\Livewire\Collection;
use App\Http\Livewire\DailyLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
        return redirect()->to('daily-log');
    }

    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('daily-log', DailyLog::class)->name('daily-log');
    Route::get('c/{collection}', Collection::class)->name('collection');
});

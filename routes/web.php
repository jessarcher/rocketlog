<?php

use App\Http\Livewire\Collection;
use App\Http\Livewire\DailyLog;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('daily-log', DailyLog::class)->name('daily-log');
    Route::get('c/{collection}', Collection::class)->name('collection');
});

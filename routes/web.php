<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\RecordController;
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

Route::match(['GET'], '/'                      , [AppController::class,    'index'      ]);
Route::match(['POST'],'/recorder/{action}/{id}', [RecordController::class, 'recordAudio'        ]);
Route::match(['POST'],'/stream/audio'          , [AppController::class,    'streamaudio'])->name('stream.audio');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
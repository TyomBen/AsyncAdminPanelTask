<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Api\CreateEventController;
use App\Http\Controllers\Api\DeleteEvent;
use App\Http\Controllers\Api\EventActions;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\SendEventController;
use App\Http\Controllers\Api\SendEventIdController;
use App\Http\Controllers\EventUserController;
use App\Http\Controllers\ParticipationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('auth.asyncActions.sentAsyncData');
})->middleware('guest')->name('auth');
Route::get('async/login', function () {
    return view('auth.asyncActions.loginAsync');
})->middleware('guest')->name('async/login');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('data/events', [SendEventController::class, 'index']);
    Route::post('take/part/{eventId}', [ParticipationController::class, 'store'])
    ->name('take/part');
    Route::post('user/{event}', [EventUserController::class, 'index'])
    ->name('event/user');
    Route::post('create/event', [CreateEventController::class, 'store']);
    Route::post('send/eventId/{evenId}', [SendEventIdController::class, 'store']);
    Route::delete('/delete/Event/id/{id}', [DeleteEvent::class, 'delete']);
    Route::get('event', function () {
        return view('adminPanel.event.index');
    })->name('adminPanel')->middleware('auth');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

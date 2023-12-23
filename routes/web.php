<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [EventController::class, 'index']);
Route::match(['get', 'post'], '/add', [EventController::class, 'create']);
Route::match(['get', 'post'], '/detail/{id}', [EventController::class, 'show']);
Route::put('detail/{id}', [EventController::class, 'update'])->name('events.update');
Route::delete('/detail/{id}', [EventController::class, 'delete'])->name('event.delete');
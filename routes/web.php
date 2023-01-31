<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])
    ->name('dashboard');

Route::prefix('/message')->group(function () {
    Route::post('/', [MessageController::class, 'create'])
        ->name('message.create');
    Route::delete('/{message}', [MessageController::class, 'delete'])
        ->name('message.user.delete');
    Route::get('/user/{user}', [MessageController::class, 'get'])
        ->name('message.user.get');
});


require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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

Route::redirect('/', 'login');
Route::group(['middleware' => ['auth','verified']], function () {
    Route::view('dashboard', 'pages.dashboard')->name('dashboard');
    Route::post('users/{id}/update/passowrd', [UserController::class , 'updatePassword'])->name('users.update.passowrd');
    Route::resources([
        'users' => UserController::class,
        'clients' => ClientController::class,
        'projects' => ProjectController::class,
        'tasks' => TaskController::class,
    ]);
});

require __DIR__.'/auth.php';

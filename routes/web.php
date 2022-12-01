<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MovieController;
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
Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'authenticate'])->name('admin.login.auth');
// Route::group(array('prefix' => 'admin'), function () {
//     Route::get('home', function () {
//     });
// });
// Route::get('/admin/dashboard', [DashboardController::class, 'index']);
Route::group(['prefix' => 'admin', 'middleware' => 'admin.auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.login.logout');
    // Group untuk Crud Data Movie
    Route::group(['prefix' => 'movie'], function () {
        Route::get('/', [MovieController::class, 'index'])->name('admin.movie');
        Route::get('/create', [MovieController::class, 'create'])->name('admin.movie.create');
        Route::post('/store', [MovieController::class, 'store'])->name('admin.movie.store');
        Route::put('/update/{id}', [MovieController::class, 'update'])->name('admin.movie.update');
        Route::delete('/delete/{id}', [MovieController::class, 'destroy'])->name('admin.movie.delete');
        Route::get('/edit/{id}', [MovieController::class, 'edit'])->name('admin.movie.edit');
    });
});

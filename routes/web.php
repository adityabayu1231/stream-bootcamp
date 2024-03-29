<?php
// admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\TransactionController;
// member
use App\Http\Controllers\Member\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\LoginController as MemberLoginController;
use App\Http\Controllers\Member\PricingController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\MovieController as MemberMovieController;
use App\Http\Controllers\Member\TransactionController as MemberTransactionController;
use App\Http\Controllers\Member\WebhookController;
use App\Http\Controllers\Member\UserPremiumController;

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

// Define Member Route Here
Route::get('/', function () {
    return view('index');
});

Route::get('/register', [RegisterController::class, 'index'])->name('member.register');
Route::post('/register', [RegisterController::class, 'store'])->name('member.register.store');
Route::get('/login', [MemberLoginController::class, 'index'])->name('member.login');
Route::post('/login', [MemberLoginController::class, 'auth'])->name('member.login.auth');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::post('/payment-notification', [WebhookController::class, 'handler'])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

// Define Admin Route Here
Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'authenticate'])->name('admin.login.auth');
Route::view('/payment-finish', 'member.payment-finish')->name('member.payment.finish');

Route::group(['prefix' => 'member', 'middleware' => 'auth'], function () {
    Route::get('/', [MemberDashboardController::class, 'index'])->name('member.dashboard');
    Route::get('movie/{id}', [MemberMovieController::class, 'show'])->name('member.movie.detail');
    Route::get('movie/{id}/watch', [MemberMovieController::class, 'watch'])->name('member.movie.watch');
    Route::post('transaction', [MemberTransactionController::class, 'store'])->name('member.transaction.store');
    Route::get('subscription', [UserPremiumController::class, 'index'])->name('member.user_premium.index');
    Route::delete('subscription/{id}', [UserPremiumController::class, 'destroy'])->name('member.user_premium.destroy');
    Route::get('logout', [MemberLoginController::class, 'logout'])->name('member.login.logout');
});

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
    Route::get('/transaction', [TransactionController::class, 'index'])->name('admin.transaction');
});

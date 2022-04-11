<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Admin\FundController;
use App\Http\Controllers\Admin\FinancialYearController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified',]], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['is_admin']], function () {
        Route::resource('financial_year', FinancialYearController::class)->only('index', 'create', 'store', 'edit', 'update');
        Route::resource('fund', FundController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    });
});

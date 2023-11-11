<?php

use App\Http\Controllers\AdminAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ProductController;

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
    return view('welcome');
});


Route::post('/login', [LoginController::class, 'login']);

Route::prefix('admin')->group(function () {
    Route::get('/dashboards-analytics', [AdminController::class, 'dashboardsAnalytics']);
    Route::get('/general-tables', [AdminController::class, 'generalTables']);
    Route::get('/config-tables', [AdminController::class, 'configTables']);
    Route::get('/product-tables', [AdminController::class, 'productTables']);
    Route::get('/admin-accounts', [AdminController::class, 'adminAccounts']);

    Route::post('/account-create', [AdminAccountController::class, 'create']);
    Route::get('/accounts', [AdminAccountController::class, 'index']);

    Route::get('/configs', [ConfigController::class, 'index']);
    Route::post('/create-config', [ConfigController::class, 'create']);
    Route::get('/config/{id}', [ConfigController::class, 'edit']);
    Route::delete('/delete/{id}', [ConfigController::class, 'destroy']);
    Route::get('/get-all-config-tables/{id}', [ConfigController::class, 'getAllConfigTables']);
    Route::put('/update-config/{id}', [ConfigController::class, 'updateConfig']);
    Route::post('/agent-hook-code', [ConfigController::class, 'agentHookCode']);

    Route::get('/products/{id}', [ProductController::class, 'index']);
    Route::get('/product/{id}/edit', [ProductController::class, 'edit']);
    Route::put('/rematched-product/{id}', [ProductController::class, 'rematchedProduct']);
});


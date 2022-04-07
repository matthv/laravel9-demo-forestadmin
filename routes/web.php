<?php

use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\UsersController;
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

Route::get('forest/company', [CompaniesController::class, 'index']);
Route::get('forest/company/count', [CompaniesController::class, 'count']);

Route::delete('forest/company/{id}', [CompaniesController::class, 'destroy']);

Route::post('forest/user', [UsersController::class, 'store']);

<?php

use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;


Route::post('forest/smart-actions/company_return-and-track', [CompaniesController::class, 'returnAndTrack']);
Route::post('forest/smart-actions/company_show-some-activity', [CompaniesController::class, 'showSomeActivity']);
Route::post('forest/smart-actions/customer_generate-invoice', [CustomersController::class, 'generateInvoice']);
Route::post('forest/smart-actions/customer_charge-credit-card', [CustomersController::class, 'chargeCreditCard']);
Route::post('forest/smart-actions/company_mark-as-live', [CompaniesController::class, 'markAsLive']);
Route::post('forest/smart-actions/order_refund-order', [OrdersController::class, 'refundOrder']);



Route::get('forest/company', [CompaniesController::class, 'index']);
Route::get('forest/company/count', [CompaniesController::class, 'count']);
Route::delete('forest/company/{id}', [CompaniesController::class, 'destroy']);
Route::post('forest/user', [UsersController::class, 'store']);

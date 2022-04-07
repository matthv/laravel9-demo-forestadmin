<?php

use App\Http\Controllers\ChartsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\Companies2Controller;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;


Route::post('forest/smart-actions/company_upload-legal-docs', [Companies2Controller::class, 'uploadLegalDocs']);


Route::post('forest/smart-actions/company_return-and-track', [Companies2Controller::class, 'returnAndTrack']);
Route::post('forest/smart-actions/company_show-some-activity', [Companies2Controller::class, 'showSomeActivity']);
Route::post('forest/smart-actions/customer_generate-invoice', [CustomersController::class, 'generateInvoice']);
Route::post('forest/smart-actions/customer_charge-credit-card', [CustomersController::class, 'chargeCreditCard']);
Route::post('forest/smart-actions/company_mark-as-live', [Companies2Controller::class, 'markAsLive']);
Route::post('forest/smart-actions/order_refund-order', [OrdersController::class, 'refundOrder']);



Route::get('forest/company', [CompaniesController::class, 'index']);
Route::get('forest/company/count', [CompaniesController::class, 'count']);
Route::delete('forest/company/{id}', [CompaniesController::class, 'destroy']);
Route::post('forest/user', [UsersController::class, 'store']);

Route::post('forest/stats/mrr', [ChartsController::class, 'mrr']);
Route::get('stripe/create-charges', [ChartsController::class, 'createCharges']);

Route::post('forest/stats/credit-card-country-repartition', [ChartsController::class, 'creditCardCountryRepartition']);

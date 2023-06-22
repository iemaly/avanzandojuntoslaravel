<?php

use Illuminate\Support\Facades\Route;

// ADMIN
Route::post('login', [App\Http\Controllers\AdminController::class, 'login']);
Route::post('forget', [App\Http\Controllers\AdminController::class, 'forgetPwdProcess']);
Route::post('reset_password', [App\Http\Controllers\AdminController::class, 'resetPwdProcess']);

Route::group(['middleware' => 'auth:admin_api', 'prefix' => 'admin'], function () 
{
    // CAREHOME
    Route::resource('carehomes', 'App\Http\Controllers\CareHomeController');
    Route::post('carehomes/bulk', [App\Http\Controllers\CareHomeController::class, 'bulk']);
    
    // PLAN
    Route::resource('plans', 'App\Http\Controllers\PlanController');
});

// CAREHOME
Route::get('carehomes', [App\Http\Controllers\CareHomeController::class, 'index']);
Route::get('carehomes/{id}', [App\Http\Controllers\CareHomeController::class, 'show']);

// PLANS
Route::get('plans', [App\Http\Controllers\PlanController::class, 'index']);
Route::get('plans/{id}', [App\Http\Controllers\PlanController::class, 'show']);

// PROFESSIONAL
Route::resource('professionals', 'App\Http\Controllers\ProfessionalController');
Route::resource('subscriptions', 'App\Http\Controllers\SubscriptionController');

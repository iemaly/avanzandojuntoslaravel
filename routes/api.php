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

    // PROFESSIONAL
    Route::resource('professionals', 'App\Http\Controllers\ProfessionalController');
    Route::post('professional/activate/{professional}', [App\Http\Controllers\ProfessionalController::class, 'activate']);

    // USER
    Route::resource('users', 'App\Http\Controllers\UserController');
});

// CAREHOME
Route::get('carehomes', [App\Http\Controllers\CareHomeController::class, 'index']);
Route::get('carehomes/{id}', [App\Http\Controllers\CareHomeController::class, 'show']);

// PLANS
Route::get('plans', [App\Http\Controllers\PlanController::class, 'index']);
Route::get('plans/{id}', [App\Http\Controllers\PlanController::class, 'show']);

// PROFESSIONAL
// Route::get('professionals/{show}', [App\Http\Controllers\ProfessionalController::class, 'show'])->name('professionals.show');
// Route::get('professionals', [App\Http\Controllers\ProfessionalController::class, 'index'])->name('professionals.index');
Route::get('professional', [App\Http\Controllers\ProfessionalController::class, 'storeByGet'])->name('professional.store');
Route::post('professional_by_email', [App\Http\Controllers\ProfessionalController::class, 'proFessionalByEmail'])->name('professional.byEmail');

// SUBSCRIPTION
Route::resource('subscriptions', 'App\Http\Controllers\SubscriptionController');
Route::get('subscription/delete_empty', [App\Http\Controllers\SubscriptionController::class, 'deleteEmpty'])->name('subscriptions.delete');

// USER
Route::post('users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');

Route::get('subscription/afterpayuser', [App\Http\Controllers\SubscriptionController::class, 'afterPayForUser'])->name('subscriptions.user.afterpay');
Route::group(['middleware' => 'auth:user_api', 'prefix' => 'user'], function () 
{
    // SUBSCRIPTION
    Route::post('subscriptions/user', [App\Http\Controllers\SubscriptionController::class, 'storeForUser'])->name('subscriptions.user.store');
    
    Route::group(['middleware' => 'subscribed_user'], function () 
    {
        // PROFESSIONAL
        Route::get('professionals', [App\Http\Controllers\ProfessionalController::class, 'index'])->name('professionals.index');
        Route::get('professionals/{show}', [App\Http\Controllers\ProfessionalController::class, 'show'])->name('professionals.show');
    });
});

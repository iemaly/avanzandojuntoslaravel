<?php

use Illuminate\Support\Facades\Route;

// ADMIN
Route::group(['middleware' => 'auth:admin_api', 'prefix' => 'admin'], function () 
{
    // CAREHOME
    Route::resource('carehomes', 'App\Http\Controllers\CareHomeController');
    Route::post('carehomes/bulk', [App\Http\Controllers\CareHomeController::class, 'bulk']);
    Route::post('carehome/activate/{carehome}', [App\Http\Controllers\CareHomeController::class, 'activate']);
    
    // PLAN
    Route::resource('plans', 'App\Http\Controllers\PlanController');

    // PROFESSIONAL
    Route::resource('professionals', 'App\Http\Controllers\ProfessionalController');
    Route::post('professional/activate/{professional}', [App\Http\Controllers\ProfessionalController::class, 'activate']);
    
    // USER
    Route::resource('users', 'App\Http\Controllers\UserController');
    Route::post('user/activate/{user}', [App\Http\Controllers\UserController::class, 'activate']);

    // BUSINESS
    Route::resource('business', 'App\Http\Controllers\BusinessController');
    Route::post('business/activate/{user}', [App\Http\Controllers\BusinessController::class, 'activate']);
    // BUSINESS POSTS
    Route::resource('posts', 'App\Http\Controllers\PostController');
    Route::post('b/post/activate/{post}', [App\Http\Controllers\PostController::class, 'activate']);
    Route::post('post/image/update/{post}', [App\Http\Controllers\PostController::class, 'imageUpdate']);

    // CAREHOME BLUEPRINT
    Route::post('approve_blueprint/{blueprint}', [App\Http\Controllers\CareHomeController::class, 'approveBlueprint']);
    Route::post('refuse_blueprint/{blueprint}', [App\Http\Controllers\CareHomeController::class, 'refuseBlueprint']);
});

// USER
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
    
    // CONVERSATION
    Route::get('conversations', [App\Http\Controllers\ConversationController::class, 'index']);
    Route::post('conversation_participants', [App\Http\Controllers\ConversationParticipantController::class, 'store']);
    Route::post('conversations', [App\Http\Controllers\ConversationController::class, 'store']);
    Route::get('conversations/{participant}', [App\Http\Controllers\ConversationController::class, 'show']);
    Route::post('conversations/update/{participant}/{sender_type}', [App\Http\Controllers\ConversationController::class, 'update']);
    
    // APPOINTMENT
    Route::post('appointments/store', [App\Http\Controllers\AppointmentController::class, 'store']);
    Route::post('appointments/{appointment}/slots', [App\Http\Controllers\AppointmentController::class, 'storeSlot']);
    
});

// CAREHOME
Route::group(['middleware' => 'auth:carehome_api', 'prefix' => 'carehome'], function () 
{
    // PROFILE UPDATE
    Route::post('update/profile_pic', [App\Http\Controllers\CareHomeController::class, 'profilePicUpdate']);
    Route::delete('delete/profile_pic', [App\Http\Controllers\CareHomeController::class, 'deleteProfilePic']);
    
    // DOCUMENT
    Route::post('upload/media', [App\Http\Controllers\CareHomeController::class, 'addMedia']);
    Route::delete('delete/document/{document}', [App\Http\Controllers\CareHomeController::class, 'deleteDocument']);

    // PROFILE UPDATE
    Route::put('update/{carehome}', [App\Http\Controllers\CareHomeController::class, 'update']);

    // CONVERSATION
    Route::get('conversations', [App\Http\Controllers\ConversationController::class, 'indexForCarehome']);
    Route::post('conversations', [App\Http\Controllers\ConversationController::class, 'store']);
    Route::get('conversations/{participant}', [App\Http\Controllers\ConversationController::class, 'show']);
    Route::post('conversations/update/{participant}/{sender_type}', [App\Http\Controllers\ConversationController::class, 'update']);
    
    // BLUEPRINT
    Route::post('buildings', [App\Http\Controllers\CareHomeController::class, 'storeBuilding']);
    Route::post('floors', [App\Http\Controllers\CareHomeController::class, 'storeFloor']);
    Route::post('beds', [App\Http\Controllers\CareHomeController::class, 'storeBed']);
    Route::post('store_single_floor/{building}', [App\Http\Controllers\CareHomeController::class, 'storeSingleFloor']);
    Route::post('store_single_bed/{floor}', [App\Http\Controllers\CareHomeController::class, 'storeSingleBed']);
    Route::delete('delete_building/{building}', [App\Http\Controllers\CareHomeController::class, 'destroyBuilding']);
    Route::delete('delete_floor/{floor}', [App\Http\Controllers\CareHomeController::class, 'destroyFloor']);
    Route::delete('delete_bed/{bed}', [App\Http\Controllers\CareHomeController::class, 'destroyBed']);

});

// PROFESSIONAL
Route::group(['middleware' => 'auth:professional_api', 'prefix' => 'professional'], function () 
{
    Route::get('show/{show}', [App\Http\Controllers\ProfessionalController::class, 'show'])->name('professionals.show');

    // PROFILE UPDATE
    Route::post('update/profile_pic', [App\Http\Controllers\ProfessionalController::class, 'profilePicUpdate']);
    Route::delete('delete/profile_pic', [App\Http\Controllers\ProfessionalController::class, 'deleteProfilePic']);
    
    // DOCUMENT
    Route::post('upload/media', [App\Http\Controllers\ProfessionalController::class, 'addMedia']);
    Route::delete('delete/document/{document}', [App\Http\Controllers\ProfessionalController::class, 'deleteDocument']);
    
    // PROFILE UPDATE
    Route::put('update/{professional}', [App\Http\Controllers\ProfessionalController::class, 'update']);
    
    // SLOTS
    Route::post('{professional}/slots', [App\Http\Controllers\ProfessionalController::class, 'storeSlot']);
    Route::delete('/slots/{slot}', [App\Http\Controllers\ProfessionalController::class, 'deleteSlot']);
});

// BUSINESS
Route::group(['middleware' => 'auth:business_api', 'prefix' => 'business'], function () 
{
    Route::get('show/{show}', [App\Http\Controllers\BusinessController::class, 'show'])->name('business.show');

    // PROFILE UPDATE
    Route::post('update/profile_pic', [App\Http\Controllers\BusinessController::class, 'profilePicUpdate']);
    Route::delete('delete/profile_pic', [App\Http\Controllers\BusinessController::class, 'deleteProfilePic']);
    Route::put('update/{business}', [App\Http\Controllers\BusinessController::class, 'update']);
    
    // POST
    Route::post('posts', [App\Http\Controllers\PostController::class, 'store']);
    Route::get('posts', [App\Http\Controllers\PostController::class, 'index']);
    Route::get('posts/{post}', [App\Http\Controllers\PostController::class, 'show']);
    Route::post('post/image/update/{post}', [App\Http\Controllers\PostController::class, 'imageUpdate']);
});

// UNIVERSAL ROUTES

// AUTH
Route::post('login', [App\Http\Controllers\AdminController::class, 'login']);
Route::post('forget', [App\Http\Controllers\AdminController::class, 'forgetPwdProcess']);
Route::post('reset_password', [App\Http\Controllers\AdminController::class, 'resetPwdProcess']);

// PLANS
Route::get('plans', [App\Http\Controllers\PlanController::class, 'index']);
Route::get('plans/{id}', [App\Http\Controllers\PlanController::class, 'show']);

// CAREHOME
Route::post('carehomes/subscribe', [App\Http\Controllers\SubscriptionController::class, 'storeForCarehome']);
Route::get('carehome/store', [App\Http\Controllers\CareHomeController::class, 'storeByGet'])->name('carehome.storeByGet');
Route::get('carehomes', [App\Http\Controllers\CareHomeController::class, 'index']);
Route::get('carehomes/{id}', [App\Http\Controllers\CareHomeController::class, 'show']);
Route::post('find_by_email', [App\Http\Controllers\CareHomeController::class, 'findByEmail']);


// PROFESSIONAL
Route::get('professional', [App\Http\Controllers\ProfessionalController::class, 'storeByGet'])->name('professional.store');
Route::post('professional_by_email', [App\Http\Controllers\ProfessionalController::class, 'proFessionalByEmail'])->name('professional.byEmail');
// SUBSCRIPTION
Route::resource('subscriptions', 'App\Http\Controllers\SubscriptionController');
Route::get('subscription/delete_empty', [App\Http\Controllers\SubscriptionController::class, 'deleteEmpty'])->name('subscriptions.delete');

// USER
Route::post('users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('subscription/afterpayuser', [App\Http\Controllers\SubscriptionController::class, 'afterPayForUser'])->name('subscriptions.user.afterpay');

// BUSINESSS
Route::post('business/subscribe', [App\Http\Controllers\SubscriptionController::class, 'storeForBusiness']);
Route::get('business/store', [App\Http\Controllers\BusinessController::class, 'storeByGet'])->name('business.storeByGet');
Route::post('business_by_email', [App\Http\Controllers\BusinessController::class, 'businessByEmail'])->name('business.byEmail');

// BUSINESS POSTS
Route::get('posts', [App\Http\Controllers\PostController::class, 'indexForAll']);
Route::get('posts/{post}', [App\Http\Controllers\PostController::class, 'showForAll']);
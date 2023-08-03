<?php

use Illuminate\Support\Facades\Route;

// ADMIN
Route::group(['middleware' => 'auth:admin_api', 'prefix' => 'admin'], function () 
{
    // CAREHOME
    Route::resource('carehomes', 'App\Http\Controllers\CareHomeController');
    Route::post('carehomes/bulk', [App\Http\Controllers\CareHomeController::class, 'bulk']);
    Route::post('carehome/activate/{carehome}', [App\Http\Controllers\CareHomeController::class, 'activate']);
    
    // FEATURE
    Route::get('carehomes/feature/{carehome}', [App\Http\Controllers\CareHomeController::class, 'feature']);
    Route::get('carehomes/unfeature/{carehome}', [App\Http\Controllers\CareHomeController::class, 'unfeature']);
    
    // PLAN
    Route::resource('plans', 'App\Http\Controllers\PlanController');

    // PROFESSIONAL
    Route::resource('professionals', 'App\Http\Controllers\ProfessionalController');
    Route::post('professional/activate/{professional}', [App\Http\Controllers\ProfessionalController::class, 'activate']);
    // FEATURE
    Route::get('professional/feature/{professional}', [App\Http\Controllers\ProfessionalController::class, 'feature']);
    Route::get('professional/unfeature/{professional}', [App\Http\Controllers\ProfessionalController::class, 'unfeature']);
    
    // USER
    Route::resource('users', 'App\Http\Controllers\UserController');
    Route::post('user/activate/{user}', [App\Http\Controllers\UserController::class, 'activate']);

    // BUSINESS
    Route::resource('business', 'App\Http\Controllers\BusinessController');
    Route::post('business/activate/{user}', [App\Http\Controllers\BusinessController::class, 'activate']);
    // BUSINESS POSTS
    Route::resource('posts', 'App\Http\Controllers\PostController');
    Route::post('b/post/activate/{post}', [App\Http\Controllers\PostController::class, 'activate']);
    Route::post('b/post/deactive/{post}', [App\Http\Controllers\PostController::class, 'deactive']);
    Route::post('post/image/update/{post}', [App\Http\Controllers\PostController::class, 'imageUpdate']);

    // CAREHOME BLUEPRINT
    Route::post('approve_blueprint/{blueprint}', [App\Http\Controllers\CareHomeController::class, 'approveBlueprint']);
    Route::post('refuse_blueprint/{blueprint}', [App\Http\Controllers\CareHomeController::class, 'refuseBlueprint']);

    Route::get('buildings', [App\Http\Controllers\CareHomeController::class, 'buildings']);
    Route::get('floors/{building}', [App\Http\Controllers\CareHomeController::class, 'floors']);
    Route::get('beds/{floor}', [App\Http\Controllers\CareHomeController::class, 'beds']);
    Route::post('buildings', [App\Http\Controllers\CareHomeController::class, 'storeBuilding']);
    Route::post('floors', [App\Http\Controllers\CareHomeController::class, 'storeFloor']);
    Route::post('beds', [App\Http\Controllers\CareHomeController::class, 'storeBed']);
    Route::post('store_single_floor/{building}', [App\Http\Controllers\CareHomeController::class, 'storeSingleFloor']);
    Route::post('store_single_bed/{floor}', [App\Http\Controllers\CareHomeController::class, 'storeSingleBed']);
    Route::delete('delete_building/{building}', [App\Http\Controllers\CareHomeController::class, 'destroyBuilding']);
    Route::delete('delete_floor/{floor}', [App\Http\Controllers\CareHomeController::class, 'destroyFloor']);
    Route::delete('delete_bed/{bed}', [App\Http\Controllers\CareHomeController::class, 'destroyBed']);

    // BUSINESS ADVERTISEMENT
    Route::get('advertisements', [App\Http\Controllers\BusinessController::class, 'advertisements']);
    Route::get('advertisements/{advertisement}', [App\Http\Controllers\BusinessController::class, 'advertisementShow']);
    Route::delete('advertisements/delete/{advertisement}', [App\Http\Controllers\BusinessController::class, 'destroyAdvertisement']);
    Route::post('approve_advertisement/{advertisement}', [App\Http\Controllers\BusinessController::class, 'approveAdvertisement']);
    Route::post('refuse_advertisement/{advertisement}', [App\Http\Controllers\BusinessController::class, 'refuseAdvertisement']);
    Route::post('feature_unfeature_advertisement/{advertisement}', [App\Http\Controllers\BusinessController::class, 'featureUnfeature']);
    
    // SUBADMIN
    Route::resource('subadmins', 'App\Http\Controllers\SubadminController');
    Route::post('subadmin/activate/{subadmin}', [App\Http\Controllers\SubadminController::class, 'activate']);
    Route::get('permissions/{subadmin}', [App\Http\Controllers\SubadminController::class, 'assignPermission']);
    Route::post('permissions/{subadmin}', [App\Http\Controllers\SubadminController::class, 'savePermission']);

    // BLUEPRINT
    Route::post('carehome/blueprint', [App\Http\Controllers\CareHomeController::class, 'storeBlueprint']);

    Route::post('carehome/update_n_send_password/{carehome}', [App\Http\Controllers\CareHomeController::class, 'setAndSendPassword']);
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

    // CONVERSATION WITH PROFESSIONAL
    Route::get('professional_conversations', [App\Http\Controllers\ProfessionalConversationController::class, 'index']);
    Route::post('professional_conversation_participants', [App\Http\Controllers\ProfessionalConverstionParticipantController::class, 'store']);
    Route::post('professional_conversations', [App\Http\Controllers\ProfessionalConversationController::class, 'store']);
    Route::get('professional_conversations/{participant}', [App\Http\Controllers\ProfessionalConversationController::class, 'show']);
    Route::post('professional_conversations/update/{participant}/{sender_type}', [App\Http\Controllers\ProfessionalConversationController::class, 'update']);
    
    // APPOINTMENT
    Route::post('appointments/store', [App\Http\Controllers\AppointmentController::class, 'store']);
    Route::post('appointments/{appointment}/slots', [App\Http\Controllers\AppointmentController::class, 'storeSlot']);
    
    // ADVERTISEMENT
    Route::get('advertisements', [App\Http\Controllers\BusinessController::class, 'advertisementsForUser']);
    Route::get('advertisements/{advertisement}', [App\Http\Controllers\BusinessController::class, 'advertisementShow']);

    // BED BOOKING
    Route::get('bookings', [App\Http\Controllers\UserController::class, 'myBookings']);
    Route::post('book_bed', [App\Http\Controllers\UserController::class, 'bookBed']);
    Route::get('find_beds', [App\Http\Controllers\UserController::class, 'findBeds']);
    Route::get('find_bed_by_date', [App\Http\Controllers\UserController::class, 'findBedByDate']);

    Route::get('inherit', [App\Http\Controllers\UserController::class, 'inherit']);
});

// CAREHOME
Route::group(['middleware' => 'auth:carehome_api', 'prefix' => 'carehome'], function () 
{
    Route::group(['middleware' => 'subscribed_carehome'], function () 
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
        Route::get('buildings', [App\Http\Controllers\CareHomeController::class, 'buildings']);
        Route::get('floors/{building}', [App\Http\Controllers\CareHomeController::class, 'floors']);
        Route::get('beds/{floor}', [App\Http\Controllers\CareHomeController::class, 'beds']);
        Route::post('buildings', [App\Http\Controllers\CareHomeController::class, 'storeBuilding']);
        Route::post('floors', [App\Http\Controllers\CareHomeController::class, 'storeFloor']);
        Route::post('beds', [App\Http\Controllers\CareHomeController::class, 'storeBed']);
        Route::post('store_single_floor/{building}', [App\Http\Controllers\CareHomeController::class, 'storeSingleFloor']);
        Route::post('store_single_bed/{floor}', [App\Http\Controllers\CareHomeController::class, 'storeSingleBed']);
        Route::delete('delete_building/{building}', [App\Http\Controllers\CareHomeController::class, 'destroyBuilding']);
        Route::delete('delete_floor/{floor}', [App\Http\Controllers\CareHomeController::class, 'destroyFloor']);
        Route::delete('delete_bed/{bed}', [App\Http\Controllers\CareHomeController::class, 'destroyBed']);

        // FEATURE
        Route::post('apply/feature', [App\Http\Controllers\CareHomeController::class, 'requestFeature']);
        
        // BLUEPRINT
        Route::post('blueprint', [App\Http\Controllers\CareHomeController::class, 'storeBlueprint']);
    });
    
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

    // CONVERSATION
    Route::get('conversations', [App\Http\Controllers\ProfessionalConversationController::class, 'indexForProfessional']);
    Route::post('conversations', [App\Http\Controllers\ProfessionalConversationController::class, 'store']);
    Route::get('conversations/{participant}', [App\Http\Controllers\ProfessionalConversationController::class, 'show']);
    Route::post('conversations/update/{participant}/{sender_type}', [App\Http\Controllers\ProfessionalConversationController::class, 'update']);

    // PAYMENT METHOD
    Route::get('payment_methods', [App\Http\Controllers\ProfessionalController::class, 'paymentMethodsIndex']);
    Route::post('payment_methods', [App\Http\Controllers\ProfessionalController::class, 'storePaymentMethod']);
    Route::put('payment_methods/{payment_method}', [App\Http\Controllers\ProfessionalController::class, 'paymentMethodUpdate']);
    Route::get('payment_methods/{payment_method}', [App\Http\Controllers\ProfessionalController::class, 'paymentMethodShow']);
    Route::delete('payment_methods/{payment_method}', [App\Http\Controllers\ProfessionalController::class, 'paymentMethodDestroy']);

    // FEATURE
    Route::post('apply/feature', [App\Http\Controllers\ProfessionalController::class, 'requestFeature']);
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
    
    // ADVERTISEMENT
    Route::get('advertisements', [App\Http\Controllers\BusinessController::class, 'businessAdvertisements']);
    Route::get('advertisements/{advertisement}', [App\Http\Controllers\BusinessController::class, 'advertisementShow']);
    Route::post('advertisements', [App\Http\Controllers\BusinessController::class, 'storeAdvertisement']);
    Route::post('advertisements/image/update/{advertisement}', [App\Http\Controllers\BusinessController::class, 'advertisementImageUpdate']);
    Route::delete('advertisements/delete/image/{advertisement}', [App\Http\Controllers\BusinessController::class, 'deleteAdvertisementImage']);
    Route::put('advertisements/update/{advertisement}', [App\Http\Controllers\BusinessController::class, 'updateAdvertisement']);
});

// SUBADMIN
Route::group(['middleware' => 'auth:subadmin_api', 'prefix' => 'subadmin'], function () 
{
    Route::get('show/{show}', [App\Http\Controllers\SubadminController::class, 'show'])->name('subadmin.show');

    // PROFILE UPDATE
    Route::post('update/profile_pic', [App\Http\Controllers\SubadminController::class, 'profilePicUpdate']);
    Route::delete('delete/profile_pic', [App\Http\Controllers\SubadminController::class, 'deleteProfilePic']);
    Route::put('update/{subadmin}', [App\Http\Controllers\SubadminController::class, 'update']);

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

    Route::get('buildings', [App\Http\Controllers\CareHomeController::class, 'buildings']);
    Route::get('floors/{building}', [App\Http\Controllers\CareHomeController::class, 'floors']);
    Route::get('beds/{floor}', [App\Http\Controllers\CareHomeController::class, 'beds']);
    Route::post('buildings', [App\Http\Controllers\CareHomeController::class, 'storeBuilding']);
    Route::post('floors', [App\Http\Controllers\CareHomeController::class, 'storeFloor']);
    Route::post('beds', [App\Http\Controllers\CareHomeController::class, 'storeBed']);
    Route::post('store_single_floor/{building}', [App\Http\Controllers\CareHomeController::class, 'storeSingleFloor']);
    Route::post('store_single_bed/{floor}', [App\Http\Controllers\CareHomeController::class, 'storeSingleBed']);
    Route::delete('delete_building/{building}', [App\Http\Controllers\CareHomeController::class, 'destroyBuilding']);
    Route::delete('delete_floor/{floor}', [App\Http\Controllers\CareHomeController::class, 'destroyFloor']);
    Route::delete('delete_bed/{bed}', [App\Http\Controllers\CareHomeController::class, 'destroyBed']);

    // BUSINESS ADVERTISEMENT
    Route::get('advertisements', [App\Http\Controllers\BusinessController::class, 'advertisements']);
    Route::get('advertisements/{advertisement}', [App\Http\Controllers\BusinessController::class, 'advertisementShow']);
    Route::delete('advertisements/delete/{advertisement}', [App\Http\Controllers\BusinessController::class, 'destroyAdvertisement']);
    Route::post('approve_advertisement/{advertisement}', [App\Http\Controllers\BusinessController::class, 'approveAdvertisement']);
    Route::post('refuse_advertisement/{advertisement}', [App\Http\Controllers\BusinessController::class, 'refuseAdvertisement']);
    Route::post('feature_unfeature_advertisement/{advertisement}', [App\Http\Controllers\BusinessController::class, 'featureUnfeature']);

    // BLUEPRINT
    Route::post('carehome/blueprint', [App\Http\Controllers\CareHomeController::class, 'storeBlueprint']);
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
// FEATURE
Route::get('payment_success/{carehome}', [App\Http\Controllers\CareHomeController::class, 'paymentSuccess'])->name('carehome.feature_payment.success');

// PROFESSIONAL
Route::get('professional', [App\Http\Controllers\ProfessionalController::class, 'storeByGet'])->name('professional.store');
Route::post('professional_by_email', [App\Http\Controllers\ProfessionalController::class, 'proFessionalByEmail'])->name('professional.byEmail');
// FEATURE
Route::get('professional/payment_success/{professional}', [App\Http\Controllers\ProfessionalController::class, 'paymentSuccess'])->name('professional.feature_payment.success');

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

// BUSINESS
Route::get('business', [App\Http\Controllers\BusinessController::class, 'index']);

// BUSINESS POSTS
Route::get('posts', [App\Http\Controllers\PostController::class, 'indexForAll']);
Route::get('posts/{post}', [App\Http\Controllers\PostController::class, 'showForAll']);

// BUSINESS ADVERTISEMENT
Route::get('advertisements', [App\Http\Controllers\BusinessController::class, 'advertisementsForUser']);
Route::get('advertisements/{advertisement}', [App\Http\Controllers\BusinessController::class, 'advertisementShow']);

// VIDEO CALLING
Route::post('/create-room', [App\Http\Controllers\VideoCallController::class, 'createRoom']);
Route::post('/generate-token', [App\Http\Controllers\VideoCallController::class, 'generateToken']);

// EMAIL VERIFICATION
Route::get('verify_email/{role}/{id}', [App\Http\Controllers\AdminController::class, 'emailVerify'])->name('email_verification');

// COUNT
Route::get('dashboard', [App\Http\Controllers\AdminController::class, 'dashboard']);
Route::get('is_viewed', [App\Http\Controllers\AdminController::class, 'isViewed']);
Route::post('is_viewed/{type}', [App\Http\Controllers\AdminController::class, 'isViewedUpdate']);

Route::get('buildings', [App\Http\Controllers\BuildingController::class, 'index']);
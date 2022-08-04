<?php

use Illuminate\Http\Request;


Route::group(['prefix' => 'system', 'middleware' => ['client'], 'namespace' => 'Api\Client'], function() {

});


Route::group(['prefix' => 'auth', 'namespace' => 'Api\Mobile'], function () {

    Route::post('send-login-otp', 'Auth\ApiAuthController@sendLoginOtp');

    Route::post('send-verify-otp', 'Auth\ApiAuthController@sendVerifyOtp');
	Route::post('forgot/sendotp', 'Auth\ApiAuthController@sendOtp');
    Route::post('forgot/password', 'Auth\ApiAuthController@passwordSet');

    /* For Front URL */
    
    Route::post('login', 'Auth\ApiAuthController@login');
    Route::post('doctor-list', 'Auth\ApiAuthController@DoctorList');
    Route::post('user-doctor-list', 'Auth\ApiAuthController@UserDoctorList');
    Route::post('doctor-details', 'Auth\ApiAuthController@DoctorDetails');
    Route::post('doctor-category-list', 'Auth\ApiAuthController@DoctorCategoryList');
    Route::post('doctor-booking', 'Auth\ApiAuthController@DoctorBooking');
    Route::post('doctor-booking-list', 'Auth\ApiAuthController@DoctorBookingList');


    Route::post('register', 'Auth\ApiAuthController@register');
    
   
    Route::post('states', 'Auth\ApiAuthController@StateList');
    
    Route::post('cities', 'Auth\ApiAuthController@CityList');

    Route::post('category', 'Auth\ApiAuthController@CategoryData');

    Route::post('myprofile', 'Auth\ApiAuthController@MyProfile');

    Route::post('update-myprofile', 'Auth\ApiAuthController@UpdatedMyProfile');
    
    Route::post('forgot-password', 'Auth\ApiAuthController@ForgotPassword');

    Route::post('change-password', 'Auth\ApiAuthController@changePassword');
    
    Route::post('verify-otp', 'Auth\ApiAuthController@verifyOtp');
    
    Route::post('update-forgot-password', 'Auth\ApiAuthController@UpdateForgotPassword');
    
    Route::post('pin-code', 'Auth\ApiAuthController@Pincode');

    Route::post('pin-code-list', 'Auth\ApiAuthController@PincodeList');


    Route::group(['middleware' => 'auth:api'], function() {
    });

});

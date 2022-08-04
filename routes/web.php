<?php

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

Route::get('/test', function () { return view('auth.login'); });
Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('migrate');
    $exitCode = Artisan::call('optimize');
    return 'DONE'; //Return anything
});
Auth::routes();

Route::get('/teamregistration', 'Backend\TeamController@frontcreate')->name('front-team-create');
Route::post('/team/store', 'Backend\TeamController@frontstore')->name('front-team-store');
Route::get('/front/get-cities', 'Backend\DoctorController@GetCities')->name('front-get-cities');

Route::get('/admin/login', 'Auth\LoginController@showLoginForm')->name('admin/login');
Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::get('/admin/franchise-list', 'Backend\SiteAuthController@getFranchiseData')->name('franchise-list')->middleware(['permission:Fund Raiser List']);
Route::get('/admin/viewdetail/{id}', 'Backend\SiteAuthController@viewDetail')->name('view-details')->middleware(['permission:Banner Edit']);

Route::group(['middleware' => ['auth'], 'namespace' => 'Backend'], function() {

    Route::get('/admin/dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::get('/admin/get-all-notification', 'DashboardController@getAllNotification');
    Route::post('/admin/send-mail', 'UserController@sendmail')->name('send-mail');
    Route::get('/get-autocomplete-users', 'DashboardController@getusers')->name('get-auto-users');

    //User Master
    Route::group(['middleware' => ['permission:User Master']], function() {
        Route::get('/admin/front-users', 'UserController@FrontUser')->name('front-users')->middleware(['permission:User List']);
        Route::get('/admin/front-users-create', 'UserController@CreateFrontUser')->name('front-users-create')->middleware(['permission:User Create']);


        Route::get('/admin/front-users-password', 'UserController@PasswordUpdate')->name('front-users-password');
        Route::post('/admin/getreporter', 'UserController@Getreporterdata')->name('front-users-getreporter');

        Route::post('/admin/save-front-users', 'UserController@SaveFrontUsers')->name('save-front-users');
        Route::post('/admin/import', 'UserController@import')->name('import');
        Route::get('/admin/users', 'UserController@index')->name('user-list')->middleware(['permission:User List']);
        Route::get('/admin/users/create', 'UserController@create')->name('user-create')->middleware(['permission:User Create']);
        Route::post('/admin/users/store', 'UserController@store')->name('user-save')->middleware(['permission:User Create']);
        Route::get('/admin/users/edit/{id}', 'UserController@edit')->name('user-edit')->middleware(['permission:User Edit']);
        Route::post('/admin/users/update/{id}', 'UserController@update')->name('user-update')->middleware(['permission:User Edit']);
        Route::get('/admin/ajax/users/view/{id}', 'UserController@show')->name('user-view')->middleware(['permission:User View']);
        Route::get('/admin/users/enquiry-list', 'UserController@enquirylist')->name('enquiry-list')->middleware(['permission:User View']);

        Route::get('/admin/cities', 'UserController@GetCitiesdfdssf')->name('get.cities')->middleware(['permission:User List']);

        Route::get('/admin/front-users/edit/{id}', 'UserController@FrontUseredit')->name('front-users-edit')->middleware(['permission:User Edit']);
        Route::post('/admin/front-users/update/{id}', 'UserController@FrontUserupdate')->name('front-users-update')->middleware(['permission:User Edit']);

    });



    //Pincode Master
    Route::group(['middleware' => ['permission:Banner Master']], function() {
        Route::get('/admin/pincode-list', 'PincodeController@index')->name('pincode-list')->middleware(['permission:Banner List']);
        Route::get('/admin/pincode/create', 'PincodeController@create')->name('pincode-create')->middleware(['permission:Banner Create']);
        Route::post('/admin/pincode/store', 'PincodeController@store')->name('pincode-store')->middleware(['permission:Banner Create']);
        Route::get('/admin/pincode/edit/{id}', 'PincodeController@edit')->name('pincode-edit')->middleware(['permission:Banner Edit']);
        Route::post('/admin/pincode/update/{id}', 'PincodeController@update')->name('pincode-update')->middleware(['permission:Banner Edit']);
        Route::get('/admin/pincode/delete/{id}', 'PincodeController@destroy')->name('pincode-delete')->middleware(['permission:Banner Delete']);
    });



    //Category Master
    Route::group(['middleware' => ['permission:Category Master']], function() {
        Route::get('/admin/category', 'CategoryController@index')->name('category-list')->middleware(['permission:Category List']);
        Route::get('/admin/category/create', 'CategoryController@create')->name('category-create')->middleware(['permission:Category Create']);
        Route::post('/admin/category/store', 'CategoryController@store')->name('category-save')->middleware(['permission:Category Create']);
        Route::get('/admin/category/edit/{id}', 'CategoryController@edit')->name('category-edit')->middleware(['permission:Category Edit']);
        Route::post('/admin/category/update/{id}', 'CategoryController@update')->name('category-update')->middleware(['permission:Category Edit']);
        Route::get('/admin/ajax/category/view/{id}', 'CategoryController@show')->name('category-view')->middleware(['permission:Category View']);
         Route::get('/admin/category/delete/{id}', 'CategoryController@destroy')->name('category-delete')->middleware(['permission:Category Delete']);
    });


    //Doctor Category Master
    Route::group(['middleware' => ['permission:Doctor Master']], function() {
        Route::get('/admin/doctor/category/list', 'DoctorCategoryController@index')->name('category-doctor-list')->middleware(['permission:Doctor List']);
        Route::get('/admin/doctor/category/create', 'DoctorCategoryController@create')->name('category-doctor-create')->middleware(['permission:Doctor Create']);
        Route::post('/admin/doctor/category/store', 'DoctorCategoryController@store')->name('category-doctor-store')->middleware(['permission:Doctor Create']);
        Route::get('/admin/doctor/category/edit/{id}', 'DoctorCategoryController@edit')->name('category-doctor-edit')->middleware(['permission:Doctor Edit']);
        Route::post('/admin/doctor/category/update/{id}', 'DoctorCategoryController@update')->name('category-doctor-update')->middleware(['permission:Doctor Edit']);
        Route::get('/admin/doctor/category/delete/{id}', 'DoctorCategoryController@destroy')->name('category-doctor-delete')->middleware(['permission:Doctor Delete']);


    });

    //Doctor Master
    Route::group(['middleware' => ['permission:Doctor Master']], function() {
        Route::get('/admin/doctor-list', 'DoctorController@index')->name('doctor-list')->middleware(['permission:Doctor List']);
        Route::get('/admin/doctor/create', 'DoctorController@create')->name('doctor-create')->middleware(['permission:Doctor Create']);
        Route::post('/admin/doctor/store', 'DoctorController@store')->name('doctor-store')->middleware(['permission:Doctor Create']);
        Route::get('/admin/doctor/edit/{id}', 'DoctorController@edit')->name('doctor-edit')->middleware(['permission:Doctor Edit']);
        Route::post('/admin/doctor/update/{id}', 'DoctorController@update')->name('doctor-update')->middleware(['permission:Doctor Edit']);
        Route::get('/admin/doctor/delete/{id}', 'DoctorController@destroy')->name('doctor-delete')->middleware(['permission:Doctor Delete']);
        Route::get('/admin/get-cities', 'DoctorController@GetCities')->name('get-cities')->middleware(['permission:Doctor Delete']);
        Route::get('/admin/delete-timings', 'DoctorController@DeleteTimings')->name('delete-timings')->middleware(['permission:Doctor Delete']);
        Route::get('/admin/doctor/appoinment/list', 'DoctorController@AppointmentList')->name('appointment-list')->middleware(['permission:Doctor List']);

        Route::get('/admin/our-expert', 'DoctorController@OurExpert')->name('our-expert')->middleware(['permission:Doctor List']);

        Route::post('/admin/doctor/import', 'DoctorController@Doctorimport')->name('doctor-import');

    });






    /* Package Controller  */
    Route::get('chart', 'ChartController@index');
    Route::post('site-register', 'SiteAuthController@siteRegisterPost');
    Route::get('search', 'PackageController@index')->name('search');
    Route::get('autocomplete', 'PackageController@autocomplete')->name('autocomplete');
    Route::get('pdfview',array('as'=>'pdfview','uses'=>'PackageController@pdfview'));
    /* Package Controller  */
    Route::get('/setting', 'SettingController@index')->name('setting');



    Route::post('/setting/password/update', 'SettingController@updatePassword')->name('password-update');

    Route::get('/admin/roles-list', 'RolePermissionController@roles')->name('roles-list');
    Route::get('/admin/roles/create', 'RolePermissionController@create')->name('roles-create');
    Route::post('/admin/roles/store', 'RolePermissionController@store')->name('roles-store');
    Route::get('/admin/roles/edit/{id}', 'RolePermissionController@edit')->name('roles-edit');
    Route::post('/admin/roles/update/{id}', 'RolePermissionController@update')->name('roles-update');
    Route::get('/admin/ajax/roles/view/{id}', 'RolePermissionController@show')->name('roles-view');

});


/* Front Routes --  */
Route::get('site-register', 'Backend\SiteAuthController@siteRegister');

Route::group(['namespace' => 'Frontend'], function() {

        Route::get('/currency', 'HomeController@currency')->name('currency');
        Route::get('/', 'HomeController@index')->name('home');
        Route::post('/cart-add', 'CartController@add')->name('cart.add');
        Route::get('/cart-checkout', 'CartController@cart')->name('cart.list');
        Route::get('/remove/{id}', 'CartController@remove')->name('remove');
        Route::post('/cart-update', 'CartController@update')->name('cart.update');
        Route::post('/cart-clear', 'CartController@clear')->name('cart.clear');

        Route::get('/login/', 'HomeController@login')->name('login');
        Route::get('/register/', 'HomeController@register')->name('register');
        Route::post('/save/register', 'HomeController@store')->name('save.register');

        Route::get('/shop/', 'HomeController@ShopPage')->name('shop');
        Route::get('/shop/products', 'HomeController@getProductsByCategory')->name('shop-products');

        Route::get('/categories/{url}', 'HomeController@categories')->name('categories');
        Route::post('/checklogin', 'LoginController@checkLogin')->name('check-login');
        Route::get('/category/{category}', 'HomeController@getCategoryData')->name('category-page');

        Route::get('/category/{category}/{subcategory}', 'HomeController@getSubCategoryData')->name('sub-category-page');

        Route::get('/category/{category}/product/{slug}', 'HomeController@SingleCategoryProductPage')->name('single-category-product');

        Route::get('/category/{category}/{subcategory}/product/{slug}', 'HomeController@getSingleProductData')->name('single-product');

        Route::get('/location/', 'HomeController@setCityForUser')->name('location');

    });

Route::group(['middleware' => ['isLogin'], 'namespace' => 'Frontend'], function() {
    /* Dashboard */
    Route::get('/users/dashboard', 'DashboardController@index')->name('users.dashboard');
    Route::get('/users/my-orders', 'DashboardController@myorders')->name('my.orders');
    Route::get('/users/my-profile', 'DashboardController@myProfile')->name('my.profile');
    Route::post('/users/update-user/{id}', 'DashboardController@UpdateUser')->name('update-user');
    Route::get('/users/order-details/{orderid}', 'DashboardController@OrderDetails')->name('order.details');
    Route::get('pdfview',array('as'=>'pdfview','uses'=>'DashboardController@pdfview'));
    /*Dashboard */

    Route::get('/checkout/', 'CartController@checkout')->name('cart.checkout');
    Route::get('/logout/', 'LoginController@logout')->name('logout');
    /* Fund  Raiser */
    Route::get('/search-data', 'FundRaiserController@SearchData')->name('search-data');
    Route::get('/get-data-by-autocomplete', 'FundRaiserController@GetDataByAutocomplete')->name('get-data-by-autocomplete');
    Route::get('/ajax-notification', 'FundRaiserController@ajaxNotification')->name('ajax-notification');
    Route::get('/ajax-notification-update', 'FundRaiserController@ajaxNotificationUpdate')->name('ajax-notification-update');
   /*  Fund  Raiser */

   /*Payment Routes */
    // Route::get('product', 'PaymentController@index');
    Route::post('paysuccess', 'PaymentController@razorPaySuccess')->name('paysuccess');
    // Route::post('razor-thank-you', 'PaymentController@thankYou');
   /*Payment Routes */
});



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

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Localization;

Route::get('/', function () {
    return redirect('/'. App::getLocale());
});
Route::get('lang/{locale}', 'HomeController@lang')->name('lang');

Route::get('/home', function (){
    return redirect('/'. App::getLocale());
})->name('home');

Route::group(['prefix' => Localization::getLocale()], function(){
    Auth::routes();
    Route::group(['prefix' => 'account'], function(){
        Route::middleware('can:accessAccount')->group(function(){
            /**
             * Admin part of routes
             */

            Route::resource('users', 'Admin\UsersController');
            Route::resource('restaurant-types', 'Admin\RestaurantTypes');
            Route::resource('cities', 'Admin\Cities');
            Route::resource('kitchens', 'Admin\KitchensController');
            Route::resource('restaurants', 'Admin\RestaurantsController');
            Route::resource('articles', 'Admin\ArticlesController');
            Route::resource('questions', 'Admin\QuestionController');
            Route::resource('roles', 'Admin\RolesController');
            Route::resource('event_types', 'Admin\EventTypeController');
            Route::resource('events', 'Admin\EventController');
            Route::resource('landings', 'Admin\LandingController');

            Route::resource('halls', 'Admin\HallsController')->only([
                'edit', 'update', 'destroy'
            ]);
            Route::get('/restaurants/{id}/halls/create', 'Admin\HallsController@create')->name('halls.create');
            Route::post('/restaurants/{id}/halls/store', 'Admin\HallsController@store')->name('halls.store');

            Route::resource('gallery', 'Admin\GalleryController')->only([
                'edit', 'update'
            ]);
            Route::resource('menu', 'Admin\MenuController')->only([
                'edit', 'update'
            ]);

            Route::resource('event_gallery', 'Admin\EventGalleryController')->only([
                'edit', 'update', 'destroy'
            ]);
            Route::get('/events/{id}/event_gallery/create', 'Admin\EventGalleryController@create')->name('event_gallery.create');
            Route::post('/events/{id}/event_gallery/store', 'Admin\EventGalleryController@store')->name('event_gallery.store');
            Route::post('/events/{id}/event_gallery/ajax_upload', 'Admin\AjaxUploadController@ajaxEventUpload')->name('event_gallery.ajax_upload');

            Route::post('/restaurants/{id}/halls/upload', 'Admin\AjaxUploadController@ajaxHallUpload')->name('halls.ajax_upload');
            Route::post('/restaurants/{id}/gallery/upload', 'Admin\AjaxUploadController@ajaxRestaurantUploadImage')->name('gallery.ajax_upload');
            Route::post('/restaurants/{id}/menu/upload', 'Admin\AjaxUploadController@ajaxMenuUploadImage')->name('menu.ajax_upload');
            Route::get('/remove-gallery-item/{id}', 'Admin\AjaxUploadController@removeGalleryItem')->name('remove_gallery_item'); //now must be get, because i don`t want write js of find solution for implementing delete method

            Route::get('/workload', 'Admin\WorkloadController@index')->name('workload-list');
            Route::get('/workload/{id}', 'Admin\WorkloadController@placeWorkload')->name('workload-place');
            Route::post('/workload/change-status', 'Admin\WorkloadController@changeStatus')->name('change-schedule');

            //Staff routes
            Route::get('/restaurants/{id}/staff/create', 'Admin\RestaurantsController@createStaff')->name('staff.create');
            Route::post('/restaurants/staff/store', 'Admin\RestaurantsController@storeStaff')->name('staff.store');
            Route::delete('/restaurant/staff/{id}/destroy', 'Admin\RestaurantsController@destroyStaff')->name('staff.destroy');

            Route::middleware('can:editSettings')->group(function(){
                Route::get('/resizes', 'Admin\ImageController@index')->name('resize-buttons');
                Route::post('/clean_resizes', 'Admin\ImageController@removeResizes')->name('clean-resizes');
                Route::post('/resize_one', 'Admin\ImageController@resizeOne')->name('resize-one');
                Route::post('/remove-wrong', 'Admin\ImageController@removeWrong')->name('remove-wrong');
            });
            /**
             * User part of cabinet routes
             */
            Route::get('/verified_notice', 'Account\SMSVerification@verifiedNotice')->name('phone_verification_notice');
            Route::post('/verified_notice', 'Account\SMSverification@checkVerification')->name('check_verification');
            Route::get('/send_verification_code', 'Account\SMSVerification@sendVerificationCode')->name('send_verification');
            Route::get('/dashboard', 'Account\Dashboard@index')->name('account')->middleware('phone_verified');

            Route::resource('my-orders', 'Account\OrderController');
            Route::resource('pouch', 'Account\PouchController');
            Route::resource('transactions', 'Account\TransactionsController');
            Route::resource('account-settings', 'Account\UserController');
            /**
             * Routes for restaurant management
             */
            Route::get('/restaurant/{restaurant_id}/orders', 'RestaurantManagement\OrdersController@index')->name('restaurant.orders');
            Route::get('/restaurant/{restaurant_id}/orders/{order_id}', 'RestaurantManagement\OrdersController@show')->name('restaurant.orders.show');
            Route::get('/restaurant/{restaurant_id}/orders/{order_id}/edit', 'RestaurantManagement\OrdersController@edit')->name('restaurant.orders.edit');
            Route::put('/restaurant/orders/{order_id}/update', 'RestaurantManagement\OrdersController@update')->name('restaurant.orders.update');
            Route::put('/restaurant/orders/{order_id}/accept', 'RestaurantManagement\OrdersController@accept')->name('restaurant.orders.accept');
            Route::put('/restaurant/orders/{order_id}/reject', 'RestaurantManagement\OrdersController@reject')->name('restaurant.orders.reject');
            Route::put('/restaurant/orders/{order_id}/user_reject', 'RestaurantManagement\OrdersController@user_cancel')->name('restaurant.orders.user_reject');
            //pay
            //check for payed and cancel if not
            //user reject with back money
            //success
            //confirm success


        });
    });

    Route::get('/create-sitemap', 'SitemapController@index')->name('sitemap');
    //Route::get('/test', 'LiqpayController@create');
    Route::get('/', 'HomeController@index')->name('start');
    Route::post('/show_city', 'HomeController@cities_form')->name('select-city');
    Route::get('/FAQ', 'ArticlesController@view_faq')->name('faq');
    Route::get('/{uri}', 'HomeController@city')->name('city-page');
    Route::get('/articles/{article_uri}', 'ArticlesController@index')->name('view-article');
    Route::get('/{city_ur}/filter', 'HomeController@filter')->name('filter');
    Route::get('/{city_uri}/{restaurant_uri}', 'RestaurantController@index')->name('restaurant-page');
    Route::post('/{city_uri}/{restaurant_uri}/order', 'OrdersController@create')->name('order.create');
    Route::get('/{city_uri}/{restaurant_uri}/order', 'OrdersController@continue')->name('order.continue');
    Route::post('/{restaurant}/order/store', 'OrdersController@store')->name('order.store');

});

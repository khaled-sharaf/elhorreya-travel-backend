<?php


Route::group(['middleware' => ['api'], 'prefix' => env('CP_PREFIX_API')], function () {

    /**************** Global *****************/

    Route::get('/models-counts', 'HomeController@modelsCounts');

    /*********************************************************************************/



    /**************** Users *****************/

    Route::apiResource('users', 'UserController')->parameters(['users' => 'id']);
    Route::patch('users/restore/{id}', 'UserController@restoreUser');
    Route::post('users/delete_restore_multi', 'UserController@deleteRestoreMulti');

    /*********************************************************************************/



    /**************** Marketing Hotels *****************/

    Route::apiResource('marketing_hotels', 'MarketingHotelController')->parameters(['marketing_hotels' => 'id']);
    Route::patch('marketing_hotels/restore/{id}', 'MarketingHotelController@restoreHotel');
    Route::post('marketing_hotels/delete_restore_multi', 'MarketingHotelController@deleteRestoreMulti');
    Route::get('marketing_hotels/select', 'MarketingHotelController@hotelsSelect');

    /*********************************************************************************/



    /**************** Hotels *****************/

    Route::apiResource('hotels', 'HotelController')->parameters(['hotels' => 'id']);
    Route::patch('hotels/restore/{id}', 'HotelController@restoreHotel');
    Route::post('hotels/delete_restore_multi', 'HotelController@deleteRestoreMulti');
    Route::get('hotels/select', 'HotelController@hotelsSelect');

    /*********************************************************************************/



    /**************** Rooms *****************/

    Route::apiResource('rooms', 'RoomController')->parameters(['rooms' => 'id']);
    Route::patch('rooms/restore/{id}', 'RoomController@restoreRoom');
    Route::post('rooms/delete_restore_multi', 'RoomController@deleteRestoreMulti');

    /*********************************************************************************/



    /**************** Travel Programs *****************/

    Route::apiResource('travel_programs', 'TravelProgramController')->parameters(['travel_programs' => 'id']);
    Route::patch('travel_programs/restore/{id}', 'TravelProgramController@restoreTravelProgram');
    Route::post('travel_programs/delete_restore_multi', 'TravelProgramController@deleteRestoreMulti');
    Route::get('travel_programs/select', 'TravelProgramController@travelProgramsSelect');

    /*********************************************************************************/



    /**************** Travel categories *****************/

    Route::apiResource('travel_categories', 'TravelCategoryController')->parameters(['travel_categories' => 'id']);
    Route::patch('travel_categories/restore/{id}', 'TravelCategoryController@restoreTravelCategory');
    Route::post('travel_categories/delete_restore_multi', 'TravelCategoryController@deleteRestoreMulti');
    Route::get('travel_categories/select', 'TravelCategoryController@travelCategoriesSelect');

    /*********************************************************************************/



    /**************** Travels *****************/

    Route::apiResource('travels', 'TravelController')->parameters(['travels' => 'id']);
    Route::patch('travels/restore/{id}', 'TravelController@restoreTravel');
    Route::post('travels/delete_restore_multi', 'TravelController@deleteRestoreMulti');
    Route::get('travels/select', 'TravelController@travelsSelect');

    /*********************************************************************************/



    /**************** Bookings *****************/

    Route::apiResource('bookings', 'BookingController')->only(['index', 'destroy'])->parameters(['bookings' => 'id']);
    Route::patch('bookings/restore/{id}', 'BookingController@restoreBooking');
    Route::post('bookings/delete_restore_multi', 'BookingController@deleteRestoreMulti');

    /*********************************************************************************/



    /**************** Mailing List *****************/

    Route::apiResource('mailing_list', 'MailingListController')->only(['index', 'destroy'])->parameters(['mailing_list' => 'id']);
    Route::post('mailing_list/delete_restore_multi', 'MailingListController@deleteRestoreMulti');

    /*********************************************************************************/



    /**************** Images *****************/

    Route::apiResource('images', 'ImageController')->parameters(['images' => 'id']);
    Route::patch('images/restore/{id}', 'ImageController@restoreImage');
    Route::post('images/delete_restore_multi', 'ImageController@deleteRestoreMulti');

    /*********************************************************************************/



    /**************** Blogs *****************/

    Route::apiResource('blogs', 'BlogController')->parameters(['blogs' => 'id']);
    Route::patch('blogs/restore/{id}', 'BlogController@restoreBlog');
    Route::post('blogs/delete_restore_multi', 'BlogController@deleteRestoreMulti');

    /*********************************************************************************/



    /**************** contact_us *****************/

    Route::apiResource('contact_us', 'ContactUsController')->only(['index', 'destroy'])->parameters(['contact_us' => 'id']);
    Route::post('contact_us/delete_restore_multi', 'ContactUsController@deleteRestoreMulti');

    /*********************************************************************************/



    /**************** Contact info *****************/

    Route::apiResource('contact_infos', 'ContactInfoController')->parameters(['contact_info' => 'id']);
    Route::post('contact_infos/delete_restore_multi', 'ContactInfoController@deleteRestoreMulti');

    /*********************************************************************************/



    /**************** Settings *****************/

    Route::apiResource('settings', 'SettingController')->parameters(['settings' => 'id']);
    Route::get('settings/get/{name}', 'SettingController@getByName');
    Route::put('settings/save', 'SettingController@save');
    Route::post('settings/delete_restore_multi', 'SettingController@deleteRestoreMulti');

    /*********************************************************************************/



    /**************** Home Tabs *****************/

    Route::get('home_tabs', 'HomeTabController@index');
    Route::get('home_tabs/getTravelsByCategories', 'HomeTabController@getTravelsByCategories');
    Route::put('home_tabs', 'HomeTabController@update');

    /*********************************************************************************/


});

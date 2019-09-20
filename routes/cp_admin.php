<?php
use App\Http\Controllers\HomeController;

// here all routes control panel
Route::get(env('CP_PREFIX') . '/{path?}', 'HomeController@index')->where('path', '.*');


Route::group(['middleware' => ['api'], 'prefix' => env('CP_PREFIX_API')], function () {

    /**************** Global *****************/

    Route::get('/models-counts', 'HomeController@modelsCounts');

    /*********************************************************************************/



    /**************** Users *****************/

    Route::apiResource('users', 'UserController')->parameters(['users' => 'id']);
    Route::patch('users/restore/{id}', 'UserController@restoreUser');

    /*********************************************************************************/



    /**************** Hotels *****************/

    Route::apiResource('hotels', 'HotelController')->parameters(['hotels' => 'id']);
    Route::patch('hotels/restore/{id}', 'HotelController@restoreHotel');
    Route::get('hotels/select', 'HotelController@hotelsSelect');

    /*********************************************************************************/



    /**************** Rooms *****************/

    Route::apiResource('rooms', 'RoomController')->parameters(['rooms' => 'id']);
    Route::patch('rooms/restore/{id}', 'RoomController@restoreRoom');

    /*********************************************************************************/



    /**************** Travel Programs *****************/

    Route::apiResource('travel_programs', 'TravelProgramController')->parameters(['travel_programs' => 'id']);
    Route::patch('travel_programs/restore/{id}', 'TravelProgramController@restoreTravelProgram');
    Route::get('travel_programs/select', 'TravelProgramController@travelProgramsSelect');

    /*********************************************************************************/



    /**************** Travel categories *****************/

    Route::apiResource('travel_categories', 'TravelCategoryController')->parameters(['travel_categories' => 'id']);
    Route::patch('travel_categories/restore/{id}', 'TravelCategoryController@restoreTravelCategory');
    Route::get('travel_categories/select', 'TravelCategoryController@travelCategoriesSelect');

    /*********************************************************************************/



    /**************** Travels *****************/

    Route::apiResource('travels', 'TravelController')->parameters(['travels' => 'id']);
    Route::patch('travels/restore/{id}', 'TravelController@restoreTravel');

    /*********************************************************************************/



    /**************** Travel Details *****************/

    Route::apiResource('travel_details', 'TravelDetailController')->parameters(['travel_details' => 'id']);

    /*********************************************************************************/



    /**************** Mailing List *****************/

    Route::apiResource('mailing_list', 'MailingListController')->only(['index', 'destroy'])->parameters(['mailing_list' => 'id']);

    /*********************************************************************************/



    /**************** Bookings *****************/

    Route::apiResource('bookings', 'BookingController')->only(['index', 'destroy'])->parameters(['bookings' => 'id']);
    Route::patch('bookings/restore/{id}', 'BookingController@restoreBooking');

    /*********************************************************************************/



    /**************** Images *****************/

    Route::apiResource('images', 'ImageController')->parameters(['images' => 'id']);
    Route::patch('images/restore/{id}', 'ImageController@restoreImage');

    /*********************************************************************************/



    /**************** Blogs *****************/

    Route::apiResource('blogs', 'BlogController')->parameters(['blogs' => 'id']);
    Route::patch('blogs/restore/{id}', 'BlogController@restoreBlog');

    /*********************************************************************************/



    /**************** Settings *****************/

    Route::apiResource('settings', 'SettingController')->parameters(['settings' => 'id']);

    /*********************************************************************************/


});

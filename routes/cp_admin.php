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

    /*********************************************************************************/



    /**************** Rooms *****************/

    Route::apiResource('rooms', 'RoomController')->parameters(['rooms' => 'id']);
    Route::post('rooms/restore/{id}', 'RoomController@restoreRoom');

    /*********************************************************************************/



    /**************** Travel Programs *****************/

    Route::apiResource('travel_programs', 'TravelProgramController')->parameters(['travel_programs' => 'id']);
    Route::post('travel_programs/restore/{id}', 'TravelProgramController@restoreTravelProgram');

    /*********************************************************************************/



    /**************** Travel Types *****************/

    Route::apiResource('travel_types', 'TravelTypeController')->parameters(['travel_types' => 'id']);
    Route::post('travel_types/restore/{id}', 'TravelTypeController@restoreTravelType');

    /*********************************************************************************/



    /**************** Travels *****************/

    Route::apiResource('travels', 'TravelController')->parameters(['travels' => 'id']);
    Route::post('travels/restore/{id}', 'TravelController@restoreTravel');

    /*********************************************************************************/



    /**************** Travel Details *****************/

    Route::apiResource('travel_details', 'TravelDetailController')->parameters(['travel_details' => 'id']);

    /*********************************************************************************/



    /**************** Mailing List *****************/

    Route::apiResource('mailing_list', 'MailingListController')->only(['index', 'destroy'])->parameters(['mailing_list' => 'id']);

    /*********************************************************************************/



    /**************** Bookings *****************/

    Route::apiResource('bookings', 'BookingController')->only(['index', 'destroy'])->parameters(['bookings' => 'id']);
    Route::post('bookings/restore/{id}', 'BookingController@restoreBooking');

    /*********************************************************************************/



    /**************** Images *****************/

    Route::apiResource('images', 'ImageController')->parameters(['images' => 'id']);
    Route::post('images/restore/{id}', 'ImageController@restoreImage');

    /*********************************************************************************/



    /**************** Blogs *****************/

    Route::apiResource('blogs', 'BlogController')->parameters(['blogs' => 'id']);
    Route::post('blogs/restore/{id}', 'BlogController@restoreBlog');

    /*********************************************************************************/



    /**************** Settings *****************/

    Route::apiResource('settings', 'SettingController')->parameters(['settings' => 'id']);

    /*********************************************************************************/


});

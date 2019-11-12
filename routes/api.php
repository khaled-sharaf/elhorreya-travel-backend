<?php

use Illuminate\Http\Request;


/*********************************************************************************/


/**************** global *****************/
Route::get('/menu-and-settings', 'TravelProgramController@getMenuAndSettings');
Route::get('/hotels-address', 'HotelController@getAddressAll');
Route::put('/visitor', 'SettingController@addVisitor');

/*********************************************************************************/


/**************** mailing_list *****************/
// store
Route::post('/mailing_list/subscribe', 'MailingListController@sendMailStore');
// destroy
Route::post('/mailing_list/unsubscribe', 'MailingListController@sendMailDelete');

/*********************************************************************************/


/**************** bookings *****************/
// store
Route::post('/booking', 'BookingController@store');

/*********************************************************************************/


/**************** contact us *****************/

Route::post('/contact_us', 'ContactUsController@store');

/*********************************************************************************/



// home page

Route::get('/best-travels-offer', 'TravelController@bestTravelsOffer');
Route::get('/best-travels-external', 'TravelController@getBestTravelsExternal');

/*********************************************************************************/

// travels page
Route::get('/search', 'TravelController@search');

Route::get('/min-max-price-travels', 'TravelController@getMinMaxPrice');
Route::get('/umrah-dates', 'TravelController@umrahDates');


Route::get('/get-travels-by-category', 'TravelController@getByCategory');
Route::get('/travel', 'TravelController@show');
Route::get('/travels-others', 'TravelController@others');


/*********************************************************************************/

// hotels

Route::get('/hotels', 'HotelController@index');
Route::get('/hotel', 'HotelController@show');
Route::get('/hotels-others', 'HotelController@others');

/*********************************************************************************/

// images

Route::get('/images-by-category', 'ImageController@imagesByCategory');

/*********************************************************************************/

// blogs

Route::get('/blogs', 'BlogController@index');
Route::get('/blog', 'BlogController@show');

/*********************************************************************************/





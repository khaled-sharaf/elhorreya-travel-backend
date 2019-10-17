<?php

use Illuminate\Http\Request;


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


/**************** settings *****************/

// get all settings
Route::get('/settings', 'SettingController@getSettings');

/*********************************************************************************/


/**************** global *****************/
Route::get('/menu', 'TravelProgramController@getMenu');
Route::get('/hotels-address', 'HotelController@getAddressAll');

/****************************************/
Route::get('/search', 'TravelController@search');

/*********************************************************************************/




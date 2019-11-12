<?php


// here all routes control panel

Route::group(['prefix' => env('CP_PREFIX')], function () {
    Route::redirect('/', url('/home'));
    Auth::routes(['register' => false]);

    Route::get('/{path?}', 'Admin\HomeController@index')->where('path', '.*');
});


Route::get('/home', 'HomeController@index')->name('home');


/**************** mailing_list *****************/
// store
Route::get('/mailing_list/subscribe/{token}', 'API\MailingListController@store');
// destroy
Route::get('/mailing_list/unsubscribe/{token}', 'API\MailingListController@destroy');



// change language form this link -- method (get)
// Route::get('lang/{lang}', 'LangController@lang')->name('lang');
/**********************************************************************************/

// use App\User;
// use App\Hotel;
// use App\ProductType;
// use App\Winner;
// use App\Travel;

Route::view('/{path?}', 'welcome')->where('path', '.*');

// Route::get('/', function () {
    // $travels = Travel::where('travel_category_id', 5)->get();
    // $travels = convert_column_to_array($travels, 'gallery');
    // dd($travels->count());
// });

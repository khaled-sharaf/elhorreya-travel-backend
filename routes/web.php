<?php


Route::group(['prefix' => env('CP_PREFIX')], function () {
    Route::redirect('/', url(env('CP_PREFIX') . '/dashboard'));
    Auth::routes(['register' => false]);
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
use App\Travel;


Route::get('/', function () {
    // $travel = Travel::find(12);
    // return view('emails.mail-travel')->with('travel', $travel);
    return view('welcome');


    // $pro = Pro::find(3)->comments()->with('user')->get();
    // $pro = Pro::find(3)->with('rates')->get();
    // $pro = Company::with(['products', 'rates'])->get();
    // $pro = ProductType::with('products')->get();
    // $pro = ProductDetails::with(['products', 'productType'])->get();
    // $pro = Winner::get();

    // dd(City::find(5)->city_name, City::find(5)->governorate->governorate_name);

    // \Image::make('C:\xampp\htdocs\Belal\xorpin-backend\public\images\camera.png')
    //         ->resize(100, 100)
    //         ->save('C:\xampp\htdocs\Belal\xorpin-backend\public\images\camera1.png');


});

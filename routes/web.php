<?php

use Illuminate\Support\Facades\Route;

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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
 
// Route::get('/section', '\App\Http\Controllers\SectionController@tester');


// Route::get('/style', '\App\Http\Controllers\copyController@style');
// Route::get('/sector', '\App\Http\Controllers\SectorController@tester');
Route::get('/',function () {
    return view('face');
})->name('page')->middleware('auth');

Route::get('start',function () {
    return view('start');
})->middleware('auth');

 
 //Route::post('/convert', '\App\Http\Controllers\InterFaceController@rabie')->name('convert');


 Route::post('/new', '\App\Http\Controllers\RabieController@rabie')->name('convert');

 //Route::post('/convert', '\App\Http\Controllers\RabieController@rabie')->name('convert');

// Route::get('/home', 'HomeController@index')->name('home');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/mokahome', 'HomeController@mokaindex')->name('home');
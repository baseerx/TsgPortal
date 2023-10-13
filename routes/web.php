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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/lec_reports/{lecid}',function (){
    return view('lectureReports');
});
Route::get('/res_reports/{cid}',function (){
    return view('trainingReports');
});
Route::get('/answersheet_reports/{cid}',function (){
    return view('answerSheet');
});
Route::get('/position_holders/{cid}',function (){
    return view('position_holders');
});
Route::get('/feedback_reports/{fid}',function (){
    return view('feedback_report');
});
Route::get('/feedback_detail/{fbid}',function (){
    return view('feedbacktext');
});
Route::get('/hrisCheck', 'HomeController@checkHris')->name('chr');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/reset_password', '\App\Http\Controllers\Auth\ResetPasswordController@CheckToken');
Route::post('/update_password', '\App\Http\Controllers\Auth\ResetPasswordController@UpdatePassword');
Route::get('/{any}/{id}', function ()
{
   return redirect('home');
});
Route::get('/logdata', 'HomeController@index')->name('home');
Route::get('/{any}', 'HomeController@index')->name('home');



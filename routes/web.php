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
    return view('welcome');
});


Route::get('/user/register/', function (){return view('register');});
Route::get('/user/friends/', function (){return view('friends');});
Route::get('/user/messages/', function (){return view('messages');});
Route::get('/admin/', function (){return view('admin');});
Route::get('/group/groups/', function (){return view('groups');});
Route::get('/group/group/', function (){return view('group');});
Route::get('/list/grouplists/', function (){return view('grouplists');});
Route::get('/list/userlists/', function (){return view('userlists');});
Route::get('/list/list/', function (){return view('list');});
Route::get('/list/teams/', function (){return view('listteams');});
Route::get('/list/users/', function (){return view('listusers');});

Route::get('/user_manager/',  'UserManagerCon@request_get');
Route::get('/component_manager/',  'CompManagerCon@request_get');
Route::get('/Listings_manager/', 'API\ListingsController@request_get');

Route::resource('/test', 'TestController');

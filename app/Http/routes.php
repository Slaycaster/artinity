<?php

header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('api/tests', 'Api\Test');

Route::group(['prefix' => 'api'], function(){

	Route::group(['prefix' => 'v1'], function(){

		Route::group(['prefix' => 'collabs'], function(){

			Route::post('{id}/members', 'Api\v1\CollabController@addMember');
			Route::get('{id}/members', 'Api\v1\CollabController@getMember');

		});

		Route::resource('collabs', 'Api\v1\CollabController');
		Route::resource('users', 'Api\v1\UserController');

		Route::group(['prefix' => 'groups'], function(){
			Route::get('{id}/members', 'Api\v1\GroupController@getMembers');
		});

		Route::resource('groups', 'Api\v1\GroupController');

		Route::post('auth/login', 'Api\v1\LoginController@login');

	});

});

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
			Route::get('{id}/requests', 'Api\v1\CollabController@getRequests');

			Route::post('{collabId}/posts/users/{userId}', 'Api\v1\PostController@savePost');
			Route::get('{collabId}/posts', 'Api\v1\PostController@getAllPost');
			Route::post('{collabId}/posts/{postId}/comments/users/{userId}', 'Api\v1\CommentController@saveComment');
			Route::get('{collabId}/posts/{postId}/comments', 'Api\v1\CommentController@getAllComment');

		});

		Route::group(['prefix' => 'users'], function(){

			Route::get('{userId}/collabs', 'Api\v1\UserController@getAllUserCollab');

			Route::post('{senderId}/invites/{receiverId}', 'Api\v1\InviteController@inviteCollabUserToUser');
			Route::post('{senderId}/invites/groups/{groupId}', 'Api\v1\InviteController@inviteCollabUserToGroup');

			Route::get('{userId}/invites', 'Api\v1\InviteController@getAllInvites');
			Route::get('{userId}/invites/{requestId}', 'Api\v1\InviteController@getInvite');
			Route::post('{userId}/invites/{requestId}/accept', 'Api\v1\InviteController@acceptInvite');

			Route::get('{userId}/requests', 'Api\v1\RequestController@getAllRequests');
			Route::get('{userId}/requests/{requestId}', 'Api\v1\RequestController@getRequest');
			Route::post('{senderId}/requests/{receiverId}', 'Api\v1\RequestController@requestCollabUserToUser');
			Route::post('{senderId}/requests/groups/{groupId}', 'Api\v1\RequestController@requestCollabUserToGroup');
			Route::post('{userId}/requests/{requestId}/accept', 'Api\v1\RequestController@acceptRequest');

		});

		Route::resource('collabs', 'Api\v1\CollabController');
		Route::resource('users', 'Api\v1\UserController');

		Route::group(['prefix' => 'groups'], function(){

			Route::get('{id}/members', 'Api\v1\GroupController@getMembers');
			Route::post('{id}/members/', 'Api\v1\GroupController@addMembers');
			Route::delete('{id}/members/', 'Api\v1\GroupController@deleteMembers');

			Route::get('{groupId}/invites', 'Api\v1\InviteController@getAllGroupInvites');
			Route::get('{groupId}/invites/{requestId}', 'Api\v1\InviteController@getGroupInvite');
			Route::post('{groupId}/invites/{requestId}/accept', 'Api\v1\InviteController@acceptGroupInvite');
			Route::post('{groupId}/invites/users/{userId}', 'Api\v1\InviteController@inviteCollabGroupToUser');
			Route::post('{senderId}/invites/{receiverId}', 'Api\v1\InviteController@inviteCollabGroupToGroup');

			Route::get('{groupId}/requests', 'Api\v1\RequestController@getAllGroupRequests');
			Route::get('{groupId}/requests/{requestId}', 'Api\v1\RequestController@getGroupRequest');
			Route::post('{groupId}/requests/users/{userId}', 'Api\v1\RequestController@requestCollabGroupToUser');
			Route::post('{senderId}/requests/{receiverId}', 'Api\v1\RequestController@requestCollabGroupToGroup');
			Route::post('{groupId}/requests/{requestId}/accept', 'Api\v1\RequestController@acceptGroupRequest');

		});

		Route::resource('groups', 'Api\v1\GroupController');

		Route::post('auth/login', 'Api\v1\LoginController@login');

	});

});

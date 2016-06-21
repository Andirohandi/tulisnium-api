<?php

Route::group(['prefix' => 'API'], function() {
	
	//alll about user
	Route::get('/USER/GET', 'UserController@getData');
	Route::get('/USER/GET/ID/{id}', 'UserController@getDataById');
	Route::post('/USER/ADD', 'UserController@getInsert');
	Route::post('/USER/EDIT', 'UserController@getUpdate');
	Route::post('/USER/DELETE', 'UserController@getDelete');
	
	// all about post
	Route::get('/POST/GET', 'PostController@getData');
	Route::get('/POST/GET/ID/{id}', 'PostController@getDataById');
	Route::post('/POST/ADD', 'PostController@getInsert');
	Route::post('/POST/EDIT', 'PostController@getUpdate');
	Route::post('/POST/DELETE', 'PostController@getDelete');
	
	// all about tags
	Route::get('/TAG/GET', 'TagController@getData');
	Route::get('/TAG/GET/ID/{id}', 'TagController@getDataById');
	Route::post('/TAG/ADD', 'TagController@getInsert');
	Route::post('/TAG/EDIT', 'TagController@getUpdate');
	Route::post('/TAG/DELETE', 'TagController@getDelete');
	
	//all about comments
	Route::get('/COMMENT/GET', 'CommentController@getData');
	Route::get('/COMMENT/GET/ID/{id}', 'CommentController@getDataById');
	Route::post('/COMMENT/ADD', 'CommentController@getInsert');
	Route::post('/COMMENT/EDIT', 'CommentController@getUpdate');
	Route::post('/COMMENT/DELETE', 'CommentController@getDelete');
	
	//all about notifier
	Route::get('/NOTIFIER/GET', 'NotifierController@getData');
	Route::get('/NOTIFIER/GET/ID/{id}', 'NotifierController@getDataById');
	Route::post('/NOTIFIER/ADD', 'NotifierController@getInsert');
	Route::post('/NOTIFIER/DELETE', 'NotifierController@getDelete');
	
	//all about notif
	Route::get('/NOTIF/GET', 'NotifController@getData');
	Route::get('/NOTIF/GET/ID/{id}', 'NotifController@getDataById');
	Route::post('/NOTIF/ADD', 'NotifController@getInsert');
	Route::post('/NOTIF/EDIT', 'NotifController@getUpdate');
	Route::post('/NOTIF/DELETE', 'NotifController@getDelete');
	
});
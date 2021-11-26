<?php

Route::group(['middleware' => ['api'], 'prefix' => 'auth'], function ($router) {
  Route::post('login', 'AuthController@login');
  Route::post('logout', 'AuthController@logout');
  Route::post('refresh', 'AuthController@refresh');
  Route::post('user', 'AuthController@me');
});

Route::group(['prefix' => 'users'], function () {
  Route::get('/', 'UserController@index');
  Route::get('/{id}', 'UserController@show');
  Route::post('/', 'UserController@create');
  Route::put('/{id}', 'UserController@update');
  Route::delete('/{id}', 'UserController@delete');
});

Route::group(['prefix' => 'roles'], function () {
  Route::get('/', 'RoleController@index');
  Route::get('/filter', 'RoleController@filter');
  Route::post('/', 'RoleController@create');
  Route::put('/{id}', 'RoleController@update');
  Route::delete('/{id}', 'RoleController@delete');

});

Route::group(['prefix' => 'permissions'], function () {
  Route::get('/', 'PermissionController@index');
  Route::get('/filter', 'PermissionController@filter');
  Route::post('/', 'PermissionController@create');
  Route::put('/{id}', 'PermissionController@update');
  Route::delete('/{id}', 'PermissionController@delete');
});
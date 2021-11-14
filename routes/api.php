<?php

Route::group(['middleware' => ['api'], 'prefix' => 'auth'], function ($router) {
  Route::post('login', 'AuthController@login');
  Route::post('logout', 'AuthController@logout');
  Route::post('refresh', 'AuthController@refresh');
  Route::post('user', 'AuthController@me');
});

Route::group(['prefix' => 'roles'], function () {
  Route::get('/', 'RoleController@index');
  Route::post('/', 'RoleController@create');
  Route::put('/{id}', 'RoleController@update');
  Route::delete('/{id}', 'RoleController@delete');
});
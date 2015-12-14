<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	if( ! Auth::check()) {
		return Redirect::to('auth/login');
	} else {
		return Redirect::to('contacts');
	}
});

Route::get('auth/register', 'AuthController@create');
Route::post('auth/register', 'AuthController@store');
Route::get('auth/login', 'AuthController@index');
Route::post('auth/login', 'AuthController@login');
Route::get('auth/facebook', 'AuthController@facebook');
Route::get('auth/github', 'AuthController@github');

Route::group(['before' => 'auth'], function()
{
	Route::get('contacts', 'ContactsController@index');
	Route::post('contacts', 'ContactsController@store');
	Route::get('contacts/table', 'ContactsController@table');
	Route::get('contacts/search', 'ContactsController@search');
	Route::get('contacts/{id}', 'ContactsController@fieldData');
	Route::put('contacts/{id}', 'ContactsController@update');
	Route::delete('contacts/{id}', 'ContactsController@destroy');

	Route::get('auth/logout', 'AuthController@logout');
});
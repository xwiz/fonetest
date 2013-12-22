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

Route::get('/', 'HomeController@landing');
Route::get('xhr', function()
{
    return View::make('pages.xhr');
});
Route::get('login/fb', 'UserController@loginWithFacebook');
Route::get('login/google', 'UserController@loginWithGoogle');
Route::get('home', 'HomeController@landing');
Route::get('contacts', 'ContactsController@home');
Route::get('contacts/view', 'ContactsController@home');
Route::get('contacts/groups', 'ContactsController@groups');
Route::get('contacts/import', 'ContactsController@import');
Route::get('contacts/groups', 'ContactsController@groups');
Route::post('contacts/upload', array('uses' => 'ContactsController@upload', 'as' => 'contacts.upload'));
Route::post('contacts/save', array('uses' => 'ContactsController@save', 'as' => 'contacts.save'));
Route::get('user/register', 'UserController@register');
Route::post('user/create', 'UserController@create');
Route::post('user/login', 'UserController@login');
Route::get('user/welcome', function()
{
    return View::make('user.welcome');
});
Route::get('user/dashboard', 'UserController@dashboard');
Route::get('user/profile', 'UserController@profile');
Route::post('user/update', 'UserController@profileUpdate');
Route::post('user/save', array('uses' => 'UserController@save', 'as' => 'user.save'));
Route::get('user/logout', 'UserController@logout');
Route::get('notes', 'NotesController@home');
Route::get('notes/create', 'NotesController@create');
Route::get('notes/quick', 'NotesController@quickNote');
Route::post('notes/upload', array('uses' => 'NotesController@upload', 'as' => 'notes.upload'));
Route::get('notes/view', 'NotesController@drafts');
Route::get('notes/sent', 'NotesController@sent');
Route::get('billing', 'BillingController@index');
Route::get('password/reset', array(
  'uses' => 'PasswordController@remind',
  'as' => 'password.remind'
));
Route::post('password/reset', array(
  'uses' => 'PasswordController@request',
  'as' => 'password.request'
));
Route::get('password/reset/{token}', array(
  'uses' => 'PasswordController@reset',
  'as' => 'password.reset'
));
Route::post('password/reset/{token}', array(
  'uses' => 'PasswordController@update',
  'as' => 'password.update'
));
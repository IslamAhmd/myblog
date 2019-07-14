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


// pages
Route::get('/', 'PagesController@index')->name('indexpage');
Route::get('/about', 'PagesController@about')->name('aboutpage');
Route::get('/contact', 'PagesController@contact')->name('contactpage');
Route::post('/dosend', 'PagesController@dosend');

// posts
Route::resource('posts', 'PostsController');


//comments
Route::post('/comments/{slug}', 'CommentsController@store')->name('comments.store');

// tags
Route::resource('tags', 'TagsController')->only(['show']);

// auth
Auth::routes();

Route::get('user/verify/{token}', 'Auth\RegisterController@verifyEmail');


Route::get('/home', 'HomeController@index')->name('home');

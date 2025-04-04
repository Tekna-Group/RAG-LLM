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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/post', 'DocumentController@create');   // Show the form
Route::post('/post', 'DocumentController@store')->name('document.store');   // Handle the form submission
Route::get('/chat', 'DocumentController@chat')->name('chat'); ; // Show chat interface
Route::post('/generate', 'DocumentController@generateResponse')->name('generateResponse');
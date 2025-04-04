<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\DocumentController;
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/documents', 'DocumentController@store');   // Handle the form submission
Route::get('/search', [DocumentController::class, 'retrieve']);
Route::post('/generate', [DocumentController::class, 'generateResponse']);

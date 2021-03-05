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

//Cargar Clase pera Middleware
use App\Http\Middleware\ApiAuthMiddleware;

Route::get('/', function () {
    return view('welcome');
});

//MailController
Route::get('/api/v1/usuarios', 'UserController@index');
Route::post('/api/v1/login','UserController@login');


Route::get('/api/v1/usuario/{id}', 'UserController@detail');

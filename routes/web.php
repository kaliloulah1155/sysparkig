<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\HomeController;

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
 App::setLocale('fr');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/template', function () {
    //return view('welcome');
    return view('layouts.template');
})->name('template');

Route::view('cajones','cajones');
Route::view('tipos','tipos');
Route::view('cajas','cajas');
Route::view('tarifas','tarifas');
Route::view('empresas','empresas');
Route::view('usuarios','usuarios');
 Route::view('rentas','rentas');

Auth::routes();
      
Route::get('/home', 'HomeController@index')->name('home');

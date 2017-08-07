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

Route::get('/', function () {
    return view('home');
});
Route::get('about',function(){
   return "Sistema de Gestão Educacional. Todos direitos reservados";
});

//------------------------------ Login 
Route::get('login',function(){
   return view('login');
});
Route::post('login_check', 'pessoaController@loginCheck');
Route::get('logout', 'pessoaController@logout');
//----------------------------- Errors treatment


Route::get('404',function(){
   return view('error-404');
});
Route::get('500',function(){
   return view('error-500');
});

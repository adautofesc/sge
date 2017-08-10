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

Route::get('/', 'painelController@index');


Route::get('addpessoa','pessoaController@adicionaPrimeiro');
Route::get('addacesso','loginController@addPrimeiro');

Route::get('/pessoa/cadastrar', 'GerenciadorAcesso@cadastrarPessoa');

//------------------------------ Login 
Route::get('login', 'loginController@login');
Route::post('loginCheck', 'loginController@loginCheck');
Route::get('loginCheck', 'loginController@logout');
Route::get('esqueciasenha', 'loginController@viewPwdRescue');
Route::get('logout','loginController@logout');
Route::post('recuperaSenha','loginController@pwdRescue');
Route::get('recuperaSenha','loginController@viewPwdRescue');
//----------------------------- Errors treatment


Route::get('404',function(){
   return view('error-404');
});
Route::get('500',function(){
   return view('error-500');
});
Route::get('about',function(){
   return "Sistema de Gestão Educacional. Todos direitos reservados";
});
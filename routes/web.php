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
Route::get('home', 'painelController@index');


Route::get('addpessoa','pessoaController@adicionaPrimeiro');
Route::get('addacesso','loginController@addPrimeiro');


Route::get ('/pessoa/cadastrar', 'PessoaController@mostraFormularioAdicionar');
Route::post('/pessoa/cadastrar','PessoaController@gravarPessoa');
Route::get ('/pessoa/mostrar/','PessoaController@listarTodos');
Route::get ('/pessoa/mostrar/{var}','PessoaController@mostrar');
Route::get('/pessoa/listar','PessoaController@listarTodos');




// procura pessoas na lista
Route::post('pessoa/listar','PessoaController@procurarPessoa');

Route::get('secretaria/atender','PessoaController@iniciarAtendimento');
Route::get('secretaria/atender/{var}','PessoaController@atender');
Route::get('pessoa/buscarapida/{var}','PessoaController@liveSearchPessoa');


Route::get('/trocarminhasenha','loginController@trocarMinhaSenha_view');
Route::post('/trocarminhasenha','loginController@trocarMinhaSenha_exec');

Route::get('/pessoa/cadastraracesso/{var}','loginController@cadastrarAcesso_view');
Route::post('/pessoa/cadastraracesso/{var}','loginController@cadastrarAcesso_exec');

Route::get('/pessoa/trocarsenha/{var}','loginController@trocarSenhaUsuario_view');
Route::post('/pessoa/trocarsenha/{var}','loginController@trocarSenhaUsuario_exec');

Route::get('/admin/listarusuarios', 'loginController@listarUsuarios');
Route::get('/admin/listarusuarios/{var}', 'loginController@listarUsuarios');
Route::post('/admin/listarusuarios/{var}', 'loginController@listarUsuarios_action');




//------------------------------ Login 
Route::get('login', 'loginController@login');
Route::post('loginCheck', 'loginController@loginCheck');
Route::get('loginCheck', 'loginController@logout');
Route::get('esqueciasenha', 'loginController@viewPwdRescue');
Route::get('logout','loginController@logout');
Route::post('recuperaSenha','loginController@pwdRescue');
Route::get('recuperaSenha','loginController@viewPwdRescue');
//----------------------------- Errors treatment

Route::get('403',function(){
   return view('error-403');
});
Route::get('404',function(){
   return view('error-404');
});
Route::get('500',function(){
   return view('error-500');
});
Route::get('about',function(){
   return "Sistema de Gestão Educacional. Todos direitos reservados";
});
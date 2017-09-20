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



// Pessoas
Route::post('pessoa/listar','PessoaController@procurarPessoa');
Route::get ('/pessoa/cadastrar', 'PessoaController@mostraFormularioAdicionar');
Route::post('/pessoa/cadastrar','PessoaController@gravarPessoa');
Route::get ('/pessoa/mostrar/','PessoaController@listarTodos');
Route::get ('/pessoa/mostrar/{var}','PessoaController@mostrar');
Route::get('/pessoa/listar','PessoaController@listarTodos');
Route::get('/pessoa/editar/geral/{var}','PessoaController@editarGeral_view');
Route::post('/pessoa/editar/geral/{var}','PessoaController@editarGeral_exec');
Route::get('/pessoa/editar/contato/{var}','PessoaController@editarContato_view');
Route::post('/pessoa/editar/contato/{var}','PessoaController@editarContato_exec');
Route::get('/pessoa/editar/dadosclinicos/{var}','PessoaController@editarDadosClinicos_view');
Route::post('/pessoa/editar/dadosclinicos/{var}','PessoaController@editarDadosClinicos_exec');
Route::get('/pessoa/editar/observacoes/{var}','PessoaController@editarObservacoes_view');
Route::post('/pessoa/editar/observacoes/{var}','PessoaController@editarObservacoes_exec');




	//dependentes
Route::get('/pessoa/adicionardependente/{var}','PessoaController@addDependente_view');
Route::post('/pessoa/adicionardependente/{var}','PessoaController@addDependente_exec');
Route::get('/pessoa/removerdependente/{var}','PessoaController@remDependente_exec');
Route::get('/pessoa/adicionarresponsavel/{var}','PessoaController@addResponsavel_view');
Route::post('/pessoa/adicionarresponsavel/{var}','PessoaController@addResponsavel_exec');
Route::get('/pessoa/removerdependente/{var}','PessoaController@remResponsavel_exec');
Route::get('/pessoa/buscarendereco/{var}','PessoaController@buscarEndereco');




// Secretaria
Route::get('secretaria','painelController@secretaria');
Route::get('secretaria/atender','PessoaController@iniciarAtendimento');
Route::get('secretaria/atender/{var}','PessoaController@atender');
Route::get('pessoa/buscarapida/{var}','PessoaController@liveSearchPessoa');

// Administrativo
Route::get('administrativo','painelController@administrativo');

// Financeiro
Route::get('financeiro','painelController@financeiro');

// Gestão Pessoal
Route::get('gestaopessoal','painelController@gestaoPessoal');
Route::get('gestaopessoal/atendimento','painelController@atendimentoPessoal');
Route::get('gestaopessoal/atender/{var}','painelController@atendimentoPessoalPara');
Route::get('gestaopessoal/relacaoinstitucional/{var}','PessoaController@relacaoInstitucional_view');
Route::post('gestaopessoal/relacaoinstitucional/{var}','PessoaController@relacaoInstitucional_exec');

// Jurídico
Route::get('juridico','painelController@juridico');


//Pedagógico
Route::get('pedagogico','painelController@pedagogico');
Route::get('docentes','painelController@docentes');
	//Cursos
Route::get('pedagogico/cursos','CursoController@index');
Route::get('pedagogico/cadastrarcurso','CursoController@create');
Route::post('pedagogico/cadastrarcurso','CursoController@store');
Route::get('pedagogico/editarcurso/{var}','CursoController@edit');
Route::post('pedagogico/editarcurso/{var}','CursoController@update');
Route::get('pedagogico/apagarcurso','CursoController@destroy');
Route::get('pedagogico/curso/{var}','CursoController@show');
Route::get('pedagogico/disciplinasdocurso/{var}','DisciplinaController@editDisciplinasAoCurso');
Route::post('pedagogico/disciplinasdocurso/{var}','DisciplinaController@storeDisciplinasAoCurso');
	//Disciplinas
Route::get('pedagogico/disciplinas','DisciplinaController@index');
Route::get('pedagogico/cadastrardisciplina','DisciplinaController@create');
Route::post('pedagogico/cadastrardisciplina','DisciplinaController@store');
Route::get('pedagogico/editardisciplina/{var}','DisciplinaController@edit');
Route::post('pedagogico/editardisciplina/{var}','DisciplinaController@update');
Route::get('pedagogico/apagardisciplina','DisciplinaController@destroy');
	//Requisitos
Route::get('pedagogico/cursos/requisitos','RequisitosController@index');
Route::get('pedagogico/cursos/requisitos/add','RequisitosController@create');
Route::post('pedagogico/cursos/requisitos/add','RequisitosController@store');
Route::get('pedagogico/cursos/requisitos/apagar/{itens}','RequisitosController@destroy');
Route::get('pedagogico/requisitosdocurso/{var}','RequisitosController@editRequisitosAoCurso');
Route::post('pedagogico/requisitosdocurso/{var}','RequisitosController@storeRequisitosAoCurso');



// Login & Acesso
Route::get('/gestaopessoal/credenciais/{var}', 'loginController@credenciais_view');
Route::post('/gestaopessoal/credenciais/{var}', 'loginController@credenciais_exec');
Route::get('/admin/listarusuarios', 'loginController@listarUsuarios_view');
Route::get('/admin/listarusuarios/{var}', 'loginController@listarUsuarios_view');
Route::post('/admin/listarusuarios/{var}', 'loginController@listarUsuarios_action');
Route::get('/admin/alterar/{acao}/{itens}', 'loginController@alterar');
Route::get('/trocarminhasenha','loginController@trocarMinhaSenha_view');
Route::post('/trocarminhasenha','loginController@trocarMinhaSenha_exec');
Route::get('/pessoa/cadastraracesso/{var}','loginController@cadastrarAcesso_view');
Route::post('/pessoa/cadastraracesso/{var}','loginController@cadastrarAcesso_exec');
Route::get('/pessoa/trocarsenha/{var}','loginController@trocarSenhaUsuario_view');
Route::post('/pessoa/trocarsenha/{var}','loginController@trocarSenhaUsuario_exec');
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
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
Route::get('login', 'loginController@login')->name('login');
Route::get('loginSaved', 'loginController@loginSaved')->name('loginSaved');
Route::get('recuperarconta/{var}','loginController@recuperarConta');
Route::post('loginCheck', 'loginController@loginCheck');
Route::get('loginCheck', 'loginController@logout');
Route::get('esqueciasenha', 'loginController@viewPwdRescue');
Route::get('logout','loginController@logout');
Route::post('recuperaSenha','loginController@pwdRescue');
Route::get('recuperaSenha','loginController@viewPwdRescue');




Route::middleware('login') ->group(function(){
	Route::get('home', 'painelController@index');
	Route::prefix('pessoa')->group(function(){
	// Pessoas
		Route::get ('listar','PessoaController@listarTodos');//->middleware('autorizar:56')
		Route::post('listar','PessoaController@procurarPessoa');
		Route::get ('cadastrar', 'PessoaController@create')->name('pessoa.cadastrar');
		Route::post('cadastrar','PessoaController@gravarPessoa');
		Route::get ('mostrar','PessoaController@listarTodos');//->middleware(['autorizar:56', 'privacy'])
		Route::get ('mostrar/{var}','PessoaController@mostrar');
		Route::get('buscarapida/{var}','PessoaController@liveSearchPessoa');
		//dependentes
		Route::get('adicionardependente/{var}','PessoaController@addDependente_view');
		Route::get('gravardependente/{pessoa}/{dependente}','PessoaController@addDependente_exec');
		Route::get('removervinculo/{var}','PessoaController@remVinculo_exec');
		Route::get('adicionarresponsavel/{var}','PessoaController@addResponsavel_view');
		Route::post('adicionarresponsavel/{var}','PessoaController@addResponsavel_exec');
		Route::get('removerdependente/{var}','PessoaController@remResponsavel_exec');
		Route::get('buscarendereco/{var}','PessoaController@buscarEndereco');
		// Editar dados das pessoas
		Route::prefix('editar')->group(function(){
			Route::get('geral/{var}','PessoaController@editarGeral_view');
			Route::post('geral/{var}','PessoaController@editarGeral_exec');
			Route::get('contato/{var}','PessoaController@editarContato_view');
			Route::post('contato/{var}','PessoaController@editarContato_exec');
			Route::get('dadosclinicos/{var}','PessoaController@editarDadosClinicos_view');
			Route::post('dadosclinicos/{var}','PessoaController@editarDadosClinicos_exec');
			Route::get('observacoes/{var}','PessoaController@editarObservacoes_view');
			Route::post('observacoes/{var}','PessoaController@editarObservacoes_exec');
		});//prfix editar
	});


	

	// Administrativo
	Route::get('administrativo','painelController@administrativo');
	Route::get('administrativo/salasdaunidade/{var}','painelController@salasDaUnidade');


	// Financeiro
	Route::get('financeiro','painelController@financeiro');

	// Gestão Pessoal
	Route::get('gestaopessoal','painelController@gestaoPessoal');
	Route::get('gestaopessoal/atendimento','painelController@atendimentoPessoal');
	Route::get('gestaopessoal/atender/{var}','painelController@atendimentoPessoalPara');
	Route::get('gestaopessoal/relacaoinstitucional/{var}','PessoaController@relacaoInstitucional_view');
	Route::post('gestaopessoal/relacaoinstitucional/{var}','PessoaController@relacaoInstitucional_exec');

	// Jurídico
	Route::prefix('juridico')->group(function(){
		Route::get('/','painelController@juridico');
		//Documentos
		Route::prefix('documentos')->group(function(){
			Route::get('/','DocumentoController@index');
			Route::get('cadastrar','DocumentoController@cadastrar');

		});

	});


	//Pedagógico
	Route::prefix('pedagogico')->group(function(){
		Route::get('/','painelController@pedagogico');
		//Turmas
		Route::prefix('turmas')->group(function(){
			Route::get('cadastrar','TurmaController@create')->name('turma.cadastrar');
			Route::post('cadastrar','TurmaController@store');
			Route::get('/','TurmaController@index')->name('turmas');
			Route::get('listar','TurmaController@index');
			Route::get('apagar/{var}','TurmaController@destroy');
			Route::get('editar/{var}','TurmaController@edit');
			Route::post('editar/{var}','TurmaController@update');
			Route::get('status/{status}/{turma}','TurmaController@status');
		});
	});

	// Secretaria
	Route::prefix('secretaria')->group(function(){
		
		Route::get('/','painelController@secretaria')->name('secretaria');
		Route::get('pre-atendimento','SecretariaController@iniciarAtendimento');
		Route::get('atendimento','SecretariaController@atender');
		Route::get('atender','SecretariaController@atender')->name('secretaria.atender');
		Route::get('atender/{var}','SecretariaController@atender');
		Route::get('turmas', 'TurmaController@listarSecretaria')->name('secretaria.turmas');
		Route::get('turmas-disponiveis/{turmas}/{filtros}', 'TurmaController@turmasDisponiveis');
		Route::get('turmas-escolhidas/{turmas}/', 'TurmaController@turmasEscolhidas');

		Route::prefix('matricula')->group(function(){
			Route::get('/nova','MatriculaController@novaMatricula');
			Route::get('/confirmacao', function(){ return redirect(asset('/secretaria/atender')); });
			Route::post('/confirmacao', 'MatriculaController@confirmacaoAtividades');
			Route::post('gravar', 'MatriculaController@gravar');
		});



	});
	Route::get('docentes','painelController@docentes');
		//Cursos
	Route::get('pedagogico/cursos','CursoController@index');
	Route::get('pedagogico/cursos/listarporprogramajs/{var}','CursoController@listarPorPrograma');
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
});//end middleware login



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
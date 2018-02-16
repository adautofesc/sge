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

//temporárias
Route::get('/turmascursosnavka', 'painelController@verTurmasAnterioresCursos');
Route::post('/turmascursosnavka', 'painelController@gravarMigracao');
Route::get('/turmasaulasnavka', 'painelController@verTurmasAnterioresAulas');
Route::get('cursos-disponiveis', 'TurmaController@turmasSite');
Route::get('vagas', 'TurmaController@turmasSite');
Route::get('turmas-professor', 'TurmaController@listarProfessores');
Route::post('turmas-professor', 'TurmaController@turmasProfessor');
Route::get('importarLocais','painelController@importarLocais');
Route::get('atualizar-inscritos','TurmaController@atualizarInscritos');
Route::get('inscricoes','InscricaoController@incricoesPorPosto');
//Route::get('revitaliza', 'MatriculaController@revitaliza');
//Route::get('auto-matriculas', 'MatriculaController@autoMatriculas');
//Route::get('recupera-inscricoes', 'InscricaoController@recuperarInscricoes');
//Route::get('importar-matriculas', 'MatriculaController@importarMatriculas');
Route::get('gerar-lancamentos/{parcela}', 'LancamentoController@gerarLancamentos');
Route::get('gerar-boletos', 'BoletoController@cadastrar');
Route::get('imprimir-boletos', 'BoletoController@imprimirLote');
Route::get('importar-bairros', 'EnderecoController@importarBairros');
Route::get('chamada', function(){ return view('pedagogico.turma.chamada');});




//Login
Route::get('login', 'loginController@login')->name('login');
Route::get('loginSaved', 'loginController@loginSaved')->name('loginSaved');
Route::get('recuperarconta/{var}','loginController@recuperarConta');
Route::post('loginCheck', 'loginController@loginCheck');
Route::get('loginCheck', 'loginController@logout');
Route::get('esqueciasenha', 'loginController@viewPwdRescue');
Route::get('logout','loginController@logout');
Route::post('recuperaSenha','loginController@pwdRescue');
Route::get('recuperaSenha','loginController@viewPwdRescue');






//Areas restritas para cadastrados
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
		Route::get('matriculas', 'MatriculaController@listarPorPessoa');
	});//prefix pessoa


	

	// Administrativo
	Route::get('administrativo','painelController@administrativo');
	Route::get('administrativo/salasdaunidade/{var}','painelController@salasDaUnidade');


	// Financeiro
	Route::prefix('financeiro')->group(function(){
		Route::get('/','painelController@financeiro');

		Route::get('boletos','BoletoController@gerar');

	});


	// Gestão Pessoal
	Route::get('gestaopessoal','painelController@atendimentoPessoal');
	Route::get('gestaopessoal/atendimento','painelController@gestaoPessoal');
	Route::get('gestaopessoal/atender/','painelController@atendimentoPessoalPara');
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
			Route::get('apagar/{var}','DocumentoController@apagar');
			Route::get('editar/{var}','DocumentoController@editar');
			Route::post('cadastrar','DocumentoController@store');

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
			Route::get('turmasjson','TurmaController@turmasJSON');
			Route::get('inscritos/{turma}','InscricaoController@verInscritos');


		});
		//Cursos
		Route::get('cursos','CursoController@index');
		Route::get('cursos/listarporprogramajs/{var}','CursoController@listarPorPrograma');
		Route::get('cadastrarcurso','CursoController@create');
		Route::post('cadastrarcurso','CursoController@store');
		Route::get('editarcurso/{var}','CursoController@edit');
		Route::post('editarcurso/{var}','CursoController@update');
		Route::get('apagarcurso','CursoController@destroy');
		Route::get('curso/{var}','CursoController@show');
		Route::get('disciplinasdocurso/{var}','DisciplinaController@editDisciplinasAoCurso');
		Route::post('disciplinasdocurso/{var}','DisciplinaController@storeDisciplinasAoCurso');
		Route::get('curso/disciplinas/{var}','DisciplinaController@disciplinasDoCurso');
		Route::get('curso/disciplinas/{curso}/{str}','DisciplinaController@disciplinasDoCurso');
		Route::get('curso/modulos/{var}','CursoController@qndeModulos');
			//Disciplinas
		Route::get('disciplinas','DisciplinaController@index');
		Route::get('cadastrardisciplina','DisciplinaController@create');
		Route::post('cadastrardisciplina','DisciplinaController@store');
		Route::get('pedagogico/editardisciplina/{var}','DisciplinaController@edit');
		Route::get('disciplina/mostrar/{var}','DisciplinaController@show');
		Route::post('editardisciplina/{var}','DisciplinaController@update');
		Route::get('apagardisciplina','DisciplinaController@destroy');
			//Requisitos
		Route::get('cursos/requisitos','RequisitosController@index');
		Route::get('cursos/requisitos/add','RequisitosController@create');
		Route::post('cursos/requisitos/add','RequisitosController@store');
		Route::get('cursos/requisitos/apagar/{itens}','RequisitosController@destroy');
		Route::get('requisitosdocurso/{var}','RequisitosController@editRequisitosAoCurso');
		Route::post('requisitosdocurso/{var}','RequisitosController@storeRequisitosAoCurso');
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
		Route::get('turma/{turma}', 'InscricaoController@verInscricoes');
		Route::post('turma/{turma}', 'InscricaoController@inscreverAlunoLote');


		Route::prefix('matricula')->group(function(){
			Route::get('/nova','InscricaoController@novaInscricao');
			Route::get('/confirmacao', function(){ return redirect(asset('/secretaria/atender')); });
			Route::post('/confirmacao', 'InscricaoController@confirmacaoAtividades');
			Route::post('gravar', 'MatriculaController@gravar');
			Route::get('termo/{id}','MatriculaController@termo');
			Route::get('editar/{id}', 'MatriculaController@editar');
			Route::post('editar/{id}','MatriculaController@update');
			Route::get('declaracao/{id}','MatriculaController@declaracao');
			Route::get('cancelar/{id}','MatriculaController@cancelarMatricula');
			Route::prefix('inscricao')->group(function(){
				Route::get('apagar/{id}', 'InscricaoController@apagar');
			});

		});





	});
	Route::get('docentes','painelController@docentes');
	

	
	




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
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

//testes / procedimentos temporários

Route::get('/bolsa/gerador', 'BolsaController@gerador');


Route::get('/corrigir-boletos','BoletoController@corrigirBoletosSemParcelas');


//Publicos

Route::get('cursos-disponiveis', 'TurmaController@turmasSite');
Route::get('vagas', 'TurmaController@turmasSite');

Route::get('meuboleto', function(){ return view('financeiro.boletos.meuboleto');});
Route::post('meuboleto', 'BoletoController@segundaVia');
Route::get('boleto/{id}','BoletoController@imprimir');



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
Route::get('/trocarminhasenha','loginController@trocarMinhaSenha_view');
Route::post('/trocarminhasenha','loginController@trocarMinhaSenha_exec');
Route::get('/pessoa/cadastraracesso/{var}','loginController@cadastrarAcesso_view');
Route::post('/pessoa/cadastraracesso/{var}','loginController@cadastrarAcesso_exec');
Route::get('/pessoa/trocarsenha/{var}','loginController@trocarSenhaUsuario_view');
Route::post('/pessoa/trocarsenha/{var}','loginController@trocarSenhaUsuario_exec');






//Areas restritas para cadastrados
Route::middleware('login') ->group(function(){
	Route::get('home', 'painelController@index');
	Route::get('recadastramento', function(){ return view('pessoa.recadastramento');});
	Route::post('recadastramento','PessoaController@iniciarRecadastramento');
	Route::post('recadastrado','PessoaController@gravarRecadastro');
	Route::get('buscarbairro/{var}','EnderecoController@buscarBairro');
	Route::get('/relatorios/alunos-concluintes','InscricaoController@relatorioConcluintes');
	Route::get('/relatorios/faixasuati', 'RelatorioController@matriculasUati');
	Route::get('/relatorios/alunos-posto', 'RelatorioController@alunosPorUnidade');
	Route::get('testar-classe', 'painelController@testarClasse');
	Route::post('testar-classe', 'painelController@testarClassePost');
	Route::get('lista/{id}','painelController@chamada'); //lista de chamada aberta
	Route::get('turma/{turma}', 'TurmaController@mostrarTurma');



	Route::prefix('pessoa')->group(function(){
	// Pessoas
		Route::get ('listar','PessoaController@listarTodos');//->middleware('autorizar:56')
		Route::post('listar','PessoaController@procurarPessoa');
		Route::get ('cadastrar', 'PessoaController@create')->name('pessoa.cadastrar');
		Route::post('cadastrar','PessoaController@gravarPessoa');
		Route::get ('mostrar','PessoaController@listarTodos');//->middleware(['autorizar:56', 'privacy'])
		Route::get ('mostrar/{var}','PessoaController@mostrar');
		Route::get('buscarapida/{var}','PessoaController@liveSearchPessoa');
		Route::get('apagar-atributo/{var}','PessoaController@apagarAtributo');
		Route::prefix('atestado')->group(function(){

			Route::get('cadastrar/{pessoa}','AtestadoController@novo');
			Route::post('cadastrar/{pessoa}','AtestadoController@create');
			Route::get('arquivar/{atestado}', 'AtestadoController@apagar');
			Route::get('editar/{atestado}', 'AtestadoController@editar');
			Route::post('editar/{atestado}', 'AtestadoController@update');
			Route::get('listar', 'AtestadoController@listar');

		});
		Route::middleware('liberar.recurso:18')->prefix('bolsa')->group(function(){ //criar novo código
			Route::get('cadastrar/{pessoa}','BolsaController@nova');
			Route::post('cadastrar/{pessoa}','BolsaController@gravar');
			Route::get('imprimir/{bolsa}','BolsaController@imprimir');
			Route::get('upload/{bolsa}','BolsaController@uploadForm');
			Route::post('upload/{bolsa}','BolsaController@uploadExec');
			Route::get('parecer/{bolsa}','BolsaController@uploadParecerForm');
			Route::post('parecer/{bolsa}','BolsaController@uploadParecerExec');


		});

		
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
			Route::get('geral/{id}','PessoaController@editarGeral_view');
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
	Route::middleware('liberar.recurso:12')->prefix('administrativo')->group(function(){
		Route::get('/','painelController@administrativo');
		Route::get('salasdaunidade/{var}','painelController@salasDaUnidade');
	});


	// Financeiro
	Route::middleware('liberar.recurso:14')->prefix('financeiro')->group(function(){
		Route::get('/','painelController@financeiro');

		Route::prefix('lancamentos')->group(function(){
			Route::get('home',  function(){ return view('financeiro.lancamentos.home'); });
			Route::get('listar-por-pessoa','LancamentoController@listarPorPessoa');
			Route::get('novo/{id}','LancamentoController@novo');
			Route::post('novo/{id}','LancamentoController@create');
			Route::get('gerar-individual/{pessoa}','LancamentoController@gerarLancamentosPorPessoa');
			Route::get('cancelar/{lancamento}','LancamentoController@cancelar');
			Route::get('excluir/{lancamento}', 'LancamentoController@excluir');
			Route::get('reativar/{lancamento}','LancamentoController@reativar');
			Route::get('relancar/{lancamento}','LancamentoController@relancarParcela');
			Route::get('editar/{lancamento}','LancamentoController@editar');
			Route::post('editar/{lancamento}','LancamentoController@update');
			Route::middleware('liberar.recurso:19')->get('gerar/{parcela}', 'LancamentoController@gerarLancamentos' );//gerar parcela para todas pessoas
		});

		Route::prefix('boletos')->group(function(){
			Route::middleware('liberar.recurso:19')->get('home',  function(){ return view('financeiro.boletos.home'); });
			Route::get('editar/{id}','BoletoController@editar');
			Route::post('editar/{id}','BoletoController@update');
			Route::get('imprimir/{id}','BoletoController@imprimir');

			Route::get('registrar/{id}','BoletoController@registrar');//registrar para o banco

			Route::get('listar-por-pessoa','BoletoController@listarPorPessoa');
			Route::get('cancelar/{id}','BoletoController@cancelar');
			Route::get('reativar/{id}','BoletoController@reativar');
			Route::get('gerar-individual/{pessoa}','BoletoController@cadastarIndividualmente');
			Route::get('gerar','BoletoController@gerar');
			Route::middleware('liberar.recurso:19')->get('gerar-boletos', 'BoletoController@cadastrar');//gerar boletos em lote para todos alunos
			Route::get('imprimir-lote', 'BoletoController@imprimirLote');
			Route::middleware('liberar.recurso:19')->get('confirmar-impressao', 'BoletoController@confirmarImpressao');//confirma impressao de todos boletos gravados
			Route::get('novo/{pesssoa}', 'BoletoController@novo');//precisa de middleware
			Route::post('novo/{pesssoa}', 'BoletoController@create');//precisa de middleware
			Route::get('/lote-csv', 'BoletoController@gerarArquivoCSV');

			

			Route::prefix('remessa')->group(function(){
				Route::get('home',  function(){ return view('financeiro.remessa.home'); });
				Route::get('gerar', 'BoletoController@gerarRemessa');//precisa de middleware
				Route::get('download/{file}', 'BoletoController@downloadRemessa');//precisa de middleware
				Route::get('listar-arquivos', 'BoletoController@listarRemessas');
			});


			Route::prefix('retorno')->group(function(){//precisa de middleware
				Route::get('home',  function(){ return view('financeiro.retorno.home'); });
				Route::get('upload',  function(){ return view('financeiro.retorno.upload'); });
				Route::post('upload',  'RetornoController@upload');
				Route::get('arquivos', 'RetornoController@listarRetornos');
				Route::get('analisar/{arquivo}','RetornoController@analisarArquivo');
				Route::get('processar/{arquivo}','RetornoController@processarArquivo');
				Route::get('reprocessar/{arquivo}','RetornoController@reProcessarArquivo');
				Route::get('marcar-processado/{arquivo}','RetornoController@marcarProcessado');
				Route::get('marcar-erro/{arquivo}','RetornoController@marcarErro');
				Route::get('com-erro','RetornoController@listarRetornosComErro');
				Route::get('processados','RetornoController@listarRetornosProcessados');


				//Route::post('processar/{arquivo}','RetornoController@processarRetornos');
				


			});

		});
		Route::prefix('relatorios')->group(function(){
				Route::get('boletos', 'BoletoController@relatorioBoletosAbertos');
				Route::get('/cobranca-xls', 'BoletoController@relatorioDevedoresXls');
				Route::get('/cobranca-sms', 'BoletoController@relatorioDevedoresSms');
			});


	});


	// Gestão Pessoal
	Route::middleware('liberar.recurso:15')->prefix('gestaopessoal')->group(function(){
		Route::get('/','painelController@atendimentoPessoal');
		Route::get('atendimento','painelController@gestaoPessoal');
		Route::get('atender/','painelController@atendimentoPessoalPara');
		Route::get('atender/{var}','painelController@atendimentoPessoalPara');
		Route::get('funcionarios','PessoaController@listarFuncionarios');
		Route::get('relacaoinstitucional/{var}','PessoaController@relacaoInstitucional_view');
		Route::post('relacaoinstitucional/{var}','PessoaController@relacaoInstitucional_exec');
	});

	// Jurídico
	Route::prefix('juridico')->group(function(){
		Route::get('/','painelController@juridico');
		//Documentos
		//
		Route::middleware('liberar.recurso:21')->prefix('bolsas')->group(function(){

			Route::get('liberacao','BolsaController@listar');
			Route::get('/status/{status}/{bolsas}','BolsaController@alterarStatus');
			Route::get('analisar/{bolsa}','BolsaController@analisar');
			Route::post('analisar/{bolsa}','BolsaController@gravarAnalise');

		});
		Route::middleware('liberar.recurso:16')->prefix('documentos')->group(function(){
			Route::get('/','DocumentoController@index');
			Route::get('cadastrar','DocumentoController@cadastrar');
			Route::get('apagar/{var}','DocumentoController@apagar');
			Route::get('editar/{var}','DocumentoController@editar');
			Route::post('cadastrar','DocumentoController@store');

		});

	});


	//Pedagógico
	Route::middleware('liberar.recurso:17')->prefix('pedagogico')->group(function(){
		Route::get('/','painelController@pedagogico');
		//Turmas
		Route::prefix('turmas')->group(function(){
			Route::get('cadastrar','TurmaController@create')->name('turmas.cadastrar');
			Route::post('cadastrar','TurmaController@store');
			Route::post('recadastrar','TurmaController@storeRecadastro');
			Route::get('/','TurmaController@index')->name('turmas');
			Route::post('/','TurmaController@acaolote');
			Route::get('listar','TurmaController@index');
			Route::get('apagar/{var}','TurmaController@destroy');
			Route::get('editar/{var}','TurmaController@edit');
			Route::post('editar/{var}','TurmaController@update');
			Route::get('status/{status}/{turma}','TurmaController@status');
			Route::get('turmasjson','TurmaController@turmasJSON');
			Route::get('inscritos/{turma}','InscricaoController@verInscritos');
			Route::get('lista/{id}','painelController@chamada');
			Route::get('importar', function(){ return view('pedagogico.turma.upload');});
			Route::post('importar', 'TurmaController@uploadImportaTurma' );
			Route::post('processar-importacao', 'TurmaController@processarImportacao');
			Route::get('expiradas','TurmaController@processarTurmasExpiradas')->name('turmas.expiradas');
			Route::get('modificar-requisitos/{id}','RequisitosController@editRequisitosTurma');
			Route::post('turmas-requisitos','RequisitosController@editRequisitosTurma');
			Route::post('modificar-requisitos/{id}','RequisitosController@storeRequisitosTurma');




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
	Route::middleware('liberar.recurso:18')->prefix('secretaria')->group(function(){
		
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
			Route::get('/nova/{pessoa}','InscricaoController@novaInscricao');
			Route::get('/upload-termo-lote', function(){ return view('secretaria.matricula.upload-termos-lote'); });
			Route::post('/upload-termo-lote', 'MatriculaController@uploadTermosLote');
			Route::get('/upload-termo/{matricula}','MatriculaController@uploadTermo_vw');
			Route::post('/upload-termo/{matricula}','MatriculaController@uploadTermo');
			Route::get('/upload-termo-cancelamento/{matricula}','MatriculaController@uploadCancelamentoMatricula_vw');
			Route::post('/upload-termo-cancelamento/{matricula}','MatriculaController@uploadCancelamentoMatricula');
			Route::get('/uploadglobal/{tipo}/{operacao}/{qnde}/{valor}','MatriculaController@uploadGlobal_vw');
			Route::post('/uploadglobal/{tipo}/{operacao}/{qnde}/{valor}','MatriculaController@uploadGlobal');
			Route::get('renovar/{pessoa}','MatriculaController@renovar_vw');
			Route::post('renovar/{pessoa}','MatriculaController@renovar');
			Route::get('duplicar/{matricula}','MatriculaController@duplicar');
			Route::post('nova/confirmacao', 'InscricaoController@confirmacaoAtividades');
			Route::post('nova/gravar', 'MatriculaController@gravar');
			Route::get('termo/{id}','MatriculaController@termo');
			Route::get('editar/{id}', 'MatriculaController@editar');
			Route::post('editar/{id}','MatriculaController@update');
			Route::get('declaracao/{id}','MatriculaController@declaracao');
			Route::get('cancelar/{id}','MatriculaController@viewCancelarMatricula');
			Route::post('cancelar/{id}','MatriculaController@cancelarMatricula');
			Route::get('imprimir-cancelamento/{matricula}','MatriculaController@imprimirCancelamento');
			Route::get('reativar/{id}','MatriculaController@reativarMatricula');
			Route::get('atualizar/{id}','MatriculaController@atualizar');
			Route::get('cancelamento', 'MatriculaController@regularizarCancelamentos');
			Route::prefix('inscricao')->group(function(){
				Route::get('editar/{id}', 'InscricaoController@editar');
				Route::post('editar/{id}', 'InscricaoController@update');
				Route::get('apagar/{id}', 'InscricaoController@viewCancelar');
				Route::post('apagar/{id}', 'InscricaoController@cancelar');
				Route::get('reativar/{id}', 'InscricaoController@reativar');
				Route::get('trocar/{id}', 'InscricaoController@trocarView');
				Route::post('trocar/{id}', 'InscricaoController@trocarExec');
				Route::get('imprimir/cancelamento/{inscricao}', 'InscricaoController@imprimirCancelamento');
				Route::get('imprimir/transferencia/{inscricao}', 'InscricaoController@imprimirTransferencia');
			});
			Route::middleware('liberar.recurso:20')->get('ativar_matriculas_em_espera','MatriculaController@ativarEmEspera');
			
		});


	});


	//Relatórios

	Route::prefix('relatorios')->group(function(){
				Route::get('turmas', 'RelatorioController@inscricoesAtivas');
				Route::get('matriculas-por-programa/{programa}','RelatorioController@matriculasPrograma');


		});

	//Docentes
	
	Route::middleware('liberar.recurso:13')->prefix('docentes')->group(function(){
		Route::get('/','painelController@docentes');
		Route::get('turmas-professor', 'TurmaController@listarProfessores');
		Route::post('turmas-professor', 'TurmaController@turmasProfessor');
	});
	Route::get('chamada/{id}/{pg}/{url}','TurmaController@getChamada');
	Route::get('plano/{professor}/{tipo}/{curso}','TurmaController@getPlano');
	





	//Administração

	Route::middleware('liberar.recurso:15')->prefix('admin')->group(function(){
		Route::get('credenciais/{var}', 'loginController@credenciais_view');
		Route::post('credenciais/{var}', 'loginController@credenciais_exec');
		Route::get('listarusuarios', 'loginController@listarUsuarios_view');
		Route::get('listarusuarios/{var}', 'loginController@listarUsuarios_view');
		Route::post('listarusuarios/{var}', 'loginController@listarUsuarios_action');
		Route::get('alterar/{acao}/{itens}', 'loginController@alterar');
		Route::get('/turmascursosnavka', 'painelController@verTurmasAnterioresCursos');
		Route::post('/turmascursosnavka', 'painelController@gravarMigracao');
		Route::get('/turmasaulasnavka', 'painelController@verTurmasAnterioresAulas');
		Route::get('importarLocais','painelController@importarLocais');
		Route::get('atualizar-inscritos','TurmaController@atualizarInscritos');
		Route::get('inscricoes','InscricaoController@incricoesPorPosto');
		//Route::get('revitaliza', 'MatriculaController@revitaliza');
		//Route::get('auto-matriculas', 'MatriculaController@autoMatriculas');
		//Route::get('recupera-inscricoes', 'InscricaoController@recuperarInscricoes');
		//Route::get('importar-matriculas', 'MatriculaController@importarMatriculas');
		//Route::get('importar-bairros', 'EnderecoController@importarBairros');
	});


});//end middleware login

Route::get('api/chamada/{id}','WebServicesController@apiChamada');
Route::get('api/turmas','WebServicesController@apiTurmas');

//----------------------------- Errors treatment

Route::get('403',function(){
   return view('error-403');
})->name('403');
Route::get('404',function(){
   return view('error-404');
})->name('404');
Route::get('500',function(){
   return view('error-500');
});
Route::get('about',function(){
   return "Sistema de Gestão Educacional. Todos direitos reservados";
});
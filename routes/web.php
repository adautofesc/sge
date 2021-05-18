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

use App\Http\Controllers\AulaController;

Route::get('/', 'painelController@index');



//Publicos**************************************************************

Route::get('cursos-disponiveis', 'TurmaController@turmasSite'); 
Route::get('vagas', 'TurmaController@turmasSite');
Route::get('meuboleto', function(){ return view('financeiro.boletos.meuboleto');});
Route::post('meuboleto', 'BoletoController@segundaVia');
Route::get('boleto/{id}','BoletoController@imprimir');
Route::get('buscarbairro/{var}','EnderecoController@buscarBairro');
Route::get('ipca','ValorController@getIPCA');

//Route::get('correcao-valor','ValorController@correcaoValor');
//Route::get('boletos-com-erros','BoletoController@analisarBoletosComErro');
Route::prefix('perfil')->group(function(){
	Route::get('cpf', function(){
		return view('perfil.cpf');
	});
	Route::get('cadastrar-pessoa/{cpf}','PerfilController@cadastrarView');
	Route::post('cadastrar-pessoa/{cpf}','PerfilController@cadastrarExec');
	Route::get('autentica/{cpf}','Auth\PerfilAuthController@verificarCPF');
	Route::post('autentica/{cpf}','Auth\PerfilAuthController@autenticaCPF');
	Route::get('recuperar-senha/{cpf}','Auth\PerfilAuthController@recuperarSenhaView');
	Route::get('resetar-senha/{token}','Auth\PerfilAuthController@recuperarSenhaExec');
	Route::post('cadastrar-senha','Auth\PerfilAuthController@cadastrarSenha');
	Route::middleware('login.perfil')->group(function(){
		Route::get('/','PerfilController@painel');
		Route::get('parceria','PerfilController@parceriaIndex');
		Route::post('parceria','PerfilController@parceriaExec');
		Route::get('parceria/curriculo','PerfilController@parceriaCurriculo');
		Route::get('parceria/cancelar','PerfilController@parceriaCancelar');
		Route::get('alterar-senha','Auth\PerfilAuthController@trocarSenhaView');
		Route::post('alterar-senha','Auth\PerfilAuthController@trocarSenhaExec');
		Route::get('alterar-dados','PerfilController@alterarDadosView');
		Route::post('alterar-dados','PerfilController@alterarDadosExec');
		Route::get('boletos','PerfilController@boletosPerfil');
		Route::get('boleto/{numero}','BoletoController@imprimir');
		Route::prefix('matricula')->group(function(){
			Route::get('/','PerfilMatriculaController@matriculasAtivas');
			Route::get('inscricao','PerfilMatriculaController@turmasDisponiveis');
			Route::post('confirmacao','PerfilMatriculaController@confirmacao');
			Route::post('inscricao','PerfilMatriculaController@inscricao');
			Route::get('cancelar/{inscricao}','PerfilMatriculaController@cancelar');
			Route::get('termo/{id}','MatriculaController@termo');
			Route::get('termo',function(){
				return view('juridico.documentos.termo_aberto_ead');
			});

		});

	});
	
	Route::get('logout','Auth\PerfilAuthController@logout');

});


Auth::routes(['register' => false]);

//************************************************* Areas restritas para cadastrados ***************************************************

Route::middleware(['auth','login']) ->group(function(){


	//Route::get('disparar-email-boletos','SecretariaController@emailBoletos');

	



	Route::get('home', 'painelController@index');
	Route::get('reimpressao', 'BoletoController@reimpressaoCarnes');
	Route::get('/trocarminhasenha','loginController@trocarMinhaSenha_view');
	Route::post('/trocarminhasenha','loginController@trocarMinhaSenha_exec');
	Route::get('/pessoa/trocarsenha/{var}','loginController@trocarSenhaUsuario_view');
	Route::post('/pessoa/trocarsenha/{var}','loginController@trocarSenhaUsuario_exec');
	Route::get('/pessoa/cadastraracesso/{var}','loginController@cadastrarAcesso_view');
	Route::post('/pessoa/cadastraracesso/{var}','loginController@cadastrarAcesso_exec');



	Route::get('notificacoes','NotificacaoController@index');


	Route::get('download/{arquivo}',function ($arquivo){
		// Atenção a divisoria de pasta deve ser a string -.-
		//use a função str_replace('/','-.-', $arquivo) para codificar a pasta.
		return App\classes\Arquivo::download($arquivo);

	});
	/*
	Route::prefix('arquivo')->group(function(){
		route::get('/atestado/{id}','AtestadoController@arquivo');

	});*/
	Route::get('/atestado/{id}', 'painelController@index');

	

	Route::get('lista/{id}','TurmaController@impressao'); //lista de chamada aberta
	Route::get('listas/{id}','TurmaController@impressaoMultipla'); //lista de chamada aberta
	
	Route::get('frequencia/{turma}','TurmaController@frequencia');
	
//******************************************************RECURSOS************************************************************** */	
	
	Route::prefix('aulas')->group(function(){
		//Route::get('/{turma}','AulaController@viewAulasTurma');
		Route::get('gerar/{turma}','AulaController@gerarAulas');
		Route::POST('alterar-status','AulaController@alterarStatus');
		Route::POST('limpar-dado', 'AulaDadoController@limparDado');
		
		

	});
	Route::prefix('turmas')->group(function(){
		Route::get('cadastrar','TurmaController@create')->name('turmas.cadastrar');
		Route::middleware('liberar.recurso:18')->post('cadastrar','TurmaController@store');
		Route::middleware('liberar.recurso:18')->post('recadastrar','TurmaController@storeRecadastro');
		Route::middleware('liberar.recurso:18')->get('/','TurmaController@listarSecretaria')->name('turmas');
		Route::middleware('liberar.recurso:18')->get('/alterar/{acao}/{turmas}','TurmaController@acaolote');
		Route::get('listar','TurmaController@index');
		Route::get('apagar/{var}','TurmaController@destroy');
		Route::get('editar/{var}','TurmaController@edit');
		Route::middleware('liberar.recurso:18')->post('editar/{var}','TurmaController@update');
		Route::middleware('liberar.recurso:18')->get('status/{status}/{turma}','TurmaController@status');
		Route::get('turmasjson','TurmaController@turmasJSON');
		Route::get('inscritos/{turma}','InscricaoController@verInscritos');
		Route::get('lista/{id}','painelController@chamada');
		Route::get('importar', function(){ return view('turmas.upload');});
		Route::middleware('liberar.recurso:18')->post('importar', 'TurmaController@uploadImportaTurma' );
		Route::post('processar-importacao', 'TurmaController@processarImportacao');
		Route::get('expiradas','TurmaController@processarTurmasExpiradas')->name('turmas.expiradas');
		Route::get('modificar-requisitos/{id}','RequisitosController@editRequisitosTurma');
		Route::post('turmas-requisitos','RequisitosController@editRequisitosTurma');
		Route::post('modificar-requisitos/{id}','RequisitosController@storeRequisitosTurma');
		Route::get('atualizar-inscritos','TurmaController@atualizarInscritos');
		Route::get('/{turma}', 'InscricaoController@verInscricoes'); //dados da turma secretaria
		Route::post('/{turma}', 'InscricaoController@inscreverAlunoLote'); // inserção de alunos direto pelo painel
		Route::get('/dados-gerais/{turma}', 'TurmaController@mostrarTurma');//dados da turma pedagógico

	});

	Route::prefix('eventos')->group(function(){
		Route::get('cadastrar/{tipo?}','EventoController@create');
		Route::post('cadastrar/{tipo?}','EventoController@store');
		Route::get('/','EventoController@index');

	});
	Route::prefix('cursos')->group(function(){
		//Cursos
		Route::get('/','CursoController@index');
		Route::get('listarporprogramajs/{var}','CursoController@listarPorPrograma');
		Route::get('cadastrar','CursoController@create');
		Route::post('cadastrar','CursoController@store');
		Route::get('editar/{var}','CursoController@edit');
		Route::post('editar/{var}','CursoController@update');
		Route::get('apagar','CursoController@destroy');
		Route::get('curso/{var}','CursoController@show');
		Route::get('curso/modulos/{var}','CursoController@qndeModulos');

		//Disciplinas
		Route::prefix('disciplinas')->group(function(){

			Route::get('vincular/{var}','DisciplinaController@editDisciplinasAoCurso');
			Route::post('vincular/{var}','DisciplinaController@storeDisciplinasAoCurso');
			Route::get('grade/{var}','DisciplinaController@disciplinasDoCurso');
			Route::get('grade/{curso}/{str}','DisciplinaController@disciplinasDoCurso');
			Route::get('/','DisciplinaController@index');
			Route::get('cadastrar','DisciplinaController@create');
			Route::post('cadastrar','DisciplinaController@store');
			Route::get('pedagogico/editardisciplina/{var}','DisciplinaController@edit');
			Route::get('disciplina/{var}','DisciplinaController@show');
			Route::get('editar/{var}','DisciplinaController@edit');
			Route::post('editar/{var}','DisciplinaController@update');
			Route::get('apagar','DisciplinaController@destroy');
		});

		//Requisitos
		Route::prefix('requisitos')->group(function(){
			
			Route::get('/','RequisitosController@index');
			Route::get('cadastrar','RequisitosController@create');
			Route::post('cadastrar','RequisitosController@store');
			Route::get('apagar/{itens}','RequisitosController@destroy');
			Route::get('requisitosdocurso/{var}','RequisitosController@editRequisitosAoCurso');
			Route::post('requisitosdocurso/{var}','RequisitosController@storeRequisitosAoCurso');
		});
		
			
		
		

	});

//**************************************************************************SETORES******************************** */

	//desenvoldedor
	Route::middleware('liberar.recurso:22')->prefix('dev')->group(function(){
		Route::get('/','painelController@indexDev');
		Route::get('testar-classe', 'painelController@testarClasse');
		Route::post('testar-classe', 'painelController@testarClassePost');
		Route::get('/bolsa/gerador', 'BolsaController@gerador');
		Route::get('/corrigir-boletos','BoletoController@corrigirBoletosSemParcelas');
		Route::get('ajusteBolsas', 'BolsaController@ajusteBolsaSemMatricula');
		
		Route::get('importar-status-boletos','painelController@importarStatusBoletos');
		Route::get('add-recesso','DiaNaoLetivoController@ViewAddRecesso');
		Route::get('cadastrarValores','ValorController@cadastrarValores');

		/*
		Route::get('/descontao','LancamentoController@descontao1');
		Route::get('/descontao2','LancamentoController@descontao2');
		Route::get('/executardesconto','BoletoController@atualizarBoletosGravados');

		*/

	});

	Route::prefix('pessoa')->group(function(){
	// Pessoas
		//Route::get('recadastramento', function(){ return view('pessoa.recadastramento');});
		//Route::post('recadastramento','PessoaController@iniciarRecadastramento');
		//Route::post('recadastrado','PessoaController@gravarRecadastro');

		Route::post('registrar-contato','ContatoController@registrar');
		Route::get('contato-whatsapp','ContatoController@enviarWhats');
		Route::get('resetar-senha-perfil/{id}','Auth\PerfilAuthController@resetarSenha');


		Route::get ('listar','PessoaController@listarTodos');//->middleware('autorizar:56')
		Route::post('listar','PessoaController@procurarPessoasAjax');
		Route::get ('cadastrar', 'PessoaController@create')->name('pessoa.cadastrar');
		Route::post('cadastrar','PessoaController@gravarPessoa');
		Route::middleware('liberar.recurso:18')->get('mostrar','PessoaController@listarTodos');//->middleware(['autorizar:56', 'privacy'])
		Route::get ('mostrar/{var}','PessoaController@mostrar');
		Route::get('buscarapida/{var}','PessoaController@liveSearchPessoa');
		Route::get('apagar-atributo/{var}','PessoaController@apagarAtributo');
		Route::POST('inserir-dado-clinico','PessoaDadosClinicosController@store');
		Route::delete('apagar-dado-clinico/{id}','PessoaDadosClinicosController@delete');

	//Atestado
		Route::prefix('atestado')->group(function(){
			Route::get('cadastrar/{pessoa}','AtestadoController@novo');
			Route::post('cadastrar/{pessoa}','AtestadoController@create');
			Route::get('arquivar/{atestado}', 'AtestadoController@apagar');
			Route::get('editar/{atestado}', 'AtestadoController@editar');
			Route::post('editar/{atestado}', 'AtestadoController@update');
			Route::get('listar', 'AtestadoController@listar');

		});
	//Justificativa Ausência
		Route::prefix('justificativa-ausencia')->group(function(){
			Route::get('/{pessoa?}','JustificativaAusenciaController@index');
			Route::post('/{pessoa}','JustificativaAusenciaController@store');
			Route::get('apagar/{id}','JustificativaAusenciaController@delete');
			

		});
	//Bolsa
		Route::middleware('liberar.recurso:18')->prefix('bolsa')->group(function(){ //criar novo código
			Route::get('cadastrar/{pessoa}','BolsaController@nova');
			Route::post('cadastrar/{pessoa}','BolsaController@gravar');
			Route::get('imprimir/{bolsa}','BolsaController@imprimir');
			Route::get('upload/{bolsa}','BolsaController@uploadForm');
			Route::post('upload/{bolsa}','BolsaController@uploadExec');
			Route::get('parecer/{bolsa}','BolsaController@uploadParecerForm');
			Route::post('parecer/{bolsa}','BolsaController@uploadParecerExec');
		});

		
	//Dependentes
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
			Route::get('dadosclinicos/{var}','PessoaDadosClinicosController@editarDadosClinicos_view');
			Route::post('dadosclinicos/{var}','PessoaDadosClinicosController@editarDadosClinicos_exec');
			Route::get('observacoes/{var}','PessoaDadosGeraisController@editarObservacoes_view');
			Route::post('observacoes/{var}','PessoaDadosGeraisController@editarObservacoes_exec');
		});

		Route::get('matriculas', 'MatriculaController@listarPorPessoa');

		Route::get('registrar-email-fesc/{pessoa}/{endereco}','PessoaDadosAcademicosController@registrarEmailFesc');
		Route::get('apagar-email-fesc/{id}','PessoaDadosAcademicosController@apagarEmailFesc');
		Route::get('inscrever-equipe-teams/{pessoa}/{turma}','PessoaDadosAcademicosController@inscreverTeams');
		Route::get('remover-equipe-teams/{id}','PessoaDadosAcademicosController@removerTeams');

	});//prefix pessoa


	

	// Administrativo
	Route::middleware('liberar.recurso:12')->prefix('administrativo')->group(function(){
		Route::get('/','painelController@administrativo');
		Route::get('locais','LocaisController@listar');
		Route::get('locais/cadastrar','LocaisController@cadastrar');
		Route::post('locais/cadastrar','LocaisController@store');
		Route::get('locais/editar/{var}','LocaisController@editar');
		Route::post('locais/editar/{var}','LocaisController@update');
		Route::get('locais/apagar/{var}','LocaisController@apagar');
		Route::get('locais/salas/{id}','SalaController@listarPorLocal');
		Route::get('locais/salas-api/{id}','SalaController@listarPorLocalApi');
		Route::get('salas/cadastrar/{id}','SalaController@cadastrar');
		Route::post('salas/cadastrar/{id}','SalaController@store');
		Route::get('salas/alterar/{id}','SalaController@editar');
		Route::post('salas/alterar/{id}','SalaController@update');

		
	});
	Route::middleware('liberar.recurso:12')->prefix('agendamento-salas')->group(function(){
		Route::get('/','SalaAgendamentoController@agendamento');


		
	});


	// Financeiro
	Route::middleware('liberar.recurso:14')->prefix('financeiro')->group(function(){
		Route::get('/','painelController@financeiro');
		Route::get('limpar-debitos','BoletoController@limparDebitos');

		Route::prefix('cobranca')->group(function(){
			Route::get('cartas','CobrancaController@cartas');

		});

		Route::prefix('lancamentos')->group(function(){
			Route::get('home',  function(){ return view('financeiro.lancamentos.home'); });
			Route::get('listar-por-pessoa','LancamentoController@listarPorPessoa');
			Route::get('novo/{id}','LancamentoController@novo');
			Route::post('novo/{id}','LancamentoController@create');
			Route::get('gerar-individual/{pessoa}','LancamentoController@gerarLancamentosPorPessoa');
			Route::get('cancelar/{lancamento}','LancamentoController@cancelar');
			Route::get('excluir/{lancamento}', 'LancamentoController@excluir');
			Route::get('excluir-abertos/{pessoa}', 'LancamentoController@excluirAbertos');
			Route::get('reativar/{lancamento}','LancamentoController@reativar');
			Route::get('relancar/{lancamento}','LancamentoController@relancarParcela');
			Route::get('editar/{lancamento}','LancamentoController@editar');
			Route::post('editar/{lancamento}','LancamentoController@update');
			Route::middleware('liberar.recurso:19')->get('gerar/{parcela}', 'LancamentoController@gerarLancamentos' );//gerar parcela para todas pessoas
		});
		Route::middleware('liberar.recurso:19')->prefix('carne')->group(function(){
			Route::get('gerar', function(){ return view('financeiro.carne.home');});
			Route::get('fase1/{pessoa?}','CarneController@carneFase1');//gera lancamentos
			Route::get('fase2/{pessoa?}','CarneController@carneFase2');//gera boletos
			Route::get('fase3/{pessoa?}','CarneController@carneFase3');//associa parcelas aos boletos
			Route::get('fase4/{pessoa?}','CarneController@carneFase4');//gera pdf
			Route::get('fase5/{pessoa?}','CarneController@carneFase5');//confirma impressão
			Route::get('fase6/{pessoa?}','CarneController@carneFase6');//gera remessa
			Route::get('fase7/{pessoa?}','CarneController@carneFase7');//download de arquivos


		});


		Route::prefix('boletos')->group(function(){
			Route::middleware('liberar.recurso:19')->get('home',  function(){ return view('financeiro.boletos.home'); });
			Route::get('editar/{id}','BoletoController@editar');
			Route::post('editar/{id}','BoletoController@update');
			Route::get('imprimir/{id}','BoletoController@imprimir');
			Route::get('imprimir-carne/{pessoa}','CarneController@imprimirCarne');
			//Route::get('registrar/{id}','BoletoController@registrar');//registrar para o banco
			Route::get('divida-ativa','BoletoController@dividaAtiva');// envia boletos para divida ativa;
			Route::get('listar-por-pessoa','BoletoController@listarPorPessoa');
			Route::get('informacoes/{id}','BoletoController@historico');
			Route::get('cancelar/{id}','BoletoController@cancelarView');
			Route::get('gerar-carne/{pessoa}','CarneController@gerarCarneIndividual');
			Route::middleware('liberar.recurso:23')->post('cancelar/{id}','BoletoController@cancelar');
			Route::middleware('liberar.recurso:23')->get('cancelar-todos/{id}','BoletoController@cancelarTodosVw');
			Route::middleware('liberar.recurso:23')->post('cancelar-todos/{id}','BoletoController@cancelarTodos');




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
				Route::get('gerar', 'RemessaController@gerarRemessa');//precisa de middleware
				Route::get('download/{file}', 'RemessaController@downloadRemessa');//precisa de middleware
				Route::get('listar-arquivos', 'RemessaController@listarRemessas');
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

			});


		});
		Route::prefix('relatorios')->group(function(){
				Route::get('boletos', 'BoletoController@relatorioBoletosAbertos');
				Route::get('boletos/{ativos}', 'BoletoController@relatorioBoletosAbertos');
				Route::get('/cobranca-xls', 'CobrancaController@relatorioDevedoresXls');
				Route::get('/cobranca-xls/{ativos}', 'CobrancaController@relatorioDevedoresXls');
				Route::get('/cobranca-sms', 'CobrancaController@relatorioDevedoresSms');
				Route::get('/cobranca-sms/{ativos}', 'CobrancaController@relatorioDevedoresSms');
			});


	});


	// Gestão Pessoal
	Route::middleware('liberar.recurso:15')->prefix('gestaopessoal')->group(function(){
		Route::get('/','painelController@atendimentoPessoal');
		Route::get('atendimento','painelController@gestaoPessoal');
		Route::get('atender/','painelController@atendimentoPessoalPara');
		Route::get('atender/{var}','painelController@atendimentoPessoalPara');
		Route::get('funcionarios','PessoaController@listarFuncionarios');
		Route::get('remover-relacao/{id}','PessoaDadosAdminController@excluir');
		Route::get('relacaoinstitucional/{var}','PessoaController@relacaoInstitucional_view');
		Route::post('relacaoinstitucional/{var}','PessoaController@relacaoInstitucional_exec');
	});


	//Bolsas

	Route::middleware('liberar.recurso:21')->prefix('bolsas')->group(function(){

		Route::get('liberacao','BolsaController@listar');
		Route::get('/status/{status}/{bolsas}','BolsaController@alterarStatus');
		Route::get('analisar/{bolsa}','BolsaController@analisar');
		Route::post('analisar/{bolsa}','BolsaController@gravarAnalise');
		Route::get('desvincular/{matricula}/{bolsa}','BolsaController@desvincular');


	});

	// Jurídico
	Route::prefix('juridico')->group(function(){
		Route::get('/','painelController@juridico');
		//Documentos
		//
		
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
			Route::get('/','TurmaController@index');
			Route::get('/alterar/{acao}/{turmas}','TurmaController@acaolote');
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
			Route::get('atualizar-inscritos','TurmaController@atualizarInscritos');
			//Route::get('aulas/{turma}','AulaController@viewAulasTurma');




		});
		
		
	});

	// Secretaria
	Route::middleware('liberar.recurso:18')->prefix('secretaria')->group(function(){
		
		Route::get('/','painelController@secretaria')->name('secretaria');
		Route::get('pre-atendimento','SecretariaController@iniciarAtendimento');
		Route::post('pre-atendimento','SecretariaController@buscaPessoaAtendimento');
		Route::get('atendimento','SecretariaController@atender');
		Route::get('atender','SecretariaController@atender')->name('secretaria.atender');
		Route::get('atender/{var}','SecretariaController@atender');
		Route::get('processar-documentos','SecretariaController@processarDocumentos');

		Route::get('turmas', 'TurmaController@listarSecretaria');
		Route::get('turmas-disponiveis/{turmas}/{filtros}', 'TurmaController@turmasDisponiveis');
		Route::get('turmas-escolhidas/{turmas}/', 'TurmaController@turmasEscolhidas');
		

		Route::get('upload','SecretariaController@uploadGlobal_vw');
		Route::post('upload','SecretariaController@uploadGlobal');
		Route::get('frequencia/{turma}','FrequenciaController@listaChamada');

		Route::get('alunos','SecretariaController@alunos');
		Route::get('alunos-cancelados','SecretariaController@alunosCancelados');




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
			//Route::post('nova/gravar', 'InscricaoController@gravarInscricoes');




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
				Route::get('imprimir/transferencia/{inscricao}', 'TransferenciaController@imprimir');
			});
			Route::middleware('liberar.recurso:20')->get('ativar_matriculas_em_espera','MatriculaController@ativarEmEspera');
			
		});


	});


	//Relatórios

	Route::prefix('relatorios')->group(function(){
		Route::get('alunos','RelatorioController@numeroAlunos');
		Route::get('turmas', 'RelatorioController@turmas');
		Route::get('dados-turmas/{turmas}', 'RelatorioController@dadosTurmas');
		Route::get('matriculas/{programa}','RelatorioController@matriculasPrograma');
		//Route::get('matriculas','RelatorioController@matriculas');
		Route::get('inscricoes','RelatorioController@inscricoes');
		Route::get('alunos-turmas','RelatorioController@alunosTurmasExport');
		Route::get('faixasuati', 'RelatorioController@matriculasUati');
		Route::get('alunos-posto', 'RelatorioController@alunosPorUnidade');
		Route::get('bolsas-fpm','RelatorioController@bolsasFuncionariosMunicipais');
		Route::get('bolsas','RelatorioController@bolsas');
		Route::get('tce-alunos/{ano?}','RelatorioController@tceAlunos');
		Route::get('tce-educadores/{ano?}','RelatorioController@tceEducadores');
		Route::get('tce-turmas/{ano?}','RelatorioController@tceTurmas');
		Route::get('tce-turmas-alunos/{ano?}','RelatorioController@tceTurmasAlunos');
		Route::get('tce-vagas/{ano?}','RelatorioController@tceVagas');
		Route::get('alunos-conselho/{ano?}','RelatorioController@alunosConselho');
		Route::get('bolsistas-com-3-faltas','RelatorioController@bolsistasComTresFaltas');
		Route::get('celulares','PessoaController@relatorioCelulares');
		





	});

	//Docentes
	
	Route::middleware('liberar.recurso:13')->prefix('docentes')->group(function(){
		Route::get('/{semestre?}','painelController@docentes');
		Route::get('turmas-professor', 'TurmaController@listarProfessores');
		Route::post('turmas-professor', 'TurmaController@turmasProfessor');
		
		Route::prefix('frequencia')->group( function(){
			Route::get('listar/{turma}','FrequenciaController@listaChamada');
			Route::get('nova-aula/{turma}/{aula?}','FrequenciaController@novaChamada_view');
			Route::post('nova-aula/{turma}/{aula?}','FrequenciaController@novaChamada_exec');
			Route::get('editar-aula/{aula}','FrequenciaController@editarChamada_view');
			Route::post('editar-aula/{aula}','FrequenciaController@editarChamada_exec');
			Route::get('preencher/{aula}','FrequenciaController@preencherChamada_view');
			Route::post('preencher/{aula}','FrequenciaController@preencherChamada_exec');
			Route::get('apagar-aula/{aula}','AulaController@apagarAula');
			Route::get('conteudos/{turma}','AulaDadoController@editarConteudo_view');
			Route::post('conteudos/{turma}','AulaDadoController@editarConteudo_exec');
		});
		
	});
	Route::get('chamada/{id}/{pg}/{url}/{hide?}','TurmaController@getChamada'); //optional parameter is used here!
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

	Route::get('cobranca-automatica','CobrancaController@cobrancaAutomatica');
	Route::get('services/excluir-aulas','AulaController@excluir');
	
});//end middleware login
Route::prefix('services')->group(function(){
	Route::get('professores','WebServicesController@listaProfessores');
	Route::get('chamada/{id}','WebServicesController@apiChamada');
	Route::get('turmas','WebServicesController@apiTurmas');
	Route::get('salas-api/{id}','SalaController@listarPorLocalApi');
	Route::get('salas-locaveis-api/{id}','SalaController@listarLocaveisPorLocalApi');

});

Route::get('alerta-covid','painelController@alertaCovid');
Route::get('cancelamento-covid','BoletoController@cancelarCovid');
Route::get('renova-login','loginController@sendNewPassword');


//----------------------------- Errors treatment

Route::get('403',function(){
   return view('error-403');
})->name('403');
Route::get('404',function(){
   return view('error-404');
})->name('404');
Route::get('503',function(){
   return view('error-503');
});
Route::get('500',function(){
	return view('error-500');
 });
Route::get('about',function(){
   return "Sistema de Gestão Educacional. Todos direitos reservados";
});
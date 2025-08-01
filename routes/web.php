<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/
use App\Http\Controllers\AtestadoController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\BoletoController;
use App\Http\Controllers\JornadaController;
use App\Http\Controllers\Reports\JornadaDocentes;
use App\Http\Controllers\Reports\JornadaPrograma;
use App\Http\Controllers\Reports\JornadaHTP;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\UsoLivreController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PessoaDadosJornadasController;
use App\Http\Controllers\FichaTecnicaController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ValorController;
use App\Http\Controllers\Auth\PerfilAuthController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\PessoaController;

Route::get('/', [App\Http\Controllers\painelController::class,'index']);



//Publicos**************************************************************

Route::get('cursos-disponiveis', [TurmaController::class,'turmasSite']); 
Route::get('vagas', [TurmaController::class,'turmasSite']);
Route::get('meuboleto', function(){ return view('financeiro.boletos.meuboleto');});
Route::post('meuboleto', [BoletoController::class,'segundaVia']);
Route::get('boleto/{id}/{token}',[BoletoController::class,'imprimir']);
Route::get('buscarbairro/{var}',[App\Http\Controllers\EnderecoController::class,'buscarBairro']);
Route::get('ipca',[ValorController::class,'getIPCA']);
Route::get('agenda-atendimento/{data}','AgendaAtendimentoController@horariosData');

Route::get('gerar-token', [App\Http\Controllers\Auth\TokenController::class, 'gerarToken'])->name('gerar.token');
Route::get('apagar-token', [App\Http\Controllers\Auth\TokenController::class, 'apagarToken'])->name('apagar.token');
//Route::get('correcao-valor',[ValorController::class,'correcaoValor']);
//Route::get('boletos-com-erros',[BoletoController::class,'analisarBoletosComErro']);
Route::get('rematricula', function(){
	return view('perfil.cpf');
});

Route::prefix('perfil')->group(function(){
	Route::get('cpf', function(){
		return view('perfil.cpf');
	});
	Route::get('cadastrar-pessoa/{cpf}',[PerfilController::class,'cadastrarView']);
	Route::post('cadastrar-pessoa/{cpf}',[PerfilController::class,'cadastrarExec']);
	Route::get('autentica/{cpf}',[PerfilAuthController::class,'verificarCPF']);
	Route::post('autentica/{cpf}',[PerfilAuthController::class,'autenticaCPF']);
	Route::get('recuperar-senha/{cpf}',[PerfilAuthController::class,'recuperarSenhaView']);
	Route::get('resetar-senha/{token}',[PerfilAuthController::class,'recuperarSenhaExec']);
	Route::post('cadastrar-senha',[PerfilAuthController::class,'cadastrarSenha']);
	Route::middleware('login.perfil')->group(function(){
		Route::get('/',[PerfilController::class,'painel']);
		Route::get('parceria',[PerfilController::class,'parceriaIndex']);
		Route::post('parceria',[PerfilController::class,'parceriaExec']);
		Route::get('parceria/curriculo',[PerfilController::class,'parceriaCurriculo']);
		Route::get('parceria/cancelar',[PerfilController::class,'parceriaCancelar']);
		Route::get('alterar-senha',[PerfilAuthController::class,'trocarSenhaView']);
		Route::post('alterar-senha',[PerfilAuthController::class,'trocarSenhaExec']);
		Route::get('alterar-dados',[PerfilController::class,'alterarDadosView']);
		Route::post('alterar-dados',[PerfilController::class,'alterarDadosExec']);
		Route::get('boletos',[PerfilController::class,'boletosPerfil']);
		Route::get('boleto/{numero}',[BoletoController::class,'imprimir']);
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
		Route::prefix('atestado')->group(function(){
			Route::get('/',[PerfilController::class,'atestadoIndex']);
			Route::get('cadastrar',[PerfilController::class,'cadastrarAtestadoView']);
			Route::post('cadastrar',[PerfilController::class,'cadastrarAtestadoexec']);

		});
		Route::prefix('rematricula')->group(function(){
			Route::get('/','Perfil\RematriculaController@rematricula_view');
			Route::post('/','PerfilMatriculaController@confirmacao');

		});
		Route::prefix('atendimento')->group(function(){
			Route::get('/','AgendaAtendimentoController@indexPerfil');
			Route::post('/','AgendaAtendimentoController@agendarPerfil');
			Route::get('cancelar/{id}','AgendaAtendimentoController@cancelarPerfil');

		});

	});
	
	Route::get('logout',[PerfilAuthController::class,'logout']);

});


Auth::routes(['register' => false]);

//************************************************* Areas restritas para cadastrados ***************************************************

Route::middleware(['auth','login']) ->group(function(){

	Route::get('home', 'painelController@index');
	Route::get('/trocarminhasenha', [loginController::class, 'trocarMinhaSenha_view']);
	Route::post('/trocarminhasenha', [loginController::class, 'trocarMinhaSenha_exec']);
	Route::get('/pessoa/trocarsenha/{var}', [loginController::class, 'trocarSenhaUsuario_view']);
	Route::post('/pessoa/trocarsenha/{var}', [loginController::class, 'trocarSenhaUsuario_exec']);
	Route::get('/pessoa/cadastraracesso/{var}', [loginController::class, 'cadastrarAcesso_view']);
	Route::post('/pessoa/cadastraracesso/{var}', [loginController::class, 'cadastrarAcesso_exec']);



	Route::get('notificacoes','NotificacaoController@index');


	Route::get('download/{arquivo}',function ($arquivo){
		// Atenção a divisoria de pasta deve ser a string -.-
		//use a função str_replace('/','-.-', $arquivo) para codificar a pasta.
		return App\classes\Arquivo::download($arquivo);

	});
	Route::get('view-atestado/{id}',function ($arquivo){
		// Atenção a divisoria de pasta deve ser a string -.-
		//use a função str_replace('/','-.-', $arquivo) para codificar a pasta.
		return App\classes\Arquivo::show('documentos-.-atestados-.-'.$arquivo.'.pdf');

	});
	
	Route::get('/atestado/{id}', 'painelController@index');
	Route::get('lista/{id}',[TurmaController::class,'impressao']); //lista de chamada aberta
	Route::get('listas/{id}',[TurmaController::class,'impressaoMultipla']); //lista de chamada aber]ta
	Route::get('frequencia/{turma}',[TurmaController::class,'frequencia']);
	Route::get('chamadas','FrequenciaController@index');
	Route::get('chamadas/{id}/{semestre?}','FrequenciaController@index');
	
//******************************************************RECURSOS************************************************************** */	
	
	Route::prefix('aulas')->group(function(){
		//Route::get('/{turma}',[AulaController::class,'viewAulasTurma']);
		Route::get('gerar/{turma}',[AulaController::class,'gerarAulas']);
		Route::POST('alterar-status',[AulaController::class,'alterarStatus']);
		Route::POST('limpar-dado', 'AulaDadoController@limparDado');
		Route::GET('recriar/{turma}',[AulaController::class,'recriarAulasView']);	

	});
	Route::prefix('agendamento')->group(function(){
		Route::get('/{data?}','AgendaAtendimentoController@index');
		Route::post('/{data?}','AgendaAtendimentoController@gravar');
		Route::get('alterar/{id}/{status}','AgendaAtendimentoController@alterarStatus');

	});

	Route::prefix('atestados')->group(function(){
		Route::get('/',[AtestadoController::class,'analiseAtestados']);
		Route::get('verificador-diario',[AtestadoController::class,'verificadorDiario']);

	});
	Route::prefix('turmas')->group(function(){
		Route::get('cadastrar',[TurmaController::class,'create'])->name('turmas.cadastrar');
		Route::middleware('liberar.recurso:30')->get('gerar-por-ficha/{id?}',[TurmaController::class,'gerarPorFichaView']);
		Route::middleware('liberar.recurso:30')->post('gerar-por-ficha/{id?}',[TurmaController::class,'store']);
		Route::middleware('liberar.recurso:18')->group(function(){
			Route::get('forcar-exclusao/{turma}', [TurmaController::class,'forcarExclusao']);
			Route::get('/',[TurmaController::class,'listarSecretaria'])->name('turmas');
			Route::post('cadastrar',[TurmaController::class,'store']);
			Route::post('recadastrar',[TurmaController::class,'storeRecadastro']);
			Route::get('/alterar/{acao}/{turmas}', [TurmaController::class,'acaolote']);
			Route::post('editar/{var}', [TurmaController::class,'update']);
			Route::get('status/{status}/{turma}', [TurmaController::class,'status']);
			Route::get('status-matriculas/{status}/{turma}', [TurmaController::class,'statusMatriculas']);
			Route::post('importar', [TurmaController::class,'uploadImportaTurma']);

		});
		Route::get('listar', [TurmaController::class,'index']);
		Route::get('apagar/{var}', [TurmaController::class,'destroy']);
		Route::get('editar/{var}', [TurmaController::class,'edit']);		
		Route::get('turmasjson', [TurmaController::class,'turmasJSON']);
		Route::get('inscritos/{turma}','InscricaoController@verInscritos');
		Route::get('lista/{id}','painelController@chamada');
		Route::get('importar', function(){ return view('turmas.upload');});		
		Route::post('processar-importacao', [TurmaController::class,'processarImportacao']);
		Route::get('expiradas', [TurmaController::class,'processarTurmasExpiradas'])->name('turmas.expiradas');
		Route::get('modificar-requisitos/{id}','RequisitosController@editRequisitosTurma');
		Route::post('turmas-requisitos','RequisitosController@editRequisitosTurma');
		Route::post('modificar-requisitos/{id}','RequisitosController@storeRequisitosTurma');
		Route::get('atualizar-inscritos', [TurmaController::class,'atualizarInscritos']);
		Route::get('/{turma}', 'InscricaoController@verInscricoes'); //dados da turma secretaria
		Route::post('/{turma}', 'InscricaoController@inscreverAlunoLote'); // inserção de alunos direto pelo painel
		Route::get('/dados-gerais/{turma}', [TurmaController::class,'mostrarTurma']);//dados da turma pedagógico

	});

	Route::prefix('eventos')->group(function(){
		Route::get('cadastrar/{tipo?}','EventoController@create');
		Route::post('cadastrar/{tipo?}','EventoController@store');
		Route::get('/{data?}','EventoController@index');

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
		Route::get('media-vagas/{id}/{tipo}','CursoController@mediaVagas');

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
	Route::prefix('planos-ensino')->group(function () {
		Route::get('/','PlanoEnsinoController@index');
		Route::get('cadastrar','PlanoEnsinoController@create');
		Route::post('cadastrar','PlanoEnsinoController@store');
		Route::get('editar/{plano}','PlanoEnsinoController@edit');
		Route::post('editar/{plano}','PlanoEnsinoController@update');
		Route::get('apagar/{planos}','PlanoEnsinoController@destroy');
		Route::post('apagar/{planos}','PlanoEnsinoController@detete');
		
		
	});
	Route::prefix('boletos')->group(function(){
		Route::get('/',[BoletoController::class,'painel']);
		

	});
	Route::prefix('BB')->group(function(){
		Route::get('testar','IntegracaoBBController@testar');
		Route::get('boletos','IntegracaoBBController@listarBoletos');//listar
		Route::post('boletos','IntegracaoBBController@registroBoletosLote');//registrar
		Route::get('boletos/{id}','IntegracaoBBController@detalharBoleto');//detalhes
		Route::get('boletos/{id}/registrar','IntegracaoBBController@viewRegistrarBoleto');//view registrar
		Route::get('boletos/{id}/pix','IntegracaoBBController@consultarPixBoleto');//detalhes do pix
		Route::post('boletos/{id}/alterar','IntegracaoBBController@alterarBoleto');//alterar (patch)
		Route::get('boletos/{id}/baixar','IntegracaoBBController@viewBaixarBoleto');//baixa ou cancelamento
		Route::post('boletos/{id}/baixar','IntegracaoBBController@baixarBoleto');//baixa ou cancelamento
		Route::get('boletos/{id}/cancelar-pix','IntegracaoBBController@cancelarPixBoleto');//baixa ou cancelamento
		Route::get('boletos/{id}/gerar-pix','IntegracaoBBController@gerarPixBoleto');//baixa ou cancelamento
		Route::get('baixar-cancelamentos','IntegracaoBBController@baixarCancelamentos');//baixar cancelamentos
		Route::get('sincronizar','IntegracaoBBController@sincronizarDados');//processamento diario


		
	});

	Route::prefix('uso-livre')->group(function(){
		Route::get('/',[UsoLivreController::class,'index']);
		Route::post('/',[UsoLivreController::class,'store']);
		route::post('/concluir',[UsoLivreController::class,'concluir']);
		route::get('/excluir/{var}',[UsoLivreController::class,'excluir']);

	});

	Route::middleware('liberar.recurso:17')->prefix('jornadas')->group(function(){
		Route::get('index-modal/{p?}', [JornadaController::class,'indexModal']);
		Route::get('/{id}',[JornadaController::class,'index']);
		Route::get('/{id}/cadastrar',[JornadaController::class,'cadastrar']);
		Route::post('/{id}/cadastrar',[JornadaController::class,'store']);
		Route::post('/{id}/excluir',[JornadaController::class,'excluir']);
		Route::get('/{docente}/editar/{jornada}',[JornadaController::class,'editar']);
		Route::post('/{docente}/editar/{jornada}',[JornadaController::class,'update']);


	});

	Route::middleware('liberar.recurso:29')->prefix('fichas')->group(function(){
		Route::get('/',[FichaTecnicaController::class,'index']);
		Route::get('cadastrar',[FichaTecnicaController::class,'cadastrar']);
		Route::post('cadastrar',[FichaTecnicaController::class,'gravar']);
		Route::get('visualizar/{id}',[FichaTecnicaController::class,'visualizar']);
		Route::get('imprimir/{id}',[FichaTecnicaController::class,'imprimir']);
		Route::get('editar/{id}',[FichaTecnicaController::class,'editar']);
		Route::post('editar/{id}',[FichaTecnicaController::class,'update']);
		Route::post('excluir', [FichaTecnicaController::class,'excluir']);
		Route::get('pesquisa',[FichaTecnicaController::class,'pesquisar']);
		Route::get('copiar/{id}',[FichaTecnicaController::class,'copiar']);
		Route::post('encaminhar',[FichaTecnicaController::class,'encaminhar']);
		Route::get('exportar',[FichaTecnicaController::class,'exportar']);

	});
	Route::prefix('carga-horaria')->group(function(){
		Route::get('importar',[PessoaDadosJornadasController::class,'importar']);
		Route::get('cadastrar/{pessoa}',[PessoaDadosJornadasController::class,'cadastrar']);
		Route::post('cadastrar/{pessoa}',[PessoaDadosJornadasController::class,'store']);
		Route::get('editar/{id}',[PessoaDadosJornadasController::class,'editar']);
		Route::post('editar/{id}',[PessoaDadosJornadasController::class,'update']);
		Route::post('excluir',[PessoaDadosJornadasController::class,'excluir']);


	});

	Route::middleware('liberar.recurso:18')->prefix('tags')->group(function(){
		Route::get('/{pessoa?}',[TagController::class,'index']);
		Route::get('/apagar/{id}/{pessoa}',[TagController::class,'apagar']);
		Route::post('/{pessoa}/criar',[TagController::class,'criar']);
	});

	Route::middleware('liberar.recurso:18')->prefix('inscricoes')->group(function(){
		Route::post('importar-dados','InscricaoController@importarDados');
	});

//**************************************************************************SETORES******************************** */

	//Desenvoldedor
	Route::middleware('liberar.recurso:22')->prefix('dev')->group(function(){
		Route::get('/','painelController@indexDev');
		Route::get('use-as/{id}',  [loginController::class, 'useAs']);
		Route::get('teste-pix','PixController@testePix');
		Route::get('testar-classe/', 'PessoaDadosGeraisController@rastrearDuplicados');
		Route::post('testar-classe', 'painelController@testarClassePost');
		Route::get('/bolsa/gerador', 'BolsaController@gerador');
		Route::get('/corrigir-boletos',[BoletoController::class,'corrigirBoletosSemParcelas']);
		Route::get('ajusteBolsas', 'BolsaController@ajusteBolsaSemMatricula');
		Route::get('gerar-dias-nao-letivos','DiaNaoLetivoController@cadastroAnual');
		Route::get('importar-status-boletos','painelController@importarStatusBoletos');
		Route::get('add-recesso','DiaNaoLetivoController@ViewAddRecesso');
		Route::get('cadastrarValores',[ValorController::class,'cadastrarValores']);
	});

	Route::prefix('pessoa')->group(function(){
	// Pessoas
		Route::post('registrar-contato','ContatoController@registrar');
		Route::get('contato-whatsapp','ContatoController@enviarWhats');
		Route::get('resetar-senha-perfil/{id}',[PerfilAuthController::class,'resetarSenha']);
		Route::get ('listar',[PessoaController::class,'listarTodos']);//->middleware('autorizar:56]')
		Route::post('listar',[PessoaController::class,'procurarPessoasAjax']);
		Route::get ('cadastrar', [PessoaController::class,'create'])->name('pessoa.cadastrar');
		Route::post('cadastrar',[PessoaController::class,'gravarPessoa']);
		Route::middleware('liberar.recurso:18')->get('mostrar',[PessoaController::class,'listarTodos']);//->middleware(['autorizar:56', 'privacy'])
		Route::get ('mostrar/{var}',[PessoaController::class,'mostrar']);
		Route::get('buscarapida/{var}',[PessoaController::class,'liveSearchPessoa']);
		Route::get('apagar-atributo/{var}',[PessoaController::class,'apagarAtributo']);
		Route::get('apagar-pendencia/{var}',[PessoaController::class,'apagarPendencia']);
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
			Route::get('analisar/{atestado}','AtestadoController@analisar_view');
			Route::post('analisar/{atestado}','AtestadoController@analisar');

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
		Route::get('adicionardependente/{var}',[PessoaController::class,'addDependente_view']);
		Route::get('gravardependente/{pessoa}/{dependente}',[PessoaController::class,'addDependente_exec']);
		Route::get('removervinculo/{var}',[PessoaController::class,'remVinculo_exec']);
		Route::get('adicionarresponsavel/{var}',[PessoaController::class,'addResponsavel_view']);
		Route::post('adicionarresponsavel/{var}',[PessoaController::class,'addResponsavel_exec']);
		Route::get('removerdependente/{var}',[PessoaController::class,'remResponsavel_exec']);
		Route::get('buscarendereco/{var}',[PessoaController::class,'buscarEndereco']);
	// Editar dados das pessoas
		Route::prefix('editar')->group(function(){
			Route::get('geral/{id}',[PessoaController::class,'editarGeral_view']);
			Route::post('geral/{var}',[PessoaController::class,'editarGeral_exec']);
			Route::get('contato/{var}',[PessoaController::class,'editarContato_view']);
			Route::post('contato/{var}',[PessoaController::class,'editarContato_exec']);
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
		Route::get('profile',function(){
			return view('pessoa.profile');
		});

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
	Route::prefix('financeiro')->group(function(){
		Route::middleware('liberar.recurso:14')->get('/','painelController@financeiro');
		Route::get('limpar-debitos',[BoletoController::class,'limparDebitos']);

		Route::prefix('cobranca')->group(function(){
			Route::get('cartas','CobrancaController@cartas');

		});

		Route::prefix('divida-ativa')->group(function(){
			Route::get('/','DividaAtivaController@index');

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
			
		});
		Route::middleware('liberar.recurso:19')->prefix('carne')->group(function(){
			Route::get('gerar', function(){ return view('financeiro.carne.home');});
			Route::get('gerarBackground','CarneController@gerarBG');
			Route::get('fase1/{pessoa?}','CarneController@carneFase1');//gera lancamentos
			Route::get('fase2/{pessoa?}','CarneController@carneFase2');//gera boletos
			Route::get('fase3/{pessoa?}','CarneController@carneFase3');//associa parcelas aos boletos
			Route::get('fase4/{pessoa?}','CarneController@carneFase4');//gera pdf
			Route::get('fase5/{pessoa?}','CarneController@carneFase5');//confirma impressão
			Route::get('fase6/{pessoa?}','CarneController@carneFase6');//gera remessa
			Route::get('fase7/{pessoa?}','CarneController@carneFase7');//download de arquivos
			Route::get('reimpressao','CarneController@reimpressao');//

		});


		Route::prefix('boletos')->group(function(){
			Route::middleware('liberar.recurso:19')->get('home',  function(){ return view('financeiro.boletos.home'); });
			Route::get('editar/{id}',[BoletoController::class,'editar']);
			Route::post('editar/{id}',[BoletoController::class,'update']);
			Route::get('imprimir/{id}',[BoletoController::class,'imprimir']);
			Route::get('imprimir-carne/{pessoa}','CarneController@imprimirCarne');
			Route::get('registrar/{id}','IntegracaoBBController@listarBoletos');
			//registrar para o banco
			Route::get('divida-ativa','DividaAtivaController@gerarDividaAtiva');
			// envia boletos para divida ativa;
			Route::get('listar-por-pessoa',[BoletoController::class,'listarPorPessoa']);
			Route::get('informacoes/{id}',[BoletoController::class,'historico']);
			Route::get('imprimir-laravel-boleto/{ids}',[BoletoController::class,'imprimirLaravelBoleto']);
			Route::get('cancelar/{id}',[BoletoController::class,'cancelarView']);
			Route::get('registrar/{ids}','IntegracaoBBController@registrarBoletos');
			Route::get('gerar-carne/{pessoa}','CarneController@gerarCarneIndividual');
			Route::middleware('liberar.recurso:23')->post('cancelar/{id}',[BoletoController::class,'cancelar']);
			Route::middleware('liberar.recurso:23')->get('cancelar-todos/{id}',[BoletoController::class,'cancelarTodosVw']);
			Route::middleware('liberar.recurso:23')->post('cancelar-todos/{id}',[BoletoController::class,'cancelarTodos']);

			Route::get('reativar/{id}',[BoletoController::class,'reativar']);
			Route::get('gerar-individual/{pessoa}',[BoletoController::class,'cadastarIndividualmente']);
			Route::get('gerar',[BoletoController::class,'gerar']);
			Route::middleware('liberar.recurso:19')->get('gerar-boletos', [BoletoController::class,'cadastrar']);//gerar boletos em lote para todos alunos
			Route::get('imprimir-lote', [BoletoController::class,'imprimirLote']);
			Route::middleware('liberar.recurso:19')->get('confirmar-impressao', [BoletoController::class,'confirmarImpressao']);//confirma impressao de todos boletos gravados
			Route::get('novo/{pesssoa}', [BoletoController::class,'novo']);
			Route::post('novo/{pesssoa}', [BoletoController::class,'create']);
			Route::get('/lote-csv', [BoletoController::class,'gerarArquivoCSV']);
			Route::get('corrigir2022',[BoletoController::class,'corrigir2022']);
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
				Route::get('boletos', [BoletoController::class,'relatorioBoletosAbertos']);
				Route::get('boletos/{ativos}', [BoletoController::class,'relatorioBoletosAbertos']);
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
		Route::get('funcionarios','PessoaDadosAdminController@listarFuncionarios');
		Route::get('remover-relacao/{id}','PessoaDadosAdminController@excluir');
		Route::get('relacaoinstitucional/{var}','PessoaDadosAdminController@relacaoInstitucional_view');
		Route::post('relacaoinstitucional/{var}','PessoaDadosAdminController@relacaoInstitucional_exec');
		Route::get('vincular-programa/{pessoa}/{programa}','PessoaDadosAdminController@vincularPrograma');
		Route::get('desvincular-programa/{pessoa}/{programa}','PessoaDadosAdminController@desvincularPrograma');
		Route::get('definir-carga/{pessoa}/{valor}', 'PessoaDadosAdminController@definirCarga');
		Route::get('remover-carga/{id}', 'PessoaDadosAdminController@removerCarga');
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
		Route::get('novo', 'painelController@novoPedagogico');
		//Turmas
		Route::prefix('turmas')->group(function(){
			Route::get('cadastrar',[TurmaController::class,'create']);
			Route::post('cadastrar',[TurmaController::class,'store']);
			Route::post('recadastrar',[TurmaController::class,'storeRecadastro']);
			Route::get('/',[TurmaController::class,'index']);
			Route::get('/alterar/{acao}/{turmas}',[TurmaController::class,'acaolote']);
			Route::get('listar',[TurmaController::class,'index']);
			Route::get('apagar/{var}',[TurmaController::class,'destroy']);
			Route::get('editar/{var}',[TurmaController::class,'edit']);
			Route::post('editar/{var}',[TurmaController::class,'update']);
			Route::get('status/{status}/{turma}',[TurmaController::class,'status']);
			Route::get('turmasjson',[TurmaController::class,'turmasJSON']);
			Route::get('inscritos/{turma}','InscricaoController@verInscritos');
			Route::get('lista/{id}','painelController@chamada');
			Route::get('importar', function(){ return view('pedagogico.turma.upload');});
			Route::post('importar', [TurmaController::class,'uploadImportaTurma' ]);
			Route::post('processar-importacao', [TurmaController::class,'processarImportacao']);
			Route::get('expiradas',[TurmaController::class,'processarTurmasExpiradas']);
			Route::get('modificar-requisitos/{id}','RequisitosController@editRequisitosTurma');
			Route::post('turmas-requisitos','RequisitosController@editRequisitosTurma');
			Route::post('modificar-requisitos/{id}','RequisitosController@storeRequisitosTurma');
			Route::get('atualizar-inscritos',[TurmaController::class,'atualizarInscritos']);

		});
		
		
	});

	// Secretaria
	Route::middleware('liberar.recurso:18')->prefix('secretaria')->group(function(){	
		Route::get('/','painelController@secretaria')->name('secretaria');
		Route::get('analisar-matriculas', [MatriculaController::class,'analiseFinanceira']);
		Route::get('pre-atendimento','SecretariaController@iniciarAtendimento');
		Route::post('pre-atendimento','SecretariaController@buscaPessoaAtendimento');
		Route::get('atendimento','SecretariaController@atender');
		Route::get('atender','SecretariaController@atender')->name('secretaria.atender');
		Route::get('atender/{var}','SecretariaController@atender');
		Route::get('profile/{var}','SecretariaController@profile');
		Route::get('processar-documentos','SecretariaController@processarDocumentos');
		Route::get('turmas', [TurmaController::class,'listarSecretaria']);
		Route::get('turmas-disponiveis/{pessoa}/{turmas}/{busca?}', [TurmaController::class,'turmasDisponiveis']);
		Route::get('turmas-escolhidas/{turmas}/', [TurmaController::class,'turmasEscolhidas']);
		Route::get('upload','SecretariaController@uploadGlobal_vw');
		Route::post('upload','SecretariaController@uploadGlobal');
		Route::get('frequencia/{turma}','FrequenciaController@listaChamada');
		Route::get('alunos','SecretariaController@alunos');
		Route::get('alunos-cancelados','SecretariaController@alunosCancelados');
		Route::get('listar-pendencias','PessoaDadosAdminController@relatorioPendentes');
		Route::prefix('matricula')->group(function(){
			Route::get('/{ids}','SecretariaController@viewMatricula');
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
				Route::get('imprimir/transferencia/{inscricao}', 'TransferenciaController@imprimir');
			});

		});
		Route::middleware('liberar.recurso:20')->get('ativar_matriculas_em_espera','MatriculaController@ativarEmEspera');
		Route::get('visualizar-ficha-tecnica/{id}',[FichaTecnicaController::class,'visualizar']);

	});


	//Relatórios

	Route::prefix('relatorios')->group(function(){
		Route::get('alunos','RelatorioController@numeroAlunos');
		Route::get('turmas', 'RelatorioController@turmas');
		Route::get('planilha-turmas', 'RelatorioController@exportarTurmas');
		Route::get('dados-turmas/{turmas}', 'RelatorioController@dadosTurmas');
		Route::get('matriculas/{programa}','RelatorioController@matriculasPrograma');
		Route::get('inscricoes','RelatorioController@inscricoes');
		Route::get('alunos-turmas','RelatorioController@alunosTurmasExport');
		Route::get('alunos-turmas-sms','RelatorioController@alunosTurmasExportSMS');
		Route::get('faixasuati', 'RelatorioController@matriculasUati');
		Route::get('alunos-posto', 'RelatorioController@alunosPorUnidade');
		Route::get('bolsas-fpm','RelatorioController@bolsasFuncionariosMunicipais');
		Route::get('bolsas','RelatorioController@bolsas');
		Route::get('tce-alunos/{ano?}','RelatorioController@tceAlunos');
		Route::get('tce-educadores/{ano?}',[JornadaDocentes::class,'relatorioGeral']);
		Route::get('tce-turmas/{ano?}/','RelatorioController@tceTurmas');
		Route::get('tce-turmas-alunos/{ano?}','RelatorioController@tceTurmasAlunos');
		Route::get('tce-vagas/{ano?}','RelatorioController@tceVagas');
		Route::get('alunos-conselho/{ano?}','RelatorioController@alunosConselho');
		Route::get('bolsistas-com-3-faltas','RelatorioController@bolsistasComTresFaltas');
		Route::get('celulares',[PessoaController::class,'relatorioCelulares']);
		Route::get('receita-anual-programa/{ano}/{mes?}','Reports\ReceitaAnualReportController@receitaPorPrograma');
		Route::get('receita-curso/{cursos}/{ano}/{mes?}','Reports\ReceitaAnualReportController@receitaPorCurso');
		Route::get('carga-docentes/{ano?}', [JornadaDocentes::class,'relatorioGeral']); //rotas inteligentes
		Route::get('salas',  [SalaController::class,'relatorioOcupacao']);
		Route::get('jornadas-por-programa/{programa}', [JornadaPrograma::class,'index']);
		Route::get('uso-livre', [UsoLivreController::class,'relatorio']);
		Route::get('horarios-htp/{programas}', [JornadaHTP::class,'index']);
		Route::get('conteudo-aulas/{turmas}/{datas?}','AulaDadoController@relatorioConteudo');
		Route::get('conteudo-ocorrencias/{turmas}/{datas?}','AulaDadoController@relatorioConteudo');
	});

	//Docentes
	
	Route::middleware('liberar.recurso:13')->prefix('docentes')->group(function(){
		Route::get('docente/{id?}/{semestre?}','painelController@docentes');
		Route::get('turmas-professor', [TurmaController::class,'listarProfessores']);
		Route::post('turmas-professor', [TurmaController::class,'turmasProfessor']);
		Route::get('jornadas/{educador?}',[JornadaController::class,'modalJornadaDocente']);
		Route::get('cargas/{educador?}',[PessoaDadosJornadaController::class,'modalCargaDocente']);
		Route::prefix('frequencia')->group( function(){
			Route::get('listar/{turma}/{datas?}','FrequenciaController@listaChamada');
			Route::get('nova-aula/{turma}/{aula?}','FrequenciaController@novaChamada_view');
			Route::post('nova-aula/{turma}/{aula?}','FrequenciaController@novaChamada_exec');
			Route::get('editar-aula/{aula}','FrequenciaController@editarChamada_view');
			Route::post('editar-aula/{aula}','FrequenciaController@editarChamada_exec');
			Route::get('preencher/{aula}','FrequenciaController@preencherChamada_view');
			Route::post('preencher/{aula}','FrequenciaController@preencherChamada_exec');
			Route::get('apagar-aula/{aula}',[AulaController::class,'apagarAula']);
			Route::get('conteudos/{turma}','AulaDadoController@editarConteudo_view');
			Route::post('conteudos/{turma}','AulaDadoController@editarConteudo_exec');
		});
	});
	Route::middleware('liberar.recurso:13')->prefix('jornada')->group(function(){
		Route::post('cadastrar','JornadaController@cadastrar');
		Route::post('excluir','JornadaController@excluir');
		Route::post('encerrar','JornadaController@encerrar');

	});
	Route::get('chamada/{id}/{pg}/{url}/{hide?}',[TurmaController::class,'getChamada']); //optiona]l parameter is used here!
	Route::get('plano/{professor}/{tipo}/{curso}',[TurmaController::class,'getPlano']);
	
	//Administração

	Route::middleware('liberar.recurso:15')->prefix('admin')->group(function(){
		Route::middleware('liberar.recurso:8')->get('credenciais/{var}',  [loginController::class], 'credenciais_view');
		Route::middleware('liberar.recurso:8')->post('credenciais/{var}',  [loginController::class], 'credenciais_exec');
		Route::middleware('liberar.recurso:10')->get('listarusuarios',  [loginController::class], 'listarUsuarios_view');
		Route::middleware('liberar.recurso:10')->get('listarusuarios/{var}',  [loginController::class], 'listarUsuarios_view');
		Route::middleware('liberar.recurso:10')->post('listarusuarios/{var}',  [loginController::class], 'listarUsuarios_action');
		Route::get('alterar/{acao}/{itens}',  [loginController::class, 'alterar']);
		Route::get('/turmascursosnavka', 'painelController@verTurmasAnterioresCursos');
		Route::post('/turmascursosnavka', 'painelController@gravarMigracao');
		Route::get('/turmasaulasnavka', 'painelController@verTurmasAnterioresAulas');
		Route::get('importarLocais','painelController@importarLocais');
		Route::get('atualizar-inscritos',[TurmaController::class,'atualizarInscritos']);
		Route::get('inscricoes','InscricaoController@incricoesPorPosto');
	});

	Route::get('cobranca-automatica','CobrancaController@cobrancaAutomatica');
	Route::post('services/excluir-aulas',[AulaController::class,'excluir']);
	
});//end middleware login
Route::prefix('services')->group(function(){
	Route::get('professores','WebServicesController@listaProfessores');
	Route::get('chamada/{id}','WebServicesController@apiChamada');
	Route::get('turmas','WebServicesController@apiTurmas');
	Route::get('salas-api/{id}','SalaController@listarPorLocalApi');
	Route::get('salas-locaveis-api/{id}','SalaController@listarLocaveisPorLocalApi');
	Route::get('catraca','CatracaController@sendData');

});

Route::get('alerta-covid','painelController@alertaCovid');
Route::get('cancelamento-covid',[BoletoController::class,'cancelarCovid']);
Route::get('renova-login', [loginController::class, 'sendNewPassword']);


//----------------------------- Errors treatment

Route::get('403/{recurso?}', function(string $recurso){
   return view('errors.403')->with('recurso',$recurso);
})->name('403');
Route::get('404',function(){
   return view('errors.404');
})->name('404');
Route::get('503',function(){
   return view('errors.503');
});
Route::get('500',function(){
	return view('errors.500');
 });
 
Route::get('about',function(){
   return 'Sistema de Gestão Educacional. Todos direitos reservados';
});
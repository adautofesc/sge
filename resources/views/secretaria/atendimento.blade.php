@extends('layout.app')
@section('pagina')
<div class="title-block">
                        <h3 class="title"> {{$pessoa->nome}} 
                        	@if(isset($pessoa->nome_resgistro))
                        		({{$pessoa->nome_resgistro}})
                        	@endif
                        </h3>
                    </div>
                    <div class="subtitle-block">
                        <h3 class="subtitle"> Dados Gerais <a href="{{asset('/pessoa/mostrar/').'/'.$pessoa->id}}" class="btn btn-secondary btn-sm rounded-s">
							Ver Dados completos
							</a>
						</h3>
                    </div>
                    <form name="item">
                        <div class="card card-block">
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Gênero
								</label>
								<div class="col-sm-2"> 
									{{$pessoa->genero}}
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Nascimento
								</label>
								<div class="col-sm-2"> 
									{{$pessoa->nascimento}}
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Idade
								</label>
								<div class="col-sm-2"> 
									{{$pessoa->idade}}
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Telefone 1
								</label>
								<div class="col-sm-2"> 
									{{$pessoa->telefone}}
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Telefone 2
								</label>
								<div class="col-sm-2"> 
									{{$pessoa->telefone_alternativo}}
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									CPF
								</label>
								<div class="col-sm-2"> 
									{{$pessoa->cpf}}
								</div>
							</div>
							
							
                        </div>
                        <div><br></div>
                        <div class="subtitle-block">
                        	<h3 class="subtitle"> Opções de atendimento	</h3>
                    	</div>
						<section class="section">
							<div class="row">
								<div class="col-xl-3 center-block">
									<div class="card card-primary">
										<div class="card-header">
											<div class="header-block">
												<p class="title" style="color:white">Matrículas</p>
											</div>
										</div>
										<div class="card-block">
											<div><a href="{{asset('/secretaria/matricula/nova'.'/'.$pessoa->id)}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-plus-circle "></i>  Nova Matrícula</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-check-square-o"></i> Efetivar Matrícula</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-times-circle"></i> Cancelar Matrícula</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-times"></i> Cancelar curso</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-print"></i> Impressão</a></div>
										</div>
										
									</div>
								</div>	
								<div class="col-xl-3 center-block">	
									<div class="card card-primary">
										<div class="card-header">
											<div class="header-block">
												<p class="title" style="color:white">Financeiro</p>
											</div>
										</div>
										<div class="card-block">
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-usd "></i>  Extrato</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-barcode"></i> 2a Via de Boleto</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-money"></i> Pagamento</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-fire-extinguisher"></i> Res. problemas</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-reply"></i> Estorno</a></div>
										</div>
										
									</div>
								</div>
								<div class="col-xl-3 center-block">	
									<div class="card card-primary">
										<div class="card-header">
											<div class="header-block">
												<p class="title" style="color:white">Acadêmico</p>
											</div>
										</div>
										<div class="card-block">
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-archive "></i>  Histórico</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-external-link"></i> Declarações</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-heart"></i> Ent. atestado</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-certificate"></i> Certificados</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-book"></i> Relação de Faltas</a></div>
										</div>
										
									</div>
								</div>
								<div class="col-xl-3 center-block">
									<div class="card card-primary">
										<div class="card-header">
											<div class="header-block">
												<p class="title" style="color:white">Sistema</p>
											</div>
										</div>
										<div class="card-block">
											<div><a href="{{asset('/pessoa/cadastraracesso/').'/'.$pessoa->id}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-plus-circle "></i>  Criar Login</a></div>
											<div><a href="{{asset('/pessoa/trocarsenha/').'/'.$pessoa->id}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-check-square-o"></i> Trocar senha</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-times-circle"></i> Recursos</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-times"></i> Histórico</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-print"></i> Relatórios</a></div>
										</div>
										
									</div>
								</div>
							</div>
						</section>
					
                    </form>


@endsection
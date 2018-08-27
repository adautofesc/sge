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
							
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Relação Institucional
								</label>
								<div class="col-sm-2"> 
									{{$pessoa->relacao_institucional}}
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Contratado(a) em
								</label>
								<div class="col-sm-2"> 
									{{$pessoa->contratado_em}}
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Vencimento Contrato
								</label>
								<div class="col-sm-2"> 
									{{$pessoa->vencimento_contratol}}
								</div>
								
							</div>
							@if($pessoa->acesso)

							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Usuário
								</label>
								<div class="col-sm-2"> 
									@if(isset($pessoa->acesso->usuario))
									{{$pessoa->acesso->usuario}}
									@endif
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Validade
								</label>
								<div class="col-sm-2"> 
									@if(isset($pessoa->acesso->validade))
									{{$pessoa->acesso->validade}}
									@endif
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									<a href="{{asset('/admin/alterar/1/').'/'.$pessoa->acesso->id}}" class="btn btn-secondary btn-sm rounded-s">	Renovar Login	</a><!-- -->
								</label>
								
								
							</div>
							@endif
                        </div>
                        <div><br></div>
                        <div class="subtitle-block">
                        	<h3 class="subtitle"> Opções de atendimento de Gestão Pessoal</h3>
                    	</div>
						<section class="section">
							<div class="row">
								<div class="col-xl-4 center-block">
									<div class="card card-primary">
										<div class="card-header">
											<div class="header-block">
												<p class="title" style="color:white">Sistema</p>
											</div>
										</div>
										<div class="card-block">
											<div><a href="{{asset('pessoa/cadastraracesso').'/'.$pessoa->id}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-plus-circle "></i>  Criar acesso</a></div>
											@if($pessoa->acesso)
											<div><a href="{{asset('pessoa/trocarsenha').'/'.$pessoa->id}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-check-square-o"></i> Trocar senha</a></div>
											
											<div><a href="#" onclick="cancelarAcesso()" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-times-circle"></i> Cancelar Acesso</a></div>
											<div><a href="{{asset('admin/credenciais').'/'.$pessoa->id}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-times-circle"></i> Credenciais</a></div>
											@endif
											<div><a href="{{asset('gestaopessoal/relacaoinstitucional').'/'.$pessoa->id}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-times-circle"></i> Rel. Institucional</a></div>
											
										</div>
										
									</div>
								</div>	
								<div class="col-xl-4 center-block">	
									<div class="card card-primary">
										<div class="card-header">
											<div class="header-block">
												<p class="title" style="color:white">Frequência</p>
											</div>
										</div>
										<div class="card-block">
											<p>sem opções no momento.</p>
										</div>
										
									</div>
								</div>
								<div class="col-xl-4 center-block">	
									<div class="card card-primary">
										<div class="card-header">
											<div class="header-block">
												<p class="title" style="color:white">Direitos Trab.</p>
											</div>
										</div>
										<div class="card-block">
											<p>Sem opções no momento
										</div>
										
									</div>
								</div>
								
							</div>
						</section>
					
                    </form>


@endsection
@section('scripts')
<script>
function cancelarAcesso(){
	if(confirm('Deseja mesmo cancelar o acesso de {{$pessoa->nome}}?'))
		@if(isset($pessoa->acesso->usuario))							
		$(location).attr('href',"{{asset('/admin/alterar/3/').'/'.$pessoa->acesso->id}}");
		@endif
}
</script>
@endsection
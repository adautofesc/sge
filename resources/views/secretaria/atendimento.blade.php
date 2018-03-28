@extends('layout.app')
@section('titulo')Atendimento Secretaria. @endsection
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <h3 class="title">Alun{{$pessoa->getArtigoGenero($pessoa->genero)}}: {{$pessoa->nome}} 
        	@if(isset($pessoa->nome_resgistro))
        		({{$pessoa->nome_resgistro}})
        	@endif
           
        </h3>
        <p class="title-description"> <b> Cod. {{$pessoa->id}}</b> - Tel. {{$pessoa->telefone}} </p>
        <div class="items-search">
            <form class="form-inline" method="POST">
            {{csrf_field()}}
                <div class="input-group"> 
                    @if(isset($_GET['mostrar']))
                    &nbsp;<a href="?" class="btn btn-primary btn-sm rounded-s">Exibir ativos</a>
                    @else
                    &nbsp;<a href="?mostrar=todos" class="btn btn-primary btn-sm rounded-s">Exibir todos</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-xl-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Matrículas</p>
                    </div>
                </div>
                <div class="card-block">
                    <div><a href="{{asset('/secretaria/matricula/nova')}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-plus-circle "></i>  <small>Nova Matrícula</small></a></div>
                    <div><a href="#" class="btn btn-secondary-outline col-xs-12 text-xs-left"><i class="fa fa-check-square-o"></i> <small>Entrega de Atestado</small> </a></div>
                  

                </div>
                
            </div>
        </div>  
        <div class="col-xl-4 center-block"> 
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Financeiro</p>
                    </div>
                </div>
                <div class="card-block">
                    <div><a href="{{asset('/financeiro/lancamentos/listar-por-pessoa')}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-usd "></i>  <small>Gerar Parcelas</small></a></div>
                    <div><a href="{{asset('/financeiro/boletos/listar-por-pessoa')}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-barcode"></i> <small>Gerar Boletos</small></a></div>
                  
                   
                </div>
                
            </div>
        </div>
        <div class="col-xl-4 center-block"> 
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Pessoal</p>
                    </div>
                </div>
                <div class="card-block">
                    <div><a href="{{asset('/pessoa/mostrar/'.$pessoa->id)}}"  class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-archive "></i> <small>Dados completos</small></a></div>
                    <div><a href="#" class="btn btn-secondary-outline col-xs-12 text-xs-left"><i class="fa fa-external-link"></i> <small>Certificados</small></a></div>
                    
                </div>
                
            </div>
        </div>
    </div>
</section>
@include('inc.errors')
<section class="section">
	<div class="row">
		<div class="col-xl-12 center-block">
			<div class="card card-primary">
				<div class="card-header">
					<div class="header-block">
						<p class="title" style="color:white">Matrículas & Inscrições</p>
					</div>
				</div>
                <div class="card-block">
                    <ul class="item-list striped">
                        <li class="item item-list-header ">
                            <div class="row ">
                                <div class="col-xl-4 " style="line-height:40px !important; padding-left: 30px;">
                                    <div><i class=" fa fa-sitemap "></i> &nbsp;<small><b>M/I Cod. - Curso/Disciplina</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small><b>Professor(a)</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div title="Vencimento"><small><b>Dia(s) / Horário(s)</b></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small><b>Local</b></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;" title="Data da ultima alteração.">
                                    <div><small><b>Alterado</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <small><b>Opções</b></small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @foreach($matriculas as $matricula)
                        @if($matricula->status == 'cancelada')
                        <li class="alert-danger" style="background-color: #F2DEDE;"> 
                        @elseif($matricula->status == 'pendente')
                        <li class="alert-warning" style="background-color: #FFD8B0;">
                        @else
                        <li>
                        @endif
                            @if(count($matricula->inscricoes) == 1 && $matricula->curso != 307 ) 
                            <div class="row"> 
                                                 
                                    @if($matricula->inscricoes->first()->turma->programa->id == 12)
                                            <div class="col-xl-4 text-success " title="CE -  Turma {{$matricula->inscricoes->first()->turma->id}} - {{$matricula->inscricoes->first()->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @elseif($matricula->inscricoes->first()->turma->programa->id == 2)
                                            <div class="col-xl-4 text-primary " title="PID - Turma {{$matricula->inscricoes->first()->turma->id}} - {{$matricula->inscricoes->first()->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @elseif($matricula->inscricoes->first()->turma->programa->id == 3)
                                            <div class="col-xl-4 text-warning " title="UATI - Turma {{$matricula->inscricoes->first()->turma->id}} - {{$matricula->inscricoes->first()->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @elseif($matricula->inscricoes->first()->turma->programa->id == 1)
                                            <div class="col-xl-4 text-danger " title="UNIT - Turma {{$matricula->inscricoes->first()->turma->id}} - {{$matricula->inscricoes->first()->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @else
                                            <div class="col-xl-4 text-secondary " style="line-height:40px !important; padding-left: 30px;" >
                                    @endif
                                    <div><i class=" fa fa-circle "></i> &nbsp;<small><b>M{{$matricula->id}}  - {{substr($matricula->inscricoes->first()->turma->curso->nome,0,25)}}</b></small></div> 
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{$matricula->inscricoes->first()->turma->professor->nome_simples}} </small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{implode($matricula->inscricoes->first()->turma->dias_semana,', ').' '.$matricula->inscricoes->first()->turma->hora_inicio. '-'.$matricula->inscricoes->first()->turma->hora_termino}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>{{$matricula->inscricoes->first()->turma->local->sigla}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>{{\Carbon\Carbon::parse($matricula->updated_at)->format('d/m/y')}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        @if($matricula->status != 'cancelada')
                                        <a a href="#" onclick="cancelar({{$matricula->id}});" title="Cancelar Matrícula"><i class=" fa fa-times "></i></a>
                                        @else
                                        <a a href="#" onclick="reativar({{$matricula->id}});" title="Reativar Matrícula"><i class=" fa fa-undo "></i></a>
                                        @endif
                                        <a href="{{asset('/secretaria/matricula/editar/').'/'.$matricula->id}}" title="Editar Matrícula"><i class=" fa fa-pencil-square-o "></i></a>
                                        <a href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}" target="_blank" title="Imprimir Termo de Matrícula"><i class=" fa fa-print "></i></a>
                                        @if($matricula->desconto > 0)
                                        &nbsp;&nbsp;<span><i class=" fa fa-flag " title="Esta matrícula possui bolsa."></i></span>
                                        @endif
                                        @if($matricula->status == 'pendente' && $matricula->obs!='')
                                        &nbsp;&nbsp;<span><i class=" fa fa-exclamation-triangle "  title="{{$matricula->obs}}"></i></span>
                                        @elseif($matricula->status == 'ativa' && $matricula->obs!='')
                                        &nbsp;&nbsp;<span><i class=" fa fa-info "  title="{{$matricula->obs}}"></i></span>
                                        @endif

                                    </div>
                                </div>
                         
                            </div>
                            @else
                            <div class="row">                          
                                    @if($matricula->inscricoes->first()->turma->programa->id == 12)
                                            <div class="col-xl-4 text-success " title="CE - {{$matricula->inscricoes->first()->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @elseif($matricula->inscricoes->first()->turma->programa->id == 2)
                                            <div class="col-xl-4 text-primary " title="PID - {{$matricula->inscricoes->first()->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @elseif($matricula->inscricoes->first()->turma->programa->id == 3)
                                            <div class="col-xl-4 text-warning " title="UATI - {{$matricula->inscricoes->first()->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @elseif($matricula->inscricoes->first()->turma->programa->id == 1)
                                            <div class="col-xl-4 text-danger " title="UNIT - {{$matricula->inscricoes->first()->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @else
                                            <div class="col-xl-4 text-secondary " style="line-height:40px !important; padding-left: 30px;" >
                                    @endif
                                    <div class="dropdown-toggle"> <i class=" fa fa-circle "></i> &nbsp;<small><b>M{{$matricula->id}}  - {{substr($matricula->inscricoes->first()->turma->curso->nome,0,25)}}</b></small></div> 
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{count($matricula->inscricoes)}} Disciplina(s) </small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;"></div>
                                <div class="col-xl-1" style="line-height:40px !important;"></div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>{{\Carbon\Carbon::parse($matricula->updated_at)->format('d/m/y')}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        @if($matricula->status != 'cancelada')
                                        <a a href="#" onclick="cancelar({{$matricula->id}});" title="Cancelar Matrícula"><i class=" fa fa-times "></i></a>
                                        @else
                                        <a a href="#" onclick="reativar({{$matricula->id}});" title="Reativar Matrícula"><i class=" fa fa-undo "></i></a>
                                        @endif
                                        <a href="{{asset('/secretaria/matricula/editar/').'/'.$matricula->id}}" title="Editar Matrícula"><i class=" fa fa-pencil-square-o "></i></a>
                                        <a href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}" target="_blank" title="Imprimir Termo de Matrícula"><i class=" fa fa-print "></i></a>
                                        <a href="{{asset('/secretaria/matricula/nova')}}" target="_blank" title="Adicionar Disciplina"><i class=" fa fa-plus-circle "></i></a>
                                        @if($matricula->desconto > 0)
                                        &nbsp;&nbsp;<span><i class=" fa fa-flag " title="Esta matrícula possui bolsa."></i></span>
                                        @endif
                                         @if($matricula->status == 'pendente' && $matricula->obs!='')
                                        &nbsp;&nbsp;<span><i class=" fa fa-exclamation-triangle "  title="{{$matricula->obs}}"></i></span>
                                        @elseif($matricula->status == 'ativa' && $matricula->obs!='')
                                        &nbsp;&nbsp;<span><i class=" fa fa-info "  title="{{$matricula->obs}}"></i></span>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                            @foreach($matricula->inscricoes as $inscricao)
                            @if($inscricao->status == 'cancelado')
                            <div class="row alert-danger">
                            @else
                            <div class="row">
                            @endif
                                                             
                                <div class="col-xl-4" title="{{$inscricao->turma->id}} - {{ isset($inscricao->turma->disciplina->nome) ? $inscricao->turma->disciplina->nome: $inscricao->turma->curso->nome}} " style="line-height:40px !important; padding-left: 50px;">
                                     <div><i class=" fa fa-caret-right"></i>&nbsp;<small>&nbsp;i{{$inscricao->id}} - 
                                        {{ isset($inscricao->turma->disciplina->nome) ? substr($inscricao->turma->disciplina->nome,0,30) : substr($inscricao->turma->curso->nome,0,35)}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{$inscricao->turma->professor->nome_simples}} </small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{implode($inscricao->turma->dias_semana,', ').' '.$inscricao->turma->hora_inicio. '-'.$inscricao->turma->hora_termino}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>{{$inscricao->turma->local->sigla}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>{{\Carbon\Carbon::parse($inscricao->updated_at)->format('d/m/y')}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        @if($inscricao->status != 'cancelado')
                                        <a a href="#" onclick="remover({{$inscricao->id}});" title="Cancelar disciplina"><i class=" fa fa-times "></i></a>
                                        @else
                                        <a a href="#" onclick="recolocar({{$inscricao->id}});" title="Reativar disciplina"><i class=" fa fa-undo "></i></a>
                                        @endif
                                        
                                   
                                    </div>
                                </div>
                         
                            </div>
                            @endforeach
                            @endif
                        </li>
                        @endforeach
                        @foreach($inscricoes as $inscricao_livre)
                        @if($inscricao_livre->status == 'cancelado')
                        <li class="alert-danger" style="background-color: #F2DEDE;">
                        @elseif($inscricao_livre->status == 'pendente')
                        <li class="alert-warning" style="background-color: #FFD8B0;" >
                        @else
                        <li>
                        @endif
                            <div class="row">                          
                                    @if($matricula->inscricoes->first()->turma->programa->id == 12)
                                            <div class="col-xl-4 text-success " title="CE - {{$inscricao_livre->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @elseif($matricula->inscricoes->first()->turma->programa->id == 2)
                                            <div class="col-xl-4 text-primary " title="PID - {{$inscricao_livre->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @elseif($matricula->inscricoes->first()->turma->programa->id == 3)
                                            <div class="col-xl-4 text-warning " title="UATI - {{$inscricao_livre->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @elseif($matricula->inscricoes->first()->turma->programa->id == 1)
                                            <div class="col-xl-4 text-danger " title="UNIT - {{$inscricao_livre->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @else
                                            <div class="col-xl-4 text-secondary " style="line-height:40px !important; padding-left: 30px;" >
                                    @endif
                                    <div><i class=" fa fa-circle-o "></i> &nbsp;<small><b>i{{$inscricao_livre->id}}  - {{$inscricao_livre->turma->curso->nome}}</b></small></div> 
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{$inscricao_livre->turma->professor->nome_simples}} </small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{implode($inscricao_livre->turma->dias_semana,', ').' '.$inscricao_livre->turma->hora_inicio. '-'.$inscricao_livre->turma->hora_termino}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>{{$inscricao_livre->turma->local->sigla}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>{{\Carbon\Carbon::parse($inscricao_livre->updated_at)->format('d/m/y')}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <a href="#" title="Cancelar Matrícula"><i class=" fa fa-times "></i></a>
                                        <a href="#" title="Editar Matrícula"><i class=" fa fa-pencil-square-o "></i></a>
                                        <a href="#" title="Imprimir Termo de Matrícula"><i class=" fa fa-print "></i></a>
                                        
                                    </div>
                                </div>
                         
                            </div>
                        </li>

                        @endforeach
                    </ul>
                </div>
			</div>
		</div>
    </div>
    <div class="row">
        <div class="col-xl-12 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Boletos</p>
                    </div>

                </div>

                <div class="card-block">
                    <ul class="item-list striped">
                        <li class="item item-list-header ">
                            <div class="row ">
                                <div class="col-xl-4 " style="line-height:40px !important; padding-left: 30px;">
                                    <div> &nbsp;<small><b>Número</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small><b>Vencimento</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div title="Vencimento"><small><b>Valor</b></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small><b>Status</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <small><b>Opções</b></small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @foreach($boletos as $boleto)
                        @if($boleto->status == 'pago')
                        <li class="alert-info">
                        @elseif($boleto->status == 'cancelar')
                        <li class="alert-warning" style="background-color: #FFD8B0;">
                        @elseif($boleto->status == 'cancelado')
                        <li class="alert-danger" style="background-color: #F2DEDE;">
                        @else
                        <li>
                        @endif
                            <div class="row ">
                                <div class="col-xl-4 " style="line-height:40px !important; padding-left: 30px;">
                                    <div class="dropdown-toggle"><i class=" fa fa-barcode "></i> &nbsp;<small><b>{{$boleto->id}}</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{\Carbon\Carbon::parse($boleto->vencimento)->format('d/m/y')}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div title="Vencimento"><small>R$ {{$boleto->valor}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>{{$boleto->status}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <i class=" fa fa-times "></i>
                                        <i class=" fa fa-pencil-square-o "></i>
                                        <i class=" fa fa-print "></i>
                                       
                                    </div>
                                </div>
                            </div>

                            <!-- foreach lancamentos do boleto -->
                            @foreach($boleto->lancamentos as $lancamento)
                             <div class="row">
                                                         
                                <div class="col-xl-4" style="line-height:40px !important; padding-left: 50px;">
                                    <div></i> &nbsp;<small>{{$lancamento->referencia}} {{$lancamento->matricula}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>Parcela {{$lancamento->parcela}} </small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>R$ {{$lancamento->valor}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>{{$lancamento->status}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <i class=" fa fa-times "></i>
                                    
                                       
                                    </div>
                                </div>
                         
                            </div>
                            @endforeach
                        </li>
                        @endforeach
                        
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Parcelas em aberto</p>
                    </div>
                </div>
                <div class="card-block">
                    <ul class="item-list striped">
                        <li class="item item-list-header ">
                            <div class="row ">
                                <div class="col-xl-4 " style="line-height:40px !important; padding-left: 30px;">
                                    <div><i class=" fa fa-usd "></i> &nbsp;<small><b>Referência</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small><b>Parcela</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div title="Vencimento"><small><b>Valor</b></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small><b>Status</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <small><b>Opções</b></small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @foreach($lancamentos as $lancamento)
                        <li>
                            <div class="row">
                                                         
                                <div class="col-xl-4" style="line-height:40px !important; padding-left: 50px;">
                                    <div></i> &nbsp;<small>{{$lancamento->referencia}} {{$lancamento->matricula}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>Parcela {{$lancamento->parcela}} </small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>R$ {{$lancamento->valor}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>{{$lancamento->status}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <i class=" fa fa-times "></i>
                                        <i class=" fa fa-pencil-square-o "></i>
                                        <i class=" fa fa-print "></i>
                                    
                                       
                                    </div>
                                </div>
                         
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
            </div>
        </div>
    </div>		
</section>

@endsection
@section('scripts')
<script>
  function remover(inscricao){
    if(confirm('Tem certeza que deseja cancelar esta inscrição?'))
        window.location.replace("{{asset('secretaria/matricula/inscricao/apagar')}}/"+inscricao);
  }
  function recolocar(inscricao){
    if(confirm('Tem certeza que deseja reativar esta inscrição?'))
        window.location.replace("{{asset('secretaria/matricula/inscricao/reativar')}}/"+inscricao);
  }

  function cancelar(matricula){
    if(confirm('Tem certeza que deseja cancelar esta matrícula?'))
        window.location.replace("{{asset('/secretaria/matricula/cancelar/')}}/"+matricula);
  }
  function reativar(matricula){
    if(confirm('Tem certeza que deseja reativar esta matrícula?'))
        window.location.replace("{{asset('/secretaria/matricula/reativar/')}}/"+matricula);
  }
</script>
@endsection
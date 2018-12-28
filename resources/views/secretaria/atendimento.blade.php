@extends('layout.app')
@section('titulo')Atendimento 2.2 @endsection
@section('pagina')

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="../">secretaria</a></li>
  <li  class="breadcrumb-item active">atendimento</li>
</ol>

<div class="title-search-block">
    <div class="title-block">
        <h3 class="title" >{{$pessoa->nome}} 
            @if(isset($pessoa->nome_resgistro))
                ({{$pessoa->nome_resgistro}})
            @endif
           
        </h3>
        <p class="title-description" style="padding-top: 7px;">Cod. {{$pessoa->id}} - Tel. {{$pessoa->telefone}}</p>
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
                    <div><a href="{{asset('/secretaria/matricula/nova').'/'.$pessoa->id}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-plus-circle "></i>  <small>Nova Matrícula</small></a></div>
                    
                    <div><a href="/secretaria/matricula/renovar/{{$pessoa->id}}" class="btn btn-warning-outline col-xs-12 text-xs-left"><i class="fa fa-check-square-o"></i> <small> Renovar (Rematricula) </small> </a></div>
                    <!--
                    <div><a href="#" class="btn btn-secondary col-xs-12 text-xs-left" title="Rematrículas encerradas."><i class="fa fa-check-square-o"></i> <small> Rematricula ENCERRADA </small> </a></div>
                    -->
                  

                </div>
                
            </div>
        </div>  
        <div class="col-xl-4 center-block"> 
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Atestado Médico</p>
                    </div>
                </div>
                <div class="card-block">
                    @if(isset($atestado))
                    <div><a href="{{asset('/documentos/atestados').'/'.$atestado->id.'.pdf'}}" class="btn btn-success col-xs-12 text-xs-left"><i class=" fa fa-medkit "></i>  <small>Válido até {{\Carbon\Carbon::parse($atestado->validade)->format('d/m/Y')}}</small></a></div>
                    @else  
                    <div><span class="btn btn-secondary col-xs-12 text-xs-left"><i class=" fa fa-exclamation-circle "></i>  <small>Nenhum atestado válido.</small></span></div>
                    @endif
                    <div><a href="{{asset('/pessoa/atestado/cadastrar').'/'.$pessoa->id}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-plus-circle"></i> <small>Novo atestado.</small></a></div>

                  
                   
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
                    <div><a href="{{asset('/pessoa/bolsa/cadastrar/'.$pessoa->id)}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-plus-square-o"></i> <small>Solicitações de Bolsa</small></a></div>
                    
                </div>
                
            </div>
        </div>
    </div>
</section>
@include('inc.errors')
@foreach($errosPessoa as $erros)
<div class="alert alert-danger alert-dismissible">
  <a href="#" class="close" onclick="apagaErro({{$erros->id}});" >&times;</a>
  <strong><i class="fa fa-warning"></i> ATENÇÃO:</strong> {{$erros->valor}}.
</div>
@endforeach
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
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small><b>Estado</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <small><b>Opções</b></small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @foreach($matriculas as $matricula)
                        <li>
                            @if(count($matricula->inscricoes) == 0)
                             <div class="row alert-danger">                                                
                                  
                                <div class="col-xl-11 text-secondary " style="line-height:40px !important; padding-left: 30px;" >
                                    
                                    <div><i class=" fa fa-exclamation-circle "></i> &nbsp;<small><b>M{{$matricula->id}}  - SEM INSCRIÇÕES </b></small></div> 
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                     @if($matricula->status != 'cancelada')
                                    <a a href="#" onclick="cancelar({{$matricula->id}});" title="Cancelar Matrícula"><i class=" fa fa-times "></i></a>
                                    @endif
                                    
                                </div>
                            </div>
                            @else
                            <div class="row">                          
                                    @if($matricula->inscricoes->first()->turma->programa->id == 12)
                                            <div class="col-xl-4 text-success" title="CE - {{$matricula->inscricoes->first()->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
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
                                <div class="col-xl-2" style="line-height:40px !important;">

                                    @if($matricula->getBolsas())

                                        @if($matricula->getBolsas()->status == 'ativa')
                                         <small><span class="text-success" title="{{$matricula->getBolsas()->tipo->nome.' - '.$matricula->getBolsas()->status}}"> <i class=" fa fa-flag"></i> RD {{$matricula->getBolsas()->bolsa}} </span></small>&nbsp;

                                        @elseif($matricula->getBolsas()->status == 'analisando')
                                        <small><span class="text-warning" title="{{$matricula->getBolsas()->tipo->nome.' - '.$matricula->getBolsas()->status}}"> <i class=" fa fa-flag"></i> RD {{$matricula->getBolsas()->bolsa}} </span></small>&nbsp;

                                        @elseif($matricula->getBolsas()->status == 'cancelada')
                                        <small><span class="text-danger" title="{{$matricula->getBolsas()->tipo->nome.' - '.$matricula->getBolsas()->status}}"> <i class=" fa fa-flag"></i> RD {{$matricula->getBolsas()->bolsa}} </span></small>&nbsp;

                                        @elseif($matricula->getBolsas()->status == 'expirada')
                                        <small><span class="text-secondar" title="{{$matricula->getBolsas()->tipo->nome.' - '.$matricula->getBolsas()->status}}"> <i class=" fa fa-flag"></i> RD {{$matricula->getBolsas()->bolsa}} </span></small>&nbsp;
                                        
                                        @else
                                        <small><span title="{{$matricula->getBolsas()->tipo->nome.' - '.$matricula->getBolsas()->status}}"> <i class=" fa fa-flag"></i> RD {{$matricula->getBolsas()->bolsa}} </span></small>&nbsp;
                                        @endif
                                    
                                    @endif
                                    @if($matricula->obs!='')
                                    <small class="text-info" title="{{ $matricula->obs}}"><i class=" fa fa-info text-info" ></i> Obs</small>
                                    @endif

                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;"></div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    
                                    @if($matricula->status == 'cancelada')
                                    <div class="btn btn-danger btn-oval btn-sm" title="Matrícula cancelada">Cancelada</div>
                                    @elseif($matricula->status == 'pendente')
                                   <div class="btn btn-warning btn-oval btn-sm" title="Matrícula pendente (termo ou documentação pendente)">Pendente</div>
                                    @elseif($matricula->status == 'espera')
                                    <div class="btn btn-info btn-oval btn-sm" title="Matrícula em espera (aguardando início do curso)">Espera</div>
                                    @elseif($matricula->status == 'expirada')
                                    <div class="btn btn-secondary btn-oval btn-sm " title="Matrícula expirada (curso encerrado)">M. Expirada</div>
                                    @elseif($matricula->status == 'ativa')
                                    <div class="btn btn-success btn-oval btn-sm" title="Matrícula ativa">Mat. Ativa</div>
                                    @else

                                    <div class="btn btn-danger-outline btn-oval btn-sm">{{$matricula->status}}</div>

                                    @endif

                                    
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important; text-align: right;">
                                    <div class="profile dropdown">
                                            <a class="btn btn-sm btn-oval btn-secondary dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
                                            <i class="fa fa-cog icon"></i>
                                             <span class="name"><small> Opções</small>
                                    </span> </a>
                                        <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <!-- <a class="dropdown-item disabled" style="text-decoration: none;" href="#"> <i class="fa fa-archive icon"></i> Histórico</a>-->




                                            @if($matricula->status =='ativa'||$matricula->status =='pendente')
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/editar/').'/'.$matricula->id}}"> <i class="fa fa-pencil-square-o icon"></i> Editar matrícula</a>
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}"> <i class="fa fa-print icon"></i> Imprimir termo</a>
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/secretaria/matricula/uploadglobal/1/1/1/{{$matricula->id}}"> <i class="fa fa-cloud-upload icon"></i> (Re)Enviar termo</a>
                                            @if(file_exists('documentos/matriculas/termos/'.$matricula->id.'.pdf'))
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/documentos/matriculas/termos/{{$matricula->id}}.pdf"> <i class="fa fa-file-text-o icon"></i> Termo disponivel</a>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" style="text-decoration: none; color:#FF4444;" href="#" onclick="cancelar({{$matricula->id}});"> <i class="fa fa-times icon"></i> Cancelar </a>




                                            @elseif($matricula->status =='espera')
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/editar/').'/'.$matricula->id}}"> <i class="fa fa-pencil-square-o icon"></i> Editar matrícula</a>
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}"> <i class="fa fa-print icon"></i> Imprimir termo</a>
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/secretaria/matricula/uploadglobal/1/1/1/{{$matricula->id}}"> <i class="fa fa-cloud-upload icon"></i> (Re)Enviar termo</a>
                                             @if(file_exists('documentos/matriculas/termos/'.$matricula->id.'.pdf'))
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/documentos/matriculas/termos/{{$matricula->id}}.pdf"> <i class="fa fa-file-text-o icon"></i> Termo disponivel</a>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" style="text-decoration: none; color:#FF4444;" href="#" onclick="cancelar({{$matricula->id}});"> <i class="fa fa-times icon"></i> Cancelar </a>




                                            @elseif($matricula->status =='expirada')
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}"> <i class="fa fa-print icon"></i> Imprimir termo</a>
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/secretaria/matricula/uploadglobal/1/1/1/{{$matricula->id}}"> <i class="fa fa-cloud-upload icon"></i> (Re)Enviar termo</a>
                                             @if(file_exists('documentos/matriculas/termos/'.$matricula->id.'.pdf'))
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/documentos/matriculas/termos/{{$matricula->id}}.pdf"> <i class="fa fa-file-text-o icon"></i> Termo disponivel</a>
                                            @endif



                                            @else 
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}"> <i class="fa fa-print icon"></i> Imprimir Termo</a>
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/imprimir-cancelamento/').'/'.$matricula->id}}"> <i class="fa fa-print icon"></i> Imprimir Cancelamento</a>
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/secretaria/matricula/uploadglobal/1/1/1/{{$matricula->id}}"> <i class="fa fa-cloud-upload icon"></i> (Re)Enviar termo</a>
                                             @if(file_exists('documentos/matriculas/termos/'.$matricula->id.'.pdf'))
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/documentos/matriculas/termos/{{$matricula->id}}.pdf"> <i class="fa fa-file-text-o icon"></i> Termo disponivel</a>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" style="text-decoration: none; color:#fe974b;" href="#reativar" onclick="reativar({{$matricula->id}});"> <i class="fa fa-undo icon"></i> Reativar </a>
                                            @endif
                                          

                                              
                                           
                                            
                                           
                                        </div>
                                                                        </div>

                                </div>                             

                            </div>
                            @foreach($matricula->inscricoes as $inscricao)
                            @if($inscricao->status =='cancelada')
                            <div class="row lista text-danger" >
                            @else
                            <div class="row lista" >
                            @endif
                           
                                                             
                                <div class="col-xl-4" title="Turma {{$inscricao->turma->id}} - {{ isset($inscricao->turma->disciplina->nome) ? $inscricao->turma->disciplina->nome: $inscricao->turma->curso->nome}} " style="line-height:40px !important; padding-left: 50px;">
                                     <div><i class=" fa fa-caret-right"></i>&nbsp;<small>&nbsp;i{{$inscricao->id}} - 
                                        {{ isset($inscricao->turma->disciplina->nome) ? substr($inscricao->turma->disciplina->nome,0,30) : substr($inscricao->turma->curso->nome,0,30)}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{$inscricao->turma->professor->nome_simples}} </small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{implode($inscricao->turma->dias_semana,', ').' '.$inscricao->turma->hora_inicio. '-'.$inscricao->turma->hora_termino}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small title="{{$inscricao->turma->local->nome}}">{{$inscricao->turma->local->sigla}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    @if($inscricao->status == 'cancelada')
                                    <div class="badge badge-pill badge-danger" title="Criada em {{$inscricao->created_at->format('d/m/y')}} e atualizada em {{$inscricao->updated_at->format('d/m/y')}}">cancelada</div>
                                    @elseif($inscricao->status == 'regular')
                                    <div class="badge badge-pill badge-success" title="Criada em {{$inscricao->created_at->format('d/m/y')}} e atualizada em {{$inscricao->updated_at->format('d/m/y')}}">regular</div>
                                    @elseif($inscricao->status == 'pendente')
                                    <div class="badge badge-pill badge-warning" title="Criada em {{$inscricao->created_at->format('d/m/y')}} e atualizada em {{$inscricao->updated_at->format('d/m/y')}}">pendente</div>
                                    @elseif($inscricao->status == 'finalizada' || $inscricao->status == 'finalizado')
                                    <div class="badge badge-pill badge-light" title="Criada em {{$inscricao->created_at->format('d/m/y')}} e atualizada em {{$inscricao->updated_at->format('d/m/y')}}">finalizada</div>
                                    @else
                                     <div class="badge badge-pill badge-secondary" title="Criada em {{$inscricao->created_at->format('d/m/y')}} e atualizada em {{$inscricao->updated_at->format('d/m/y')}}">{{$inscricao->status}}</div>
                                    @endif
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        @if($inscricao->status == 'cancelada')
                                        <a a href="#" 
                                            onclick="recolocar({{$inscricao->id}});" 
                                            title="Reativar disciplina"
                                            class="badge badge-pill badge-warning">
                                            <i class=" fa fa-undo " style="color:white;"></i>
                                        </a>
                                        @if(file_exists('documentos/inscricoes/cancelamentos/'.$inscricao->id.'.pdf'))
                                            &nbsp;
                                            <a href="/documentos/inscricoes/cancelamentos/{{$inscricao->id}}.pdf" target="_blank" class="badge badge-pill badge-primary">  <i class=" fa fa-file-text-o " title="Termo de cancelamento disponível" style="color:white;"></i>
                                            </a>
                                        @else
                                            &nbsp;<a href="{{asset('secretaria/matricula/uploadglobal/0/0/1').'/'.$inscricao->id}}" class="badge badge-pill badge-primary"><i class="fa fa-cloud-upload " title="Enviar Termo de Cancelamento de disciplina" style="color:white;"></i></a>
                                        @endif
                                        <a a href="{{asset('secretaria/matricula/inscricao/imprimir/cancelamento'.'/'.$inscricao->id)}}" 
                                            title="Imprimir cancelamento"
                                            class="badge badge-pill badge-primary">
                                            <i class=" fa fa-print " style="color:white;"></i>
                                        </a>
                                        
                                        @elseif($inscricao->status == 'regular')
                                        <a a href="#"
                                             onclick="remover({{$inscricao->id}});" 
                                             title="Cancelar inscrição" 
                                             class="badge badge-pill badge-danger">
                                             <i class=" fa fa-times" style="color:white;"></i>
                                         </a>
                                         &nbsp;
                                        <a href="{{asset('/secretaria/matricula/inscricao/editar/').'/'.$inscricao->id}}"                                
                                            title="Editar Inscrição" 
                                            class="badge badge-pill badge-primary">
                                            <i class=" fa fa-pencil-square-o " style="color:white;"></i>
                                        </a>
                                        <!--
                                         &nbsp;
                                        <a href="{{asset('/secretaria/matricula/inscricao/trocar/').'/'.$inscricao->id}}"                                
                                            title="Mudar de turma" 
                                            class="badge badge-pill badge-primary">
                                            <i class=" fa fa-exchange" style="color:white;"></i>
                                        </a>
                                    -->
                                        


                                        @elseif($inscricao->status == 'transferida')
                                        &nbsp;
                                        @if(file_exists('documentos/inscricoes/transferencias/'.$inscricao->id.'.pdf'))
                                            &nbsp;
                                            <a href="/documentos/inscricoes/transferencias/{{$inscricao->id}}.pdf" target="_blank" class="badge badge-pill badge-primary">  <i class=" fa fa-file-text-o " title="Formulário de transferencia disponível" style="color:white;"></i>
                                            </a>
                                        @else
                                            &nbsp;<a href="#" class="badge badge-pill badge-primary"><i class="fa fa-cloud-upload " title="Enviar formulário de transferencia de turma" style="color:white;"></i></a>
                                        @endif
                                          <a a href="{{asset('secretaria/matricula/inscricao/imprimir/transferencia'.'/'.$inscricao->id)}}" 
                                            title="Imprimir transferência"
                                            class="badge badge-pill badge-primary">
                                            <i class=" fa fa-print " style="color:white;"></i>
                                        </a>

                                        @else

                                        
                                        @endif
                                    </div>
                                </div>
                         
                            </div>
                            @endforeach
                            @endif
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
                         &nbsp;
                         <a href="{{asset('financeiro/boletos/novo'.'/'.session('pessoa_atendimento'))}}" title="Gerar novo boleto individual" class="text-white te" style="" ><i class=" fa fa-plus-circle "></i></a>
                         &nbsp;
                         <a href="#"  onclick="gerarBoletos();" title="Gerar boleto com todas parcelas em aberto para daqui 5 dias úteis." class="text-white te" style="" ><i class=" fa fa-cogs "></i></a>
                    </div>


                </div>

                <div class="card-block">
                    <ul class="item-list striped">
                        <li class="item item-list-header ">
                            <div class="row ">
                                <div class="col-xl-5 " style="line-height:40px !important; padding-left: 30px;">
                                    <div> &nbsp;<small><b>Número</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small><b>Vencimento</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div title="Vencimento"><small><b>Valor</b></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important; ">
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
             
                        <li >
                       
                            <div class="row lista">
                                <div class="col-xl-5 " style="line-height:40px !important; padding-left: 30px;">
                                    <div class="dropdown-toggle"><i class=" fa fa-barcode "></i> &nbsp;<small>Documento nº <b>{{$boleto->id}}</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{\Carbon\Carbon::parse($boleto->vencimento)->format('d/m/y')}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div title="Vencimento"><small>R$ {{$boleto->valor}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    @if($boleto->status == 'pago')
                                    <div class="badge badge-pill badge-success">pago</div>
                                    @elseif($boleto->status == 'emitido')
                                    <div class="badge badge-pill badge-info">emitido</div>
                                    @elseif($boleto->status == 'impresso')
                                    <div class="badge badge-pill badge-primary">impresso</div>
                                    @elseif($boleto->status == 'cancelar')
                                    <div class="badge badge-pill badge-warning">cancelar</div>
                                    @elseif($boleto->status == 'cancelado')
                                    <div class="badge badge-pill badge-danger">cancelado</div>
                                    @else
                                    <div class="badge badge-pill badge-secondary">gravado</div>

                                    @endif




                                    
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div >
                                        @if($boleto->status == 'impresso' || $boleto->status == 'gravado')
                                        <a href="{{asset('financeiro/boletos/imprimir/').'/'.$boleto->id}}" title="Imprimir Boleto" ><i class=" fa fa-print "></i></a>
                                        <a href="{{asset('financeiro/boletos/editar/').'/'.$boleto->id}}"  title="Editar Boleto" ><i class=" fa fa-pencil-square-o "></i></a>
                                        <a href="#" onclick="cancelarBoleto({{$boleto->id}});" title="Cancelar Boleto" ><i class=" fa fa-times "></i></a>




                                        @elseif($boleto->status == 'emitido')
                                        <a href="{{asset('financeiro/boletos/imprimir/').'/'.$boleto->id}}" title="Imprimir Boleto" ><i class=" fa fa-print " ></i></a>
                                        <a href="#" onclick="cancelarBoleto({{$boleto->id}});" title="Cancelar Boleto" ><i class=" fa fa-times " ></i></a>
                                        
                                        @elseif($boleto->status == 'cancelar')
                                        
                                        <a href="{{asset('financeiro/boletos/imprimir').'/'.$boleto->id}}"  title="Imprimir"><i class=" fa fa-print "></i></a>
                                        <a href="#" onclick="reativarBoleto({{$boleto->id}});" title="Reativar Boleto"><i class=" fa fa-undo "></i></a>
                                        
                                        @endif
                                        
                                       
                                    </div>
                                </div>
                            </div>

                            <!-- foreach lancamentos do boleto -->
                            @foreach($boleto->lancamentos as $lancamento)
                             @if($lancamento->status == 'cancelado')
                             <div class="row text-danger">
                            @else
                             <div class="row">
                            @endif
                                                         
                                <div class="col-xl-5" style="line-height:40px !important; padding-left: 50px;">
                                    <div></i> &nbsp;<small>{{$lancamento->referencia}} {{$lancamento->matricula}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>Parcela {{$lancamento->parcela}} </small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>R$ {{$lancamento->valor}}</small></div>
                                </div>
                         
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>{{$lancamento->status}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>





                                        @if($lancamento->status == 'cancelado' )
                                        
                                         <a href="#" onclick="reativarParcela({{$lancamento->id}})" title="Reativar parcela"> <i class="fa fa-undo "></i></a>&nbsp;
                                         <a a href="#" onclick="relancarParcela({{$lancamento->id}});" title="Relançar Parcela"><i class=" fa fa-external-link-square "></i></a>

                                        @elseif($boleto->status=='gravado')

                                         <a class="remove" onclick="cancelarParcela({{$lancamento->id}})" href="#" title="Cancelar parcela"> <i class="fa fa-times "></i></a>&nbsp;
                                        <a href="{{asset('financeiro/lancamentos/editar').'/'.$lancamento->id}}" title="Editar parcela"> <i class="fa fa-pencil-square-o "></i></a>&nbsp;
                                         
                            
                                        @endif
                                      
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
                        &nbsp;
                        <a href="{{asset('financeiro/lancamentos/novo'.'/'.session('pessoa_atendimento'))}}" title="Gerar parcela individual" class="text-white te" style="" ><i class=" fa fa-plus-circle "></i></a>
                        &nbsp;
                         <a href="#" onclick="gerarLancamentos()"  title="Gerar parcela atual das matriculas ativas" class="text-white te" style="" ><i class=" fa fa-cogs "></i></a>
                    </div>
                </div>
                <div class="card-block">
                    <ul class="item-list striped">
                        <li class="item item-list-header ">
                            <div class="row ">
                                <div class="col-xl-5 " style="line-height:40px !important; padding-left: 30px;">
                                    <div><i class=" fa fa-usd "></i> &nbsp;<small><b>Referência</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small><b>Parcela</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div title="Vencimento"><small><b>Valor</b></small></div>
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
                        @if($lancamento->status == 'cancelado')
                        <li class="text-danger" >
                        @else
                        <li>
                        @endif
                            <div class="row">
                                                         
                                <div class="col-xl-5" style="line-height:40px !important; padding-left: 50px;">
                                    <div></i> &nbsp;<small>{{$lancamento->referencia}} {{$lancamento->matricula}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>Parcela {{$lancamento->parcela}} </small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>R$ {{$lancamento->valor}}</small></div>
                                </div>
                              
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>{{$lancamento->status}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        @if($lancamento->status == null)
                                        <a class="remove" onclick="cancelarParcela({{$lancamento->id}})" href="#" title="Cancelar parcela"> <i class="fa fa-times "></i></a>&nbsp;
                                        <a href="{{asset('financeiro/lancamentos/editar').'/'.$lancamento->id}}" title="Editar parcela"> <i class="fa fa-pencil-square-o "></i></a>&nbsp;
                                         <a href="#" onclick="excluirParcela({{$lancamento->id}})" title="Excluir parcela"> <i class="fa fa-trash-o"></i></a>
                                        @else
                                        <a href="#" onclick="reativarParcela({{$lancamento->id}})" title="Reativar parcela"> <i class="fa fa-undo "></i></a>&nbsp;
                                         <a href="#" onclick="excluirParcela({{$lancamento->id}})" title="Excluir parcela"> <i class="fa fa-trash-o "></i></a>
                                        @endif
                                        
                                        
                                    
                                       
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
  function cancelarBoleto(boleto){
    if(confirm('Tem certeza que deseja cancelar este boleto? Todos lançamentos deste serão cancelados.'))
        window.location.replace("{{asset('/financeiro/boletos/cancelar/')}}/"+boleto);
  }
  function reativarBoleto(boleto){
    if(confirm('Tem certeza que deseja cancelar este boleto? Todos lançamentos deste serão cancelados.'))
        window.location.replace("{{asset('/financeiro/boletos/reativar/')}}/"+boleto);
  }
  function cancelarParcela(item)
  {
    if(confirm("Tem certeza que deseja cancelar esse lancamento?")){
        $(location).attr('href','{{asset("/financeiro/lancamentos/cancelar")}}/'+item);
    }
  }
  function reativarParcela(item)
  {
    if(confirm("Tem certeza que deseja reativar essa parcela?")){
        $(location).attr('href','{{asset("/financeiro/lancamentos/reativar")}}/'+item);
    }
  }
  function relancarParcela(item)
  {
    if(confirm("Tem certeza que deseja relançar essa parcela?")){
        $(location).attr('href','{{asset("/financeiro/lancamentos/relancar")}}/'+item);
    }
  }
  function gerarLancamentos(){
    if(confirm("Tem certeza que deseja gerar todas parcelas das matriculas ativas e pendentes?")){
        $(location).attr('href','{{asset("/financeiro/lancamentos/gerar-individual").'/'.$pessoa->id}}');
    }
}
function gerarBoletos()
{
    if(confirm("Tem certeza que deseja gerar um boleto com os lancamentos em aberto? OBS: O vencimento será em 5 dias.")){
        $(location).attr('href','{{asset("/financeiro/boletos/gerar-individual").'/'.$pessoa->id}}');
    }
}

function apagaErro(id){

    if(confirm("Deseja excluir o aviso?")){
        $(location).attr('href','{{asset("/pessoa/apagar-atributo")}}/'+id);
    }

}
function excluirParcela(id){

    if(confirm("Deseja excluir a parcela "+id)){
         $(location).attr('href','{{asset("/financeiro/lancamentos/excluir").'/'}}'+id);
    }

}
</script>
@endsection
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
                    <div><a href="{{asset('/secretaria/matricula/nova').'/'.$pessoa->id}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-plus-circle "></i>  <small>Nova Matrícula</small></a></div>
                    <div><a href="/secretaria/matricula/renovar/{{$pessoa->id}}" class="btn btn-warning-outline col-xs-12 text-xs-left"><i class="fa fa-check-square-o"></i> <small> Renovar (Rematricula) </small> </a></div>
                  

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
                    <div><a href="#" class="btn btn-secondary-outline col-xs-12 text-xs-left"><i class="fa fa-external-link"></i> <small>Certificados</small></a></div>
                    
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
                                    <div><small title="Criada em {{\Carbon\Carbon::parse($matricula->created_at)->format('d/m/y')}}">{{\Carbon\Carbon::parse($matricula->updated_at)->format('d/m/y')}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        @if($matricula->status != 'cancelada')
                                                    
                                            <a href="#" class="remove" onclick="cancelar({{$matricula->id}});" title="Cancelar Matrícula"><i class=" fa fa-times "></i></a>
                                                    
                                        @else
                                                    
                                            <a href="#" onclick="reativar({{$matricula->id}});" title="Reativar Matrícula"><i class=" fa fa-undo "></i></a>
                                            @if(file_exists('documentos/matriculas/cancelamentos/'.$matricula->id.'.pdf'))
                                                &nbsp;<a href="/documentos/matriculas/cancelamentos/{{$matricula->id}}.pdf" target="_blank"><i class=" fa fa-file-text-o " title="Termo de cancelamento disponível"></i></a>
                                            @else
                                                &nbsp;<a href="/secretaria/matricula/uploadglobal/1/0/1/{{$matricula->id}}"><i class="fa fa-cloud-upload " title="Enviar Termo de Cancelamento de Matrícula"></i></a>
                                            @endif
                                                    
                                        @endif
                                                    
                                         &nbsp;<a class="edit" href="{{asset('/secretaria/matricula/editar/').'/'.$matricula->id}}" title="Editar Matrícula"><i class=" fa fa-pencil-square-o "></i></a>
                                                   
                                        
                                                                              
                                         &nbsp;<a href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}" target="_blank" title="Imprimir Termo de Matrícula"><i class=" fa fa-print "></i></a>
                                         

                                        @if($matricula->desconto > 0)
                                             &nbsp;<span><i class=" fa fa-flag " title="Esta matrícula possui bolsa."></i></span>
                                        @endif
                                         @if($matricula->status == 'pendente')
                                            &nbsp;<span><i class=" fa fa-exclamation-triangle"  title="{{$matricula->obs}}"></i></span>
                                        @elseif(($matricula->status == 'ativa' || $matricula->status == 'cancelada') && $matricula->obs!='')
                                            &nbsp; <span><i class=" fa fa-info "  title="{{ $matricula->obs}}"></i></span>
                                        @endif
                                        @if(file_exists('documentos/matriculas/termos/'.$matricula->id.'.pdf'))
                                            &nbsp;<a href="/documentos/matriculas/termos/{{$matricula->id}}.pdf" target="_blank"><i class=" fa fa-file-text-o " title="Termo disponível"></i></a>
                                        @else
                                            &nbsp;<a href="/secretaria/matricula/uploadglobal/1/1/1/{{$matricula->id}}"><i class="fa fa-cloud-upload " title="Enviar Termo de Matrícula"></i></a>
                                        @endif
                                        &nbsp;<a href="/secretaria/matricula/duplicar/{{$matricula->id}}" ><i class=" fa fa-files-o" title="Duplicar matrícula e colocar em espera"></i></a>



                                
                                        
                                                    

                                    
                                    </div>

                                </div>                             

                            </div>
                            @foreach($matricula->inscricoes as $inscricao)
                            @if($inscricao->status == 'cancelado')
                            <div class="row alert-danger">
                            @else
                            <div class="row">
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
                                    <div><small title="Criada em {{\Carbon\Carbon::parse($inscricao->created_at)->format('d/m/y')}}">{{\Carbon\Carbon::parse($inscricao->updated_at)->format('d/m/y')}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        @if($inscricao->status != 'cancelado')
                                        <a a href="#" onclick="remover({{$inscricao->id}});" title="Cancelar disciplina"><i class=" fa fa-times "></i></a>
                                        <a href="{{asset('/secretaria/matricula/inscricao/editar/').'/'.$inscricao->id}}" target="_blank" title="Editar Inscrição"><i class=" fa fa-pencil-square-o "></i></a>
                                        @else

                                        <a a href="#" onclick="recolocar({{$inscricao->id}});" title="Reativar disciplina"><i class=" fa fa-undo "></i></a>
                                         @if(file_exists('documentos/inscricoes/cancelamentos/'.$inscricao->id.'.pdf'))
                                            &nbsp;<a href="/documentos/inscricoes/cancelamentos/{{$inscricao->id}}.pdf" target="_blank"><i class=" fa fa-file-text-o " title="Termo de cancelamento disponível"></i></a>
                                        @else
                                            &nbsp;<a href="{{asset('secretaria/matricula/uploadglobal/0/0/1').'/'.$inscricao->id}}"><i class="fa fa-cloud-upload " title="Enviar Termo de Cancelamento de disciplina"></i></a>
                                        @endif
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
                                    @if($inscricao_livre->turma->programa->id == 12)
                                            <div class="col-xl-4 text-success " title="CE - {{$inscricao_livre->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @elseif($inscricao_livre->turma->programa->id == 2)
                                            <div class="col-xl-4 text-primary " title="PID - {{$inscricao_livre->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @elseif($inscricao_livre->turma->programa->id == 3)
                                            <div class="col-xl-4 text-warning " title="UATI - {{$inscricao_livre->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @elseif($inscricao_livre->turma->programa->id == 1)
                                            <div class="col-xl-4 text-danger " title="UNIT - {{$inscricao_livre->turma->curso->nome}}" style="line-height:40px !important; padding-left: 30px;" >
                                    @else
                                            <div class="col-xl-4 text-secondary " style="line-height:40px !important; padding-left: 30px;" >
                                    @endif
                                    <div><i class=" fa fa-circle-o "></i> &nbsp;<small><b>i{{$inscricao_livre->id}}  - {{ isset($inscricao_livre->turma->disciplina->nome) ? $inscricao_livre->turma->disciplina->nome: $inscricao_livre->turma->curso->nome}}</b></small></div> 
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{$inscricao_livre->turma->professor->nome_simples}} </small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>{{implode($inscricao_livre->turma->dias_semana,', ').' '.$inscricao_livre->turma->hora_inicio. '-'.$inscricao_livre->turma->hora_termino}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small title="{{$inscricao_livre->turma->local->nome}}">{{$inscricao_livre->turma->local->sigla}}</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small title="{{\Carbon\Carbon::parse($inscricao_livre->created_at)->format('d/m/y')}}">{{\Carbon\Carbon::parse($inscricao_livre->updated_at)->format('d/m/y')}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        @if($inscricao_livre->status != 'cancelado')
                                        <a a href="#" onclick="remover({{$inscricao_livre->id}});" title="Cancelar disciplina"><i class=" fa fa-times "></i></a>
                                        @else
                                        <a a href="#" onclick="recolocar({{$inscricao_livre->id}});" title="Reativar disciplina"><i class=" fa fa-undo "></i></a>
                                        @if(file_exists('documentos/inscricoes/cancelamentos/'.$inscricao_livre->id.'.pdf'))
                                            &nbsp;<a href="/documentos/inscricoes/cancelamentos/{{$inscricao_livre->id}}.pdf" target="_blank"><i class=" fa fa-file-text-o " title="Termo de cancelamento disponível"></i></a>
                                        @else
                                            &nbsp;<a href="{{asset('secretaria/matricula/uploadglobal/0/0/1').'/'.$inscricao_livre->id}}"><i class="fa fa-cloud-upload " title="Enviar Termo de Cancelamento de disciplina"></i></a>
                                        @endif
                                        @endif
                                        <a href="#" title="Imprimir inscrição"><i class=" fa fa-print "></i></a>
                                        
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
                                        @if($boleto->status == 'impresso' || $boleto->status == 'gravado')
                                        <a a href="{{asset('financeiro/boletos/imprimir/').'/'.$boleto->id}}" target="_blank" title="Imprimir Boleto"><i class=" fa fa-print "></i></a>
                                        <a a href="{{asset('financeiro/boletos/editar/').'/'.$boleto->id}}" target="_blank"  title="Editar Boleto"><i class=" fa fa-pencil-square-o "></i></a>
                                        <a a href="#" onclick="cancelarBoleto({{$boleto->id}});" title="Cancelar Boleto"><i class=" fa fa-times "></i></a>
                                        @elseif($boleto->status == 'emitido')
                                        <a a href="{{asset('financeiro/boletos/imprimir/').'/'.$boleto->id}}" target="_blank" title="Imprimir Boleto"><i class=" fa fa-print "></i></a>
                                        <a a href="#" onclick="cancelarBoleto({{$boleto->id}});" title="Cancelar Boleto"><i class=" fa fa-times "></i></a>
                                        
                                        @elseif($boleto->status == 'cancelar')
                                        
                                        <a a href="{{asset('financeiro/boletos/imprimir').'/'.$boleto->id}}" target="_blank" title="Imprimir"><i class=" fa fa-print "></i></a>
                                        <a a href="#" onclick="reativarBoleto({{$boleto->id}});" title="Reativar Boleto"><i class=" fa fa-undo "></i></a>
                                        @elseif($boleto->status == 'pago' || $boleto->status == 'cancelado')
                                        <a a href="{{asset('financeiro/boletos/imprimir').'/'.$boleto->id}}" target="_blank" title="Imprimir"><i class=" fa fa-print "></i></a>
                                        @endif
                                        
                                       
                                    </div>
                                </div>
                            </div>

                            <!-- foreach lancamentos do boleto -->
                            @foreach($boleto->lancamentos as $lancamento)
                             @if($lancamento->status == 'cancelado')
                             <div class="row alert-danger">
                            @else
                             <div class="row">
                            @endif
                                                         
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
                                        @if($lancamento->status == 'cancelado')
                                        <a a href="#" onclick="relancarParcela({{$lancamento->id}});" title="Relançar Parcela"><i class=" fa fa-external-link-square "></i></a>
                                         <a href="#" onclick="reativarParcela({{$lancamento->id}})" title="Reativar parcela"> <i class="fa fa-undo "></i></a>
                                        @else 
                                        <a class="remove" onclick="cancelarParcela({{$lancamento->id}})" href="#" title="Cancelar parcela"> <i class="fa fa-times "></i></a>
                                        @endif
                                        <a href="{{asset('financeiro/lancamentos/editar').'/'.$lancamento->id}}" title="Editar parcela"> <i class="fa fa-pencil-square-o "></i></a>
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
                        @if($lancamento->status == 'cancelado')
                        <li class="alert-danger" style="background-color: #F2DEDE;">
                        @else
                        <li>
                        @endif
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
                                        @if($lancamento->status == null)
                                        <a class="remove" onclick="cancelarParcela({{$lancamento->id}})" href="#" title="Cancelar parcela"> <i class="fa fa-times "></i></a>
                                        <a href="{{asset('financeiro/lancamentos/editar').'/'.$lancamento->id}}" title="Editar parcela"> <i class="fa fa-pencil-square-o "></i></a>
                                        @else
                                        <a href="#" onclick="reativarParcela({{$lancamento->id}})" title="Reativar parcela"> <i class="fa fa-undo "></i></a>
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
</script>
@endsection
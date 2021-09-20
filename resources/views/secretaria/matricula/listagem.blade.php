@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('titulo')Atendimento 2.2 @endsection
@section('pagina')

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="../">secretaria</a></li>
  <li  class="breadcrumb-item active">matricula(s)</li>
</ol>

    
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
                                    
                                    
                                    &nbsp;<small><b>M/I Cod. - Curso/Disciplina</b></small>
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
                                   <div class="col-xl-4" style="line-height:40px !important; padding-left: 30px;" >
                                     <div class="dropdown-toggle"> <i class=" fa fa-circle "></i> &nbsp;<small><b>{{$matricula->id}}</b> - Aluno(a): <b> <a href="/secretaria/atender/{{$matricula->pessoa_obj->id}}">{{$matricula->pessoa_obj->nome}}</a></b></small></div> 
                                    <!--<div class="dropdown-toggle"> <i class=" fa fa-circle "></i> &nbsp;<small><b>M{{$matricula->id}}  - {{substr($matricula->inscricoes->first()->turma->curso->nome,0,25)}}</b></small></div>--> 
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>M{{$matricula->id}}</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">

                                    @if($matricula->getBolsas())

                                        @if($matricula->getBolsas()->status == 'ativa')
                                         <small><span class="text-success" title="{{$matricula->getBolsas()->tipo->nome.' - '.$matricula->getBolsas()->status}}"> <i class=" fa fa-flag"></i> RD {{$matricula->getBolsas()->id}} </span></small>&nbsp;

                                        @elseif($matricula->getBolsas()->status == 'analisando')
                                        <small><span class="text-warning" title="{{$matricula->getBolsas()->tipo->nome.' - '.$matricula->getBolsas()->status}}"> <i class=" fa fa-flag"></i> RD {{$matricula->getBolsas()->id}} </span></small>&nbsp;

                                        @elseif($matricula->getBolsas()->status == 'cancelada')
                                        <small><span class="text-danger" title="{{$matricula->getBolsas()->tipo->nome.' - '.$matricula->getBolsas()->status}}"> <i class=" fa fa-flag"></i> RD {{$matricula->getBolsas()->id}} </span></small>&nbsp;

                                        @elseif($matricula->getBolsas()->status == 'expirada')
                                        <small><span class="text-secondar" title="{{$matricula->getBolsas()->tipo->nome.' - '.$matricula->getBolsas()->status}}"> <i class=" fa fa-flag"></i> RD {{$matricula->getBolsas()->id}} </span></small>&nbsp;
                                        
                                        @else
                                        <small><span title="{{$matricula->getBolsas()->tipo->nome.' - '.$matricula->getBolsas()->status}}"> <i class=" fa fa-flag"></i> RD {{$matricula->getBolsas()->id}} </span></small>&nbsp;
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


                                            @if($matricula->status =='ativa')
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}"> <i class="fa fa-print icon"></i> Imprimir termo</a>
                                            @endif
                                            @if($matricula->status =='ativa'||$matricula->status =='pendente')
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/editar/').'/'.$matricula->id}}"> <i class="fa fa-pencil-square-o icon"></i> Editar matrícula</a>
                                            
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/secretaria/matricula/uploadglobal/1/1/1/{{$matricula->id}}"> <i class="fa fa-cloud-upload icon"></i> (Re)Enviar termo</a>
                                            @if(file_exists('documentos/matriculas/termos/'.$matricula->id.'.pdf'))
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/download/{{str_replace('/','-.-', 'documentos/matriculas/termos/'.$matricula->id.'.pdf')}}"> <i class="fa fa-file-text-o icon"></i> Termo disponivel</a>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" style="text-decoration: none; color:#FF4444;" href="#" onclick="cancelar({{$matricula->id}});"> <i class="fa fa-times icon"></i> Cancelar </a>




                                            @elseif($matricula->status =='espera')
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/editar/').'/'.$matricula->id}}"> <i class="fa fa-pencil-square-o icon"></i> Editar matrícula</a>
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}"> <i class="fa fa-print icon"></i> Imprimir termo</a>
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/secretaria/matricula/uploadglobal/1/1/1/{{$matricula->id}}"> <i class="fa fa-cloud-upload icon"></i> (Re)Enviar termo</a>
                                             @if(file_exists('documentos/matriculas/termos/'.$matricula->id.'.pdf'))
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/download/{{str_replace('/','-.-', 'documentos/matriculas/termos/'.$matricula->id.'.pdf')}}"> <i class="fa fa-file-text-o icon"></i> Termo disponivel</a>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" style="text-decoration: none; color:#FF4444;" href="#" onclick="cancelar({{$matricula->id}});"> <i class="fa fa-times icon"></i> Cancelar </a>




                                            @elseif($matricula->status =='expirada')
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}"> <i class="fa fa-print icon"></i> Imprimir termo</a>
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/secretaria/matricula/uploadglobal/1/1/1/{{$matricula->id}}"> <i class="fa fa-cloud-upload icon"></i> (Re)Enviar termo</a>
                                             @if(file_exists('documentos/matriculas/termos/'.$matricula->id.'.pdf'))
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/download/{{str_replace('/','-.-', 'documentos/matriculas/termos/'.$matricula->id.'.pdf')}}"> <i class="fa fa-file-text-o icon"></i> Termo disponivel</a>
                                            @endif



                                            @else 
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}"> <i class="fa fa-print icon"></i> Imprimir Termo</a>
                                            <a class="dropdown-item" style="text-decoration: none;"  href="{{asset('/secretaria/matricula/imprimir-cancelamento/').'/'.$matricula->id}}"> <i class="fa fa-print icon"></i> Imprimir Cancelamento</a>
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/secretaria/matricula/uploadglobal/1/1/1/{{$matricula->id}}"> <i class="fa fa-cloud-upload icon"></i> (Re)Enviar termo</a>
                                            <a class="dropdown-item" style="text-decoration: none; color:#fe974b;"  href="/secretaria/matricula/uploadglobal/1/0/1/{{$matricula->id}}"> <i class="fa fa-cloud-upload icon"></i> (Re)Enviar cancelamento</a>
                                             @if(file_exists('documentos/matriculas/termos/'.$matricula->id.'.pdf'))
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/download/{{str_replace('/','-.-', 'documentos/matriculas/termos/'.$matricula->id.'.pdf')}}"> <i class="fa fa-file-text-o icon"></i> Termo disponivel</a>
                                            @endif
                                            @if(file_exists('documentos/matriculas/cancelamentos/'.$matricula->id.'.pdf'))
                                            <a class="dropdown-item" style="text-decoration: none;"  href="/download/{{str_replace('/','-.-', 'documentos/matriculas/cancelamentos/'.$matricula->id.'.pdf')}}"> <i class="fa fa-file-text-o icon"></i> Cancelamento disponivel</a>
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
                                            <a href="/download/{{str_replace('/','-.-', 'documentos/inscricoes/cancelamentos/'.$inscricao->id.'.pdf')}}" target="_blank" class="badge badge-pill badge-primary">  <i class=" fa fa-file-text-o " title="Termo de cancelamento disponível" style="color:white;"></i>
                                            </a>
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
                                       
                                        

                                        
                                        @elseif($inscricao->status == 'transferida')
                                        &nbsp;
                                        @if(file_exists('documentos/inscricoes/transferencias/'.$inscricao->transferencia->id.'.pdf'))
                                            &nbsp;
                                            <a href="/download/{{str_replace('/','-.-', '/documentos/inscricoes/transferencias/'.$inscricao->transferencia->id.'.pdf')}}"  target="_blank" class="badge badge-pill badge-primary">  <i class=" fa fa-file-text-o " title="Formulário de transferencia disponível" style="color:white;"></i>
                                            </a>
                                        @else
                                            &nbsp;<a href="#" class="badge badge-pill badge-primary"><i class="fa fa-cloud-upload " title="Enviar formulário de transferencia de turma" style="color:white;"></i></a>
                                        @endif
                                          <a href="{{asset('secretaria/matricula/inscricao/imprimir/transferencia/'.$inscricao->transferencia->id) }} " 
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
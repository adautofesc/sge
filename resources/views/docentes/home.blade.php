@extends('layout.app')
@section('pagina')
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('docentes.modal.add_jornada')
@include('docentes.modal.exclusao_jornada')
<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Departamento de Docência da FESC</h3>
            <p class="title-description"><strong>Prof.:</strong> {{$docente->nome}} | <strong>{{$carga_ativa->floatDiffInHours(\Carbon\Carbon::Today())}}h/{{isset($carga->valor)?$carga->valor:'00'}}h</strong>  </p>
        </div>
    </div>
</div>
<section class="section">
 @include('inc.errors')
    <div class="row">
        <div class="col-md-7">
            <div class="card">
            <div class="card card-block">
                <div class="card-title-block">
                    <h3 class="title"> Horário semanal </h3>
                </div>
                <section>
                <table class="table table-striped table-bordered table-sm">
                    
                    <thead>
                        <tr>
                        <th>Hora</th>
                        <th>Segunda</th>
                        <th>Terça</th>
                        <th>Quarta</th>
                        <th>Quinta</th>
                        <th>Sexta</th>
                        <th>Sábado</th>
                       </tr>
                    </thead>
                    <tbody>
                        @for($i=6;$i<24;$i++)
                            @if(isset($horarios['seg'][str_pad($i, 2, 0, STR_PAD_LEFT)]) || isset($horarios['ter'][str_pad($i, 2, 0, STR_PAD_LEFT)]) || isset($horarios['qua'][str_pad($i, 2, 0, STR_PAD_LEFT)]) || isset($horarios['qui'][str_pad($i, 2, 0, STR_PAD_LEFT)]) || isset($horarios['sex'][str_pad($i, 2, 0, STR_PAD_LEFT)]) || isset($horarios['sab'][str_pad($i, 2, 0, STR_PAD_LEFT)]))
                            <tr>
                                <th title="Atividades com início entre {{str_pad($i, 2, 0, STR_PAD_LEFT)}}:00 às {{str_pad($i, 2, 0, STR_PAD_LEFT)}}:59"><small>{{str_pad($i, 2, 0, STR_PAD_LEFT)}}h</small> </th>
                                @foreach($dias as $dia)
                                    <td>
                                       @if(isset($horarios[$dia][str_pad($i, 2, 0, STR_PAD_LEFT)])) 
                                            @foreach($horarios[$dia][str_pad($i, 2, 0, STR_PAD_LEFT)] as $horario) 

                                                @if(!isset($horario->tipo))
                                                
                                                &nbsp;&nbsp;<small><a  title="{{$horario->hora_inicio}} -> {{$horario->hora_termino}} | {{$horario->getNomeCurso()}} | {{$horario->local->sigla}} | {{$horario->nome_sala}}" href="/docentes/frequencia/nova-aula/{{$horario->id}}">{{$horario->id}}</a></small>
                                                @elseif(isset($horario->tipo))
                                                
                                                &nbsp;&nbsp;<small><a href="#"  title="{{$horario->hora_inicio}} -> {{$horario->hora_termino}} - {{$horario->getLocal()->sigla}}"> {{$horario->tipo}}  </a></small>

                                                @else
                                                
                                                
                                                @endif
                                                
                                            @endforeach
                                        @endif  
                                    </td>                        
 
                                @endforeach
                            </tr>

                            @endif
                        
                        @endfor
                        
                          
                        
                    </tbody>

                </table>
                </section>

            </div>
            </div>

        </div>
        <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Jornadas de trabalho</p>
                    </div>
                </div>
                <div class="card-block">
                    <table class="table table-sm table-striped">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Dia(s)</th>
                            <th>Início</th>
                            <th>Termino</th>
                            <th>Tipo</th>
                            <th>&nbsp;</th>
                        </tr>
                        
                        @foreach($jornadas as $jornada)
                        <tr>
                            <td><small>
                                @switch($jornada->status)
                                    @case('analisando')
                                        <i class="fa fa-clock-o"></i>
                                        @break
                                    @case('ativa')
                                        <i class="fa fa-check text-success"></i>
                                        @break
                                    @default
                                        
                                @endswitch</small></td>
                            <td><small>{{implode(',',$jornada->dias_semana)}}</small></td>
                            <td><small>{{$jornada->hora_inicio}}</small></td>
                            <td><small>{{$jornada->hora_termino}}</small></td>
                            <td><small>{{$jornada->tipo}}</small></td>
                            <td>
                                @if(in_array('17', Auth::user()->recursos))
                                <small><a href="#" data-toggle="modal" data-target="#modal-exclusao-jornada" title="Excluir Jornada" onclick="atribJornada('{{$jornada->id}}')">
                                            <i class="fa fa-times text-danger"></i>
                                        </a>
                                </small>
                                @else
                                &nbsp;
                                @endif
                            </td>

                        </tr>
                    
                        @endforeach
                    
                    </table>
                   
                    <p>&nbsp;</p>
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="#" data-toggle="modal" data-target="#modal-add-jornada" class="btn btn-sm btn-primary">Adicionar</a>
                            
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Listas de Frequência &nbsp;&nbsp;</p>

                        <div class="action dropdown pull-right" >

                            <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Semestre de início
                            </button>
                            <div class="dropdown-menu "  aria-labelledby="dropdownMenu5"> 
                                @foreach($semestres as $semestre)
                                @if(isset($semestre_selecionado) && array_search($semestre->semestre.$semestre->ano,[$semestre_selecionado]) !== false)
                                <a class="dropdown-item" href="/docentes/{{$docente->id}}/{{$semestre->semestre.$semestre->ano}}" style="text-decoration: none;">
                                    <i class="fa fa-check-circle-o icon"></i> {{$semestre->semestre.'º Sem. '.$semestre->ano}}
                                </a> 
                                @else
                                <a class="dropdown-item" href="/docentes/{{$docente->id}}/{{$semestre->semestre.$semestre->ano}}" style="text-decoration: none;">
                                    <i class="fa fa-circle-o icon"></i> {{$semestre->semestre.'º Sem. '.$semestre->ano}}
                                </a> 
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-block">
                    
                    <table class="table table-striped table-condensed">
                    
                        <thead class="row">
                            <tr>
                            <th class="col-sm-1 col-xs-1"><small>Cód.</small></th>
                            <th class="col-sm-2 col-xs-2"><small>Dia(s)</small></th>
                            <th class="col-sm-2 col-xs-2"><small>Inicio</small></th>
                            <th class="col-sm-5 col-xs-5"><small>Curso/Disciplina</small></th>
                            <th class="col-sm-2 col-xs-2"><small>Opções</small></th>
                        </tr>
                        </thead>
                    
                        <tbody>
                            @foreach($turmas as $turma)
                            <tr class="row">
                                <td class="col-sm-1 col-xs-1" title="Status: {{$turma->status}}" ><small>{{$turma->id}}</small></td>
                            <td class="col-sm-2 col-xs-2"title="Inicio: {{$turma->data_inicio}}"><small>{{implode(', ',$turma->dias_semana)}}<br>{{$turma->data_inicio}}</small></td>
                                <td class="col-sm-2 col-xs-2"><small>{{$turma->hora_inicio}}h<br>{{$turma->hora_termino}}h</small></td>
                                <td class="col-sm-5 col-xs-5">
                                    @if(substr($turma->data_inicio,6,4)<2020)
                                    
                                    
                                    <small>
                                    <a href="/chamada/{{$turma->id}}/0/url/ativos"  title="Chamada de alunos ativos (modelo planilha)">
                                        
                                        {{$turma->getNomeCurso()}}

                                    </a>
                                    
                                    </small>
                                   
                                    @else
                                    <small>
                                    <a href="/docentes/frequencia/nova-aula/{{$turma->id}}" title="Chamada OnLine.">
                                        
                                        {{$turma->getNomeCurso()}}

                                    </a>
                                    
                                    </small>
                                    @endif
                                </td>
                            
                                <td class="col-sm-2 col-xs-2">
                                    @if(substr($turma->data_inicio,6,4)<2020)
                                        <a href="/chamada/{{$turma->id}}/0/url/todos"  title="Chamada modelo planilha, com alunos desistentes/transferidos">       
                                            <i class=" fa fa-indent "></i></a>
                                        &nbsp;
                                        @if(isset($turma->disciplina->id))
                                            <a href="/plano/{{$turma->professor->id}}/1/{{$turma->disciplina->id}}" title="Plano de ensino" >
                                                <i class=" fa fa-clipboard "></i>
                                            </a>
                                        @else
                                            <a href="/plano/{{$turma->professor->id}}/0/{{$turma->curso->id}}" title="Plano de ensino" >
                                                <i class=" fa fa-clipboard "></i>
                                            </a>
                                        @endif


                                    @else
                                        <a href="/docentes/frequencia/listar/{{$turma->id}}"  title="Relatório de frequência.">
                                            <i class=" fa fa-indent "></i></a>
                                        &nbsp;
                                        <a href="/docentes/frequencia/preencher/{{$turma->id}}"  title="Chamada completa">
                                            <i class=" fa fa-list "></i></a>
                                        &nbsp;
                                        <a href="/lista/{{$turma->id}}" title="Impressão de lista em branco" >
                                            <i class=" fa fa-print "></i></a>&nbsp;
                                    @endif


                                    
                                    

                                
                                   
                                    

                                

                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                                   
                </div>     
            </div>
        </div> 
        <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Opções</p>
                    </div>
                </div>
                <div class="card-block">
                    <!--
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;<a href="#"> Listas de Frequência Anteriores</a>
                    </div>
                -->
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/oficios/calendario_2020.pdf')}}" >Calendário</a>
                    </div>
                    <!--
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Planos de ensino  
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Planejamento de aula
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Solicitação de equipamentos
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Solicitação de sala de aula extra
                    </div>
                -->
                </div>   
            </div>
        </div>
        
        <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Formulários</p>
                    </div>
                </div>
                <div class="card-block">

                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/formularios/formulario_turmas.doc')}}"  title="Formulário de definição de Turmas e horários">Formulário de Horário</a>
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/formularios/inscricao.doc')}}"  title="Inscrição para os cursos de parceria.">Formulário de Inscrição em Turmas</a>
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/usolivre.pdf')}}" >Formulário de cadastro no Uso Livre</a>
                    </div>
    
                
                </div>   
            </div>
        </div> 

    </div>
</section>

@endsection
@section('scripts')
<script>
function carregarSalas(local){
	var salas;
	$("#select_sala").html('<option>Sem salas cadastradas</option>');
	$.get("{{asset('services/salas-api/')}}"+"/"+local)
 				.done(function(data) 
 				{
 					$.each(data, function(key, val){
						console.log(val.nome);
 						salas+='<option value="'+val.id+'">'+val.nome+'</option>';
 					});
 					//console.log(namelist);
 					$("#select_sala").html(salas);
				 });
				 
}

let jornada = 0;
function atribJornada(id){
   jornada = id;
}

function excluirJornada(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/jornada/excluir",
        data: { jornada }
        
    })
	.done(function(msg){
		location.reload(true);
	})
    .fail(function(msg){
        alert('Falha ao excluir jornada: '+msg.statusText);
    });
}
</script>
@endsection
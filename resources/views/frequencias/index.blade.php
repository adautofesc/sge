@extends('layout.app')
@section('titulo')Chamadas Digitais @endsection

@section('pagina')
<meta name="csrf-token" content="{{ csrf_token() }}">



  <div class="title-block">
        <h3 class="title"> <i class=" fa fa-check-square-o"></i> Chamadas Digitais</h3>
  <small>Prof.(a) {{$docente->nome_simples}}</small>
    </div>

<div class="row">
    <div class="col-md-12 center-block">
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
                            <a class="dropdown-item" href="/chamadas/{{$docente->id}}/{{$semestre->semestre.$semestre->ano}}" style="text-decoration: none;">
                                <i class="fa fa-check-circle-o icon"></i> {{$semestre->semestre>0?$semestre->semestre.'º Sem. '.$semestre->ano:' '.$semestre->ano}}
                            </a> 
                            @else
                            <a class="dropdown-item" href="/chamadas/{{$docente->id}}/{{$semestre->semestre.$semestre->ano}}" style="text-decoration: none;">
                                <i class="fa fa-circle-o icon"></i> {{$semestre->semestre>0?$semestre->semestre.'º Sem. '.$semestre->ano:' '.$semestre->ano}}
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
                        <th class="col-sm-1 col-xs-1"><small>Turma</small></th>
                        <th class="col-sm-2 col-xs-2"><small>Dia(s)/Horário</small></th>
                        <th class="col-sm-2 col-xs-2"><small>Inicio/Termino</small></th>
                        <th class="col-sm-4 col-xs-4"><small>Curso (clique para acessar a chamada digital)</small></th>
                        <th class="col-sm-1 col-xs-1"><small>Matriculas</small></th>
                        <th class="col-sm-2 col-xs-2"><small>Opções</small></th>
                    </tr>
                    </thead>
                
                    <tbody>
                        @foreach($turmas as $turma)
                        <tr class="row">
                            <td class="col-sm-1 col-xs-1" title="Status: {{$turma->status}}" ><small>{{$turma->id}}</small></td>
                        <td class="col-sm-2 col-xs-2"title="Inicio: {{$turma->data_inicio}}"><small>{{implode(', ',$turma->dias_semana)}}<br>{{$turma->hora_inicio}}h - {{$turma->hora_termino}}h</small></td>
                            <td class="col-sm-2 col-xs-2"><small>{{$turma->data_inicio}}<br>{{$turma->data_termino}}</small></td>
                            <td class="col-sm-4 col-xs-4">
                                <small>
                                    
                                @if(substr($turma->data_inicio,6,4)<2020)
                                    <a href="/chamada/{{$turma->id}}/0/url/ativos"  title="Chamada de alunos ativos (modelo planilha)">     
                                        {{$turma->getNomeCurso()}}
                                    </a>
                                @else
                                    @if(substr($turma->data_inicio,6,4)<date('Y'))
                                          {{$turma->getNomeCurso()}}                                        
                                    @else
                                    <a href="/docentes/frequencia/nova-aula/{{$turma->id}}" title="clique para acessar a chamada dessa turma">
                                        {{$turma->getNomeCurso()}}
                                        </a>
                                    @endif

                                
                                
                                
                                @endif
                                </small>
                            </td>
                            <td class="col-sm-1 col-xs-1">
                                <small>
                                    @switch($turma->status)
                                    @case('cancelada')
                                    <i class="fa fa-times-circle-o text-danger" title="Cancelada"></i>
                                    @break
                                    @case('iniciada')
                                    <i class="fa fa-circle text-success" title="Iniciada"></i>
                                    @break
                                    @case('encerrada')
                                    <i class="fa fa-minus-circle" title="Encerrada"></i>
                                    @break
                                    @case('lancada')
                                    <i class="fa fa-circle-o text-info" title="Lançada"></i>
                                    @break
                                    @default
                                    @break
                                    @endswitch
                                    
                                    <br>
                                    {{$turma->status_matriculas}}
                                </small>
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
                                    <a href="/docentes/frequencia/preencher/{{$turma->id}}"  title="Chamada completa">
                                        <i class=" fa fa-table "></i></a>
                                    &nbsp;
                                    <a href="/docentes/frequencia/listar/{{$turma->id}}"  title="Relatório de frequência.">
                                        <i class=" fa fa-file-text-o "></i></a>
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
</div>
@endsection
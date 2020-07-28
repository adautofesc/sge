@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Departamento de Docência da FESC</h3>
            <p class="title-description">Planos de trabalho, listas de frequência, calendário etc.</p>
        </div>
    </div>
</div>
<section class="section">
 @include('inc.errors')
    <div class="row">
        <div class="col-md-7 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Listas de Frequência &nbsp;&nbsp;</p>

                        <div class="action dropdown pull-right" >

                            <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Semestre
                            </button>
                            <div class="dropdown-menu "  aria-labelledby="dropdownMenu5"> 
                                @foreach($semestres as $semestre)
                                @if(isset($semestre_selecionado) && array_search($semestre->semestre.$semestre->ano,[$semestre_selecionado]) !== false)
                                <a class="dropdown-item" href="/docentes/{{$semestre->semestre.$semestre->ano}}" style="text-decoration: none;">
                                    <i class="fa fa-check-circle-o icon"></i> {{$semestre->semestre.'º Sem. '.$semestre->ano}}
                                </a> 
                                @else
                                <a class="dropdown-item" href="/docentes/{{$semestre->semestre.$semestre->ano}}" style="text-decoration: none;">
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
                            <th class="col-sm-1 col-xs-1"><small>Cód.</small></th>
                            <th class="col-sm-2 col-xs-2"><small>Dia(s)</small></th>
                            <th class="col-sm-2 col-xs-2"><small>Inicio</small></th>
                            <th class="col-sm-5 col-xs-5"><small>Curso/Disciplina</small></th>
                            <th class="col-sm-2 col-xs-2"><small>Opções</small></th>
                        </thead>
                    
                        <tbody>
                            @foreach($turmas as $turma)
                            <tr class="row">
                                <td class="col-sm-1 col-xs-1" title="Status: {{$turma->status}}" ><small>{{$turma->id}}</small></td>
                                <td class="col-sm-2 col-xs-2"title="Inicio: {{$turma->data_inicio}}"><small>{{implode(', ',$turma->dias_semana)}}</small></td>
                                <td class="col-sm-2 col-xs-2"><small>{{$turma->hora_inicio}}h<br>{{$turma->hora_termino}}h</small></td>
                                <td class="col-sm-5 col-xs-5">
                                    @if(substr($turma->data_inicio,6,4)<2020)
                                    
                                    
                                    <small>
                                    <a href="/chamada/{{$turma->id}}/0/url/ativos" target="_blank" title="Chamada de alunos ativos (modelo planilha)">
                                        
                                        {{$turma->getNomeCurso()}}

                                    </a>
                                    
                                    </small>
                                   
                                    @else
                                    <small>
                                    <a href="/docentes/frequencia/nova-aula/{{$turma->id}}" title="Chamada OnLine. Início em {{$turma->data_inicio}}">
                                        
                                        {{$turma->getNomeCurso()}}

                                    </a>
                                    
                                    </small>
                                    @endif
                                </td>
                            
                                <td class="col-sm-2 col-xs-2">
                                    @if(substr($turma->data_inicio,6,4)<2020)
                                        <a href="/chamada/{{$turma->id}}/0/url/todos" target="_blank" title="Chamada modelo planilha, com alunos desistentes/transferidos">       
                                            <i class=" fa fa-indent "></i></a>
                                        &nbsp;
                                        @if(isset($turma->disciplina->id))
                                            <a href="/plano/{{$turma->professor->id}}/1/{{$turma->disciplina->id}}" title="Plano de ensino" target="_blank">
                                                <i class=" fa fa-clipboard "></i>
                                            </a>
                                        @else
                                            <a href="/plano/{{$turma->professor->id}}/0/{{$turma->curso->id}}" title="Plano de ensino" target="_blank">
                                                <i class=" fa fa-clipboard "></i>
                                            </a>
                                        @endif


                                    @else
                                        <a href="/docentes/frequencia/listar/{{$turma->id}}" target="_blank" title="Lista de chamada preenchida">
                                            <i class=" fa fa-indent "></i></a>
                                        &nbsp;
                                        <a href="/docentes/frequencia/preencher/{{$turma->id}}" target="_blank" title="Lista de chamada preenchida">
                                            <i class=" fa fa-list "></i></a>
                                        &nbsp;
                                        <a href="/lista/{{$turma->id}}" title="Impressão de lista em branco" target="_blank">
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
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/oficios/calendario_2020.pdf')}}" target="_blank">Calendário</a>
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
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/formularios/formulario_turmas.doc')}}" target="_blank" title="Formulário de definição de Turmas e horários">Formulário de Horário</a>
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/formularios/inscricao.doc')}}" target="_blank" title="Inscrição para os cursos de parceria.">Formulário de Inscrição em Turmas</a>
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/usolivre.pdf')}}" target="_blank">Formulário de cadastro no Uso Livre</a>
                    </div>
    
                
                </div>   
            </div>
        </div> 

    </div>
</section>

@endsection
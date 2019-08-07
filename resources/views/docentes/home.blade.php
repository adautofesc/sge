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
    <div class="row">
        <div class="col-md-7 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Listas de Frequência</p>
                    </div>
                </div>

                <div class="card-block">
                    
                    <table class="table table-striped table-condensed">
                    
                        <thead>
                            <th><small>Cód.</small></th>
                            <th><small>Dia(s)</small></th>
                            <th><small>Inicio</small></th>
                            <th><small>Curso/Disciplina</small></th>
                            <th><small>Opções</small></th>
                        </thead>
                    
                        <tbody>
                            @foreach($turmas as $turma)
                            <tr>
                                <td><small>{{$turma->id}}</small></td>
                                <td title="Inicio: {{$turma->data_inicio}}"><small>{{implode(', ',$turma->dias_semana)}}</small></td>
                                <td><small>{{$turma->hora_inicio}}h</small></td>
                                <td><small>
                                    <a href="/chamada/{{$turma->id}}/0/url" target="_blank">
                                        
                                        @if(isset($turma->disciplina))
                                         {{$turma->disciplina->nome}}
                                         @else
                                          {{$turma->curso->nome}}
                                        @endif

                                    </a>
                                    </small>
                                </td>
                            
                                <td>
                                    <a href="/lista/{{$turma->id}}" title="Impressão de lista em branco" target="_blank">
                                        <i class=" fa fa-print "></i></a>&nbsp;
                                        @if(isset($turma->disciplina->id))
                                        <a href="/plano/{{$turma->professor->id}}/1/{{$turma->disciplina->id}}" title="Plano de ensino" target="_blank">
                                            <i class=" fa fa-clipboard "></i></a>
                                        @else
                                           <a href="/plano/{{$turma->professor->id}}/0/{{$turma->curso->id}}" title="Plano de ensino" target="_blank"><i class=" fa fa-clipboard "></i></a>
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
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/oficios/2018004.pdf')}}" target="_blank">Calendário</a>
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
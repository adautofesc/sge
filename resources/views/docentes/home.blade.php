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
        <div class="col-md-6 center-block">
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
                        &nbsp;&nbsp;<a href="/documentos/oficios/2018004.pdf" target="_blank">Calendário</a>
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
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Listas de Frequência</p>
                    </div>
                </div>

                <div class="card-block">
                    @foreach($turmas as $turma)

                    <div class="row" >
                        <div class="col-md-1">
                             <i class=" fa fa-users "></i>
                        </div>
                        <div class="col-md-3" >
                             <a href="{{$turma->url}}" target="_blank"
                            title="Acessar a lista do curso: {{$turma->curso->nome}}@if(isset($turma->disciplina)) / {{$turma->disciplina->nome}}@endif "> Turma {{$turma->id}}</a>
                        </div>
                        <div class="col-md-3" >
                             {{implode(', ',$turma->dias_semana)}}
                        </div>
                        <div class="col-md-4">
                             {{$turma->hora_inicio}}h~{{$turma->hora_termino}}h
                        </div>
                        <div class="col-md-1">
                             <i class=" fa fa-cog "></i>
                        </div>
                           

                    </div>

                    @endforeach

                    
                </div>     
            </div>
        </div> 
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Formulários</p>
                    </div>
                </div>
                <div class="card-block">

                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/documentos/formularios/formulario_turmas.doc" target="_blank" title="Formulário de definição de Turmas e horários">Formulário de Horário</a>
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/documentos/formularios/inscricao.doc" target="_blank" title="Inscrição para os cursos de parceria.">Formulário de Inscrição em Turmas</a>
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/documentos/insc_usolivre.pdf" target="_blank">Formulário de cadastro no Uso Livre</a>
                    </div>
    
                
                </div>   
            </div>
        </div> 

    </div>
</section>

@endsection
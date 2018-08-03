 @extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title">Turma {{$turma->id}} - 
        @if(!empty($turma->disciplina->nome))
            {{$turma->disciplina->nome}} / 
        @endif
        {{$turma->curso->nome}}

    </h3>
    <p class="title-description">
        @foreach($turma->dias_semana as $dia)
            {{ucwords($dia)}}, 
        @endforeach
        das {{$turma->hora_inicio}} às {{$turma->hora_termino}} - 
        Prof(a). {{$turma->professor->nome_simples}}
        <br>
        <i class="fa fa-{{$turma->icone_status}} icon"></i> Status: {{$turma->status}} . Início em {{$turma->data_inicio}} Término em {{$turma->data_termino}}
    </p> 
</div>
@include('inc.errors')
<section class="section">
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Alunos inscritos</p>
                    </div>
                </div>

                <div class="card-block">
                   <ol>
                        @foreach($inscricoes as $inscricao)
                        <li>
                            {{$inscricao->pessoa->nome}} 
                        </li>
                        @endforeach
                    </ol>
                    <a href="#"> Acessar turma pela secretaria.</a>

                    
                </div>     
            </div>
        </div> 
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Frequência</p>
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
                        &nbsp;&nbsp;<a href="/lista/{{$turma->id}}" target="_blank">Lista em branco</a>
                    </div>
                    
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;
                        <a href="/chamada/{{$turma->id}}" target="_blank">Frequência digital 1</a>
                        <a href="/documentos/oficios/2018004.pdf" target="_blank"> 2 </a>
                        <a href="/documentos/oficios/2018004.pdf" target="_blank"> 3 </a>
                        <a href="/documentos/oficios/2018004.pdf" target="_blank"> 4 </a>
                        <a href="/documentos/oficios/2018004.pdf" target="_blank"> <i class=" fa fa-print"></i> </a>
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Plano de ensino
                    </div>
                    <!--
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
                        &nbsp;&nbsp;<a href="/documentos/usolivre.pdf" target="_blank">Formulário de cadastro no Uso Livre</a>
                    </div>
    
                
                </div>   
            </div>
        </div> 

    </div>
</section>


   
@endsection

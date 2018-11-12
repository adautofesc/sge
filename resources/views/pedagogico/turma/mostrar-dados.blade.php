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
                    <a href="/secretaria/turma/{{$turma->id}}"> Acessar turma pela secretaria.</a>

                    
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
                        &nbsp;&nbsp;<a href="/lista/{{$turma->id}}" >Lista em branco</a>
                    </div>
                    
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;
                        <a href="/chamada/{{$turma->id}}/0/url" >Frequência digital</a>
                        <a href="/chamada/{{$turma->id}}/1/url"> 1 </a>
                        <a href="/chamada/{{$turma->id}}/2/url"> 2 </a>
                        <a href="/chamada/{{$turma->id}}/3/url"> 3 </a>
                        <a href="/chamada/{{$turma->id}}/4/url"> 4 </a>
                        <a href="/chamada/{{$turma->id}}/0/rel" title="Atualizar"> <i class=" fa fa-refresh"></i> </a>
                        <!--
                        <a href="/chamada/{{$turma->id}}/0/pdf" title="Imprimir"> <i class=" fa fa-print"></i> </a>
                    -->
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        @if(isset($turma->disciplina->id))
                            &nbsp;&nbsp;<a href="/plano/{{$turma->professor->id}}/1/{{$turma->disciplina->id}}" title="Plano de ensino">Plano de ensino</a>
                        @else
                            &nbsp;&nbsp;<a href="/plano/{{$turma->professor->id}}/0/{{$turma->curso->id}}" title="Plano de ensino">Plano de ensino</a>
                        @endif
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
                        &nbsp;&nbsp;<a href="/pedagogico/turmas/editar/{{$turma->id}}" target="_blank" title="Formulário de definição de Turmas e horários">Editar dados da turma</a>
                    </div>
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
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Requisitos</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        @if(isset($requisitos))
                            <a href="{{ asset("pedagogico/turmas/modificar-requisitos/").'/'.$turma->id}}" class="btn btn-secondary rounded-s btn-sm" >Modificar Requisitos</a>
                            <ul>
                        @foreach($requisitos as $requisito)
                            <li> {{ $requisito->requisito->nome}}</li>
                        @endforeach
                            </ul>
                        @else
                            <a href="{{ asset("pedagogico/requisitosdocurso/").'/'.$turma->id}}" class="btn btn-secondary rounded-s btn-sm" >Adicionar Requisito(s)</a>
                        @endif
                    </div>
    
                
                </div>   
            </div>
        </div> 

    </div>
</section>


   
@endsection

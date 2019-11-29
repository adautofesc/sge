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
        @if($turma->status == 'andamento' || $turma->status == 'iniciada' )
        <span  class="badge badge-pill badge-success" style="font-size: 0.8rem">
        @elseif($turma->status == 'espera' || $turma->status == 'lancada' || $turma->status == 'inscricao' )
         <span  class="badge badge-pill badge-info" style="font-size: 0.8rem">
        @elseif($turma->status == 'cancelada')
         <span  class="badge badge-pill badge-danger" style="font-size: 0.8rem">
        @else
         <span  class="badge badge-pill badge-secondary" style="font-size: 0.8rem">
        @endif

            <i class="fa fa-{{$turma->icone_status}} icon"></i> {{$turma->status}}
        </span>
        Início em {{$turma->data_inicio}} Término em {{$turma->data_termino}}
    </p>
</div>
@include('inc.errors')
<section class="section">
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                    <p class="title" style="color:white">Inscritos: {{$turma->matriculados}} alunos para {{$turma->vagas}} vagas</p>
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
                    <a href="/turmas/{{$turma->id}}"> Acessar turma pela secretaria.</a>

                    
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
                            <a href="/chamada/{{$turma->id}}/0/url/ativos" title="Lista sem nomes de alunos cancelados ou transferidos" >Frequência digital (limpa)</a>
                            <a href="/chamada/{{$turma->id}}/1/url/ativos"> 1 </a>
                            <a href="/chamada/{{$turma->id}}/2/url/ativos"> 2 </a>
                            <a href="/chamada/{{$turma->id}}/3/url/ativos"> 3 </a>
                            <a href="/chamada/{{$turma->id}}/4/url/ativos"> 4 </a>
                            <a href="/chamada/{{$turma->id}}/0/rel/ativos" title="Atualizar"> <i class=" fa fa-refresh"></i> </a>
                            <!--
                            <a href="/chamada/{{$turma->id}}/0/pdf" title="Imprimir"> <i class=" fa fa-print"></i> </a>
                        -->
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
                        <p class="title" style="color:white">Aulas</p>
                    </div>
                </div>
                <div class="card-block">
                    <form method="post">
                        {{csrf_field()}}
                    <div>
                        <div>
                            Com as selecionadas
                            <select name="acao" onchange="mudarGeral(this);">
                                <option value="">Escolha após selecionar as aulas</option>
                                <option value="adiar">Adiar</option>
                                <option value="atribuir">Atribuir</option>
                                <option value="cancelar">Cancelar</option>
                            </select>
                        </div>
                        <table class="table table-sm">
                            <thead>
                                <th><input type="checkbox" id="selectAll" onclick="marcardesmarcar(this)"></th>
                                <th>Data</th>
                                <th>status</th>
                                <th>Opções</th>
                                <tbody>
                                @foreach($aulas as $aula)
                                    <tr>
                                        <td><input type="checkbox" class="checkboxx" id="{{$aula->id}}"></td>
                                        <td>{{$aula->data->format('d/m')}}</td>
                                        <td><span class="badge badge-pill badge-{{$aula->badge}}">{{$aula->status}}</span></td>
                                        <td>
                                        @if($aula->status == 'planejada' || $aula->status == 'prevista' )
                                            <a href="#" title="Visualizar aula"><i class="fa fa-eye"></i></a>&nbsp;
                                            <a href="#" title="Atribuir a professor substituto"><i class="fa fa-briefcase"></i></a>&nbsp;
                                            <a href="#" title="Adiar aula"><i class="fa fa-calendar-o"></i></a>&nbsp;
                                        <a href="#{{$aula->id}}" onclick="cancelar('{{$aula->id}}')" title="Cancelar"><i class="fa fa-ban"></i></a>&nbsp;
                                        @elseif($aula->status == 'cancelada') 
                                            carregar motivo.
                                        @elseif($aula->status == 'executada')
                                            <a href="#" title="Visualizar aula"><i class="fa fa-eye"></i></a>&nbsp;
                                        @elseif($aula->status == 'adiada')
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                                   
                                </tbody>
                            </thead>
                        </table>
                    </div>
                    </form>
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
@section('scripts');
<script>
function cancelar(id){
    if(confirm('Confirmar cancelamento dessa aula?')){
        window.location.href = "/pedagogico/aulas/mudar-status/"+id+"/cancelar";
    }
   

}
function mudarGeral(field){
    var selecionados;
    if(confirm('Confirmar a alteração das aulas selecionadas?')){
        $('.checkboxx').each(function(){

            if($(this).is(":checked") == true){
                selecionados +=','+$(this).prop('id'); 
            }
            
        });
        console.log(selecionados);
        console.log(field.value);
        window.location.href = "/pedagogico/aulas/mudar-status/"+selecionados+"/"+field.value;
    }
}

function marcardesmarcar(campo){
	$(".checkboxx").each(
		function(){
			$(this).prop("checked", campo.checked)
		}
	);
}
</script>
@endsection

 @extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('pagina')
<div class="title-block">
    
    <h3 class="title">
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
        Turma {{$turma->id}} - 
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
        
        Início em {{$turma->data_inicio}} Término em {{$turma->data_termino}}. Em: {{$turma->local->nome}}
        @if(isset($turma->sala))
        -Sala: {{($turma->getSala())->nome}}
        @endif
    </p>
</div>
@include('inc.errors')
<div class="modal fade in" id="modal-contato" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" title="Fechar caixa">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-bullhorn"></i> Registrar contato</h4>
            </div>
            <div class="modal-body">
               
               <div class="row">
                <div class="col-xs-3">
                    <select class="form-control form-control-sm" name="meio">
                        <option>Meio</option>
                            <option value="telefone">Telefone</option>
                            <option value="sms">SMS</option>
                            <option value="carta">Carta</option>
                            <option value="pessoa">Pessoal</option>
                            <option value="email">E-mail</option>
                            <option value="whatsapp">WhatsApp</option>
                    </select>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="form-control form-control-sm" name="mensagem" placeholder="Escreva aqui o motivo" maxlength="300"><br>
                    <input type="hidden" name="pessoa" value="">
                
                </div>

                    
                </div>
                
                <div>
                    <button type="button" class="btn btn-primary" onclick="registrar_contato(null,null);" data-dismiss="modal">Confirmar</button>                
                    <button type="button" class="btn btn-warning" onclick="registrar_contato(null,'Tentiva de contato telefônico fracassada: caixa postal');" data-dismiss="modal">Caixa postal</button> 
                    <button type="button" class="btn btn-warning" onclick="registrar_contato(null,'Tentiva de contato telefônico fracassada: número consta como inexistente');" data-dismiss="modal">Inexistente</button> 

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> 
                </div>
            
            
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade in" id="confirm-modal" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" title="Fechar caixa">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-info-circle"></i> Título Modal</h4>
            </div>
            <div class="modal-body">
               <!-- conteúdo do modal -->
               <!--
               <div>
                   <input type="text" class="form-control form-control-sm" name="motivo-cancelamento" placeholder="Escreva aqui o motivo"><br>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" onclick="alterar_aula('cancelar',320);" data-dismiss="modal">Confirmar</button> 
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> 
                </div>
            -->
            
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<section class="section">
    <div class="row">
        <div class="col-md-9 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                    <p class="title" style="color:white">Inscritos: {{$turma->matriculados}} alunos para {{$turma->vagas}} vagas</p>
                    </div>
                </div>

                <div class="card-block">
                    <table class="table table-striped table-condensed" style="font-size: 11px;">
                        <thead>
                            <th width="0px">&nbsp;</th>
                            <th>Nome</th>
                            <th>Nascimento</th>
                            <th>Telefone</th>
                            <th>Atestado</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @php($a=0)
                            @foreach($inscricoes as $inscricao)
                            @php($a++)
                            <tr>
                                <td>
                                   {{$a}}
                                </td>
                                <td>                                                                 
                                    <b>{{$inscricao->pessoa->nome}}</b>  
                                </td>
                                <td>
                                    {{\Carbon\Carbon::parse($inscricao->aluno->nascimento)->format('d/m/y')}} 
                                </td>
                                <td>
                                    @foreach($inscricao->telefone as $telefone)
                                    {{\App\classes\Strings::formataTelefone($telefone->valor)}}| 
                                     @endforeach    
                                </td>
                                <td>
                                    @if(isset($inscricao->atestado))
                                        @if($inscricao->atestado->validade<=date('Y-m-d'))
                                        <a class="badge badge-pill badge-danger" style="font-size: 10px; text-decoration: none; color:white;" href="#">
                                            {{\Carbon\Carbon::parse($inscricao->atestado->validade)->format('d/m/y')}}
                                        </a>
                                        @else
                                        <a href="#">
                                            {{\Carbon\Carbon::parse($inscricao->atestado->validade)->format('d/m/y')}}
                                        </a>
                                        @endif
   
                                    @endif
                                    <!--
                                    <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal"> <i class="fa fa-trash-o "></i> </a>
                                    -->
                                </td>
                                <td>
                                    <a href="#" class="btn btn-secondary btn-sm rounded-s" onclick="setPessoaContato({{$inscricao->pessoa->id}})" title="Registrar contato" data-toggle="modal" data-target="#modal-contato"><i class="fa fa-phone"></i></a>&nbsp;

                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    <a href="/turmas/{{$turma->id}}"> Acessar turma pela secretaria.</a>

                    
                </div>     
            </div>
        </div> 
        <div class="col-md-3 center-block">
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
                    
                    @if(substr($turma->data_inicio,6,4)<2020)
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
                    @else 
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/docentes/frequencia/listar/{{$turma->id}}" title="Planilha com a frequencia dos alunos" >Frequência</a>
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/docentes/frequencia/nova-aula/{{$turma->id}}" title="Página para realizar chamada">Chamada</a>
                    </div>
                    @endif
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/lista/{{$turma->id}}" >Lista em branco</a>
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
        
        <div class="col-md-3 center-block">
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
        <div class="col-md-9 center-block">
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
                        <div class="row">
                            <div class="col-xs-3">
                                Com as selecionadas
                            </div>
                            <div class="col-xs-5">
                               
                                <select name="acao" onchange="mudarGeral(this);" class="form-control form-control-sm">
                                    <option value="">Escolha após selecionar as aulas</option>
                                    <!--<option value="atribuir">Atribuir</option>-->
                                    <option value="cancelar">Cancelar</option>
                                    <option value="executar">Marcar como executada</option>
                                    <option value="prevista">Marcar como prevista</option>
                                </select>
                            </div>
                            <div class="col-xs-4 float-right">
                                <!--
                                    <a class="btn btn-secondary btn-sm rounded-s" href="#" data-toggle="modal" data-target="#confirm-modal"> 
                                        <i class="text-success fa fa-plus"></i> <span class="text-success"><small>Adicionar</small></span>
                                    </a>
                                -->
                            </div>
                        </div>
                        <table class="table table-striped table-condensed table-sm" style="font-size: 11px;">
                            <thead>
                                <th><input type="checkbox" id="selectAll" onclick="marcardesmarcar(this)"></th>
                                <th>Data</th>
                                <th>status</th>
                                <th>Ocorrências</th>
                                <th>Opções</th>
                                <tbody>
                                @foreach($aulas as $aula)
                                    <tr>
                                        <td><input type="checkbox" class="checkboxx" id="{{$aula->id}}"></td>
                                        <td>{{$aula->data->format('d/m')}}</td>
                                        <td><span class="badge badge-pill badge-{{$aula->badge}}">{{$aula->status}}</span></td>
                                        <td>
                                            @if($aula->status == 'executada')
                                                {{$aula->getOcorrencia()}}
                                            @elseif($aula->status == 'cancelada')
                                                {{$aula->getDados('cancelamento')}}
                                            @else 
                                                &nbsp;
                                            @endif
                                            
                                        </td>
                                        <td>
                                        @if($aula->status == 'planejada' || $aula->status == 'prevista' )
                                            
                                            <!-- <a href="#" onclick="modal_atribuir({{$aula->id}});" title="Atribuir a professor substituto" data-toggle="modal" data-target="#confirm-modal"><i class="fa fa-briefcase"></i></a>&nbsp;-->
                                            <a href="#" title="Adiar aula" data-toggle="modal" data-target="#confirm-modal"><i class="fa fa-calendar-o"></i></a>&nbsp;
                                            <a href="#{{$aula->id}}" onclick="modal_cancelar('{{$aula->id}}')" title="Cancelar" data-toggle="modal" data-target="#confirm-modal"><i class="fa fa-ban"></i></a>&nbsp;
                                        @elseif($aula->status == 'cancelada') 
                                            <a href="#{{$aula->id}}" onclick="modal_cancelar('{{$aula->id}}')" title="Adicionar motivo" data-toggle="modal" data-target="#confirm-modal"><i class="fa fa-plus"></i></a>&nbsp;
                                            <a href="#" onclick="removerMotivosCancelamento('{{$aula->id}}')" title="Remover Motivos"><i class="fa fa-times"></i></a>&nbsp;
                                            <a href="#" onclick="alterar_aula('previsionar',{{$aula->id}})"title="Retornar como prevista"><i class="fa fa-undo"></i></a>&nbsp;
                                        @elseif($aula->status == 'executada')
                                            &nbsp;
                                        @elseif($aula->status == 'adiada')
                                            &nbsp;
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
        <div class="col-md-3 center-block">
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
function modal_cancelar(id){
    $('.modal-title').html('<i class="fa fa-exclamation-triangle text-warning"></i> Motivo do cancelamento');
    conteudo_modal = '<div>'+
                '<input type="text" class="form-control form-control-sm" name="motivo-cancelamento" placeholder="Escreva aqui o motivo"><br>'+
            '</div>'+
            '<div >'+
                '<button type="button" class="btn btn-primary" onclick="alterar_aula(\'cancelar\','+id+');" data-dismiss="modal">Confirmar</button> '+
                '<button type="button" class="btn btn-secondary"  data-dismiss="modal">Cancelar</button> '+
            '</div>';

    $('.modal-body').html(conteudo_modal);
   
        //window.location.href = "/pedagogico/aulas/mudar-status/"+id+"/cancelar";
}
function modal_atribuir(id){
    $('.modal-title').html('<i class="fa fa-exclamation-triangle text-warning"></i> Escolha o professor');
    conteudo_modal = '<div>'+
                '<select name="professor" class="form-control form-control-sm">'+
                    '<option selected="selected">Escolha o professor</option>';
    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "GET",
        url: "/services/professores"
        
        
    })
    .done(function(data){
        $.each(data, function(key, val){
            console.log(val.nome);
            conteudo_modal+='<option value="'+val.id+'">'+val.nome_simples+'</option>';
 		});
         conteudo_modal+=
                '</select>'+
                '<br>'+
             '</div>'+
             '<div>'+
                 '<button type="button" class="btn btn-primary" onclick="alterar_aula(\'atribuir\','+id+');" data-dismiss="modal">Confirmar</button> '+
                 '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> '+
             '</div>';
        $('.modal-body').html(conteudo_modal);
    })
    .fail(function(jqXHR, textStatus, msg){
         alert("Desculpe, mas não foi possível carregar a lista de professores");
    });

    
    
}

function alterar_aula(acao,id){

    var cod = [];
    if(id!=null)
        cod.push(id);

    else{
        $('.checkboxx').each(function(){

            if($(this).is(":checked") == true){
             cod.push($(this).prop('id'));
            }

        });

    }
    switch(acao){
        case 'cancelar': 
            dado = $("input[type=text][name=motivo-cancelamento]").val();
        break;
        case 'atribuir': 
            dado = $("input[type=text][name=professor]").val();
        break;
        default: 
            dado = null;
        break;
    }
    
    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/aulas/alterar-status",
        data: { action: acao, aulas: cod, motivo: dado }
        
    })
    .done(function(msg){
        console.log(msg);
        location.reload(true);
    })
    .fail(function(jqXHR, textStatus, msg){
         alert("Desculpe, mas não foi possível concluir o cancelamento");
         console.log('erro ao acessar a url'+'/aulas/mudar-status/'+id+'/cancelar'+msg);
    });

    //location.reload(true);
}
function mudarGeral(field){
    switch(field.value){
        case 'cancelar':
            modal_cancelar(null);
            $('#confirm-modal').modal('show');
        break;
        case 'prevista':
            alterar_aula('previsionar',null);
        break;
    }    
}
function removerMotivosCancelamento(id){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/aulas/limpar-dado",
        data: { aula:id, dado:'cancelamento' }
        
    })
    .done(function(msg){
        location.reload(true);
    });

}
function marcardesmarcar(campo){
	$(".checkboxx").each(
		function(){
			$(this).prop("checked", campo.checked)
		}
	);
}

function setPessoaContato(pessoa){
    $("input[name=pessoa]").val(pessoa);
    //alert($("input[name=pessoa]").val());
}

function registrar_contato(cod,content){
    if(cod==null)
        cod = $("input[name=pessoa]").val();

    mensagem =  $("input[type=text][name=mensagem]").val();
    if(content != null)
        mensagem += ' '+content;
    

    meio = $('select[name=meio]').val();

    if(meio == 'Meio'){
        alert('meio não escolhido');
        return false;
    }
    if(meio == 'whatsapp'){
        window.open('/pessoa/contato-whatsapp?pessoa='+cod+'&msg='+mensagem,'_blank');
        return true;
    }


    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/pessoa/registrar-contato",
        data: { meio, mensagem, pessoa:cod }
        
    })
    .fail(function(msg){
        alert('falha no registro de contato');
    });

}
</script>
@endsection

 @extends('layout.app')
 <meta name="csrf-token" content="{{ csrf_token() }}">
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
@php ($a=0)
<section class="section">
    <div class="row">
        <div class="col-md-9 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    
                    <div class="col-md-9">

                        <p class="title" style="color:white">Inscritos: {{$turma->matriculados}} alunos para {{$turma->vagas}} vagas</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-md-right">
                            <a href="/relatorios/dados-turmas/{{$turma->id}}" class="badge badge-pill " style="text-decoration: none; font-size: 1rem; background-color: white;" title="Modo de impressão"><i class=" fa fa-print "></i></a>
                            <!--<a href="#" class="badge badge-pill " style="text-decoration: none; font-size: 1rem; background-color: white;" title="Exportar em Xls"><i class=" fa fa-table "></i></a>-->
                        </div>
                    </div>
                   
            </div>

                <div class="card-block">
                    <table class="table table-striped table-condensed" style="font-size: 11px;">
                        <thead>
                            <th width="0px">&nbsp;</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Atestado</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach($inscricoes as $inscricao)
                            @php($a++)
                            <tr>
                                <td>
                                    <!--
                                    <small>
                                        <a hrfe="#" class="btn btn-danger btn-sm" title="Remover esta pessoa da turma" onclick="remover('{{$inscricao->id}}')">
                                            <i class=" fa fa-times text-white"></i>
                                        </a>
                                    </small>-->
                                   {{$a}} 

                                </td>
                                <td>

                                    <a href="{{asset('/secretaria/atender').'/'.$inscricao->pessoa->id}}" title="Abrir tela de atendimento desta pessoa">
                                        <b>{{$inscricao->pessoa->nome}}</b>
                                    </a> 
                                   
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
                                        @else
                                        <a href="#">
                                        @endif
                                    {{\Carbon\Carbon::parse($inscricao->atestado->validade)->format('d/m/y')}}
                                </span>

                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-secondary btn-sm rounded-s" onclick="setPessoaContato({{$inscricao->pessoa->id}})" title="Registrar contato" data-toggle="modal" data-target="#modal-contato"><i class="fa fa-phone"></i></a>&nbsp;

                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    <a href="/turmas/dados-gerais/{{$turma->id}}"> Acessar turma pelo pedagógico.</a>

                    
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
                <div class="card-block" style="font-size: 0.8em;">
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
                        &nbsp;&nbsp;<a href="/secretaria/frequencia/{{$turma->id}}" title="Relatório de frequência dos alunos" >Frequência</a>
                    </div>
                 
                    @endif
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/lista/{{$turma->id}}" >Lista em branco</a>
                                            

                    </div>
                    
                
                </div>   
            </div>
        </div>
        
        <div class="col-md-3 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white" >Opções</p>
                    </div>
                </div>
                <div class="card-block" style="font-size: 0.9em;">
                    <div>
                        <div class="action dropdown"> 
                            <button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenuAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Alterar Status
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuAction">  
                                <a class="dropdown-item" href="#" onclick="alterarStatus('lancada')" style="line-height: 30px; text-decoration: none">
                                    <i class="fa fa-clock-o icon text-warning"></i> Lançada
                                </a>
                           
                                <a class="dropdown-item" href="#" onclick="alterarStatus('iniciada')" style="line-height: 30px;text-decoration: none;">
                                    <i class="fa fa-check-circle-o icon text-success"></i> Iniciada  
                                </a>
                                <a class="dropdown-item" href="#" onclick="alterarStatus('encerrada')" style="line-height: 30px;text-decoration: none;" >
                                    <i class="fa fa-minus-circle icon text-danger" ></i> Encerrada
                                </a>
                               
                                 
                            </div>
                         </div>
                    </div>
                    <div>
                        <i class=" fa fa-pencil "></i> 
                        &nbsp;&nbsp;<a href="/turmas/editar/{{$turma->id}}" title="Formulário de definição de Turmas e horários">Editar dados da turma</a>
                    </div>
                    <div>
                        <i class=" fa fa-sign-in icon"></i> 
                        &nbsp;&nbsp;<a href="#" target="_blank" onclick="alterarOpcoes('requisitos')" title="Alterar requisitos">Alterar requisitos</a>
                    </div>
                    <div>
                        <i class=" fa fa-ban text-warning"></i> 
                        &nbsp;&nbsp;<a href="#" target="_blank" onclick="cancelar();" title="Cancelar turma" class="text-warning">Cancelar</a>
                    </div>
                    <div>
                        <i class=" fa fa-trash text-danger"></i> 
                        &nbsp;&nbsp;<a href="#" target="_blank" onclick="apagar();" title="Apagar turma" class="text-danger">Apagar</a>
                    </div>
                  
    
                
                </div>   
            </div>
        </div> 

    </div>
</section>
<br>
<div class="subtitle-block">
    <h3 class="title-description"> Adicionar Aluno </h3>

</div>
<form name="item" method="POST">
    {{csrf_field()}}
    <div class="card card-block">
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Nome
            </label>
            <div class="col-sm-8"> 
                <input type="search" id="search"  class="form-control boxed" placeholder="Você pode digitar numero, nome, RG e CPF"> 

                <input type="hidden" id="id_pessoa" name="id_pessoa">
            </div>
            <div class="col-sm-2"> 
                <button class="btn btn-primary" onclick="enviar()">Adicionar</button>
                
            </div>
           
        </div>
        
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                 
            </label>
            <div class="col-sm-8"> 
                 <ul class="item-list" id="listapessoas">
                 </ul>

                
            </div>
        </div>
    </div>
</form>
   
@endsection
@section('scripts')
<script>
    $(document).ready(function() 
    {
 
   //On pressing a key on "Search box" in "search.php" file. This function will be called.
 
   $("#search").keyup(function() {
 
       //Assigning search box value to javascript variable named as "name".
 
       var name = $('#search').val();
       $('#id_pessoa').val('');
       var namelist="";

 
       //Validating, if "name" is empty.
 
       if (name == "") {
 
           //Assigning empty value to "display" div in "search.php" file.
 
           $("#listapessoas").html("");
 
       }
 
       //If name is not empty.
 
       else {
 
           //AJAX is called.
            $.get("{{asset('pessoa/buscarapida/')}}"+"/"+name)
                .done(function(data) 
                {
                    $.each(data, function(key, val){
                        namelist+='<li class="item item-list-header hidden-sm-down">'
                                    +'<a href="#" onclick="adicionar(\''+val.id+'\',\''+val.nome+'\')">'
                                        +val.numero+' - '+val.nascimento+' - '+val.nome
                                    +'</a>'
                                  +'</li>';
                    

                    });
                    //console.log(namelist);
                    $("#listapessoas").html(namelist).show();



                });

                /*
                <option value="324000000000 Adauto Junior 10/11/1984 id:0000014">
                    <option value="326500000000 Fulano 06/07/1924 id:0000015">
                    <option value="3232320000xx Beltrano 20/02/1972 id:0000016">
                    <option value="066521200010 Ciclano 03/08/1945 id:0000017">
                    */
            
            
 
       }
 
    });
 
});
function adicionar(id,nome){
    $('#id_pessoa').val(id);
    $('#search').val(nome);
    $("#listapessoas").html("");

}
function enviar(){
    event.preventDefault();
    if(!$('#id_pessoa').val()>0){
        alert('Escolha uma pessoa na lista de nomes encontrados.');
        return false;
    }
    if(confirm('Tem certeza que deseja cadastrar esta pessoa na turma?')){
        $('form').submit();
    }
    else
        return false;

}
function remover(inscricao){
    if(confirm('Tem certeza que deseja remover esta inscrição?'))
        window.location.replace("{{asset('secretaria/matricula/inscricao/apagar')}}/"+inscricao);
}

function apagar(){
    if(confirm("Deseja mesmo apagar essa turma?"))
        $(location).attr('href','{{route('turmas')}}/apagar/{{$turma->id}}');

}

function editar(){
        $(location).attr('href','{{route('turmas')}}/editar/{{$turma->id}}');

}
function cancelar(){
    if(confirm("Deseja mesmo cancelar essa turma?"))
        $(location).attr('href','{{route('turmas')}}/status/cancelada/{{$turma->id}}');

}
function alterarStatus(status){
     
        if(confirm('Deseja realmente alterar o status dessa turma para '+status+' ?'))
            $(location).attr('href','{{route('turmas')}}/status/'+status+'/{{$turma->id}}');

    
}
function alterarOpcoes(status){
    if(confirm('Deseja realmente '+status+' dessa turma?'))
            $(location).attr('href','{{route('turmas')}}/alterar/'+status+'/{{$turma->id}}');
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
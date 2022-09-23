@extends('layout.app')
@section('titulo')Jornada de trabalho @endsection
@section('pagina')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    @media (min-width: 767px){
        .codigo{
            max-width: 50px; }
        .pessoa{
            max-width: 300px; }
        .curso{
            max-width: 300px; }
            
            
        }
    @media (max-width: 766px){
        .pessoa{
            font-size: 20px;
        }
    }   
</style>

@include('docentes.modal.add_jornada')
@include('docentes.modal.editar_jornada')
@include('docentes.modal.exclusao_jornada')

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="#">Jornada</a></li>
</ol>

<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Jornadas de Trabalho <a href="#" data-toggle="modal" data-target="#modal-add-jornada" class="btn btn-primary btn-sm rounded-s"> Cadastrar nova </a>
                    <!--
-->
                    <div class="action dropdown">
                        <button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Opções... </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 5px, 0px);" x-out-of-boundaries="">
                            <a class="dropdown-item" href="#" style="text-decoration: none; font-weight: 550;"><i class="fa fa-bar-chart-o icon"></i>Gráfico</a>
                            
                        </div>
                    </div>
                </h3>
                <p class="title-description">
                     <strong>Prof.:</strong> {{$docente->nome}} <br>
                     <strong class="badge badge-pill badge-primary">{{$carga_ativa->floatDiffInHours(\Carbon\Carbon::Today())}}h</strong> Efetivas | <strong class="badge badge-pill badge-primary">{{isset($carga->carga)?$carga->carga:'00'}}h</strong> Carga Semanal </p>
            </div>
        </div>
    </div>


    <!--<div class="items-search">
        <form class="form-inline" method="GET>
        {{csrf_field()}}
            <div class="input-group"> 
                <input type="text" class="form-control boxed rounded-s" name="codigo" placeholder="Procurar p/ código.">
                <span class="input-group-btn">
                    <button class="btn btn-secondary rounded-s" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>-->
    <div class="items-search col-md-3">
        <div class="header-block header-block-search hidden-sm-down">
           <form action="/fichas/pesquisa" method="GET">
            {{csrf_field()}}
               <div class="input-group input-group-sm" style="float:right;">
                   <input type="text" class="form-control" name="curso" placeholder="Buscar por curso">
                   <i class="input-group-addon fa fa-search" onclick="document.forms[1].submit();" style="cursor:pointer;"></i>
               </div>
           </form>
       </div>

   </div>
</div>
@include('inc.errors')
<form name="item" class="form-inline">
    <section class="section">
    <div class="row ">
        <div class="col-xl-12">
            <div class="card sameheight-item">
                <div class="card-block">
                    <!-- Nav tabs -->
                    <div class="row">
                        <div class="col-xs-10 text-xs">
                            {{ $jornadas->links() }}
                        </div>
                        <div class="col-xs-2 text-xs-right">

                            
                            <div class="action dropdown pull-right "> 
                                <!-- <a href="#" class="btn btn-sm rounded-s btn-secondary" title="Exportar para excel"><img src="/img/excel.svg" alt="excel" width="20px"></a> -->
                                <button class="btn btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Com os selecionadas...
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                <!--
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('aprovar')">
                                        <label><i class="fa fa-check-circle-o icon text-success"></i> Aprovar</label>
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('negar')">
                                        <label><i class="fa fa-ban icon text-danger"></i> Negar</label>
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('analisando')">
                                        <label><i class="fa fa-clock-o icon text-warning"></i><span> Analisando</span></label>
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('cancelar')">
                                        <label><i class="fa fa-minus-circle icon text-danger"></i> <span> Cancelar</span></label>
                                    </a> -->
                                    <a class="dropdown-item" href="#" onclick="excluirSelecionados()">
                                        <label><i class="fa fa-times-circle icon text-danger"></i> <span> Excluir</span></label>
                                    </a> 
                                    
                                </div>
                             </div>
                            
                        </div>

                    </div>
                    <table class="table">
                        <thead>
                            <th>
                                <div class="item-col item-col-header fixed item-col-check"> 
                                    <label class="item-check" id="select-all-items">
                                        <input type="checkbox" class="checkbox" name="jornada" onchange="selecionarTodos(this);"><span></span>
                                    </label>
                                </div>    
                            </th>
                            <th class="tb_id">
                                Id
                            </th>
                            <th class="tb_docente">
                                Docente
                            </th>     
                            <th class="tb_inicio">
                                Datas
                            </th>
                            <th class="tb_dias">
                                Dias
                            </th>
                            <th class="tb_horario">
                                Horários
                            </th>
                            <th class="tb_horario">
                                Local
                            </th>
                            <th class="tb_tipo">
                                Tipo
                            </th>
                            <th class="tb_status">
                                Estado
                            </th>
                            <th class="tb_opt">
                                Opções
                            </th>
                        </thead>
                        <tbody>
                            @foreach($jornadas as $jornada)
                            <tr>
                                <td>
                                    <div class="item-col item-col-header fixed item-col-check"> 
                                        <label class="item-check" id="select-all-items">
                                            <input type="checkbox" class="checkbox" name="jornada" value="{{$jornada->id}}"><span></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="/jornadas/visualizar/{{$jornada->id}}">#{{$jornada->id}}</a>
                                </td>
                                <td>
                                    {{$jornada->getPessoa()->nome_simples}}
                                </td>
                                
                            
                                <td>
                                    {{$jornada->inicio->format('d/m/Y')}} <br>{{$jornada->termino?$jornada->termino->format('d/m/Y'):'Em andamento'}}
                                </td>
                                <td>
                                    @foreach($jornada->dias_semana as $dia)
                                    {{$dia}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    {{$jornada->hora_inicio}} <br>{{$jornada->hora_termino}}
                                </td>
                                <td>
                                    {{$jornada->getLocal()->sigla}}
                                </td>
                                <td>
                                    {{$jornada->tipo}}
                                </td>
                                <td>
                                    @switch($jornada->status)
                                        @case('ativa')
                                            <span class="badge badge-pill badge-success">
                                            @break
                                        @case('solicitada')
                                            <span class="badge badge-pill badge-primary">
                                            @break
                                        @case('encerrada')
                                            <span class="badge badge-pill badge-secondary">
                                            @break
                                        @case('negada')
                                            <span class="badge badge-pill badge-warning">
                                            @break
                                        @default
                                            <span class="badge badge-pill badge-primary">
                                            @break
                                    @endswitch                                
                                        {{$jornada->status}}</span>                                  
                                </td>

                                <td>
                                    <h5>
                                    <a href="#" data-toggle="modal" data-target="#modal-encerrar-jornada" title="Editar jornada"  onclick="atribJornada('{{$jornada->id}}')"> <i class="fa fa-edit "></i></a>
                                    <a href="/jornadas/copiar/{{$jornada->id}}" title="Criar cópia jornada"> <i class="fa fa-copy"></i></a>
                                    <a href="#" onclick="excluir({{$jornada->id}})" title="Excluir jornada"><i class="fa fa-times-circle text-danger"></i> </a>
                                    </h5>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>



                    
                    
                           
                </div>
                <!-- /.card-block -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-xl-6 -->
        
        <!-- /.col-xl-6 -->
    </div>

{{ $jornadas->links() }}

</form>
</section>
@endsection
@section('scripts')
<script>
function selecionarTodos(campo){
	$("input:checkbox").each(
		function(){
			$(this).prop("checked", campo.checked)
		}
	);
}
function alterarStatus(status){
     var selecionados='';
        $("input:checkbox[name=ficha]:checked").each(function () {
            excluirFicha(this.value);

        });
        if(selecionados==''){
            alert('Nenhum item selecionado');
            return false;
        }
        if(status ==  'aprovar' || status ==  'negar' )
            $(location).attr('href','./analisar/'+selecionados);
        else
            if(confirm('Deseja realmente alterar as bolsas selecionadas?'))
                $(location).attr('href','/jornadas/status/'+status+'/'+selecionados);

        return false;

    
}
function excluirSelecionados(){

    if(confirm("Deseja mesmo apagar os itens selecionados?")){
        $("input:checkbox[name=ficha]:checked").each(function () {
            excluirFicha(this.value);

        });
        location.reload(true);
    }

    
}
function parado(){
    console.log('parei');
    //$('#filtro2').css('display','inline');
    $('#dropdownMenu2').trigger('click');
}

function excluir(id){
    if(confirm("Deseja mesmo excluir essa jornada?")){
        excluirFicha(id);
        location.reload(true);
    }
}

function excluirJornada(id){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/jornadas/excluir",
        data: { id }
        
    })
	.done(function(msg){
		//location.reload(true);
	})
    .fail(function(msg){
       // alert('Falha ao excluir ficha: '+msg.statusText);
    });
}


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
        url: "/jornada/encerrar",
        data: { jornada }
        
    })
	.done(function(msg){
		location.reload(true);
	})
    .fail(function(msg){
        alert('Falha ao excluir jornada: '+msg.statusText);
    });
}

function encerrarJornada(){
    encerramento = $("#data_encerramento").val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/jornada/encerrar",
        data: { jornada,encerramento }
        
    })
	.done(function(msg){
		location.reload(true);
	})
    .fail(function(msg){
        alert('Falha ao encerrar jornada: '+msg.statusText);
    });
}


</script>



@endsection
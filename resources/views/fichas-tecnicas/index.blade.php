@extends('layout.app')
@section('titulo')Fichas Técnicas de Turmas @endsection
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
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="#">Fichas Técnicas</a></li>
 
</ol>

<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Fichas Técnicas <a href="/fichas/cadastrar" class="btn btn-primary btn-sm rounded-s"> Cadastrar nova </a>
                    <!--
-->
                    <div class="action dropdown">
                        <button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Opções... </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 5px, 0px);" x-out-of-boundaries="">
                            <a class="dropdown-item" href="#" style="text-decoration: none; font-weight: 550;"><i class="fa fa-bar-chart-o icon"></i>Em construção</a>
                            
                        </div>
                    </div>
                </h3>
                <p class="title-description"> Fluxo de controle de lançamento de turmas. </p>
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
                            {{ $fichas->links() }}
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
                                        <input type="checkbox" class="checkbox" name="ficha" onchange="selecionarTodos(this);"><span></span>
                                    </label>
                                </div>    
                            </th>
            
                            <th class="tb_curso">
                                Curso
                            </th>
                            <th class="tb_programa">
                                Programa
                            </th>
                            <th class="tb_docente">
                                Docente
                            </th>   
                            <th class="tb_dias">
                                Dias
                            </th>
                            <th class="tb_inicio">
                                Datas
                            </th>
                            <th class="tb_horario">
                                Horários
                            </th>
                            <th class="tb_status">
                                Estado
                            </th>
                            <th class="tb_opt">
                                Opções
                            </th>
                        </thead>
                        <tbody>
                            @foreach($fichas as $ficha)
                            <tr>
                                <td>
                                    <div class="item-col item-col-header fixed item-col-check"> 
                                        <label class="item-check" id="select-all-items">
                                            <input type="checkbox" class="checkbox" name="ficha" value="{{$ficha->id}}"><span></span>#{{$ficha->id}}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="/fichas/visualizar/{{$ficha->id}}" title="Analizar">{{$ficha->curso}}</a>
                                </td>
                                <td>
                                    {{$ficha->getPrograma()->sigla}}
                                </td>
                                <td>
                                    {{$ficha->getDocente()}}
                                </td>
                               
                                <td>
                                    {{$ficha->dias_semana}}
                                </td>
                                <td>
                                    {{$ficha->data_inicio->format('d/m/y')}} <br>{{$ficha->data_termino->format('d/m/y')}}
                                </td>
                                <td>
                                    {{$ficha->hora_inicio}} <br>{{$ficha->hora_termino}}
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-primary">{{$ficha->status}}</span>
                                    
                                </td>
                                <td>
                                    
                                    <a href="/fichas/visualizar/{{$ficha->id}}" class="btn btn-sm rounded-s btn-primary-outline" title="Analizar"><i class="fa fa-search"></i></a>
                                    <a href="/fichas/editar/{{$ficha->id}}" title="Editar Ficha" class="btn btn-sm rounded-s btn-primary-outline"><i class="fa fa-edit "></i></a>
                                    <a href="/fichas/copiar/{{$ficha->id}}" title="Criar cópia Ficha" class="btn btn-sm rounded-s btn-primary-outline"><i class="fa fa-copy"></i></a>
                                    <a href="#" onclick="excluir({{$ficha->id}})" title="Excluir ficha" class="btn btn-sm rounded-s btn-danger-outline"><i class="fa fa-times-circle"></i></a>
                                    
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

{{ $fichas->links() }}

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
                $(location).attr('href','/fichas/status/'+status+'/'+selecionados);

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
    if(confirm("Deseja mesmo excluir essa ficha técnica?")){
        excluirFicha(id);
        alert('Ficha excluída');
        location.reload(true);
         
        
    }
}

function excluirFicha(id){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/fichas/excluir",
        data: { id }
        
    })
	.done(function(msg){
		//location.reload(true);
	})
    .fail(function(msg){
       // alert('Falha ao excluir ficha: '+msg.statusText);
    });
}


</script>



@endsection
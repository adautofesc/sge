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
                    <div class="action dropdown">{{$view}}
                        <button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Opções... </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 5px, 0px);" x-out-of-boundaries="">
                            @if($view=='all')
                            <a class="dropdown-item" href="?" style="text-decoration: none; font-weight: 550;"><i class="fa fa-eye-slash"></i> Ocultar lançadas</a>
                            @else
                            <a class="dropdown-item" href="?view=all" style="text-decoration: none; font-weight: 550;"><i class="fa fa-eye"></i> Visualizar lançadas</a>
                            @endif
                            <a class="dropdown-item" href="/fichas/exportar" style="text-decoration: none; font-weight: 550;"><img src="/img/excel.png" width="17px;"> Exportar dados</a>
                            
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
           <form action="/fichas/" method="GET">
            {{csrf_field()}}
               <div class="input-group input-group-sm" style="float:right;">
                   <input type="text" class="form-control" name="busca" placeholder="Buscar por id/curso">
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
                        
                        <div class="col-xs-5">
                            @foreach($filtros as $filtro=>$valor)
                                @if(count($filtros[$filtro]))
                                    <a href="?removefiltro={{$filtro}}" class="badge badge-primary" style="color:white;text-decoration: none;" title="Remover este filtro">
                                        <i class="fa fa-remove" ></i>
                                        {{$filtro}}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-xs-5 text-xs">
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
                                    
                                    <a class="dropdown-item" href="#" onclick="imprimirSelecionados()">
                                        <label><i class="fa fa-print icon "></i> <span> Imprimir</span></label>
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="excluirSelecionados()">
                                        <label><i class="fa fa-times-circle icon text-danger"></i> <span> Excluir</span></label>
                                    </a> 
                                    
                                </div>
                             </div>
                            
                        </div>

                    </div>
                    <table class="table table-hover table-sm">
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
                                <div class="action dropdown "> 
                                    <button class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Programa 
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                        @foreach($programas as $programa)
        
                                        @if(isset($filtros['programa']) &&  array_search($programa->id,$filtros['programa']) !== false)
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=programa&valor={{$programa->id}}&remove=1')">
                                            <i class="fa fa-check-circle-o icon"></i> {{$programa->sigla}}
                                        </label>
                                        @else
                                        <label class="dropdown-item"  onclick="window.location.replace('?filtro=programa&valor={{$programa->id}}')">
                                            <i class="fa fa-circle-o icon"></i> {{$programa->sigla}}
                                        </label>
                                        @endif
                                        @endforeach 
                                       
                                    </div>
                                </div>
                            </th>
                            <th class="tb_docente">
                                <div class="action dropdown "> 
                                    <button class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Docente 
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                        @foreach($professores as $professor)
        
                                        @if(isset($filtros['professor']) &&  array_search($professor->id,$filtros['professor']) !== false)
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=professor&valor={{$professor->id}}&remove=1')">
                                            <i class="fa fa-check-circle-o icon"></i> {{$professor->nome_simples}}
                                        </label>
                                        @else
                                        <label class="dropdown-item"  onclick="window.location.replace('?filtro=professor&valor={{$professor->id}}')">
                                            <i class="fa fa-circle-o icon"></i> {{$professor->nome_simples}}
                                        </label>
                                        @endif
                                        @endforeach 
                                       
                                    </div>
                                </div>
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
                                <div class="action dropdown "> 
                                    <button class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Status
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu4"> 
                                        @if(isset($filtros['status']))                             
                                       
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=docente{{array_search('docente',$filtros['status'])!==false?'&remove=1':''}}');">
                                            <i class="fa fa-{{array_search('docente',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Docente
                                        </label>
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=coordenacao{{array_search('coordenacao',$filtros['status'])!==false?'&remove=1':''}}');">
                                            <i class="fa fa-{{array_search('coordenacao',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Coordenação
                                        </label>
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=diretoria{{array_search('diretoria',$filtros['status'])!==false?'&remove=1':''}}');">
                                            <i class="fa fa-{{array_search('diretoria',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Diretoria
                                        </label>
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=administracao{{array_search('administracao',$filtros['status'])!==false?'&remove=1':''}}');">
                                            <i class="fa fa-{{array_search('administracao',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Administração 
                                        </label>
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=presidencia{{array_search('presidencia',$filtros['status'])!==false?'&remove=1':''}}');">
                                            <i class="fa fa-{{array_search('presidencia',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Presidência 
                                        </label>
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=secretaria{{array_search('secretaria',$filtros['status'])!==false?'&remove=1':''}}');">
                                            <i class="fa fa-{{array_search('secretaria',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Secretaria 
                                        </label>
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=lancada{{array_search('lancada',$filtros['status'])!==false?'&remove=1':''}}');">
                                            <i class="fa fa-{{array_search('lancada',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Lançada
                                        </label>
                                        
                                        
                                        @else
                                
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=docente');">
                                            <i class="fa fa-circle-o icon"></i>  Docente
                                        </label>
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=coordenacao');">
                                            <i class="fa fa-circle-o icon"></i> Coordenação
                                        </label>
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=diretoria');">
                                            <i class="fa fa-circle-o icon"></i> Diretorias
                                        </label>
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=administracao');">
                                            <i class="fa fa-circle-o icon"></i> Administração
                                        </label>
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=presidencia');">
                                            <i class="fa fa-circle-o icon"></i> Presidência
                                        </label>
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=secretaria');">
                                            <i class="fa fa-circle-o icon"></i> Secretaria
                                        </label>
                                        <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=lancada');">
                                            <i class="fa fa-circle-o icon"></i> Lançada
                                        </label>
                                        
                                        @endif
                                    </div>
        
                                </div>
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
                                    <a href="/fichas/visualizar/{{$ficha->id}}" title="Analisar">{{$ficha->curso}}</a>
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
                                    @if($ficha->data_inicio)
                                    {{$ficha->data_inicio->format('d/m/y')}}
                                    @else
                                    SEM DATA DE INICIO
                                    @endif
                                    <br>
                                    @if($ficha->data_termino)
                                    {{$ficha->data_termino->format('d/m/y')}}
                                    @else
                                    SEM DATA DE TERMINO
                                    @endif
                                    
                                </td>
                                <td>
                                    {{$ficha->hora_inicio}} <br>{{$ficha->hora_termino}}
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-primary">{{$ficha->status}}</span>
                                    @if($ficha->status == 'lancada')
                                        <br><small> <a href="/turmas/{{$ficha->turma}}"> Turma {{$ficha->turma}}</a></small>
                                    @endif
                                    
                                </td>
                                <td>
                                    
                                    <a href="/fichas/imprimir/{{$ficha->id}}" target="_blank" class="btn btn-sm rounded-s btn-primary-outline" title="Imprimir"><i class="fa fa-print"></i></a>
                                    <a href="/fichas/copiar/{{$ficha->id}}" title="Criar cópia Ficha" class="btn btn-sm rounded-s btn-primary-outline"><i class="fa fa-copy"></i></a>
                                    @if($ficha->status == 'lancada' && !in_array('30', Auth::user()->recursos))
                                        <a href="#" title="Ficha já lançada, favor alterar a turma" class="btn btn-sm rounded-s btn-secondary-outline"><i class="fa fa-edit "></i></a>
                                        <a href="#" title="Ficha já lançada, favor alterar a turma" class="btn btn-sm rounded-s btn-secondary-outline"><i class="fa fa-times-circle"></i></a>
                                    @else
                                        <a href="/fichas/editar/{{$ficha->id}}" title="Editar Ficha" class="btn btn-sm rounded-s btn-primary-outline"><i class="fa fa-edit "></i></a>
                                        <a href="#" onclick="excluir({{$ficha->id}})" title="Excluir ficha" class="btn btn-sm rounded-s btn-danger-outline"><i class="fa fa-times-circle"></i></a>
                                    @endif
                                    
                                    
                                    
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
function imprimirSelecionados(){

    itens='';
    $("input:checkbox[name=ficha]:checked").each(function () {
        itens+=this.value+',';

    });
    location.href = '/fichas/imprimir/'+itens;



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
@extends('layout.app')
@section('titulo')Criando novo requisito @endsection
@section('pagina')
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="../">Pedagogico</a></li>
 
</ol>




      
        <div class="form-group row">
            <div class="col-md-9">
                <!--<a href="#" class="btn btn-secondary btn-sm rounded-s" title="Opções"><i class="text-info fa fa-cogs"></i></a>-->
                <a href="{{asset('cursos/requisitos/cadastrar')}}" class="btn btn-secondary btn-sm rounded-s" title="Adicionar"><i class="text-success fa fa-plus"></i></a>
                
                <a href="#" onclick="apagar()" class="btn btn-secondary btn-sm rounded-s" title="Apagar selecionados"><i class="text-danger fa fa-trash-o"></i></a>      
            </div>
            
            <div class="form-group col-md-3">
                 <div class="header-block header-block-search hidden-sm-down">
                    <form role="search">
                        <div class="input-group input-group-sm" style="float:right;">
                            <input type="text" class="form-control" placeholder="Buscar...">
                            <i class="input-group-addon fa fa-search" onclick="this.form.submit();"></i>
                        </div>
                    </form>
                </div>

            </div>

        </div>

@include('inc.errors')

<div class="card" style="margin-top:-20px;">

    <div class="card-block">
        <div class="card-title-block">
            <h3 class="title"> Lista de requisitos <small>filtrado por: 
                @foreach($filtros as $filtro=>$valor)
                @if(is_array($filtros[$filtro]))

                    <a href="?removefiltro={{$filtro}}{{isset($_GET['page'])?'&page='.$_GET['page']:''}}" title="Remover este filtro" style="text-decoration: none;">
                        <i class="fa fa-remove" style="color:red"></i>
                        {{$filtro}}
                    </a> | 
                @endif
                @endforeach



            </small></h3>


        </div>
          <small>
            {{ $requisitos->links() }}
            <div style="float:right;">
                1 item selecionado
            </div>
            </small>
        <small>
        <table class="table table-striped">
            <thead>
                <th style="width: 10px;">
                    <div class="item-col item-col-header fixed item-col-check"> 
                        <label class="item-check" id="select-all-items">
                            <input type="checkbox" class="checkbox" value="0"><span></span>
                        </label>
                    </div>
                </th>
                <th><i class="fa fa-caret-down"></i>&nbsp;&nbsp;<a href="#" title="Ordenar por requisito">Requisito</a></th>
            </thead>
            <tbody>
            @foreach($requisitos->all() as $requisito)
                <tr scope="row">
                    <td>
                        <div class="item-col item-col-header fixed item-col-check"> 
                            <label class="item-check">
                                <input type="checkbox" class="checkbox"  name="requisito" value="{{$requisito->id}}">
                                <span></span>
                            </label> 
                        </div> 
                    </td>
                    <td>{{$requisito->nome}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </small>
        <small>
            {{ $requisitos->links() }}
            <div style="float:right;">
                1 item selecionado
            </div>
            </small>
    </div>

    <!--btn btn-primary btn-sm dropdown-toggle
	
    <ul class="item-list striped"> <!-- lista com itens encontrados
        <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
                <div class="item-col item-col-header fixed item-col-check"> 
                	<label class="item-check" id="select-all-items">
                		<input type="checkbox" class="checkbox" value="0"><span></span>
					</label>
				</div>
                <div class="item-col item-col-header ">
                    <div> <span>Requisito</span> </div>
                </div>
            </div>
        </li>
        @foreach($requisitos->all() as $requisito)
        <li class="item">
            <div class="item-row">
                <div class="item-col item-col-header fixed item-col-check"> 
                	<label class="item-check">
						<input type="checkbox" class="checkbox"  name="requisito" value="{{$requisito->id}}">
						<span></span>
					</label> 
                </div>                
                <div class="item-col fixed pull-left item-col-title">
                    <div class="item-heading">Requisito</div>
                    <div>                        
                        <h4 class="item-title">{{$requisito->nome}}</h4>
                    </div>
                </div>
        	</div>
        </li>
        @endforeach
    </ul>-->

</div>

@endsection
@section('scripts')
<script>
function apagar() 
{
    var selecionados='';
        $("input:checkbox[name=requisito]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente apagar os requisitos selecionados'))
            $(location).attr('href','{{asset("/cursos/requisitos/apagar")}}/'+selecionados);
}
</script>

@endsection
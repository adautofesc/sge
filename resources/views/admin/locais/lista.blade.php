@extends('layout.app')
@section('titulo')Locais cadastrados. @endsection
@section('pagina')
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="/administrativo/">Adminstrativo</a></li>
 
</ol>

<div class="row">
        <div class="col-md-5">
                <h3 class="title" style="margin-bottom:20px;"> Lista de locais físicos de atendimento </h3> 
                <hr>
            
         </div>
         <div class="col-md-7" style="text-align:right;">
                <small>{{ $locais->links() }}</small>
        </div>
</div>



@include('inc.errors')

<div class="card">

    <div class="card-block">
        <div class="row">
            <div class="col-md-9">
                <small>
                        <a href="{{asset('/administrativo/locais/cadastrar')}}" class="btn btn-secondary btn-sm rounded-s text-success" title="Adicionar"><i class=" fa fa-plus"> Novo Local</i></a>
            
                        <!-- <a href="#" onclick="apagar()" class="btn btn-secondary btn-sm rounded-s text-danger" title="Apagar selecionados"><i class=" fa fa-trash-o"> Excluir selecionados</i></a>-->      
                           
                </small>

            </div>
            
                
                
                <div class="form-group col-md-3">
                     <div class="header-block header-block-search hidden-sm-down">
                        <form method="GET">
                            <div class="input-group input-group-sm" style="float:right;">
                                <input type="text" class="form-control" placeholder="Buscar..." name="buscar">
                                <i class="input-group-addon fa fa-search" onclick="document.forms[0].submit();"></i>
                            </div>
                        </form>
                    </div>
    
                </div>
        </div>
          
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
            <th>&nbsp;&nbsp;Nome </th>
                <th>&nbsp;&nbsp;Sigla</th>
               
                <th style="text-align:right;">&nbsp;&nbsp;Opções</th>
            </thead>
            <tbody>
            @foreach($locais->all() as $local)
                <tr scope="row">
                    <td>
                        <div class="item-col item-col-header fixed item-col-check"> 
                            <label class="item-check">
                                <input type="checkbox" class="checkbox"  name="local" value="{{$local->id}}">
                                <span></span>
                            </label> 
                        </div> 
                    </td>
                    <td>{{$local->nome}}</td>
                    <td>{{$local->sigla}}</td>
                    
                    <td style="float:right;">
                        <!--<a href="#" class="btn btn-secondary btn-sm rounded-s text-info" title="Informações" data-toggle="modal" data-target="#info-modal"><i class=" fa fa-info"> Informações</i></a> -->
                        <a href="./locais/salas/{{$local->id}}" class="btn btn-secondary btn-sm rounded-s text-success" title="Salas"><i class=" fa fa-home"> Salas</i></a>   
                        <a href="./locais/editar/{{$local->id}}" class="btn btn-secondary btn-sm rounded-s text-dark" title="Editar"><i class=" fa fa-pencil"> Alterar</i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </small>
        <small>
            {{ $locais->links() }}
            <div style="float:right;">
               <!-- 1 item selecionado -->
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
                    <div> <span>local</span> </div>
                </div>
            </div>
        </li>
        @foreach($locais->all() as $local)
        <li class="item">
            <div class="item-row">
                <div class="item-col item-col-header fixed item-col-check"> 
                	<label class="item-check">
						<input type="checkbox" class="checkbox"  name="local" value="{{$local->id}}">
						<span></span>
					</label> 
                </div>                
                <div class="item-col fixed pull-left item-col-title">
                    <div class="item-heading">local</div>
                    <div>                        
                        <h4 class="item-title">{{$local->nome}}</h4>
                    </div>
                </div>
        	</div>
        </li>
        @endforeach
    </ul>-->

</div>
<div class="modal fade" id="info-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i class="fa fa-info"></i><small> Dados do local</small></h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to do this?</p>
                </div>
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button> 
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button> 
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
@endsection
@section('scripts')
<script>
function apagar() 
{
    var selecionados='';
        $("input:checkbox[name=local]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente apagar os locais selecionados'))
            $(location).attr('href','{{asset("/administrativo/locais/apagar")}}/'+selecionados);
}
</script>

@endsection
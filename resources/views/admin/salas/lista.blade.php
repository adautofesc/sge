@extends('layout.app')
@section('titulo')Salas cadastradas. @endsection
@section('pagina')
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="/">Início</a></li>
  <li class="breadcrumb-item"><a href="/administrativo/">Adminstrativo</a></li>
  <li class="breadcrumb-item"><a href="/administrativo/locais">locais</a></li>
 
</ol>

<div class="row">
        <div class="col-md-5">
                <h3 class="title" style="margin-bottom:20px;"> Salas de: {{$local->nome}} </h3> 
                <hr>
            
         </div>
         <div class="col-md-7" style="text-align:right;">
                <small>{{ $salas->links() }}</small>
        </div>
</div>



@include('inc.errors')

<div class="card">

    <div class="card-block">
        <div class="row">
            <div class="col-md-9">
                <small>
                        <a href="{{asset('/administrativo/salas/cadastrar/'.$local->id)}}" class="btn btn-secondary btn-sm rounded-s text-success" title="Adicionar"><i class=" fa fa-plus"> Adicionar Sala</i></a>
            
                        <a href="#" onclick="apagar()" class="btn btn-secondary btn-sm rounded-s text-danger" title="Apagar selecionados"><i class=" fa fa-trash-o"> Excluir selecionados</i></a>      
                           
                </small>

            </div>
            
                
                
                <div class="form-group col-md-3">
                     <div class="header-block header-block-search hidden-sm-down">
                        <form method="GET">
                            <div class="input-group input-group-sm" style="float:right;">
                                <input type="text" class="form-control" placeholder="Buscar..." name="buscar">
                                <i class="input-group-addon fa fa-search" onclick="document.forms[1].submit();"></i>
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
            <th>&nbsp;&nbsp;Nome</th>
            <th title="capacidade">&nbsp;&nbsp;Cap.</th>
            <th title="tamanho">&nbsp;&nbsp;Tam.</th>
            <th>&nbsp;&nbsp;Observações</th>
            <th>&nbsp;&nbsp;Recursos</th>
               
                <th style="text-align:right;">&nbsp;&nbsp;Opções</th>
            </thead>
            <tbody>
            @foreach($salas->all() as $sala)
                <tr scope="row">
                    <td>
                        <div class="item-col item-col-header fixed item-col-check"> 
                            <label class="item-check">
                                <input type="checkbox" class="checkbox"  name="sala" value="{{$sala->id}}">
                                <span></span>
                            </label> 
                        </div> 
                    </td>

                    <td>{{$sala->nome}}</td>
                    <td title="pessoas">{{$sala->capacidade}} p.</td>
                    <td>{{$sala->metragem}}m²</td>
                    <td>{{$sala->obs}}</td>
                    <td><!--
                    <ul style="list-style-type:none; padding-left:0%;" id="lista{{$sala->id}}">
                            <li>
                                <a href="#" onclick="apagar(123)" class="btn btn-secondary btn-sm rounded-s text-danger" title="Apagar selecionados"><i class=" fa fa-trash-o"></i></a>
                                teste com um  grande
                            </li>
                            <li>
                                    <a href="#" onclick="apagar()" class="btn btn-secondary btn-sm rounded-s text-danger" title="Apagar selecionados"><i class=" fa fa-trash-o"></i></a>
                                    teste com um  grande
                            </li>
                        </ul>
                    <input type="text" class="form-control form-control-sm" name="recurso{{$sala->id}}" id="recurso{{$sala->id}}" size="2px" placeholder=" 1 Computador"> 
                        <a href="#" class="btn btn-secondary btn-sm rounded-s text-success" style="margin-top:5px;" onclick="addrecurso({{$sala->id}})" title="Adicionar recurso à sala"><i class=" fa fa-plus"> Adicionar</i></a>
                    </td>-->
                    
                    <td style="float:right;">
                        <!--<a href="#" class="btn btn-secondary btn-sm rounded-s text-info" title="Informações" data-toggle="modal" data-target="#info-modal"><i class=" fa fa-info"> Informações</i></a> -->  
                        <a href="/administrativo/salas/alterar/{{$sala->id}}" class="btn btn-secondary btn-sm rounded-s text-dark" title="Modificar dados dessa sala"><i class=" fa fa-pencil"> Alterar</i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </small>
        <small>
            {{ $salas->links() }}
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
                    <div> <span>sala</span> </div>
                </div>
            </div>
        </li>
        @foreach($salas->all() as $sala)
        <li class="item">
            <div class="item-row">
                <div class="item-col item-col-header fixed item-col-check"> 
                	<label class="item-check">
						<input type="checkbox" class="checkbox"  name="sala" value="{{$sala->id}}">
						<span></span>
					</label> 
                </div>                
                <div class="item-col fixed pull-left item-col-title">
                    <div class="item-heading">sala</div>
                    <div>                        
                        <h4 class="item-title">{{$sala->nome}}</h4>
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
                    <h4 class="modal-title"><i class="fa fa-info"></i><small> Dados do sala</small></h4>
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
function addrecurso(id){
    var recurso = document.querySelector('#recurso'+id);
    var lista = document.querySelector('#lista'+id);
    var item_lista = document.createElement('li');
    var btn = document.createElement('a');
    btn.setAttribute('href','#');
    btn.setAttribute('onclick','apagar()');
    btn.setAttribute('title','Apagar este recurso')
    btn.setAttribute('class','btn btn-secondary btn-sm rounded-s text-danger');

    var icon = document.createElement('i');
    icon.setAttribute('class','fa fa-trash-o')

    var texto_item = document.createTextNode(' '+recurso.value);
    btn.appendChild(icon);
    item_lista.appendChild(btn);
    item_lista.appendChild(texto_item);
    lista.appendChild(item_lista);
    recurso.value = '';
    
    
}
function apagar() 
{
    var selecionados='';
        $("input:checkbox[name=sala]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente apagar os salas selecionados'))
            $(location).attr('href','{{asset("/administrativo/salas/apagar")}}/'+selecionados);
}
</script>

@endsection
@extends('layout.app')
@section('titulo')Criando novo requisito @endsection
@section('pagina')
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="../">Pedagogico</a></li>
 
</ol>



<div class="">
        <div class="row">
            <div class="col-md-3">
                <h3 class="title border-bottom"><i class=" fa fa-asterisk "></i> Requisitos
                     
                </h3>
            </div>
            <div class="col-md-7 ">
                &nbsp;
            </div>
            <div class="form-group col-md-2">
                 <div class="header-block header-block-search hidden-sm-down">
                    <form role="search">
                        <div class="input-group input-group-sm">
                
                            
                            <input type="text" class="form-control" placeholder="Buscar...">
                            <i class="input-group-addon fa fa-search" onclick="this.form.submit();"></i>


                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-5">
                <a href="{{asset('pedagogico/cursos/requisitos/add')}}" class="btn btn-secondary btn-sm rounded-s"><i class="text-success fa fa-plus"></i></a>
                
                <a href="#" onclick="apagar()" class="btn btn-secondary btn-sm rounded-s" title="Apagar selecionados"><i class="text-danger fa fa-trash-o"></i></a>      
            </div>
        </div>
</div>
@include('inc.errors')
<div class="card items">
	
    <ul class="item-list striped"> <!-- lista com itens encontrados -->
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
    </ul>
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
            $(location).attr('href','{{asset("/pedagogico/cursos/requisitos/apagar")}}/'+selecionados);
}
</script>

@endsection
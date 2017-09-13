@extends('layout.app')
@section('pagina')

<div class="title-block">
        <div class="row">
            <div class="col-md-12">
                <h3 class="title"> Requisitos dos cursos/atividades <a href="{{asset('pedagogico/cursos/requisitos/add')}}" class="btn btn-primary btn-sm rounded-s">Adicionar</a>  
                <a href="#" onclick="apagar()" class="btn btn-danger btn-sm rounded-s">Remover selecionados</a>           
                </h3>
                <p class="title-description"> Lista de requisitos que podem ser solicitados ao criar um curso ou atividade.</p>
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
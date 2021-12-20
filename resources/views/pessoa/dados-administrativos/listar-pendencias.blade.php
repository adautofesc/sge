@extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Pendências  <!--                
	                <div class="action dropdown"> 
	                	<button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mais ações...
	                	</button>
	                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
	                    	<a class="dropdown-item" href="#"><i class="fa fa-pencil-square-o icon"></i>Enviar e-mail</a> 
	                    	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirm-modal"><i class="fa fa-close icon"></i>Apagar</a>
	                    </div>
	                </div> -->
                </h3>
                <p class="title-description"> Listagem de pessoas com pendências  </p>
            </div>
        </div>
    </div>
</div>

@if($pessoas->count())
<div class="card items">
    <ul class="item-list striped"> <!-- lista com itens encontrados -->
        <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
                <div class="item-col fixed item-col-check"> 
                	<label class="item-check" id="select-all-items">
                		<input type="checkbox" class="checkbox"><span></span>
					</label>
				</div>
                <div class="item-col item-col-header item-col-title">
                    <div> <span>Nome</span> </div>
                </div>
          
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Atestado de Saúde</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Atestado de Vacinação</span> </div>
                </div>

                <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
            </div>
        </li>
        @foreach($pessoas as $pessoa)
        <li class="item">
            <div class="item-row">
                <div class="item-col fixed item-col-check"> 
                	<label class="item-check" id="select-all-items">
						<input type="checkbox" class="checkbox" value="">
						<span></span>
					</label> </div>                
                <div class="item-col fixed pull-left item-col-title">
                    <div class="item-heading">Nome</div>
                    <div>
                        
                            <h4 class="item-title">{{$pessoa->nome}} </h4>
                        
                    </div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Atestado</div>
                    <div>
                        @if(in_array($pessoa->id,$atestados_saude))
                        <span class="text-danger">pendente</span>
                        @else
                        <span class="text-success">&nbsp;</span>
                        @endif
                    </div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Vacinação</div>
                    <div>
                        @if(in_array($pessoa->id,$atestados_vacina))
                        <span class="text-danger">pendente</span>
                        @else
                        <span class="text-success">ok</span>
                        @endif
                    </div>
                </div>
            
                <div class="item-col item-col-sales">
                    <div class="item-heading">Atendimento</div>
                    <div>
                       <a href="/secretaria/atender/{{$pessoa->id}}" class="btn btn-primary btn-sm">Atender</a>
                    </div>
                </div> 
            

                
            </div>
        </li>
        @endforeach


    </ul>
</div>

<nav class="text-xs-right">
{!! $pessoas->links()  !!}
</nav>




@else
<h3 class="title-description"> Nenhum atestado encontrado. </p>
@endif

@endsection
@section('scripts')
<script>

function desativarAtestado(id){
    if(confirm("Deseja mesmo arquivar esse atestado?")){
        $(location).attr('href', '{{asset('/pessoa/arquivar-atestado')}}/'+id);
    }

}
</script>



@endsection
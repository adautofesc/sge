@extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Análise de Atestados     <!--                
	                <div class="action dropdown"> 
	                	<button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mais ações...
	                	</button>
	                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
	                    	<a class="dropdown-item" href="#"><i class="fa fa-pencil-square-o icon"></i>Enviar e-mail</a> 
	                    	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirm-modal"><i class="fa fa-close icon"></i>Apagar</a>
	                    </div>
	                </div> -->
                </h3>
                <p class="title-description"> Lista de atestados a serem aprovados </p>
            </div>
        </div>
    </div>
</div>
@if(isset($queryword))
<p class="title-description"> Entrontrei esses atestados: <i>{{$queryword}}</i> </p>
@endif
@if(count($atestados))
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
                    <div> <span>Tipo</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Data de Emissão</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Data de Validade</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Data de envio</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales "> </div>

                <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
            </div>
        </li>
        @foreach($atestados as $atestado)
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
                        
                            <h4 class="item-title">{{$atestado->pessoa}} </h4>
                        
                    </div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Tipo</div>
                    <div> {{$atestado->tipo}}</div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Emissão</div>
                    <div> {{$atestado->emissao}}</div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Validade</div>
                    <div> {{$atestado->validade}}</div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Recebido em</div>
                    <div>
                       {{$atestado->cadastro}}
                    </div>
                </div> 
                <div class="item-col item-col-sales">
                    <div class="item-heading">Analisar</div>
                    <div>
                       <a href="/pessoa/atestado/analisar/{{$atestado->id}}" class="btn btn-primary btn-sm">Analisar</a>
                    </div>
                </div> 
            

                <div class="item-col fixed item-col-actions-dropdown">
                    <div class="item-actions-dropdown">
                        <a class="item-actions-toggle-btn"> <span class="inactive">
				<i class="fa fa-cog"></i>
			</span> <span class="active">
			<i class="fa fa-chevron-circle-right"></i>
			</span> </a>
                        <div class="item-actions-block">
                            <ul class="item-actions-list">
                                @if(file_exists('documentos/atestados/'.$atestado->id.'.pdf'))
                                <li>
                                    <a href="{{'/documentos/atestados/'.$atestado->id.'.pdf'}}" target="_blank"><i class="fa fa-file"></i></a>
                                 </li>
                                @endif
                                <li>
                                    <a class="edit" href="{{asset('pessoa/atestado/editar').'/'.$atestado->id}}" title="Editar Atestado"> <i class="fa fa-pencil-square-o "></i> </a>
                                </li>
                                <li>
                                    <a class="remove" href="#" onclick="desativarAtestado({{$atestado->id}})" title="Arquivar Atestado"> <i class="fa fa-trash "></i> </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        @endforeach


    </ul>
</div>

<nav class="text-xs-right">
{!! $atestados->links()  !!}
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
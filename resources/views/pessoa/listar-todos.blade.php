@extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Pessoas <a href="{{asset('/pessoa/cadastrar')}}" class="btn btn-primary btn-sm rounded-s">Adicionar</a>    <!--                
	                <div class="action dropdown"> 
	                	<button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mais ações...
	                	</button>
	                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
	                    	<a class="dropdown-item" href="#"><i class="fa fa-pencil-square-o icon"></i>Enviar e-mail</a> 
	                    	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirm-modal"><i class="fa fa-close icon"></i>Apagar</a>
	                    </div>
	                </div> -->
                </h3>
                <p class="title-description"> Lista de pessoas que fazem parte ou interagem com a FESC </p>
            </div>
        </div>
    </div>


    <div class="items-search">
        <form class="form-inline" method="POST">
        {{csrf_field()}}
            <div class="input-group"> 
            	<input type="text" class="form-control boxed rounded-s" name="queryword" placeholder="Procurar...">
            	<span class="input-group-btn">
					<button class="btn btn-secondary rounded-s" type="submit">
						<i class="fa fa-search"></i>
					</button>
				</span>
			</div>
        </form>
    </div>
</div>
@if(isset($queryword))
<p class="title-description"> Entrontrei essas pessoas na sua procura por <i>{{$queryword}}</i> </p>
@endif
@if(count($pessoas))
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
                    <div> <span>Data de nascimento</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Contato</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Gênero</span> </div>
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
                        <a href="{{asset('/pessoa/mostrar/'.$pessoa->id)}}" class="">
                            <h4 class="item-title">{{$pessoa->nome}} </h4>
                        </a>
                    </div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Nascimento</div>
                    <div> {{$pessoa->nascimento}} ({{$pessoa->idade}})</div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Contato</div>
                    <div>
                        @if(isset($pessoa->telefone))
                        {{$pessoa->telefone}}
                        @endif
                    </div>
                </div> 
                <div class="item-col item-col-sales">
                    <div class="item-heading">Genero</div>
                    <div>{{$pessoa->genero}}</div>
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
                                <li>
                                    <a class="remove" href="{{asset('secretaria/atender').'/'.$pessoa->id}}" title="Relizar atendimento"> <i class="fa fa-th-large "></i> </a>
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
{!! $pessoas->links()  !!}
</nav>




@else
<h3 class="title-description"> Nenhuma pessoa para exibir. </p>
@endif

@endsection
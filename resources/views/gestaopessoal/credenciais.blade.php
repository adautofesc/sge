@extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-8">
                <h3 class="title"> Credenciais de acesso aos recursos do sistema  </h3>
                <p class="title-description "> Dados de: {{$pessoa->nome}} </p>
            </div>
        </div>

    </div>

    @include('inc.errors')
    <div class="items-search">
        <form class="form-inline" method="POST">
        {{csrf_field()}}
        <button class="btn btn-primary rounded-s" type="submit">
            <i class="fa fa-save"></i> &nbsp;&nbsp;Salvar
        </button>
 
       
    </div>
</div>

@if(isset($dados) && count($dados))
<div class="card items">
    <ul class="item-list striped"> <!-- lista com itens encontrados -->
        <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
                <div class="item-col item-col-header fixed item-col-check"> 
                	<label class="item-check" id="select-all-items">
                		<input type="checkbox" class="checkbox" value="0"><span></span>
					</label>
				</div>
                <div class="item-col item-col-header item-col-title">
                    <div> <span>dado</span> </div>
                </div>
            </div>
        </li>
        @foreach($dados as $dado)
        <li class="item">
            <div class="item-row">
                <div class="item-col item-col-header fixed item-col-check"> 
                	<label class="item-check">
						<input type="checkbox" class="checkbox" {{ $dado->checked }}  name="recurso[{{ $dado->id }}]" value="{{ $dado->id }}">
						<span></span>
					</label> 
                </div>                
                <div class="item-col fixed pull-left item-col-title">
                    <div class="item-heading">dado</div>
                    <div>                        
                        <h4 class="item-title">{{ $dado->desc }} </h4>
                    </div>
                </div>  
            </div>
        </li>
        @endforeach



    </ul>
    <input type="hidden" name="pessoa" value="{{ $pessoa->id }}">
    </form>
</div>
@if(method_exists($dados, 'links'))
<nav class="text-xs-right">
{!! $dados->links()  !!}
</nav>
@endif


@else
<h3 class="title-description"> Nenhum dado encontrado </p>
@endif

@endsection


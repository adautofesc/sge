@extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Disciplinas do curso  </h3>
                <p class="title-description "> {{ $curso['nome'] }} </p>
            </div>
        </div>

    </div>

    @include('inc.errors')
    <div class="items-search">
        <form class="form-inline" method="post">
        {{csrf_field()}}<button class="btn btn-primary rounded-s" type="submit">
                        <i class="fa fa-save"></i> &nbsp;&nbsp;Salvar
                    </button>

       
    </div>
</div>

@if(isset($disciplinas) && count($disciplinas))
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
                    <div> <span>Disciplina</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Programa</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Vagas</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Carga Horária</span> </div>
                </div>
                <div class="item-col item-col-header fixed item-col-actions-dropdown "> 
                <div> <span>Obr</span> </div>
                </div>
            </div>
        </li>
        @foreach($disciplinas as $disciplina)
        <li class="item">
            <div class="item-row">
                <div class="item-col item-col-header fixed item-col-check"> 
                	<label class="item-check">
						<input type="checkbox" class="checkbox" {{ $disciplina->checked }}  name="disciplina[{{ $disciplina->id }}]" value="{{ $disciplina->id }}">
						<span></span>
					</label> 
                </div>                
                <div class="item-col fixed pull-left item-col-title">
                    <div class="item-heading">Disciplina</div>
                    <div>                        
                        <h4 class="item-title">{{ $disciplina->nome }} </h4>
                    </div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Programa</div>
                    <div> {{$disciplina->programa}}</div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Vagas</div>
                    <div>
                        {{$disciplina->vagas}}

                    </div>
                </div> 
                <div class="item-col item-col-sales">
                    <div class="item-heading">Carga horária</div>
                    <div>{{$disciplina->carga}} hs</div>
                </div> 

                <div class="item-col fixed item-col-check"> 
                    <label class="item-check">
                        <input type="checkbox" class="checkbox" {{ $disciplina->obrigatoria }}  name="obrigatoria[{{$disciplina->id }}]"  value="1">
                        <span></span>
                    </label> 
                </div>  
            </div>
        </li>
        @endforeach



    </ul>
    <input type="hidden" name="curso" value="{{ $curso['id_curso'] }}">
    </form>
</div>
@if(method_exists($disciplinas, 'links'))
<nav class="text-xs-right">
{!! $disciplinas->links()  !!}
</nav>
@endif


@else
<h3 class="title-description"> Nenhuma disciplina encontrada </p>
@endif

@endsection
@section('scripts')
<script>
    function apagar(item)
    {
        if(confirm("Tem certeza que deseja apagar essa disciplina?"))
        {
            $(location).attr('href','{{asset("/pedagogico/apagardisciplina")}}/?disciplina='+item);
        }
    }
    function editar (item)
    {
        $(location).attr('href','{{asset("/pedagogico/editardisciplina")}}/'+item);
    }
</script>
@endsection

@extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Requisitos da turma {{$turma->id}}</h3>
                    <p class="title-description">
                        @foreach($turma->dias_semana as $dia)
                            {{ucwords($dia)}}, 
                        @endforeach
                        das {{$turma->hora_inicio}} às {{$turma->hora_termino}} - 
                        Prof(a). {{$turma->professor->nome_simples}}
                        <br>
                        <i class="fa fa-{{$turma->icone_status}} icon"></i> Status: {{$turma->status}} . Início em {{$turma->data_inicio}} Término em {{$turma->data_termino}}
                    </p> 
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

@if(isset($requisitos) && count($requisitos))
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
                    <div> <span>Requisito</span> </div>
                </div>
                
                <div class="item-col item-col-header fixed"> 
                <div> <span>Obrigatório</span> </div>
                </div>
            </div>
        </li>
        @foreach($requisitos as $requisito)
        <li class="item">
            <div class="item-row">
                <div class="item-col item-col-header fixed item-col-check"> 
                	<label class="item-check">
						<input type="checkbox" class="checkbox" {{ $requisito->checked }}  name="requisito[{{ $requisito->id }}]" value="{{ $requisito->id }}">
						<span></span>
					</label> 
                </div>                
                <div class="item-col fixed pull-left item-col-title">
                    <div class="item-heading">requisito</div>
                    <div>                        
                        <h4 class="item-title">{{ $requisito->nome }} </h4>
                    </div>
                </div>
            
                <div class="item-col fixed item-col-check"> 
                    <label class="item-check">
                        <input type="checkbox" class="checkbox" {{ $requisito->obrigatorio }}  name="obrigatorio[]"  value="{{$requisito->id }}">
                        <span></span>
                    </label> 
                </div>  
            </div>
        </li>
        @endforeach



    </ul>
    <input type="hidden" name="turmas" value="{{ $turma->id }}">
    </form>
</div>
@if(method_exists($requisitos, 'links'))
<nav class="text-xs-right">
{!! $requisitos->links()  !!}
</nav>
@endif


@else
<h3 class="title-description"> Nenhuma requisito encontrada </p>
@endif

@endsection
@section('scripts')
<script>
    function apagar(item)
    {
        if(confirm("Tem certeza que deseja apagar essa requisito?"))
        {
            $(location).attr('href','{{asset("/pedagogico/apagarrequisito")}}/?requisito='+item);
        }
    }
    function editar (item)
    {
        $(location).attr('href','{{asset("/pedagogico/editarrequisito")}}/'+item);
    }
</script>
@endsection

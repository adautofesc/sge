@extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Boletos Bancários </h3>
                <p class="title-description"> {{$nome}}</p>
            </div>
        </div>
    </div>

    @include('inc.errors')
</div>
<div class="card items">
    <ul class="item-list striped"> <!-- lista com itens encontrados -->
        <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
                <div class="item-col fixed item-col-check"> 
                	<label class="item-check" id="select-all-items">
                		<input type="checkbox" class="checkbox" value="0"><span></span>
					</label>
				</div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>ID</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Vencimento</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Valor</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Status</span> </div>
                </div>
                <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
            </div>
        </li>
@if(count($boletos) > 0)
        @foreach($boletos as $boleto)
        <li class="item">
            <div class="item-row">
                <div class="item-col fixed item-col-check"> 
                	<label class="item-check" id="select-all-items">
						<input type="checkbox" class="checkbox" name="usuarios" value="{{ $boleto->id }}">
						<span></span>
					</label> </div>                
                <div class="item-col item-col-sales">
                    <div class="item-heading">Numero</div>
                    <div>                        
                        <div>{{$boleto->id}} </div>
                    </div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Vencimento</div>
                    <div> {{$boleto->vencimento}}</div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Valor</div>
                    <div>
                        R$ {{$boleto->valor}}

                    </div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Situação</div>
                    <div>
                      @if($boleto->status == '')
                        ok
                      @else
                        {{$boleto->status}}
                      @endif

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
                                <li>
                                    <a class="remove" onclick="cancelar({{$boleto->id}})" href="#" title="Cancelar"> <i class="fa fa-ban "></i> </a>
                                </li>
                                <li>
                                    <a  class="edit" target="_blank" href="{{asset('financeiro/boletos/imprimir').'/'.$boleto->id}}" title="Imprimir"> <i class="fa fa-print " ></i> </a>
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
{!! $boletos->links()  !!}
</nav>


@else
<h3 class="title-description"> Nenhum lançamento para exibir. </p>
@endif

@endsection
@section('scripts')
<script>

function renovar() 
{
    var selecionados='';
        $("input:checkbox[name=usuarios]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente renovar os selecionados?'))
            $(location).attr('href','{{asset("/admin/alterar")}}/1/'+selecionados);
}
function ativar() 
{
    var selecionados='';
        $("input:checkbox[name=usuarios]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente ativar os logins selecionados?'))
            $(location).attr('href','{{asset("/admin/alterar")}}/2/'+selecionados);
}
function desativar() 
{
    var selecionados='';
        $("input:checkbox[name=usuarios]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente desativar os logins selecionados?'))
            $(location).attr('href','{{asset("/admin/alterar")}}/3/'+selecionados);
}
function cancelar(item)
{
    if(confirm("Deseja mesmo solicitar o cancelamento desse boleto?")){
        $(location).attr('href','{{asset("/financeiro/boletos/cancelar")}}/'+item);
    }
}
</script>
@endsection

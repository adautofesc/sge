@extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Lançamentos Financeiros </h3>
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
                    <div> <span>Curso</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Parcela</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Valor</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Status</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Boleto (situação)</span> </div>
                </div>
                <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
            </div>
        </li>
@if(count($lancamentos) > 0)
        @foreach($lancamentos as $lancamento)
        <li class="item">
            <div class="item-row">
                <div class="item-col fixed item-col-check"> 
                	<label class="item-check" id="select-all-items">
						<input type="checkbox" class="checkbox" name="usuarios" value="{{ $lancamento->id }}">
						<span></span>
					</label> </div>                
                <div class="item-col item-col-sales">
                    <div class="item-heading">Curso</div>
                    <div>                        
                        <div>{{$lancamento->nome_curso}} </div>
                    </div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Parcela</div>
                    <div> {{$lancamento->parcela}}</div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Valor</div>
                    <div>
                        R$ {{$lancamento->valor}}

                    </div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Situação</div>
                    <div>
                      @if($lancamento->status == '')
                        ok
                      @else
                        {{$lancamento->status}}
                      @endif

                    </div>
                </div> 
                <div class="item-col item-col-sales">
                    <div class="item-heading">Boleto</div>
                    <div><a href="{{asset('financeiro/boletos/imprimir').'/'.$lancamento->boleto}}" target="_blank">{{$lancamento->boleto}} ({{$lancamento->boleto_status}})</a></div>
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
                                    <a class="remove" onclick="" href="#" title="Cancelar"> <i class="fa fa-lock "></i> </a>
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
{!! $lancamentos->links()  !!}
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
function alterar(acao,item)
{
    if(confirm("Confirma essa alteração ?")){
        $(location).attr('href','{{asset("/admin/alterar")}}/'+acao+'/'+item);
    }
}
</script>
@endsection

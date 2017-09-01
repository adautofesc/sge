@extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Usuários do sistema                   
	                <div class="action dropdown"> 
	                	<button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Mais ações...
	                	</button>
	                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
	                    	<a class="dropdown-item" href="#" onclick="renovar()"> <i class="fa fa-retweet icon"></i> Renovar </a> 
                            <a class="dropdown-item" href="#" onclick="ativar()"data-toggle="modal" data-target="#confirm-modal"><i class="fa fa-unlock icon"></i> Habilitar</a>
	                    	<a class="dropdown-item" href="#" onclick="desativar()"data-toggle="modal" data-target="#confirm-modal"><i class="fa fa-lock icon"></i> Desabilitar</a>
	                    </div>
	                </div>
                </h3>
                <p class="title-description"> Lista de pessoas que acessam o sistema </p>
            </div>
        </div>
    </div>

    @include('inc.errors')
    <div class="items-search">
        <form class="form-inline" method="get" action="{{asset('/admin/listarusuarios')}}">
        {{csrf_field()}}
            <div class="input-group"> 
            	<input type="text" class="form-control boxed rounded-s" name="buscar" placeholder="Procurar...">
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
@if(isset($dados['usuarios']) && count($dados['usuarios']))
<div class="card items">
    <ul class="item-list striped"> <!-- lista com itens encontrados -->
        <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
                <div class="item-col fixed item-col-check"> 
                	<label class="item-check" id="select-all-items">
                		<input type="checkbox" class="checkbox" value="0"><span></span>
					</label>
				</div>
                <div class="item-col item-col-header item-col-title">
                    <div> <span>Pessoa</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Login</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Validade</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Status</span> </div>
                </div>
                <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
            </div>
        </li>
        @foreach($dados['usuarios'] as $pessoa)
        <li class="item">
            <div class="item-row">
                <div class="item-col fixed item-col-check"> 
                	<label class="item-check" id="select-all-items">
						<input type="checkbox" class="checkbox" name="usuarios" value="{{ $pessoa->id }}">
						<span></span>
					</label> </div>                
                <div class="item-col fixed pull-left item-col-title">
                    <div class="item-heading">Pessoa</div>
                    <div>                        
                        <h4 class="item-title">{{$pessoa->nome}} </h4>
                    </div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Login</div>
                    <div> {{$pessoa->usuario}}</div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Validade</div>
                    <div>
                        {{$pessoa->validade}}

                    </div>
                </div> 
                <div class="item-col item-col-sales">
                    <div class="item-heading">Status</div>
                    <div>{{$pessoa->status}}</div>
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
                                    <a class="remove" onclick=alterar(3,{{$pessoa->id}}) href="#" title="Bloquear"> <i class="fa fa-lock "></i> </a>
                                </li>
                                <li>
                                    <a class="edit"  onclick=alterar(2,{{$pessoa->id}}) href="#" title="Ativar"> <i class="fa fa-unlock"></i> </a>
                                </li>
                                <li>
                                    <a class="edit" href="{{asset('/pessoa/trocarsenha').'/'.$pessoa->pessoa}}" title="Trocar senha"> <i class="fa fa-key "></i> </a>
                                </li>
                                <li>
                                    <a class="edit"  onclick=alterar(1,{{$pessoa->id}}) href="#" title="Renovar"> <i class="fa fa-retweet "></i> </a>
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
{!! $dados['usuarios']->links()  !!}
</nav>


@else
<h3 class="title-description"> Nenhuma pessoa para exibir. </p>
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

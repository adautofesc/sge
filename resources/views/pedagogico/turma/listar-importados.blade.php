@extends('layout.app')
@section('titulo')Alunos importados @endsection
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Lista de pessoas encontradas  
                <!--                
	                <div class="action dropdown"> 
	                	<button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mais ações...
	                	</button>
	                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
	                    	<a class="dropdown-item" href="#"><i class="fa fa-pencil-square-o icon"></i>Enviar e-mail</a> 
	                    	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirm-modal"><i class="fa fa-close icon"></i>Apagar</a>
	                    </div>
	                </div> 
                -->
                </h3>
                <p class="title-description"> Confirme os dados abaixo, desmarque se for necessário algum aluno e grave os dados </p>
            </div>
        </div>
    </div>

</div>
@if(count($pessoas))
<form method="POST" action="./processar-importacao">
    {{csrf_field()}}
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
                    <div> <span>Turma</span> </div>
                </div>
                <div class="item-col item-col-header item-col-title">
                    <div> <span>Nome</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Nascimento</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Contato</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>Gênero</span> </div>
                </div>
                <div class="item-col item-col-header item-col-sales">
                    <div> <span>&nbsp;</span> </div>
                </div>
            </div>
        </li>
        @foreach($pessoas as $pessoa)
        <li class="item">
            <div class="item-row">
                <div class="item-col fixed item-col-check"> 
                	<label class="item-check" id="select-all-items">
						<input type="checkbox" class="checkbox" name="pessoa[{{$pessoa->id}}]" checked>
						<span></span>
					</label> </div>  
                <div class="item-col item-col-sales">
                    <div class="item-heading">Turma</div>
                    <div><input type="number" class="form-control boxed" name="turma[{{$pessoa->id}}]" value="{{$pessoa->turma}}">  </div>
                </div>              
                <div class="item-col fixed item-col-title">
                    <div class="item-heading">Nome</div>
                    <div>             
                            <input type="text" class="form-control boxed" name="nome[{{$pessoa->id}}]" value="{{$pessoa->nome}}"> 
                    </div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Nascimento</div>
                    <div> <input type="text" class="form-control boxed" name="nascimento[{{$pessoa->id}}]" value="{{$pessoa->nascimento}}"> </div>
                </div>
                <div class="item-col item-col-sales">
                    <div class="item-heading">Contato</div>
                    <div>
                        
                        <input type="text" class="form-control boxed" name="telefone[{{$pessoa->id}}]"
                        @if(isset($pessoa->telefone))
                        value="{{$pessoa->telefone}}" 
                        @endif
                        >
                    </div>
                </div> 
                <div class="item-col item-col-sales">
                    <div class="item-heading">Genero</div>
                    <div>
                        <label>
                            <input class="radio" name="genero[{{$pessoa->id}}]" value="M" {{$pessoa->genero=="m"?"checked":""}} type="radio"><span>M</span>
                        </label>
                        <label>
                            <input class="radio" name="genero[{{$pessoa->id}}]" value="F" {{$pessoa->genero=="f"?"checked":""}} type="radio"><span>F</span>
                        </label> 
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
                                    <a class="remove" href="{{asset('secretaria/atender').'/'}}" title="Relizar atendimento"> <i class="fa fa-th-large "></i> </a>
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

<div class="form-group row">
    <div class="col-sm-10 col-sm-offset-2">
        <button type="submit" name="btn" value="1" class="btn btn-primary">Cadastrar</button> 
        <button type="submit" name="btn" value="2" href="disciplinas_show.php?" class="btn btn-secondary">Cadastrar a próxima</button> 
        <!-- 
        <button type="submit" class="btn btn-primary"> Cadastrar</button> 
        -->
    </div>
</div>
</form>



@else
<h3 class="title-description"> Nenhuma pessoa para exibir / Formato de arquivo importado inválido.</p>
@endif

@endsection
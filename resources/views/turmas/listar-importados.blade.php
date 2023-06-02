@extends('layout.app')
@section('titulo')Importação de alunos @endsection
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Lista de pessoas importadas 
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
                <p class="title-description"> Confirme os dados abaixo, desmarque se necessário e/ou modifique os dados. Após isso clique em GRAVAR para efetivar a importação.  </p>
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
                	<label title="{{$pessoa->id}}" class="item-check" id="select-all-items">
						<input type="checkbox" class="checkbox" name="pessoa[{{$pessoa->id}}]" checked >
						<span></span>
                    </label> 
                </div>  
                <div class="item-col">
                    <div class="item-heading">Turma</div>
                    <div><input type="number" class="form-control form-control-sm boxed" name="turma[{{$pessoa->id}}]" value="{{$pessoa->turma}}" maxlength="10" title="Código da turma" required="required">  </div>
                </div>              
                <div class="item-col">
                    <div class="item-heading">Nome</div>
                    <div>             
                            <input type="text" class="form-control form-control-sm boxed" name="nome[{{$pessoa->id}}]" value="{{$pessoa->nome}}" maxlength="250" title="Nome da pessoa" required="required"> 
                    </div>
                </div>
                <div class="item-col">
                    <div class="item-heading">Nascimento</div>
                    <div> 
                        <input type="date" class="form-control form-control-sm boxed" name="nascimento[{{$pessoa->id}}]" value="{{$pessoa->nascimento}}" maxlength="11" title="Nascimento" required="required"> </div>
                    </div>
                <div class="item-col ">
                    <div class="item-heading">Contato</div>
                    <div>
                        
                        <input type="text" class="form-control form-control-sm boxed" name="telefone[{{$pessoa->id}}]" maxlength="12" title="Telefone"
                        @if(isset($pessoa->fone))
                        value="{{$pessoa->fone}}" 
                        @endif
                        >
                    </div>
                </div> 
                @if(isset($pessoa->rg))
            
                    <div class="item-col ">
                        <div class="item-heading">RG</div>
                        <div><input type="text" class="form-control form-control-sm boxed" name="rg[{{$pessoa->id}}]" value="{{$pessoa->rg}}" title="RG" maxlength="14">  </div>
                    </div>  

                
                @endif
                @if(isset($pessoa->cpf))
                
                    <div class="item-col ">
                        <div class="item-heading">CPF</div>
                        <div><input type="text" class="form-control form-control-sm boxed" name="cpf[{{$pessoa->id}}]" value="{{$pessoa->cpf}}" title="CPF" maxlength="14">  </div>
                    </div>  

                
                @endif
                <div class="item-col ">
                    <div class="item-heading">Genero</div>
                    <div>
                        <label title="Gênero Masculino">
                            <input class="radio" name="genero[{{$pessoa->id}}]" value="M" {{$pessoa->genero=="M"||$pessoa->genero=="m"?"checked":""}} type="radio" required><span>M</span>
                        </label>
                        <label title="Gênero Feminino">
                            <input class="radio" name="genero[{{$pessoa->id}}]" value="F" {{$pessoa->genero=="F"||$pessoa->genero=="f"?"checked":""}} type="radio"><span>F</span>
                        </label> 
                    </div>
                </div> 

                
            </div>
            <div class="item-row">
            
            @if(isset($pessoa->endereco))
            
                <div class="item-col ">
                    <div class="item-heading">Endereço</div>
                    <div><input type="text" class="form-control form-control-sm boxed" name="endereco[{{$pessoa->id}}]" value="{{$pessoa->endereco}}" title="Endereço" maxlength="150">  </div>
                </div>  

    
            @endif
            @if(isset($pessoa->numero))
            
                <div class="item-col ">
                    <div class="item-heading">Número</div>
                    <div><input type="text" class="form-control form-control-sm boxed" name="numero[{{$pessoa->id}}]" value="{{$pessoa->numero}}" title="Numero Endereço" max="5">  </div>
                </div>  

    
            @endif
            @if(isset($pessoa->complemento))
            
                <div class="item-col ">
                    <div class="item-heading">Complemento</div>
                    <div><input type="text" class="form-control form-control-sm boxed" name="complemento[{{$pessoa->id}}]" value="{{$pessoa->complemento}}" title="Complemento" maxlength="20">  </div>
                </div>  

    
            @endif
            @if(isset($pessoa->bairro))
            
                <div class="item-col ">
                    <div class="item-heading">Bairro</div>
                    <div><input type="text" class="form-control form-control-sm boxed" name="bairro[{{$pessoa->id}}]" value="{{$pessoa->bairro}}" title="Bairro" maxlength="200">  </div>
                </div>  

    
            @endif
            @if(isset($pessoa->cidade))
            
                <div class="item-col ">
                    <div class="item-heading">Cidade</div>
                    <div><input type="text" class="form-control form-control-sm boxed" name="cidade[{{$pessoa->id}}]" value="{{$pessoa->cidade}}" title="Cidade" maxlength="50">  </div>
                </div>  

    
            @endif
            @if(isset($pessoa->estado))
            
                <div class="item-col ">
                    <div class="item-heading">UF</div>
                    <div><input type="text" class="form-control form-control-sm boxed" name="estado[{{$pessoa->id}}]" value="{{$pessoa->estado}}" title="UF" maxlength="2">  </div>
                </div>  

    
            @endif
            @if(isset($pessoa->cep))
            
                <div class="item-col">
                    <div class="item-heading">CEP</div>
                    <div><input type="text" class="form-control form-control-sm boxed" name="cep[{{$pessoa->id}}]" value="{{$pessoa->cep}}" title="CEP" maxlength="8">  </div>
                </div> 

                <div class="item-col">
                    <div class="item-heading">Email</div>
                    <div><input type="text" class="form-control form-control-sm boxed" name="email[{{$pessoa->id}}]" value="{{$pessoa->email}}" title="Email" maxlength="200">  </div>
                </div> 
    
            @endif
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
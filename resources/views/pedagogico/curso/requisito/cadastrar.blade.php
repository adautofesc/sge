@extends('layout.app')
@section('titulo')Criando novo requisito @endsection
@section('pagina')
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="../">Pedagogico</a></li>
 
</ol>


  <div class="title-block">
        <h3 class="title"> <i class=" fa fa-asterisk "></i> Requisitos </h3>
        <small>Os requisitos são utilizados para ajudar o atendente sobre os itens necessários para que o aluno possa realizar matrículas.</small>
    </div>
    <form name="item" method="POST">
     {{csrf_field()}}
        <div class="card card-block">
        	<div class="subtitle-block">
            <h3 class="subtitle"><i class=" fa fa-plus-circle "></i> Criando novo</h3>
           
        </div>
        @include('inc.errors')
			<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right">
					Nome
				</label>
				<div class="col-sm-8"> 
					<input type="text" class="form-control boxed" name="nome" maxlength="150" placeholder=""> 
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-2 form-control-label text-xs-right">
					&nbsp;
				</label>
				<div class="col-sm-10 col-sm-offset-2">
					<button class="btn btn-primary" type="submit" name="btn" value="1">Salvar</button> 
					<button class="btn btn-primary" type="submit" name="btn" value="2">Salvar e adicionar mais</button> 
					<button type="reset" name="btn"  class="btn btn-primary">Limpar</button>
                	<button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
					
					<!-- 
					<button type="submit" class="btn btn-primary"> Cadastrar</button> 
					-->
				</div>
           </div>
        </div>
    </form>
@endsection
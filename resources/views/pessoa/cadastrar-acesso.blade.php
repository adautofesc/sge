@extends('layout.app')
@section('pagina')
<section>
 <div class="title-block">
    <h3 class="title"> Cadastrar Usuário do sistema </h3>
 </div>
<form name="item">
    <div class="card card-block">
    	@include('inc.errors')
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Usuário
			</label>
			<div class="col-sm-5"> 
				<input type="text" name="username" class="form-control boxed" placeholder="Sem espaço e sem caracteres especiais"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Senha
			</label>
			<div class="col-sm-5"> 
				<input type="password" name="senha" class="form-control boxed" placeholder="Mínimo 6 caracteres"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Repetir senha
			</label>
			<div class="col-sm-5"> 
				<input type="password" name="retsenha" class="form-control boxed" placeholder=""> 
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right">
				
			</label>
			<div class="col-sm-10 col-sm-offset-2">
				<button type="submit" class="btn btn-primary"> Cadastrar</button> 
				

			</div>
       </div>

    </div>
</form>
</section>
@endsection
@extends('layout.app')
@section('pagina')
<section>
 <div class="title-block">
    <h3 class="title"> Trocar senha de usuário </h3>
 </div>
<form name="item">
    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Nova Senha
			</label>
			<div class="col-sm-5"> 
				<input type="password" class="form-control boxed" placeholder="Mínimo 6 caracteres"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Repetir nova senha
			</label>
			<div class="col-sm-5"> 
				<input type="password" class="form-control boxed" placeholder=""> 
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
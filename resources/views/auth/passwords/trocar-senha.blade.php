@extends('layout.app')
@section('pagina')
<section>
 <div class="title-block">
    <h3 class="title"> Alteração de senha própia </h3>
 </div>
<form name="item" method="post">
    <div class="card card-block">
    	@include('inc.errors')
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Senha anterior
			</label>
			<div class="col-sm-5"> 
			<input type="hidden" name="username" value="{{Auth::user()->username}}">
				<input type="password" name="password" class="form-control boxed" placeholder="Sua senha anterior"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Nova senha
			</label>
			<div class="col-sm-5"> 
				<input type="password" name="novasenha" class="form-control boxed" placeholder="Mínimo 6 caracteres"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Repetir nova senha
			</label>
			<div class="col-sm-5"> 
				<input type="password" name="confirmanovasenha" class="form-control boxed" placeholder="A mesma do campo anterior"> 
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right">
				
			</label>
			<div class="col-sm-10 col-sm-offset-2">
				<input type="hidden" name="userid" value="{{Session::get('usuario')}}">
				<button type="submit" class="btn btn-primary">Alterar</button> 
				

			</div>
       </div>

    </div>
    {{csrf_field()}}
</form>
</section>
@endsection
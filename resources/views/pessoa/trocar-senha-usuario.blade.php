@extends('layout.app')
@section('pagina')
<section>
 <div class="title-block">
    <h3 class="title"> Trocar senha de usuário </h3>
 </div>
 <div class="subtitle-block">
    <h3 class="subtitle"> 
    @if(isset($pessoa->nome))
    	{{$pessoa->nome}}   	
    @endif
  
    </h3>
</div>
<form name="item" method="POST">
    <div class="card card-block">
    	@include('inc.errors')
    	@if(isset($pessoa->id))
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Nova Senha*
			</label>
			<div class="col-sm-5"> 
				<input type="password" name="nova_senha" class="form-control boxed" placeholder="Mínimo 6 caracteres"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Repetir nova senha*
			</label>
			<div class="col-sm-5"> 
				<input type="password" name="repetir_senha" class="form-control boxed" placeholder=""> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Validade <i class="fa fa-info-circle" title="Se não for definida, será valida até o fim do ano atual"></i>
			</label>
			<div class="col-sm-5"> 
				<input type="date" name="validade" class="form-control boxed" placeholder="dd/mm/aaaa"> 
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right">
				
			</label>
			<div class="col-sm-10 col-sm-offset-2">
				<input type="hidden" name="pessoa" value="{{$pessoa->id}}">
				{{csrf_field()}}

				<button type="submit" class="btn btn-primary"> Cadastrar</button> 
				@endif
			</div>
       </div>

    </div>
</form>
</section>
@endsection
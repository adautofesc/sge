@extends('layout.app')
@section('pagina')
<section>
 <div class="title-block">
    <h3 class="title"> Cadastrar Usuário do sistema </h3>
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
				Usuário*
			</label>
			<div class="col-sm-5"> 
				<input type="text" name="nome_usuario" class="form-control boxed" placeholder="Sem espaço e sem caracteres especiais" required> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				E-mail
			</label>
			<div class="col-sm-5"> 
				<input type="email" name="email" class="form-control boxed" placeholder="Deve-se utilizar o e-mail institucional" required> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Senha*
			</label>
			<div class="col-sm-5"> 
				<input type="password" name="senha" class="form-control boxed" minlength="8" placeholder="Mínimo 8 caracteres" required> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Repetir senha*
			</label>
			<div class="col-sm-5"> 
				<input type="password" name="repetir_senha" class="form-control boxed" minlength="8" required> 
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
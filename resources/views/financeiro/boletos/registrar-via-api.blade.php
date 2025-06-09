@extends('layout.app')
@section('pagina')
<div class="title-block">
	
    <h3 class="title"> Registrando boleto {{$boleto->id}} via API de Cobrança do BB<span class="sparkline bar" data-type="bar"></span> </h3>
    
</div>
@include('inc.errors')
<form name="item" action="https://mpag.bb.com.br/site/mpag/" method="POST">

	<input type="hidden" name="boletos" value="318737">
	

    <div class="card card-block">
    	<div class="row">
			<div class="col-sm-12">
				<h5>Boleto alterado para "emitido" no sistema.</h5>			
			</div>
			
       </div>
	   <div class="row">
			<div class="col-sm-12">
				<small>Para registrar o boleto, <b>após avançar</b>, clique no ícone:</small>
				<br>
				<img src="https://mpag.bb.com.br/site/mpag/img/imgBoletoBancario.gif" alt="selo BB">		
			</div>
	   </div>
		
   </div>			            
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-2">
				<input type="hidden" name="boleto" value="{{$boleto->id}}">
				<button type="submit" name="btn"  class="btn btn-primary">Avançar</button>
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
				<!-- 
				<button type="submit" class="btn btn-primary"> Cadastrar</button> 
				-->
			</div>
       </div>
    </div>
    {{csrf_field()}}
</form>
        
@endsection

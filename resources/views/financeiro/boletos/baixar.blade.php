@extends('layout.app')
@section('pagina')
<div class="title-block">
	
    <h3 class="title"> Baixa do boleto {{$id}}.<span class="sparkline bar" data-type="bar"></span> </h3>
    
</div>
@include('inc.errors')
<form name="item" action="?" method="POST">
	
    <div class="card card-block">
    	<div class="row">
			<div class="col-sm-12">
				<h5>Para prosseguir com a baixa clique em avançar.</h5>			
			</div>
			
       </div>

		
   </div>			            
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-2">
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

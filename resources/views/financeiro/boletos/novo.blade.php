@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Novo Boleto <span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="item" method="POST">
	<p>Os valores dos boletos serão obtidos exclusivamente através da soma das parcelas das matrículas. </p>
    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Vencimento*
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
					<input type="date" class="form-control boxed" name="vencimento" value="" required> 
				</div>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">Matrículas ativas</label>
            <div class="col-sm-10"> 
            	@foreach($matriculas as $matricula)
				<div>
					<label>
					<input class="checkbox" id="{{$matricula->id}}" type="checkbox" name="matriculas[]" onchange="atualizaValor({{$matricula->id}},{{$matricula->valor->valor/$matricula->valor->parcelas}})" value="{{$matricula->id}}">
					<span>{{$matricula->id}} <small>({{$matricula->status}})</small>  - {{$matricula->getNomeCurso().' R$ '.number_format($matricula->valor->valor/$matricula->valor->parcelas,2,',','.')}} </span>
					</label>
				</div>
				@endforeach
        	</div>
                
        </div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Valor
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					<span class="input-group-addon">R$ </span> 
					<input type="text" class="form-control boxed" name="valor" id="valor" value="" readonly="true" required> 
				</div>
			</div>
		</div>

		            
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-2">
				<input type="hidden" name="pessoa" value="{{$pessoa}}">
				<button type="submit" name="btn"  class="btn btn-primary">Salvar</button>
                <button type="reset" name="btn"  class="btn btn-primary">Restaurar</button>
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
@section('scripts')
<script type="text/javascript">
var valor_global =0;

function atualizaValor(item,valor_parcela){
	if($('#'+item).is(":checked")){

		valor_global = valor_global + valor_parcela;
		
	}
	else{
		
		valor_global = valor_global - valor_parcela;
	}

	$('#valor').val(valor_global.toFixed(2));
		
	

}

</script>


@endsection
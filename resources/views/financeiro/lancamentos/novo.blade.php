@extends('layout.app')
@section('titulo')Gerador de parcelas. @endsection
@section('pagina')
<div class="title-block">
    <h3 class="title"> Gerador de parcelas<span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="item" method="POST">
	
    <div class="card card-block">
    	
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">Matricula</label>
            <div class="col-sm-10"> 
            	@foreach($matriculas as $matricula)
				<div>
					<label>
					<input class="checkbox" id="{{$matricula->id}}" type="checkbox" name="matriculas[]"  value="{{$matricula->id}}">
					<span>{{$matricula->id.' - '.$matricula->getNomeCurso()}}</span>
					</label>
				</div>
				@endforeach
        	</div>
                
        </div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Parcela
			</label>
			<div class="col-sm-4"> 
				<select class="c-select form-control boxed" name="parcela" required>
					<option value="0">Selecione o mês</option>
					<option value="1" >Fevereiro</option>
					<option value="2" >Março</option>
					<option value="3" >Abril</option>
					<option value="4" >Maio</option>
					<option value="5" >Junho</option>
					<option value="6" >Julho</option>
					<option value="7" >Agosto</option>
					<option value="8" >Setembro</option>
					<option value="9" >Outubro</option>
					<option value="10" >Novembro</option>
					<option value="11" >Dezembro</option>

				</select> 
			</div>
		
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				
			</label>
			<div class="col-sm-3"> 
				
				<div>
					<label>
						<input class="checkbox" type="checkbox" name="retroativas"  value="1">
						<span>Gerar retroativas</span>
					</label>
				</div>
			</div>
		</div>	            
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right">
				
			</label>
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
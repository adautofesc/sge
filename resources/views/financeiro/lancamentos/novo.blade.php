@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Novo(s) Lançamento(s) <span class="sparkline bar" data-type="bar"></span> </h3>
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
			<div class="col-sm-3"> 
				<div class="input-group">
 
					<input type="number" class="form-control boxed" name="valor" id="valor" value="" required> 
					
				</div>
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
				Referencia
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					<input type="text" class="form-control boxed" name="valor" id="valor" value="Parcela " required> 
					
				</div>
			
			</div>
		</div>

		            
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-2">
				<input type="hidden" name="pessoa" value="{{$pessoa}}">
				<button type="submit" name="btn" value="1" class="btn btn-primary">Salvar</button> 
				<button type="reset" name="btn" value="2" href="#" class="btn btn-secondary">Cancelar</button> 
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
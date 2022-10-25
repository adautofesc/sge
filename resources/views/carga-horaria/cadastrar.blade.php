@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Nova Carga horária <span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="item" method="POST">
    <div class="card card-block">
		<div>
			<label class="alert text-warning"><i class="fa fa-warning"></i> Atenção: Esse cadastro pode impactar diversos relatórios.</label>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 text-xs-right">
				Nº Horas
			</label>
			<div class="col-sm-3"> 
				<input type="number" class="form-control boxed" name="horas" placeholder="Horas" required> 

				
			</div>
			
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 text-xs-right">
				Início
			</label>
			<div class="col-sm-3">                         
				<input type="date" class="form-control boxed" name="inicio" placeholder="Início" required> 
			</div>
		</div>

		<div class="form-group row"> 
		
			<label class="col-sm-2 text-xs-right">
				Fim
			</label>
			<div class="col-sm-3"> 
				
					<input type="date" class="form-control boxed" name="termino" placeholder="Termino" > 
				
			</div>
			
		</div>
		<div class="form-group row"> 
		
			<label class="col-sm-2 text-xs-right">
				Status
			</label>
			<div class="col-sm-3"> 
				<select name="status" class="form-control form-control-sm">
					<option>ativa</option>
					<option>expirada</option>
					<option>prevista</option>
					
				</select>
					
				
			</div>
			
		</div>
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right">
				&nbsp;
			</label>
			<div class="col-sm-10 col-sm-offset-2">
				<input type="hidden" name="pessoa" value="{{$pessoa}}">
				<button type="submit" class="btn btn-primary" >Salvar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>	
			</div>

    	</div>
    {{csrf_field()}}
	</div>
</form>  
@endsection
@section('scripts')
<script>

</script>

@endsection
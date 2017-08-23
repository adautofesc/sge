@extends('layout.app')
@section('pagina')

<div class="title-block">
	<h3 class="title"> Atendimento ao aluno<span class="sparkline bar" data-type="bar"></span> </h3>
</div>
<form name="item">
    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Nome e/ou CPF
			</label>
			<div class="col-sm-8"> 
				<input type="search" list="nomes" class="form-control boxed" placeholder=""> 
				<datalist id="nomes" style="display:hidden;">
					<option value="324000000000 Adauto Junior 10/11/1984 id:0000014">
					<option value="326500000000 Fulano 06/07/1924 id:0000015">
					<option value="3232320000xx Beltrano 20/02/1972 id:0000016">
					<option value="066521200010 Ciclano 03/08/1945 id:0000017">
					
				</datalist>
				<input type="hidden" name="id_pessoa">
			</div>
		</div>
		
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				
			</label>
			<div class="col-sm-8"> 
				<a href="pessoas_aluno_atendimento.php" class="btn btn-primary">Procurar</a> 
				<a href="{{ asset('/pessoa/cadastrar')}}" class="btn btn-secondary">Cadastrar Aluno</a> 
			
				<!-- 
				<button type="submit" class="btn btn-primary"> Cadastrar</button> 
				-->
			</div>
		</div>
		
    </div>
</form>
@endsection
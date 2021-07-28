@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Novo Plano de Ensino <span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="item" method="POST">
    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Programa 
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed" name="programa" required>
					<option >Selecione um programa</option>
					@if(isset($programas))
					@foreach($programas as $programa)
					<option value="{{$programa->id}}">{{$programa->nome}}</option>
					@endforeach
					@endif
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Período
			</label>
			<div class="col-sm-3"> 
				<select class="c-select form-control boxed" name="professor" required>
					@if(isset($semestres))
					
					@foreach($semestres as $semestre)
						<option value="{{$semestre->semestre.$semestre->ano}}">{{$semestre->semestre.'º Sem. '.$semestre->ano}}</option>
					@endforeach
					@endif
				</select> 
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Carga Horária
			</label>
			<div class="col-sm-1"> 
				<div class="input-group">
					 
					<input type="number" class="form-control boxed" name="carga" placeholder="" required> 
				</div>
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Professor
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed" name="professor" required readonly>
					<option>Selecione um professor</option>
					@if(isset($professores))
					@foreach($professores as $professor)
					<option value="{{$professor->id}}">{{$professor->nome}}</option>
					@endforeach
					@endif
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Curso/Atividade
			</label>
			<div class="col-sm-6"> 
				<input type="text" class="form-control boxed" id="fcurso" name="curso" placeholder="Digite o nome do curso" required> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Habilidades gerais
			</label>
			<div class="col-sm-6"> 
				<textarea rows="3" class="form-control" name="habilidades_gerais" maxlenght="300"></textarea>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Habilidades específicas
			</label>
			<div class="col-sm-6"> 
				<textarea rows="3" class="form-control" name="habilidades_especificas" maxlenght="300"></textarea>
			</div>
		</div>
		
		

            
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-2">
				<button type="submit" name="btn" value="1" class="btn btn-primary">Cadastrar</button> 
				<button type="submit" name="btn" value="2" href="disciplinas_show.php?" class="btn btn-secondary">Cadastrar a próxima</button> 
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



</script>


@endsection
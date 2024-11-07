@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Nova ficha técnica <span class="sparkline bar" data-type="bar"></span> </h3>
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
				Professor
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed" name="professor" required>
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
				<input type="text" class="form-control boxed" id="curso" name="curso" placeholder="Digite o nome do curso" required> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Objetivo
			</label>
			<div class="col-sm-6"> 
				<textarea rows="5" class="form-control" name="objetivos" maxlenght="500"></textarea>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Conteúdo Programático
			</label>
			<div class="col-sm-6"> 
				<textarea rows="10" class="form-control" name="conteudo" maxlenght="750"></textarea>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Requisitos
			</label>
			<div class="col-sm-6"> 
				<textarea rows="2" class="form-control" name="requisitos" maxlenght="500"></textarea>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Recursos necessários
			</label>
			<div class="col-sm-6"> 
				<textarea rows="2" class="form-control" name="recorrencia" maxlenght="500"></textarea>
			</div>
		</div>
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Dia(s) semana.
			</label>
			<div class="col-sm-6"> 
				
				<label><input class="checkbox" name="dias[]" value="seg" type="checkbox"><span>Seg</span></label>
				<label><input class="checkbox" name="dias[]" value="ter" type="checkbox"><span>Ter</span></label>
				<label><input class="checkbox" name="dias[]" value="qua" type="checkbox"><span>Qua</span></label>
				<label><input class="checkbox" name="dias[]" value="qui" type="checkbox"><span>Qui</span></label>
				<label><input class="checkbox" name="dias[]" value="sex" type="checkbox"><span>Sex</span></label>
				<label><input class="checkbox" name="dias[]" value="sab" type="checkbox"><span>Sab</span></label>
			</div>
		</div>
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Data Início
			</label>
			<div class="col-md-2">
				<input type="date" class="form-control" name="data_inicio" required>
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Data Termino
			</label>
			<div class="col-md-2">
				<input type="date" class="form-control" name="data_termino" required>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Hora Início
			</label>
			<div class="col-md-2">
				<input type="time" class="form-control" name="hora_inicio" >
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Hora Termino
			</label>
			<div class="col-md-2">
				<input type="time" class="form-control" name="hora_termino" >
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Idade Maxima
			</label>
			<div class="col-md-2">
				<input type="number" class="form-control" name="idade_max" max="200" min="0" value="0">
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Idade Minima
			</label>
			<div class="col-md-2">
				<input type="number" class="form-control" name="idade_min" max="99" min="0" value="0">
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Lotação Maxima
			</label>
			<div class="col-md-2">
				<input type="number" class="form-control" name="lotacao_max" max="1000" min="0" value="0">
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Lotação Minima
			</label>
			<div class="col-md-2">
				<input type="number" class="form-control" name="lotacao_min" max="99" min="0" value="0">
			</div>
		</div>
		

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Carga
			</label>
			<div class="col-md-2">
				<input type="number" class="form-control" name="carga" max="999" min="0" value="0">
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Periodicidade(t)
			</label>
			<div class="col-md-2">
				<select class="form-control" name="periodicidade" >
					
					<option>mensal</option>
					<option>bimestral</option>
					<option>trimestral</option>
					<option>semestral</option>
					<option selected="selected">anual</option>
					
				</select>
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Local
			</label>
			<div class="col-sm-2"> 
				<select class="c-select form-control boxed" name="local" onchange="carregarSalas(this.value)" required >
					<option>Selecione ums unidade de atendimento</option>
					@if(isset($unidades))
					@foreach($unidades as $unidade)
					<option value="{{$unidade->id}}">{{$unidade->nome}}</option>
					@endforeach
					@endif
				</select> 
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Sala
			</label>
			<div class="col-sm-2"> 
				<select class="c-select form-control boxed" name="sala" id="select_sala" required >
					<option>Selecione um local antes.</option>
				
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Valor
			</label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="valor" maxlength="6" value="0">
			</div>
			
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Mais informações
			</label>
			<div class="col-sm-6"> 
				<textarea rows="2" class="form-control" name="obs" maxlenght="500"></textarea>
			</div>
		</div>
		
		
		

            
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right">
				&nbsp;
			</label>
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
<script>
	function carregarSalas(local){
	var salas;
	$("#select_sala").html('<option>Sem salas cadastradas</option>');
	$.get("{{asset('services/salas-api/')}}"+"/"+local)
 				.done(function(data) 
 				{
 					$.each(data, function(key, val){
						console.log(val.nome);
 						salas+='<option value="'+val.id+'">'+val.nome+'</option>';
 					});
 					//console.log(namelist);
 					$("#select_sala").html(salas);
				 });
				 
}
</script>

@endsection
@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Edição da ficha técnica {{$ficha->id}}<span class="sparkline bar" data-type="bar"></span> </h3>
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
					<option value="{{$programa->id}}" {{$programa->id==$ficha->programa?'selected':''}}>{{$programa->nome}}</option>
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
					<option value="{{$professor->id}}" {{$professor->id==$ficha->docente?'selected':''}}>{{$professor->nome}}</option>
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
				<input type="text" class="form-control boxed" id="curso" name="curso" placeholder="Digite o nome do curso"  value="{{$ficha->curso}}"required> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Objetivo
			</label>
			<div class="col-sm-6"> 
				<textarea rows="3" class="form-control" name="objetivos" maxlenght="500">{{$ficha->objetivo}}</textarea>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Conteúdo Programático
			</label>
			<div class="col-sm-6"> 
				<textarea rows="3" class="form-control" name="conteudo" maxlenght="500">{{$ficha->conteudo}}</textarea>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Requisitos
			</label>
			<div class="col-sm-6"> 
				<textarea rows="3" class="form-control" name="requisitos" maxlenght="500">{{$ficha->requisitos}}</textarea>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Dia(s) semana.
			</label>
			<div class="col-sm-6"> 
				
				<label><input class="checkbox" name="dias[]" value="seg" type="checkbox" {{str_contains($ficha->dias_semana,'seg')?'checked':''}}><span>Seg</span></label>
				<label><input class="checkbox" name="dias[]" value="ter" type="checkbox" {{str_contains($ficha->dias_semana,'ter')?'checked':''}}><span>Ter</span></label>
				<label><input class="checkbox" name="dias[]" value="qua" type="checkbox" {{str_contains($ficha->dias_semana,'qua')?'checked':''}}><span>Qua</span></label>
				<label><input class="checkbox" name="dias[]" value="qui" type="checkbox" {{str_contains($ficha->dias_semana,'qui')?'checked':''}}><span>Qui</span></label>
				<label><input class="checkbox" name="dias[]" value="sex" type="checkbox" {{str_contains($ficha->dias_semana,'sex')?'checked':''}}><span>Sex</span></label>
				<label><input class="checkbox" name="dias[]" value="sab" type="checkbox" {{str_contains($ficha->dias_semana,'sab')?'checked':''}}><span>Sab</span></label>
			</div>
		</div>
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Data Início
			</label>
			<div class="col-md-2">
				<input type="date" class="form-control" name="data_inicio" value="{{$ficha->data_inicio->format('Y-m-d')}}" >
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Data Termino
			</label>
			<div class="col-md-2">
				<input type="date" class="form-control" name="data_termino" value="{{$ficha->data_termino->format('Y-m-d')}}" >
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Hora Início
			</label>
			<div class="col-md-2">
				<input type="time" class="form-control" name="hora_inicio" value="{{$ficha->hora_inicio}}" >
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Hora Termino
			</label>
			<div class="col-md-2">
				<input type="time" class="form-control" name="hora_termino" value="{{$ficha->hora_termino}}" >
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Idade Maxima
			</label>
			<div class="col-md-2">
				<input type="number" class="form-control" name="idade_max" max="200" min="0"  value="{{$ficha->idade_maxima}}">
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Idade Minima
			</label>
			<div class="col-md-2">
				<input type="number" class="form-control" name="idade_min" max="99" min="0"  value="{{$ficha->idade_minima}}">
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Lotação Maxima
			</label>
			<div class="col-md-2">
				<input type="number" class="form-control" name="lotacao_max" max="1000" min="0"  value="{{$ficha->lotacao_maxima}}">
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Lotação Minima
			</label>
			<div class="col-md-2">
				<input type="number" class="form-control" name="lotacao_min" max="99" min="0"  value="{{$ficha->lotacao_minima}}">
			</div>
		</div>
		

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Carga
			</label>
			<div class="col-md-2">
				<input type="number" class="form-control" name="carga" max="999" min="0" value="{{$ficha->carga}}">
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Periodicidade(t)
			</label>
			<div class="col-md-2">
				<select class="form-control" name="periodicidade" >
					
					<option {{$ficha->periodicidade=='mensal'?'selected':''}}>mensal</option>
					<option {{$ficha->periodicidade=='bimestral'?'selected':''}}>bimestral</option>
					<option {{$ficha->periodicidade=='trimestral'?'selected':''}}>trimestral</option>
					<option {{$ficha->periodicidade=='semestral'?'selected':''}}>semestral</option>
					<option {{$ficha->periodicidade=='anual'?'selected':''}}>anual</option>
					
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
					<option value="{{$unidade->id}}" {{$unidade->id==$ficha->local?'selected':''}}>{{$unidade->nome}}</option>
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
					@if(isset($salas))
					@foreach($salas as $sala)
					<option value="{{$sala->id}}" {{$sala->id==$ficha->sala?'selected':''}}>{{$sala->nome}}</option>
					@endforeach
					@endif
				
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Valor
			</label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="valor" maxlength="6"  value="{{$ficha->getValor()}}">
			</div>
			
		</div>
		
		
		

            
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right">
				&nbsp;
			</label>
			<div class="col-sm-10 col-sm-offset-2">
				<button type="submit" name="btn" value="1" class="btn btn-primary">Gravar</button> 
				<button type="reset" name="btn" class="btn btn-secondary">Resetar</button> 
				<a class="btn btn-secondary" href="/fichas/">Cancelar</a>
				<!-- 
				<button type="submit" class="btn btn-primary"> Cadastrar</button> 
				-->
			</div>
       </div>
    </div>
    {{csrf_field()}}
	<input type="hidden" name="id" value="{{$ficha->id}}">
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
@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Criar nova turma <span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="item">
    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Programa 
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed" name="programa">
					<option selected>Selecione um programa</option>
					@if(isset($dados['programas']))
					@foreach($dados['programas'] as $programa)
					<option value="{{$programa->id}}">{{$programa->nome}}</option>
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
				<select class="c-select form-control boxed" name="curso">
					<option selected>Selecione um programa antes</option>

				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Professor
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed">
					<option selected>Selecione um professor</option>
					@if(isset($dados['professores']))
					@foreach($dados['professores'] as $professor)
					<option value="{{$professor->id}}">{{$professor->nome}}</option>
					@endforeach
					@endif
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Unidade
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed" name="unidade">
					<option selected>Selecione ums unidade de atendimento</option>
					@if(isset($dados['unidades']))
					@foreach($dados['unidades'] as $unidade)
					<option value="{{$unidade->unidade}}">{{$unidade->unidade}}</option>
					@endforeach
					@endif
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Sala/Local
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed" name="sala">
					<option selected>Selecione a sala/local</option>
		
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Dia(s) semana.
			</label>
			<div class="col-sm-10"> 
				<label><input class="checkbox" disabled="disabled" type="checkbox"><span>Dom</span></label>
				<label><input class="checkbox" type="checkbox"><span>Seg</span></label>
				<label><input class="checkbox" type="checkbox"><span>Ter</span></label>
				<label><input class="checkbox" type="checkbox"><span>Qua</span></label>
				<label><input class="checkbox" type="checkbox"><span>Qui</span></label>
				<label><input class="checkbox" type="checkbox"><span>Sex</span></label>
				<label><input class="checkbox" type="checkbox"><span>Sab</span></label>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Data de início
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
					<input type="date" class="form-control boxed" placeholder="dd/mm/aaaa"> 
				</div>
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Data do fim
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
					<input type="date" class="form-control boxed" placeholder="dd/mm/aaaa"> 
				</div>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Horário de início
			</label>
			<div class="col-sm-2"> 
				<input type="time" class="form-control boxed" placeholder="00:00"> 
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Horário Termino
			</label>
			<div class="col-sm-2"> 
				<input type="time" class="form-control boxed" placeholder="00:00"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Nº de vagas
			</label>
			<div class="col-sm-4"> 
				<input type="text" class="form-control boxed" placeholder="Recomendado: 30 vagas"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Preço
			</label>
			<div class="col-sm-4"> 
				<div class="input-group">
					<span class="input-group-addon">R$ </span> 
					<input type="number" class="form-control boxed" placeholder=""> 
				</div>
			</div>
			
		</div>
		
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">Opções (ao selecionar alguma, zera o preço)</label>
            <div class="col-sm-10"> 
				<div>
					<label>
					<input class="checkbox" type="checkbox">
					<span>Preço por carga semanal (número de atividades na semana)</span>
					</label>
				</div>
				<div>
					<label>
					<input class="checkbox" type="checkbox">
					<span>Turma de Parceria</span>
					</label>
				</div>
				<div>
					<label>
					<input class="checkbox" type="checkbox">
					<span>Turma EMG</span>
					</label>
				</div>
				<div>
					<label>
					<input class="checkbox" type="checkbox">
					<span>Turma Eventual</span>
					</label>
				</div>
        	</div>
                
        </div>
            
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-2">
				<a href="disciplinas_show.php?" class="btn btn-primary">Cadastrar</a> 
				<a href="disciplinas_show.php?" class="btn btn-secondary">Cadastrar a próxima</a> 
				<!-- 
				<button type="submit" class="btn btn-primary"> Cadastrar</button> 
				-->
			</div>
       </div>
    </div>
</form>
        
@endsection
@section('scripts')
<script type="text/javascript">
$("select[name=programa]").change( function(){
	var cursos='<option selected>Selecione o curso/atividade</option>';
	$("select[name=curso]").html('').show();
	$.get("{{asset('pedagogico/cursos/listarporprogramajs/')}}"+"/"+$("select[name=programa]").val())
 				.done(function(data) 
 				{
 					$.each(data, function(key, val){
 						cursos+='<option value="'+val.id+'">'+val.nome+'</option>';
 					});
 					//console.log(namelist);
 					$("select[name=curso]").html(cursos).show();
 				})

	});
$("select[name=unidade]").change( function(){
	var salas='<option selected>Selecione a Sala</option>';
	$("select[name=sala]").html('');
	$.get("{{asset('administrativo/salasdaunidade/')}}"+"/"+$("select[name=unidade]").val())
 				.done(function(data) 
 				{
 					$.each(data, function(key, val){
 						salas+='<option value="'+val.id+'">'+val.sala+'</option>';
 					});
 					//console.log(namelist);
 					$("select[name=sala]").html(salas).show();
 				})
	

	
	});

	


</script>


@endsection
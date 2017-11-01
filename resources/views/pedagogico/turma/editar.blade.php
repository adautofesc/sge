@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Edição dos dados da turma {{$turma->id}} <span class="sparkline bar" data-type="bar"></span> </h3>
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
					@if(isset($dados['programas']))
					@foreach($dados['programas'] as $programa)
					<option value="{{$programa->id}}" {{$programa->id==$turma->programa->id?'selected':''}}>{{$programa->nome}}</option>
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
				<select class="c-select form-control boxed" name="curso" required>
					<option >Selecione um programa antes</option>
					@if(isset($turma->curso))
					<option value="{{$turma->curso->id}}" selected>{{$turma->curso->nome}}</option>
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
					@if(isset($dados['professores']))
					@foreach($dados['professores'] as $professor)
					<option value="{{$professor->id}}" {{$professor->id==$turma->professor->id?'selected':''}}>{{$professor->nome}}</option>
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
				<select class="c-select form-control boxed" name="unidade" required>
					<option>Selecione ums unidade de atendimento</option>
					@if(isset($dados['unidades']))
					@foreach($dados['unidades'] as $unidade)
					<option value="{{$unidade->unidade}}" {{$unidade->unidade==$turma->local->unidade?'selected':''}}>{{$unidade->unidade}}</option>
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
				<select class="c-select form-control boxed" name="local" required>
					<option>Selecione a sala/local</option>
					@if(isset($turma->local))
					<option value="{{$turma->local->id}}" selected>{{$turma->local->sala}}</option>
					@endif
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Dia(s) semana.
			</label>
			<div class="col-sm-10"> 
				<label><input class="checkbox" name="dias[]" value="dom" type="checkbox" {{in_array('dom',$turma->dias_semana)?'checked':''}}><span>Dom</span></label>
				<label><input class="checkbox" name="dias[]" value="seg" type="checkbox" {{in_array('seg',$turma->dias_semana)?'checked':''}}><span>Seg</span></label>
				<label><input class="checkbox" name="dias[]" value="ter" type="checkbox" {{in_array('ter',$turma->dias_semana)?'checked':''}}><span>Ter</span></label>
				<label><input class="checkbox" name="dias[]" value="qua" type="checkbox" {{in_array('qua',$turma->dias_semana)?'checked':''}}><span>Qua</span></label>
				<label><input class="checkbox" name="dias[]" value="qui" type="checkbox" {{in_array('qui',$turma->dias_semana)?'checked':''}}><span>Qui</span></label>
				<label><input class="checkbox" name="dias[]" value="sex" type="checkbox" {{in_array('sex',$turma->dias_semana)?'checked':''}}><span>Sex</span></label>
				<label><input class="checkbox" name="dias[]" value="sab" type="checkbox" {{in_array('sab',$turma->dias_semana)?'checked':''}}><span>Sab</span></label>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Data de início
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
					<input type="date" class="form-control boxed" name="dt_inicio" value="{{$turma->data_iniciov}}" placeholder="dd/mm/aaaa" required> 
				</div>
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Data do termino
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
					<input type="date" class="form-control boxed" name="dt_termino" value="{{$turma->data_terminov}}" placeholder="dd/mm/aaaa" required> 
				</div>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Horário de início
			</label>
			<div class="col-sm-2"> 
				<input type="time" class="form-control boxed" name="hr_inicio" value="{{$turma->hora_inicio}}"  placeholder="00:00" required > 
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Horário Termino
			</label>
			<div class="col-sm-2"> 
				<input type="time" class="form-control boxed" name="hr_termino" value="{{$turma->hora_termino}}"  placeholder="00:00" required> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Nº de vagas
			</label>
			<div class="col-sm-4"> 
				<input type="number" class="form-control boxed" name="vagas" value="{{$turma->vagas}}"  placeholder="Recomendado: 30 vagas"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Valor
			</label>
			<div class="col-sm-4"> 
				<div class="input-group">
					<span class="input-group-addon">R$ </span> 
					<input type="text" class="form-control boxed" name="valor" value="{{$turma->valor}}"  placeholder=""> 
				</div>
			</div>
			
		</div>
		
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">Opções</label>
            <div class="col-sm-10"> 
				<div>
					<label>
					<input class="checkbox" name="atributo[]" value="P" type="checkbox" {{in_array('P',$turma->atributos)?'checked':''}}>
					<span>Turma paga pela parceria</span>
					</label>
				</div>
				<div>
					<label>
					<input class="checkbox" name="atributo[]" value="D" type="checkbox" {{in_array('D',$turma->atributos)?'checked':''}} >
					<span>Turma com desconto pela Parceria</span>
					</label>
				</div>
				<div>
					<label>
					<input class="checkbox" name="atributo[]" value="M" type="checkbox" {{in_array('M',$turma->atributos)?'checked':''}} >
					<span>Turma EMG</span>
					</label>
				</div>
				<div>
					<label>
					<input class="checkbox" name="atributo[]" value="E" type="checkbox" {{in_array('E',$turma->atributos)?'checked':''}} >
					<span>Turma Eventual</span>
					</label>
				</div>
        	</div>
                
        </div>
            
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-2">
				<button type="submit" name="btn" value="1" class="btn btn-primary">Salvar</button> 
				<button type="button" onclick="history.back(1);" class="btn btn-secondary">Cancelar</button> 
				<!-- 
				<button type="submit" class="btn btn-primary"> Cadastrar</button> 
				-->
			</div>
       </div>
    </div>
    <input type="hidden" name="turmaid" value="{{$turma->id}}" >
    {{csrf_field()}}
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
	$("select[name=local]").html('');
	$.get("{{asset('administrativo/salasdaunidade/')}}"+"/"+$("select[name=unidade]").val())
 				.done(function(data) 
 				{
 					$.each(data, function(key, val){
 						salas+='<option value="'+val.id+'">'+val.sala+'</option>';
 					});
 					//console.log(namelist);
 					$("select[name=local]").html(salas).show();
 				})
	

	
	});

	
</script>


@endsection
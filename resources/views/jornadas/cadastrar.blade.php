@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Nova Jornada de trabalho <span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="item" method="POST">
    <div class="card card-block">
		<div>
			<label class="alert text-warning"><i class="fa fa-warning"></i> Atenção: Esse cadastro não verifica a ocupação das salas.</label>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 text-xs-right">
				Atividade
			</label>
			<div class="col-sm-3"> 
				<select class="c-select form-control boxed" name="tipo" required>
					<option>Selecione uma opção</option>
					<option value="Aula" title="Utilizado para turmas posteriores ou mudanças de horários">Aula - turma a definir</option>
					<option value="Coordenação" >Coordenação</option>
					<option value="HTP" >HTP</option>
					<option value="Intervalo entre turmas" >Intervalo entre turmas</option>
					<option value="Translado">Translado</option>
					<option value="Projeto">Projeto</option>
					<option value="Uso Livre">Uso Livre</option>
					<option value="Home Office">Home Office</option>
				   
		
				</select> 
			</div>
			<label class="col-sm-1 text-xs-right">
				Estado
			</label>
			<div class="col-sm-3"> 
				<select class="c-select form-control boxed" name="status" required>
					<option value="ativa">Ativa</option>
					<option value="encerrada" >Encerrada</option>
					<option value="solicitada" >Solicitada</option>
					<option value="negada" >Negada</option>
				</select> 
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 text-xs-right">
				Início
			</label>
			<div class="col-sm-3">                         
				<input type="date" class="form-control boxed" name="dt_inicio" placeholder="Início" required> 
			</div>
		
			<label class="col-sm-1 text-xs-right">
				Fim
			</label>
			<div class="col-sm-3"> 
				
					<input type="date" class="form-control boxed" name="dt_termino" placeholder="Termino" onfocusout="verificaTermino(this);"> 
				
			</div>
			
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Local
			</label>
			<div class="col-sm-3 "> 
				<select class="c-select form-control boxed" name="unidade" onchange="carregarSalas(this.value)" required >
					<option>Selecione ums unidade de atendimento</option>
					<option value="84">FESC 1</option>
					<option value="85">FESC 2</option>
					<option value="86">FESC 3</option>
					<option value="118">FESC VIRTUAL</option>
					@if($locais)
					@foreach($locais as $unidade)
					<option value="{{$unidade->id}}">{{$unidade->nome}}</option>
					@endforeach
					@endif
				</select> 
			</div>
			<label class="col-sm-1 form-control-label text-xs-right">
				Sala
			</label>
			<div class="col-sm-3"> 
				<select class="c-select form-control boxed" name="sala" id="select_sala" required >
					<option>Selecione um local antes.</option>
				
				</select> 
			</div>
		</div>

		
		

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Horário de início
			</label>
			<div class="col-sm-2"> 
				<input type="time" class="form-control boxed" name="hr_inicio" placeholder="00:00" required > 
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Horário Termino
			</label>
			<div class="col-sm-2"> 
				<input type="time" class="form-control boxed" name="hr_termino" placeholder="00:00" required> 
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Dia(s) semana.
			</label>
			<div class="col-sm-10"> 
				
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
				&nbsp;
			</label>
			<div class="col-sm-10 col-sm-offset-2">
				<input type="hidden" name="pessoa" value="{{$docente}}">
				<button type="submit" class="btn btn-primary" >Salvar</button>
				<button type="submit" class="btn btn-primary" name="retornar" value='1' >Salvar e adicionar outra</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>	
			</div>

    	</div>
    {{csrf_field()}}
	</div>
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
function verificaTermino(campo){
	status = $("select[name=status").val();
	if(campo.value && status=='ativa')
		alert('O fim só deve ser preenchido caso o estado da atividade esteja encerrada.');
}
</script>

@endsection
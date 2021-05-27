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
				<div class="input-group">
					<span class="input-group-addon"><i class=" fa fa-toggle-right  "></i></span> 
					<input type="text" class="form-control boxed" id="fcurso" name="fcurso" placeholder="Digite e selecione. Cód. 307 para UATI" required value="{{$turma->curso->nome}}"> 
					<input type="hidden" name="curso" value="{{$turma->curso->id}}">
				</div>
				<div class="col-sm-12"> 
				 <ul class="item-list" id="listacursos">
				 </ul>
				</div> 
			</div>
		</div>
		<div class="form-group row" id="row_disciplina" style="display:none"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Disciplina
			</label>
			<div class="col-sm-6"> 
				<div class="input-group">
					<span class="input-group-addon"><i class=" fa fa-toggle-down "></i></span> 
					<input type="text" class="form-control boxed" id="fdisciplina" name="fdisciplina" placeholder="Digite e selecione" value="{{isset($turma->disciplina)?$turma->disciplina->nome:''}}" > 
					<input type="hidden" name="disciplina" value="{{isset($turma->disciplina)?$turma->disciplina->id:''}}">
				</div>
				<div class="col-sm-12"> 
				 <ul class="item-list" id="listadisciplinas">
				 </ul>
				</div> 
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
			<div class="col-sm-2"> 
				<select class="c-select form-control boxed" name="unidade" onchange="carregarSalas(this.value)" required >
					<option>Selecione ums unidade de atendimento</option>
					@if(isset($dados['unidades']))
					@foreach($dados['unidades'] as $unidade)
					<option value="{{$unidade->id}}" {{$unidade->id==$turma->local->id?'selected':''}}>{{$unidade->nome}}</option>
					@endforeach
					@endif
				</select> 
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Sala
			</label>
			<div class="col-sm-2"> 
				<select class="c-select form-control boxed" name="sala" id="select_sala" required>
					<option>Selecione ums unidade de atendimento</option>
					@if(isset($dados['salas']))
					@foreach($dados['salas'] as $sala)
					<option value="{{$sala->id}}" {{$sala->id==$turma->sala?'selected':''}}>{{$sala->nome}}</option>
					@endforeach
					@endif
				</select> 
			</div>
		</div>
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Parceria 
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed" name="parceria" required>
					<option value="0" >Selecione parceria, se houver</option>
					@if(isset($dados['parcerias']))
					@foreach($dados['parcerias'] as $parceria)
					<option value="{{$parceria->id}}" {{isset($turma->parceria->id) && $parceria->id==$turma->parceria->id?'selected':''}}>{{$parceria->nome}}</option>
					@endforeach
					@endif
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Periodicidade
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed" name="periodicidade" required>
					<option>Selecione o período da turma</option>
					<option value="mensal" {{$turma->periodicidade=="mensal"?"selected":"" }}>Mensal</option>
					<option value="bimestral" {{$turma->periodicidade=="bimestral"?"selected":"" }}>Bimestral</option>
					<option value="trimestral" {{$turma->periodicidade=="trimestral"?"selected":"" }}>Trimestral</option>
					<option value="semestral" {{$turma->periodicidade=="semestral"?"selected":"" }}>Semestral</option>
					<option value="anual" {{$turma->periodicidade=="anual"?"selected":"" }}>Anual</option>
					<option value="eventual" {{$turma->periodicidade=="eventual"?"selected":"" }}>Eventual</option>
					<option value="ND" {{$turma->periodicidade=="ND"?"selected":"" }}>Não Definido</option>
		
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
			<div class="col-sm-2"> 
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
					<input type="date" class="form-control boxed" name="dt_inicio" value="{{$turma->data_iniciov}}" placeholder="dd/mm/aaaa" required> 
				</div>
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Data do termino
			</label>
			<div class="col-sm-2"> 
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
				<input type="time" class="form-control boxed" name="hr_inicio" value="{{$turma->hora_inicio}}" placeholder="00:00" required > 
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Horário Termino
			</label>
			<div class="col-sm-2"> 
				<input type="time" class="form-control boxed" name="hr_termino" value="{{$turma->hora_termino}}" placeholder="00:00" required> 
			</div>
		</div>
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Nº de vagas
			</label>
			<div class="col-sm-2"> 
				<input type="number" class="form-control boxed" name="vagas" value="{{$turma->vagas}}" placeholder="Recomendado: 30 vagas"> 
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Carga Horária
			</label>
			<div class="col-sm-2"> 
				<div class="input-group">
					 
					<input type="number" class="form-control boxed" name="carga" value="{{$turma->carga}}" placeholder="" required> 
				</div>
			</div>
		</div>
	
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Valor
			</label>
			<div class="col-sm-2"> 
				<div class="input-group">
					<span class="input-group-addon">R$ </span> 
					<input type="text" class="form-control boxed" name="valor" value="{{number_format($turma->valor,2,',','.')}}" placeholder="Valor TOTAL"> 
				</div>
			</div>
			
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">Opções</label>
            <div class="col-sm-2"> 
				<div>
					<label>
					<input class="checkbox" name="online" value="P" {{isset($turma->automatricula)?'checked ':''}} type="checkbox">
					<span>Permitir matrícula online </span>
					</label>
				</div>
				
				
        	</div>
			<label class="col-sm-2 form-control-label text-xs-right"></label>
            <div class="col-sm-2"> 
            	
				<a href="/turmas/modificar-requisitos/{{$turma->id}}" target="_blank">Modificar Requisitos obrigatórios</a>
				
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
$(document).ready(function() 
	{
		@if(isset($turma->disciplina))
			$('#row_disciplina').show();
		@endif
 
   //On pressing a key on "Search box" in "search.php" file. This function will be called.
 
   $("#fcurso").keyup(function() {
   		
   		$('#fmodulo').val('1');
   		$('#row_modulos').hide();
   		var disciplina = $("input[name=disciplina]").val('');
   		$("#fdisciplina").val('');
   		$('#row_disciplina').hide();

 
       //Assigning search box value to javascript variable named as "name".
 
       var name = $('#fcurso').val();
       var namelist="";

 
       //Validating, if "name" is empty.
 
       if (name == "") {
 
           //Assigning empty value to "display" div in "search.php" file.
 
           $("#listacursos").html("");
 
       }
 
       //If name is not empty.
 
       else {
 
           //AJAX is called.
 			$.get("{{asset('cursos/listarporprogramajs/')}}"+"/"+name)
 				.done(function(data) 
 				{
 					$.each(data, function(key, val){
 						namelist+='<li class="item item-list-header hidden-sm-down">'
 									+'<a href="#" onClick="cursoEscolhido(\''+val.id+'\',\''+val.nome+'\')">'
 										+val.id+' - '+val.nome
 									+'</a>'
 								  +'</li>';
 					});
 					//console.log(namelist);
 					$("#listacursos").html(namelist).show();
 				});
       }
 
  	});
   $("#fdisciplina").keyup(function() {
  
   		
   	
 
       //Assigning search box value to javascript variable named as "name".
 
       var name = $('#fdisciplina').val();
       var namelist="";
       var curso = $("input[name=curso]").val();
       var disciplina = $("input[name=disciplina]").val('');



       if (curso<=0){
       	alert("escolha um curso");
       }
       	

 
       //Validating, if "name" is empty.
 
       if (name == "") {
 
           //Assigning empty value to "display" div in "search.php" file.
 
           $("#listadisciplinas").html("");
 
       }
 
       //If name is not empty.
 
       else {
 
           //AJAX is called.
 			$.get("{{asset('cursos/disciplinas/grade/')}}"+"/"+curso+"/"+name)
 				.done(function(data) 
 				{
 					$.each(data, function(key, val){
 						namelist+='<li class="item item-list-header hidden-sm-down">'
 									+'<a href="#" onClick="disciplinaEscolhida(\''+val.id+'\',\''+val.nome+'\')">'
 										+val.id+' - '+val.nome
 									+'</a>'
 								  +'</li>';
 					

 					});
 					//console.log(namelist);
 					$("#listadisciplinas").html(namelist).show();



 				});

 				/*
 				<option value="324000000000 Adauto Junior 10/11/1984 id:0000014">
					<option value="326500000000 Fulano 06/07/1924 id:0000015">
					<option value="3232320000xx Beltrano 20/02/1972 id:0000016">
					<option value="066521200010 Ciclano 03/08/1945 id:0000017">
					*/
 			
 			
 
       }
 
  	});
 
});
function cursoEscolhido(id,nome){
	$("#listacursos").hide();
	$("#fcurso").val(id +' - '+nome);
	$("input[name=curso]").val(id);
/* -- Curso em módulos
	$.get("{{asset('/pedagogico/curso/modulos/')}}"+"/"+id)
		.done(function(data) {
			//console.log(data);
			if(data>1){
				$('#row_modulos').show();
				$('#fmodulo').attr('max',data);
			}
		});*/
	$.get("{{asset('cursos/disciplinas/grade/')}}"+"/"+id)
		.done(function(data) {
			
			if(data.length>0){
				$('#row_disciplina').show();
			}
		});

}
function disciplinaEscolhida(id,nome){
	$("#fdisciplina").val(id +' - '+nome);
	$("input[name=disciplina]").val(id);
	$('#listadisciplinas').hide();

}
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
/* ao selecionar a unidade mostra as salas
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
	

	
	});*/

	


</script>


@endsection
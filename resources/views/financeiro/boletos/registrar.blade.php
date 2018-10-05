@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Registrando boleto {{$boleto->id}} no banco para impressão.<span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="item" action="https://mpag.bb.com.br/site/mpag/" method="POST">
	<input type="hidden" name="idConv" value="2838669">
	<input type="hidden" name="refTran" value="2838669{{str_pad($boleto->id,10,'0',STR_PAD_LEFT)}}">
	<input type="hidden" name="valor" value="{{preg_replace( '/[^0-9]/is', '',$boleto->valor)}}">
	<input type="hidden" name="qtdPontos" value="">
	<input type="hidden" name="dtVenc" value="{{\Carbon\Carbon::parse($boleto->vencimento)->format('dmY')}}">
	<input type="hidden" name="tpPagamento" value="2">
	<input type="hidden" name="cpfCnpj" value="{{$pessoa->cpf}}">
	<input type="hidden" name="indicadorPessoa" value="1">
	<input type="hidden" name="valorDesconto" value="">
	<input type="hidden" name="dataLimiteDesconto" value="">
	<input type="hidden" name="tpDuplicata" value="DS">
	<input type="hidden" name="urlRetorno" value="/financeiro/boletos/retorno-direto">
	<input type="hidden" name="urlInforma" value="">
	<input type="hidden" name="nome" value="{{$pessoa->nome}}">
	<input type="hidden" name="endereco" value="{{$pessoa->logradouro.' '.$pessoa->end_numero.' '.$pessoa->end_complemento.' '.$pessoa->bairro}}">
	<input type="hidden" name="cidade" value="{{$pessoa->cidade}}">
	<input type="hidden" name="uf" value="{{$pessoa->estado}}">
	<input type="hidden" name="cep" value="{{$pessoa->cep}}">
	<input type="hidden" name="msgLoja" value="{{$lancamentos}}">


    <div class="card card-block">
    	<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Estado
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed" name="status" required>
					<option >Selecione uma opção</option>
					<option value="gravado" {{$boleto->status == 'gravado' ? "selected" : ""}} >Gravado</option>
					<option value="impresso" {{$boleto->status == 'impresso' ? "selected" : ""}} >Impresso</option>
					<option value="emitido" {{$boleto->status == 'emitido' ? "selected" : ""}}>Enviado ao banco</option>
					<!--
					<option value="cancelar" {{$boleto->status == 'cancelar' ? "selected" : ""}}>Cancelar</option>
					<option value="cancelado" {{$boleto->status == 'cancelado' ? "selected" : ""}}>Cancelado</option>
					-->
					
					
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Vencimento
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
					<input type="text" class="form-control boxed" name="vencimento" value="{{$boleto->vencimento}}" required> 
				</div>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Valor
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					<span class="input-group-addon">R$ </span> 
					<input type="text" class="form-control boxed" name="valore" value="{{str_replace('.',',',$boleto->valor)}}" required> 
				</div>
			</div>
		</div>

		            
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-2">
				<input type="hidden" name="boleto" value="{{$boleto->id}}">
				<button type="submit" name="btn"  class="btn btn-primary">Salvar</button>
                <button type="reset" name="btn"  class="btn btn-primary">Restaurar</button>
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
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
$(document).ready(function() 
	{
 
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
 			$.get("{{asset('pedagogico/cursos/listarporprogramajs/')}}"+"/"+name)
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
 			$.get("{{asset('pedagogico/curso/disciplinas/')}}"+"/"+curso+"/"+name)
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
/*
	$.get("{{asset('/pedagogico/curso/modulos/')}}"+"/"+id)
		.done(function(data) {
			//console.log(data);
			if(data>1){
				$('#row_modulos').show();
				$('#fmodulo').attr('max',data);
			}
		});*/
	$.get("{{asset('pedagogico/curso/disciplinas')}}"+"/"+id)
		.done(function(data) {
			
			if(data.length>1){
				$('#row_disciplina').show();
			}
		});

}
function disciplinaEscolhida(id,nome){
	$("#fdisciplina").val(id +' - '+nome);
	$("input[name=disciplina]").val(id);
	$('#listadisciplinas').hide();

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
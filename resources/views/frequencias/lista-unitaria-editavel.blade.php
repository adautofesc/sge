<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="pt-br" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Lista de frequência</title>
<meta content="Sheets" name="generator" />
<style type="text/css"><!--br {mso-data-placement:same-cell;}
body{
	font-family:Calibri;
}
.auto-style1 {
	text-align: center;
	vertical-align: middle;
	font-size: large;
}
.auto-style2 {
	text-align: center;
	font-size: medium;
}
.auto-style3 {
	font-size: small;
}
.stilo1{
	overflow: hidden;
	padding: 0px 3px 0px 3px;
	vertical-align: bottom;
	 height: 33px;
}
.stilo2{
	overflow: hidden;
	 padding: 0px 3px 0px 3px; 
	 vertical-align: bottom; 
	 height: 28px;
}
.stilo3{
	overflow:hidden;
	padding:0px 3px 0px 3px;
	vertical-align:bottom;
}
.stilo4{
	border-bottom:1px solid #000000;
	overflow:hidden;
	padding:0px 3px 0px 3px;
	vertical-align:bottom;
}
.datas{
	border-right:1px solid #000000;
	border-top:1px solid #000000;
	border-bottom:1px solid #000000;
	overflow:hidden;
	padding:0px 3px 0px 3px;
	vertical-align:middle;
	background-color:#cccccc;
	font-size:8pt;
	color:#000000;
	text-align:center;
}
.presenca{
	border-right:1px solid #000000;
	border-bottom:1px solid #000000;
	overflow:hidden;
	padding:0px 3px 0px 3px;
	vertical-align:middle;


}
.default{
	overflow:hidden;
	padding:0px 3px 0px 3px;
	vertical-align:middle;
}
@media print {
            .hide-onprint { 
                display: none;
			}
}


</style>
<script src="https://code.jquery.com/jquery-3.5.1.slim.js"></script>
<script>
	function todos(){
		location.href = location.href+'?filtrar=todos';
	}
	function marcardesmarcar(campo,inscricao){
		console.log(inscricao);
		$(".insc-"+inscricao).each(
			function(){
				$(this).prop("checked", campo.checked)
			
				
			});
		contarFaltas(inscricao);
	}

	
	function underclass(x,y){

	}
	function contarFaltas(inscricao){
		faltas =0;
		$(".insc-"+inscricao).each(
			function(){		
				if($(this).prop("checked")==false)
					faltas++;
				
			}
		);
		$("#faltas-"+inscricao).html(faltas);
		console.log(faltas);
	}

</script>
</head>

<body>
<div class="hide-onprint">
	<button onclick="todos()">Visualizar ocultos</button>
</div>
<table width="100%">
	<tr>
		<td style="width:40rem;">&nbsp;</td>
		<td class="titulo" align="center">
			<strong>FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong><br>
			<span class="subtitulo">{{$turma->programa->nome}}</span>
		</td>
		<td>&nbsp;</td>
		
	</tr>
	<tr>
		<td><strong>RELATÓRIO DE FREQUÊNCIA</strong> <br>
			<span class="nome-curso">{{$turma->getNomeCurso()}}</span>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td >{{$turma->local->nome}} / 
			@if(isset($turma->sala->nome))
				{{$turma->sala->nome}}
			@endif
			<br>
			TURMA: {{$turma->id}} - {{implode($turma->dias_semana,',')}} feiras das {{$turma->hora_inicio}} às {{$turma->hora_termino}}

		</td>
		<td >&nbsp;
		</td>
		<td  align="right" ><strong>Início:</strong>&nbsp;{{$turma->data_inicio}}<br>
			<strong>Termino:</strong>&nbsp;{{$turma->data_termino}}</td>
	</tr>
</table>
<form method="POST">
	{{csrf_field()}}
<input type="hidden" name="turma" value="{{$turma->id}}">
<table cellpadding="0" cellspacing="0" dir="ltr" style="table-layout:fixed;font-size:11pt;font-family:Calibri;width:0px;" xmlns="http://www.w3.org/1999/xhtml">
	<colgroup>
		<col width="31" />
		<col width="236" />

		@for($col=1;$col<=count($aulas)+1;$col++)
		<col width="18" />
		@endfor

		<col width="38" />
		<col width="60" />
	</colgroup>

	<tr style="height:17px;">
		<td colspan="1" rowspan="2" style="border-top:1px solid #000000;border-right:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;font-size:8pt;color:#000000;text-align:center;">
		<span>
		<div style="max-height:37px;"  >
			No</div>
		</span></td>
		<td colspan="2"  rowspan="2" style="border-top:1px solid #000000;border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:10pt;font-weight:bold;color:#000000;">
		<span>
		<div style="max-height:37px" >
			Aluno</div>
		</span></td>
		
		







		<!-- numero da aula -->
		@for($i=1;$i<count($aulas)+1;$i++)
		<td  rowspan="1" colspan="1" class="datas">
		{{$i}}</td>
		
		@endfor
		<!--// fim numero da aula-->





		<td colspan="1" class="datas" rowspan="2">
		<span>
		<div style="max-height:37px">
			Faltas</div>
		</span></td>
		<td colspan="1" rowspan="2" class="datas">
		<span>
		<div style="max-height:37px">
			Conceito</div>
		</span></td>
	</tr>
	<tr style="height:20px;">
		<!-- data das aulas -->
		@foreach($aulas as $aula)		
		<td colspan="1" rowspan="1" class="datas" style="border-top:none;">
			{{$aula->data->format('d m')}}
		</td>
		@endforeach
		<!-- // fim data aulas -->
		
	</tr>
	@php
		$ordem = 1;
	@endphp
	<!-- início da linha do aluno -->
	@foreach($inscritos as $inscrito)
	@if(($ordem%2)>0)
	<tr style="height:16px;">
	@else 
	<tr style="height:16px;background-color:#cccccc;">
	@endif

		<td  style="border-right:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;font-size:8pt;color:#000000;text-align:center;">
		{{$ordem++}}</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
			@if(strlen($inscrito->pessoa->nome)>36)
				{{substr($inscrito->pessoa->nome,0,36)}}.
			@else
			    {{$inscrito->pessoa->nome}}
			@endif

			@if($inscrito->status == 'cancelado')
			&nbsp;<small>({{$inscrito->status}})</small>
			
			@endif
			<input type="hidden" name="alunos[]" value="{{$inscrito->pessoa->id}}">
		</td>
		<!-- Selecionador -->
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;" >
		<input type="checkbox" name="" id="" style="margin: 0;padding:0;" onclick="marcardesmarcar(this,'{{$inscrito->id}}')" class="hide-onprint">
		</td>
		<!-- // fim selecionador -->

		@php($falta=0)
		<!-- presença do aluno -->
		@foreach($aulas as $aula)
		<td class="presenca aula-{{$aula->id}} aluno-{{$inscrito->id}}" >
		@if(isset($aula->presentes) && in_array($inscrito->pessoa->id,$aula->presentes))
			<input type="checkbox" name="presente[{{$inscrito->pessoa->id}},{{$aula->id}}]" checked="true" style="margin: 0;padding:0;" class="aula-{{$aula->id}} insc-{{$inscrito->id}}" onclick="contarFaltas('{{$inscrito->id}}')">
		@elseif($aula->status == 'executada' &&  ($inscrito->status == 'regular' || $inscrito->status == 'finalizada' ) && $inscrito->created_at < $aula->data->format('Y-m-d') ) 
			@php ($falta++)
			<input type="checkbox" name="presente[{{$inscrito->pessoa->id}},{{$aula->id}}]"  id="" style="margin: 0;padding:0;" class="aula-{{$aula->id}} insc-{{$inscrito->id}}" onclick="contarFaltas('{{$inscrito->id}}')">
		@elseif($aula->status == 'executada')
		<input type="checkbox"  disabled style="margin: 0;padding:0;" title="Inscrição cancelada/transferida">
		@elseif($aula->status == 'cancelada')
		<input type="checkbox"  disabled style="margin: 0;padding:0;" title="Aula cancelada">
		@endif
		</td>
		@endforeach
		<!-- // fim das presenças do aluno-->
		
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;text-align:center;" id="faltas-{{$inscrito->id}}">{{$falta}}
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
			<select name="conceito[{{$inscrito->id}}]" id="">
				<option value="">&nbsp;</option>
				<option value="CA" {{$inscrito->conceito=="CA"?"selected":''}}>CA</option>
				<option value="SA" {{$inscrito->conceito=="SA"?"selected":''}}>SA</option>
				<option value="EV" {{$inscrito->conceito=="EV"?"selected":''}}>EV</option>
				<option value="NF" {{$inscrito->conceito=="NF"?"selected":''}}>NF</option>
			</select>
		</td>
	</tr>
	@endforeach
	<!-- fim da linha do aluno -->



	<tr style="height:60px;">
		<td class="stilo3 hide-onprint" colspan="33">
			<button type="submit">Salvar dados</button>
			<button type="button" onclick="location.reload();return false;">Resetar dados</button>
		<button type="button" onclick="location.replace('/docentes/frequencia/conteudos/{{$turma->id}}');return false;">Editar conteúdo</button>
			<button type="button" onclick="location.reload();return false;">Editar ocorrências</button>
		</td>
		
		<td data-sheets-numberformat="[null,2,&quot;dd/mm/yy&quot;,1]" class="stilo3">
		</td>
	</tr>



	<tr style="height:50px; padding-top:50px;">
		<td colspan="33" style="overflow:hidden;vertical-align:bottom;font-size:8pt;color:#000000;">
		Conceito: CA = Concluído com Aproveitamento, EV = Evadido, SA = 
		Concluído SEM Aproveitamento, NF = Nunca Frequentou</td>
		<td class="stilo3">
		</td>
	</tr>
	
</table>

</body>

</html>

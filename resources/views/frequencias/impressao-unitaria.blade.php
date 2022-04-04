<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="pt-br" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Lista de chamada</title>
</head>

<body>

<meta content="Sheets" name="generator" />
<style type="text/css"><!--br {mso-data-placement:same-cell;}
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
--></style>
<table cellpadding="0" cellspacing="0" dir="ltr" style="table-layout:fixed;font-size:11pt;font-family:Calibri;width:0px;" xmlns="http://www.w3.org/1999/xhtml">
	<colgroup>
		<col width="31" /><col width="236" /><col width="18" />
		<col width="18" /><col width="18" /><col width="18" /><col width="18" />
		<col width="18" /><col width="18" /><col width="18" /><col width="18" />
		<col width="18" /><col width="18" /><col width="18" /><col width="18" />
		<col width="18" /><col width="18" /><col width="18" /><col width="18" />
		<col width="18" /><col width="18" /><col width="18" /><col width="18" />
		<col width="18" /><col width="18" /><col width="18" /><col width="18" />
		<col width="18" /><col width="18" /><col width="18" /><col width="18" />
		<col width="18" /><col width="38" /><col width="60" />
	</colgroup>
	<tr>
		<td class="stilo1">
		</td>
		<td class="stilo1">
		</td>
		<td class="stilo1">
		</td>
		<td class="stilo1">
		</td>
		<td class="stilo1">
		</td>
		<td class="auto-style1" colspan="19" class="stilo1">
		<strong>FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong></td>
		<td class="stilo1">
		</td>
		<td class="stilo1">
		</td>
		<td class="stilo1">
		</td>
		<td class="stilo1">
		</td>
		<td class="stilo1">
		</td>
		<td class="stilo1">
		</td>
		<td class="stilo1">
		</td>
		<td class="stilo1">
		</td>
		<td colspan="2" rowspan="3" style="overflow: hidden; padding: 0px 3px 0px 3px; vertical-align: bottom;">
		</td>
	</tr>
	<tr>
		<td class="stilo2">
		</td>
		<td class="stilo2">
		</td>
		<td class="stilo2">
		</td>
		<td class="stilo2">
		</td>
		<td class="stilo2">
		</td>
		<td class="auto-style2" colspan="19" class="stilo2" valign="top">
		<strong>{{$inscritos->first()->turma->programa->nome}}</strong></td>
		<td class="stilo2">
		</td>
		<td class="stilo2">
		</td>
		<td class="stilo2">
		</td>
		<td class="stilo2">
		</td>
		<td class="stilo2">
		</td>
		<td class="stilo2">
		</td>
		<td class="stilo2">
		</td>
		<td class="stilo2">
		</td>
	</tr>
	<tr style="height:26px;">
		<td class="auto-style3" colspan="2" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;RELATÓRIO DE FREQUÊNCIA&quot;}" rowspan="1" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-family:Arial;font-weight:bold;color:#000000;">
		RELATÓRIO DE FREQUÊNCIA</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:20px;">
		<td colspan="34" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Oficina de Photoscape&quot;}" rowspan="1" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-family:Arial;font-size:10pt;font-weight:normal;color:#000000;">
		{{$inscritos->first()->turma->curso->nome}}
		@if(isset($inscritos->first()->turma->disciplina->nome))
		- {{$inscritos->first()->turma->disciplina->nome}}
		@endif
	</td>
	</tr>
	<tr style="height:31px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Início&quot;}" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-size:8pt;font-weight:bold;color:#000000;text-align:right;">
		Início</td>
		<td data-sheets-numberformat="[null,2,&quot;dd/mm/yy&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42590}" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-size:8pt;color:#000000;">
		{{$inscritos->first()->turma->data_inicio}}</td>
	</tr>
	<tr style="height:17px;">
		<td colspan="2" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;CRAS São Carlos VIII&quot;}" rowspan="1" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-family:Arial;font-size:8pt;font-weight:normal;color:#000000;">
		{{$inscritos->first()->turma->local->nome}}</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Término&quot;}" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-size:8pt;font-weight:bold;color:#000000;text-align:right;">
		Término</td>
		<td data-sheets-numberformat="[null,2,&quot;dd/mm/yy&quot;,1]" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-size:8pt;color:#000000;">{{$inscritos->first()->turma->data_termino}}
		</td>
	</tr>
	<tr style="height:23px;">
		<td colspan="11" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;TURMA: 2ª feiras das 08h às 10h&quot;}" rowspan="1" style="border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:top;font-family:Arial;font-size:8pt;font-weight:normal;color:#000000;">
		TURMA: {{$inscritos->first()->turma->id}} - {{implode(',',$inscritos->first()->turma->dias_semana)}} feiras das {{$inscritos->first()->turma->hora_inicio}} às {{$inscritos->first()->turma->hora_termino}}</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td class="stilo4">
		</td>
		<td data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Semestral&quot;}" style="border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;font-size:8pt;color:#ffffff;">
		</td>
	</tr>
	<tr style="height:17px;">
		<td colspan="1" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;No&quot;}" rowspan="2" style="border-right:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;font-size:8pt;color:#000000;text-align:center;">
		<span>
		<div style="max-height:37px">
			No</div>
		</span></td>
		<td colspan="1" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Aluno&quot;}" rowspan="2" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:10pt;font-weight:bold;color:#000000;">
		<span>
		<div style="max-height:37px">
			Aluno</div>
		</span></td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:1}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		1</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:2}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		2</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:3}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		3</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:4}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		4</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:5}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		5</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:6}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		6</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:7}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		7</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:8}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		8</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:9}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		9</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:10}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		10</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:11}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		11</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:12}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		12</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:13}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		13</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:14}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		14</td>
		<td colspan="2" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:15}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		15</td>
		<td colspan="1" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Faltas&quot;}" rowspan="2" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#d9d9d9;font-size:8pt;color:#000000;text-align:center;">
		<span>
		<div style="max-height:37px">
			Faltas</div>
		</span></td>
		<td colspan="1" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Conceito&quot;}" rowspan="2" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#d9d9d9;font-size:8pt;color:#000000;text-align:center;">
		<span>
		<div style="max-height:37px">
			Conceito</div>
		</span></td>
	</tr>
	<tr style="height:20px;">
		<td colspan="2" data-sheets-formula="=R[-4]C[31]" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42590}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42604}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-formula="=IF(R6C35=&quot;Semestral&quot;;R[0]C[-2]+7;IF(WEEKDAY(R[0]C[-2])=2;R[0]C[-2]+2;R[0]C[-2]+5))" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42611}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-formula="=IF(R6C35=&quot;Semestral&quot;;R[0]C[-2]+7;IF(WEEKDAY(R[0]C[-2])=2;R[0]C[-2]+2;R[0]C[-2]+5))" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42618}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-formula="=IF(R6C35=&quot;Semestral&quot;;R[0]C[-2]+7;IF(WEEKDAY(R[0]C[-2])=2;R[0]C[-2]+2;R[0]C[-2]+5))" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42625}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-formula="=IF(R6C35=&quot;Semestral&quot;;R[0]C[-2]+7;IF(WEEKDAY(R[0]C[-2])=2;R[0]C[-2]+2;R[0]C[-2]+5))" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42632}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-formula="=IF(R6C35=&quot;Semestral&quot;;R[0]C[-2]+7;IF(WEEKDAY(R[0]C[-2])=2;R[0]C[-2]+2;R[0]C[-2]+5))" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42639}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-formula="=IF(R6C35=&quot;Semestral&quot;;R[0]C[-2]+7;IF(WEEKDAY(R[0]C[-2])=2;R[0]C[-2]+2;R[0]C[-2]+5))" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42646}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-formula="=IF(R6C35=&quot;Semestral&quot;;R[0]C[-2]+7;IF(WEEKDAY(R[0]C[-2])=2;R[0]C[-2]+2;R[0]C[-2]+5))" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42653}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-formula="=IF(R6C35=&quot;Semestral&quot;;R[0]C[-2]+7;IF(WEEKDAY(R[0]C[-2])=2;R[0]C[-2]+2;R[0]C[-2]+5))" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42660}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-formula="=IF(R6C35=&quot;Semestral&quot;;R[0]C[-2]+7;IF(WEEKDAY(R[0]C[-2])=2;R[0]C[-2]+2;R[0]C[-2]+5))" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42667}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-formula="=IF(R6C35=&quot;Semestral&quot;;R[0]C[-2]+7;IF(WEEKDAY(R[0]C[-2])=2;R[0]C[-2]+2;R[0]C[-2]+5))" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42674}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-formula="=IF(R6C35=&quot;Semestral&quot;;R[0]C[-2]+7;IF(WEEKDAY(R[0]C[-2])=2;R[0]C[-2]+2;R[0]C[-2]+5))" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42681}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42695}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
		<td colspan="2" data-sheets-formula="=IF(R6C35=&quot;Semestral&quot;;R[0]C[-2]+7;IF(WEEKDAY(R[0]C[-2])=2;R[0]C[-2]+2;R[0]C[-2]+5))" data-sheets-numberformat="[null,5,&quot;dd\&quot;/\&quot;mm&quot;,1]" data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:42702}" rowspan="1" style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#cccccc;font-size:8pt;color:#000000;text-align:center;">
		&nbsp;</td>
	</tr>

	@foreach($inscritos as $inscrito)

	<tr style="height:16px;">
		<td data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:1}" style="border-right:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;font-size:8pt;color:#000000;text-align:center;">
		{{$i++}}</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
			@if($inscrito->status != 'regular')
			<small>{{$inscrito->status}}</small> - {{$inscrito->pessoa->nome}}
			@else
			{{$inscrito->pessoa->nome}}
			@endif
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;background-color:#ffffff;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;">
		</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;">
		</td>
	</tr>
	@endforeach



	<tr style="height:20px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td class="stilo3">
		</td>
		<td data-sheets-numberformat="[null,2,&quot;dd/mm/yy&quot;,1]" class="stilo3">
		</td>
	</tr>
	<tr style="height:20px;">
		<td colspan="6" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Educador:  Adauto Inocêncio de Oliveira Jr.&quot;}" rowspan="1" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;color:#000000;">
		Educador: {{$inscrito->turma->professor->nome}}</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
		</td>
		<td colspan="18" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Coordenador: Marco Antonio Lozano Porta Lopes&quot;}" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;color:#000000;">
		Coordenador: </td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:28px;">
		<td colspan="6" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Assinatura: &quot;}" rowspan="1" style="border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-size:8pt;color:#000000;">
		Assinatura: </td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td colspan="17" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Assinatura: &quot;}" style="border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-size:8pt;color:#000000;">
		Assinatura: </td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:20px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:20px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:20px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:20px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:12px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:14px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:13px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:11px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:20px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:5px;">
		<td colspan="33" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Conceito: CA = Concluído com Aproveitamento, EV = Evadido, SA = Concluído SEM Aproveitamento, NF = Nunca Frequentou&quot;}" rowspan="1" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-size:8pt;color:#000000;">
		Conceito: CA = Concluído com Aproveitamento, EV = Evadido, SA = 
		Concluído SEM Aproveitamento, NF = Nunca Frequentou</td>
		<td class="stilo3">
		</td>
	</tr>
	<tr style="height:20px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;lista v15.12.15&quot;}" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-size:5pt;color:#000000;">
		lista v0.1</td>
	</tr>
	<tr style="height:20px;">
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
		<td class="stilo3">
		</td>
	</tr>
</table>

</body>

</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="pt-br" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Lista de frequência</title>
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
.datas{
	border-right:1px solid #000000;
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
</style>
</head>

<body>



<table cellpadding="0" cellspacing="0" dir="ltr" style="table-layout:fixed;font-size:11pt;font-family:Calibri;width:0px;" xmlns="http://www.w3.org/1999/xhtml">
	<colgroup>
		<col width="31" />
		<col width="236" />

		@for($col=1;$col<=count($aulas);$col++)
		<col width="18" />
		@endfor
		


		<col width="38" />
		<col width="60" />
	</colgroup>
	<tr>
		<td class="stilo1" colspan="5">
		</td>
		
		<td class="auto-style1" colspan="19" class="stilo1">
		<strong>FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong></td>
		<td class="stilo1" colspan="8">
		</td>
		
		<td colspan="2" rowspan="3" style="overflow: hidden; padding: 0px 3px 0px 3px; vertical-align: bottom;">
		</td>
	</tr>
	<tr>
		<td class="stilo2" colspan="5"></td>
	
		<td class="auto-style2" colspan="19" class="stilo2" valign="top">
		<strong>{{$inscritos->first()->turma->programa->nome}}</strong></td>
		<td class="stilo2" colspan="8">
		</td>

	</tr>
	<tr style="height:26px;">
		<td class="auto-style3" colspan="2" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;RELATÓRIO DE FREQUÊNCIA&quot;}" rowspan="1" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-family:Arial;font-weight:bold;color:#000000;">
		RELATÓRIO DE FREQUÊNCIA</td>
		<td class="stilo3" colspan="30">
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
		<td class="stilo3" colspan="10">
		</td>
		
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-size:8pt;font-weight:bold;color:#000000;text-align:right;" colspan="5">
		Início</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-size:8pt;color:#000000;" colspan="3">
		{{$inscritos->first()->turma->data_inicio}}</td>
	</tr>
	<tr style="height:17px;">
		<td colspan="2" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;CRAS São Carlos VIII&quot;}" rowspan="1" style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-family:Arial;font-size:8pt;font-weight:normal;color:#000000;">
		{{$inscritos->first()->turma->local->nome}}</td>
		<td class="stilo3" colspan="10">
		</td>
		
		<td  style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-size:8pt;font-weight:bold;color:#000000;text-align:right;" colspan="5">
		Término</td>
		<td style="overflow:hidden;padding:0px 3px 0px 3px;vertical-align:bottom;font-size:8pt;color:#000000;" colspan="3">{{$inscritos->first()->turma->data_termino}}
		</td>
	</tr>
	<tr style="height:23px;">
		<td colspan="11" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;TURMA: 2ª feiras das 08h às 10h&quot;}" rowspan="1" style="border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:top;font-family:Arial;font-size:8pt;font-weight:normal;color:#000000;">
		TURMA: {{$inscritos->first()->turma->id}} - {{implode($inscritos->first()->turma->dias_semana,',')}} feiras das {{$inscritos->first()->turma->hora_inicio}} às {{$inscritos->first()->turma->hora_termino}}</td>
		<td class="stilo4" colspan="{{count($aulas)}}}">
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








		@for($i=1;$i<count($aulas)+1;$i++)
		<td  rowspan="1" colspan="1" class="datas">
		{{$i}}</td>
		
		@endfor





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
		@foreach($aulas as $aula)
		
		<td colspan="1" rowspan="1" class="datas">
			{{$aula->data->format('d m')}}</td>

		@endforeach
		
	</tr>
	@php
		$ordem = 1;
	@endphp
	@foreach($inscritos as $inscrito)
	@if(($ordem%2)>0)
	<tr style="height:16px;">
	@else 
	<tr style="height:16px;background-color:#cccccc;">
	@endif

		<td data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:1}" style="border-right:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;font-size:8pt;color:#000000;text-align:center;">
		{{$ordem++}}</td>
		<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;overflow:hidden;padding:0px 3px 0px 3px;vertical-align:middle;">
			@if(strlen($inscrito->pessoa->nome)>36)
				{{substr($inscrito->pessoa->nome,0,36)}}.
			@else
			    {{$inscrito->pessoa->nome}}
			@endif
		</td>

		@foreach($aulas as $aula)
		<td class="presenca">
		@if(isset($aula->presentes) && in_array($inscrito->pessoa->id,$aula->presentes))
		    • 
		@elseif($aula->status == 'executada') 	
			F
		@endif
		</td>
		@endforeach
		
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

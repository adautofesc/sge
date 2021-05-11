<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Boletos em Lote</title>
<META http-equiv=Content-Type content=text/html charset=ISO-8859-1>
<meta name="Generator" content="Projeto BoletoPHP - www.boletophp.com.br - Licença GPL" />
	
<style type="text/css">
<!--
.ti {font: 9px Arial, Helvetica, sans-serif}
-->


@media screen,print {

/* *** TIPOGRAFIA BASICA *** */
.page-break { 
page-break-before: always; 
}

* {
	font-family: Arial;
	font-size: 12px;
	margin: 0;
	padding: 0;
}

.notice {
	color: red;
}


/* *** LINHAS GERAIS *** */

#container {
	width: 666px;
	margin: 0px auto;
	padding-bottom: 30px;
}

#instructions {
	margin: 0;
	padding: 0 0 20px 0;
}

#boleto {
	width: 666px;
	margin: 0;
	padding: 0;
}


/* *** CABECALHO *** */

#instr_header {
	background: url({{asset('img/logo_empresa.png')}}) no-repeat top left;
	padding-left: 160px;
	height: 65px;
}

#instr_header h1 {
	font-size: 16px;
	margin: 5px 0px;
}

#instr_header address {
	font-style: normal;
}

#instr_content {

}

#instr_content h2 {
	font-size: 10px;
	font-weight: bold;
}

#instr_content p {
	font-size: 10px;
	margin: 4px 0px;
}

#instr_content ol {
	font-size: 10px;
	margin: 5px 0;
}

#instr_content ol li {
	font-size: 10px;
	text-indent: 10px;
	margin: 2px 0px;
	list-style-position: inside;
}

#instr_content ol li p {
	font-size: 10px;
	padding-bottom: 4px;
}


/* *** BOLETO *** */

#boleto .cut {
	width: 666px;
	margin: 0px auto;
	border-bottom: 1px navy dashed;
}

#boleto .cut p {
	margin: 0 0 5px 0;
	padding: 0px;
	font-family: 'Arial Narrow';
	font-size: 9px;
	color: navy;
}

table.header {
	width: 666px;
	height: 38px;
	margin-top: 20px;
	margin-bottom: 10px;
	border-bottom: 2px navy solid;
	
}


table.header div.field_cod_banco {
	width: 46px;
	height: 19px;
  margin-left: 5px;
	padding-top: 3px;
	text-align: center;
	font-size: 14px;
	font-weight: bold;
	color: navy;
	border-right: 2px solid navy;
	border-left: 2px solid navy;
	font-size: 16px;
}

table.header td.linha_digitavel {
	width: 464px;
	text-align: right;
	font: bold 15px Arial; 
	color: navy
}

table.line {
	margin-bottom: 3px;
	padding-bottom: 1px;
	border-bottom: 1px black solid;
}

table.line tr.titulos td {
	height: 13px;
	font-family: 'Arial Narrow';
	font-size: 9px;
	color: navy;
	border-left: 5px #ffe000 solid;
	padding-left: 2px;
}

table.line tr.campos td {
	height: 12px;
	font-size: 10px;
	color: black;
	border-left: 5px #ffe000 solid;
	padding-left: 2px;
}

table.line td p {
	font-size: 10px;
}


table.line tr.campos td.ag_cod_cedente,
table.line tr.campos td.nosso_numero,
table.line tr.campos td.valor_doc,
table.line tr.campos td.vencimento2,
table.line tr.campos td.ag_cod_cedente2,
table.line tr.campos td.nosso_numero2,
table.line tr.campos td.xvalor,
table.line tr.campos td.valor_doc2,
table.line tr.campos td.desconto2,
table.line tr.campos td.outros_acrescimos2,
table.line tr.campos td.valor_cobrado,
table.line tr.campos td.valor_cobrado2

{
	text-align: right;
}

table.line tr.campos td.especie,
table.line tr.campos td.qtd,
table.line tr.campos td.vencimento,
table.line tr.campos td.especie_doc,
table.line tr.campos td.aceite,
table.line tr.campos td.carteira,
table.line tr.campos td.especie2,
table.line tr.campos td.qtd2
{
	text-align: center;
}

table.line td.last_line {
	vertical-align: top;
	height: 25px;
}

table.line td.last_line table.line {
	margin-bottom: -5px;
	border: 0 white none;
}

td.last_line table.line td.instrucoes {
	border-left: 0 white none;
	padding-left: 5px;
	padding-bottom: 0;
	margin-bottom: 0;
	height: 20px;
	vertical-align: top;
}

table.line td.cedente {
	width: 298px;
}

table.line td.valor_cobrado2 {
	padding-bottom: 0;
	margin-bottom: 0;
}


table.line td.ag_cod_cedente {
	width: 126px;
}

table.line td.especie {
	width: 35px;
}

table.line td.qtd {
	width: 53px;
}

table.line td.nosso_numero {
	/* width: 120px; */
	width: 115px;
	padding-right: 5px;
}

table.line td.num_doc {
	width: 113px;
}

table.line td.contrato {
	width: 72px;
}

table.line td.cpf_cei_cnpj {
	width: 132px;
}

table.line td.vencimento {
	width: 134px;
}

table.line td.valor_doc {
	/* width: 180px; */
	width: 175px;
	padding-right: 5px;
}

table.line td.desconto {
	width: 113px;
}

table.line td.outras_deducoes {
	width: 112px;
}

table.line td.mora_multa {
	width: 113px;
}

table.line td.outros_acrescimos {
	width: 113px;
}

table.line td.valor_cobrado {
	/* width: 180px; */
	width: 175px;
	padding-right: 5px;
	background-color: #ffc ;
}

table.line td.sacado {
	width: 659px;
}

table.line td.local_pagto {
	width: 472px;
}

table.line td.vencimento2 {
	/* width: 180px; */
	width: 175px;
	padding-right: 5px;
	background-color: #ffc;
}

table.line td.cedente2 {
	width: 472px;
}

table.line td.ag_cod_cedente2 {
	/* width: 180px; */
	width: 175px;
	padding-right: 5px;
}

table.line td.data_doc {
	width: 93px;
}

table.line td.num_doc2 {
	width: 173px;
}

table.line td.especie_doc {
	width: 72px;
}

table.line td.aceite {
	width: 34px;
}

table.line td.data_process {
	width: 72px;
}

table.line td.nosso_numero2 {
	/* width: 180px; */
	width: 175px;
	padding-right: 5px;
}

table.line td.reservado {
	width: 93px;
	background-color: #ffc;
}

table.line td.carteira {
	width: 93px;
}

table.line td.especie2 {
	width: 53px;
}

table.line td.qtd2 {
	width: 133px;
}

table.line td.xvalor {
	/* width: 72px; */
	width: 67px;
	padding-right: 5px;
}

table.line td.valor_doc2 {
	/* width: 180px; */
	width: 175px;
	padding-right: 5px;
}
table.line td.instrucoes {
	width: 475px;
}

table.line td.desconto2 {
	/* width: 180px; */
	width: 175px;
	padding-right: 5px;
}

table.line td.outras_deducoes2 {
	/* width: 180px; */
	width: 175px;
	padding-right: 5px;
}

table.line td.mora_multa2 {
	/* width: 180px; */
	width: 175px;
	padding-right: 5px;
}

table.line td.outros_acrescimos2 {
	/* width: 180px; */
	width: 175px;
	padding-right: 5px;
}

table.line td.valor_cobrado2 {
	/* width: 180px; */
	width: 175px;
	padding-right: 5px;
	background-color: #ffc ;
}

table.line td.sacado2 p {
	width: 659px;
	padding-left: 10%;
	margin-left: 10%;
	font-size: 14px;
}

table.line td.sacador_avalista {
	width: 659px;
}

table.line tr.campos td.sacador_avalista {
	width: 472px;
}

table.line td.cod_baixa {
	color: navy;
	width: 180px;
}

.referencia {
	vertical-align: text-top;
	height: 100px;
    overflow-y: hidden;
}


div.footer {
	margin-bottom: 30px;
}

div.footer p {
	width: 88px;
	margin: 0;
	padding: 0;
	padding-left: 525px;
	font-family: 'Arial Narro';
	font-size: 9px;
	color: navy;
}


div.barcode {
	width: 666px;
	margin-bottom: 20px;
}

}



@media print {

#instructions {
	height: 1px;
	visibility: hidden;
	overflow: hidden;
}

}

</STYLE>
</HEAD>
<BODY>
	<div id="container" class="page-break">
		<div id="">
	<!--
  Use no lugar do <div id=""> caso queira imprimir sem o logotipo e instruções 
  <div id="instructions">-->
  		<div class="info-empresa">
         
                <div style="display: inline-block;">
                    <img alt="logo" src="/img/logo-small.png"/>
                </div>

            <div style="display: inline-block; vertical-align: super;">
                <div><strong>Fundação Educacional São Carlos</strong></div>
                <div>CNPJ 45.361.904/0001-80</div>
                <div>Rua São Sebastião, 2828 Vila Nery</div>
                <div>13560-230 - São Carlos - SP</div>
            </div>
        </div>

		
	<div id="boleto">
		
	<table class="header" border=0 cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
			<td width=150><IMG SRC="{{asset('img/logobb.gif')}}" with="150px" height="40"></td>
			<td width=50>
        <div class="field_cod_banco">{{ $boleto->dados["codigo_banco_com_dv"]}}</div>
			</td>
			<td class="linha_digitavel">{{ $boleto->dados["linha_digitavel"]}}</td>
		</tr>
		</tbody>
		</table>

		<table class="line" cellspacing="0" cellpadding="0">
		<tbody>
		<tr class="titulos">
			<td class="cedente">Beneficiário</TD>
			<td class="ag_cod_cedente">Ag&ecirc;ncia / C&oacute;digo do Beneficiário</td>
			<td class="especie">Esp&eacute;cie</TD>
			<td class="qtd">Quantidade</TD>
			<td class="nosso_numero">Nosso n&uacute;mero</td>
		</tr>

		<tr class="campos">
			<td class="cedente">{{ $boleto->dados["cedente"]}}&nbsp;</td>
			<td class="ag_cod_cedente">{{ $boleto->dados["agencia_codigo"]}} &nbsp;</td>
			<td class="especie">{{ $boleto->dados["especie"]}}&nbsp;</td>
			<TD class="qtd">{{ $boleto->dados["quantidade"]}}&nbsp;</td>
			<TD class="nosso_numero">{{ $boleto->dados["nosso_numero"]}}&nbsp;</td>
		</tr>
		</tbody>
		</table>

		<table class="line" cellspacing="0" cellPadding="0">
		<tbody>
		<tr class="titulos">
			<td class="num_doc">N&uacute;mero do documento</td>
			<td class="contrato">Aluno</TD>
			<td class="cpf_cei_cnpj">CNPJ</TD>
			<td class="vencmento">Vencimento</TD>
			<td class="valor_doc">Valor documento</TD>
		</tr>
		<tr class="campos">
			<td class="num_doc">{{ $boleto->dados["numero_documento"]}}</td>
			<td class="contrato">{{ $boleto->dados["cpf_sacado"]}}</td>
			<td class="cpf_cei_cnpj">{{ $boleto->dados["cpf_cnpj"]}}</td>
			<td class="vencimento">{{ $boleto->dados["data_vencimento"]}}</td>
			<td class="valor_doc">{{ $boleto->dados["valor_boleto"]}}</td>
		</tr>
      </tbody>
      </table>

		<table class="line" cellspacing="0" cellPadding="0">
		<tbody>
		<tr class="titulos">
			<td class="desconto">(-) Desconto / Abatimento</td>
			<td class="outras_deducoes">(-) Outras dedu&ccedil;&otilde;es</td>
			<td class="mora_multa">(+) Mora / Multa</td>
			<td class="outros_acrescimos">(+) Outros acr&eacute;scimos</td>
			<td class="valor_cobrado">(=) Valor cobrado</td>
		</tr>
		<tr class="campos">
			<td class="desconto">&nbsp;</td>
			<td class="outras_deducoes">&nbsp;</td>
			<td class="mora_multa">&nbsp;</td>
			<td class="outros_acrescimos">&nbsp;</td>
			<td class="valor_cobrado">{{$boleto->valor_cobrado}}</td>
		</tr>
		</tbody>
		</table>

      
		<table class="line " cellspacing="0" cellpadding="0">	
		<tbody>
		<tr class="titulos">
			<td class="sacado">Referência</td>
		</tr>
		<tr class="campos referencia">
			<td valign="top" class="sacado">
				
		@foreach($lancamentos as $lancamento)
		{{ $lancamento->referencia}} - R$ {{ $lancamento->valor}}
		<BR>
		
		@endforeach
		</td>
		</tr>
		</tbody>
		</table>

		
		<div class="cut">
			<p>dobre na linha pontilhada</p>
		</div>


		<table class="header" border=0 cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
			<td width=150><IMG SRC="{{asset('img/logobb.gif')}}" with="150px" height="40"></td>
			<td width=50>
        <div class="field_cod_banco">{{ $boleto->dados["codigo_banco_com_dv"]}}</div>
			</td>
			<td class="linha_digitavel">{{ $boleto->dados["linha_digitavel"]}}</td>
		</tr>
		</tbody>
		</table>

		<table class="line" cellspacing="0" cellpadding="0">
		<tbody>
		<tr class="titulos">
			<td class="local_pagto">Local de pagamento</td>
			<td class="vencimento2">Vencimento</td>
		</tr>
		<tr class="campos">
			<td class="local_pagto">QUALQUER BANCO AT&Eacute; O VENCIMENTO</td>
			<td class="vencimento2">{{ $boleto->dados["data_vencimento"]}}</td>
		</tr>
		</tbody>
		</table>
		
		<table class="line" cellspacing="0" cellpadding="0">
		<tbody>
		<tr class="titulos">
			<td class="cedente2">Cedente</td>
			<td class="ag_cod_cedente2">Ag&ecirc;ncia/C&oacute;digo cedente</td>
		</tr>
		<tr class="campos">
			<td class="cedente2">{{ $boleto->dados["cedente"]}}</td>
			<td class="ag_cod_cedente2">{{ $boleto->dados["agencia_codigo"]}}</td>
		</tr>
		</tbody>
		</table>

		<table class="line" cellspacing="0" cellpadding="0">
		<tbody>
		<tr class="titulos">
			<td class="data_doc">Data do documento</td>
			<td class="num_doc2">No. documento</td>
			<td class="especie_doc">Esp&eacute;cie doc.</td>
			<td class="aceite">Aceite</td>
			<td class="data_process">Data process.</td>
			<td class="nosso_numero2">Nosso n&uacute;mero</td>
		</tr>
		<tr class="campos">
			<td class="data_doc">{{ $boleto->dados["data_documento"]}}</td>
			<td class="num_doc2">{{ $boleto->dados["numero_documento"]}}</td>
			<td class="especie_doc">{{ $boleto->dados["especie_doc"]}}</td>
			<td class="aceite">{{ $boleto->dados["aceite"]}}</td>
			<td class="data_process">{{ $boleto->dados["data_processamento"]}}</td>
			<td class="nosso_numero2">{{ $boleto->dados["nosso_numero"]}}</td>
		</tr>
		</tbody>
		</table>

		<table class="line" cellspacing="0" cellPadding="0">
		<tbody>
		<tr class="titulos">
			<td class="reservado">Uso do  banco</td>
			<td class="carteira">Carteira</td>
			<td class="especie2">Espécie</td>
			<td class="qtd2">Quantidade</td>
			<td class="xvalor">x Valor</td>
			<td class="valor_doc2">(=) Valor documento</td>
		</tr>
		<tr class="campos">
			<td class="reservado">&nbsp;</td>
			<td class="carteira">{{ $boleto->dados["carteira"]}} {{ isset($boleto->dados["variacao_carteira"]) ? $boleto->dados["variacao_carteira"] : '&nbsp;' }}</td>
			<td class="especie2">{{ $boleto->dados["especie"]}}</td>
			<td class="qtd2">{{ $boleto->dados["quantidade"]}}</td>
			<td class="xvalor">{{ $boleto->dados["valor_unitario"]}}</td>
			<td class="valor_doc2">{{ $boleto->dados["valor_boleto"]}}</td>
		</tr>
		</tbody>
		</table>
		
		
		<table class="line" cellspacing="0" cellpadding="0">
		<tbody>
		<tr><td class="last_line" rowspan="6">
			<table class="line" cellspacing="0" cellpadding="0">
			<tbody>
			<tr class="titulos">
				<td class="instrucoes">
						Instru&ccedil;&otilde;es (Texto de responsabilidade do cedente)
				</td>
			</tr>
			<tr class="campos">
				<td class="instrucoes" rowspan="5">
					<p>{{ $boleto->dados["demonstrativo1"] }}</p>		
					<p>{{ $boleto->dados["demonstrativo2"]}}</p>
					<p>{{ $boleto->dados["demonstrativo3"] }}</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>{{ $boleto->dados["instrucoes1"] }}</p>
					<p>{{ $boleto->dados["instrucoes2"] }}</p>
					<p>{{ $boleto->dados["instrucoes3"] }}</p>
					<p>{{ $boleto->dados["instrucoes4"] }}</p>
				</td>
			</tr>
			</tbody>
			</table>
		</td></tr>
		
		<tr><td>
			<table class="line" cellspacing="0" cellpadding="0">
			<tbody>
			<tr class="titulos">
				<td class="desconto2">(-) Desconto / Abatimento</td>
			</tr>
			<tr class="campos">
				<td class="desconto2">&nbsp;</td>
			</tr>
			</tbody>
			</table>
		</td></tr>
		
		<tr><td>
			<table class="line" cellspacing="0" cellpadding="0">
			<tbody>
			<tr class="titulos">
				<td class="outras_deducoes2">(-) Outras dedu&ccedil;&otilde;es</td>
			</tr>
			<tr class="campos">
				<td class="outras_deducoes2">&nbsp;</td>
			</tr>
			</tbody>
			</table>
		</td></tr>

		<tr><td>
			<table class="line" cellspacing="0" cellpadding="0">
			<tbody>
			<tr class="titulos">
				<td class="mora_multa2">(+) Mora / Multa</td>
			</tr>
			<tr class="campos">
				<td class="mora_multa2">&nbsp;</td>
			</tr>
			</tbody>
			</table>
		</td></tr>

		<tr><td>
			<table class="line" cellspacing="0" cellpadding="0">
			<tbody>
			<tr class="titulos">
				<td class="outros_acrescimos2">(+) Outros Acr&eacute;scimos</td>
			</tr>
			<tr class="campos">
				<td class="outros_acrescimos2">&nbsp;</td>
			</tr>
			</tbody>
			</table>
		</td></tr>

		<tr><td class="last_line">
			<table class="line" cellspacing="0" cellpadding="0">
			<tbody>
			<tr class="titulos">
				<td class="valor_cobrado2">(=) Valor cobrado</td>
			</tr>
			<tr class="campos">
				<td class="valor_cobrado2">{{$boleto->valor_cobrado}}</td>
			</tr>
			</tbody>
			</table>
		</td></tr>
		</tbody>
		</table>
		
		
				
	    <table cellspacing=0 cellpadding=0 width=666 border=0>
	    	<TBODY>
	    		<TR>
	    			<TD width=666 align=right >
	    				<font style="font-size: 10px;">Autentica&ccedil;&atilde;o mec&acirc;nica - Ficha de Compensação</font>
	    			</TD>
	    		</tr>
	    	</tbody>
	    
	   	</table>
	   <div class="barcode">
			<img src="{{asset('img/barcode.php').'?code='. $boleto->dados["codigo_barras"]}}"  with="600" height="50">		
		</div>
	   	<div class="cut">
			<p>dobre na linha pontilhada</p>
		</div>
		<br>
		<div id="instr_content">
			<p>
				O pagamento deste boleto tamb&eacute;m poder&aacute; ser efetuado 
				nos terminais de Auto-Atendimento BB.
			</p>
			
			<h2>Observações:</h2>
			<ol>
			<li>
				Em caso de desistência é obrigatório o preenchimento do Pedido de Cancelamento na secretaria da FESC.
			</li>
			<li>
				Aos servidores públicos municipais da ativa, apresentar holerite atualizado no ato da matrícula.
			</li>
		
			</ol>	
			

		</div>	<!-- id="instr_content" -->
	</div>	<!-- id="instructions" -->
		<br><br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
	

		
		<table class="line" cellspacing="0" cellPadding="0">
		<tbody>
		<tr class="titulos">
			<td class="sacado2">Pagador</td>
		</tr>
		<tr class="campos">
			<td class="sacado2" style="margin-top: 18em; margin-left:150px; font-family: Tahoma;" >
				<p style="font-size: 20px;">{{ $boleto->dados["sacado"]}}</p>
				<p>{{ $boleto->dados["endereco1"]}}</p>
				<p>{{ $boleto->dados["endereco2"]}}</p>
				
			</td>
		</tr>
		</tbody>
		</table>


	</div>

</div>


</body>

</html>
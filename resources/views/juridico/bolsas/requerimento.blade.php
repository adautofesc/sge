<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/')}}/css/vendor.css"/>
<title>Requerimento de Bolsa de Estudo / Concessão de desconto - Fesc</title>
<style type="text/css">
	h5{
		font-size: 20px;
		margin: 0 0 0 0;
	}
	table tr td{
		border: solid 1px black;
		text-align: center;
		font-size: 12px;
	}
	@media screen,print {

       
            .hide-onprint { 
                display: none;
            }
        }
</style>
</head>

<body>
	<div class="container">
		<div class="row" style="margin-bottom: 0;">
			<div class="col-xs-2" tyle="margin-bottom: 0;">
				<img src="{{asset('/')}}/img/logofesc.png" width="80"/>
			</div>
			<div class="col-xs-8" tyle="margin-bottom: 0;">
				<p>
					<small><small>
						<strong>
						FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong><br/>
						Rua São Sebastião, 2828, Vila Nery <br/>
						São Carlos - SP. CEP 13560-230<br/>
						Tel.: (16) 3372-1308 e 3372-1325
					</small></small>
				</p>
			</div>
			<div class="col-2" tyle="margin-bottom: 0;">
				<img src="/img/code39.php?code=RD{{$bolsa->id}}">
			
			</div>

			
		</div>
	
		<div class="title-block">
			<center>
            <h5> Requerimento de Bolsa de Estudo / Concessão de Desconto</h5></center>
        </div>


        <div class="row">
        	<div class="col-xs-12">
		       <div style="border: solid 1px black; padding: 10px 10px 10px 10px"> 
		       	<small>
	        	<strong>Dados Pessoais:</strong> <br>
	        	<strong>Nome: </strong> {{$pessoa->nome}} <strong>Cód.: </strong> {{$pessoa->id}} <br>
	        	<strong>Endereço: </strong> {{$pessoa->logradouro}} {{$pessoa->end_numero}}, {{$pessoa->end_complemento}} <strong>Bairro: </strong> {{$pessoa->bairro}} <strong>Telefone: </strong> {{$pessoa->telefone}} {{$pessoa->celular}}<br>
	        	<strong>RG: </strong> {{$pessoa->rg}} <strong>CPF: </strong> {{$pessoa->cpf}} <strong>Nascimento: </strong> {{$pessoa->nascimento}} <strong>Idade: </strong> {{$pessoa->idade}} anos<br><br>
	        	<strong>Requisita Bolsa / desconto na matrícula:</strong> {{$bolsa->matriculas->implode('matricula',', ')}} <strong>&nbsp;&nbsp;Pedido:</strong> {{$bolsa->id}}<br>
	        	<strong>Curso(s):</strong>
	        		<br>
	        		<ul>
	        			@foreach($bolsa->matriculas as $bolsa_matricula)
	        				<li> <strong>{{$bolsa->getNomeCurso($bolsa_matricula->matricula)}}</strong></li>
	        			@endforeach
	        		</ul>
	        		@if($bolsa->rematricula == '1')
	        		Rematrícula:</strong> (X) sim  (&nbsp;&nbsp;) não</small>
	        		@else
	        		Rematrícula:</strong> (&nbsp;&nbsp;) sim  (X) não</small>
	        		@endif
		       </div><br>
		       <p style="border: solid 1px black; padding: 10px 10px 10px 10px"> 
	        	<small>
	        	Venho pelo presente, requerer a concessão de desconto para frequência ao curso supra indicado por:<br>
	        	<strong>{{$bolsa->desconto_str->descricao}}</strong>
	        	</small>
		       </p>
		       <!--
		       <table width="100%">
		       		<tr>
						<td colspan="5" style="text-align: left; padding-left: 10px;">Caso assinalado item 1, preencher os campos abaixo com os dados dos dependentes:</td>
					</tr>
					<tr>
						<td width="3%">Nº</td><td>	Nome</td><td width="20%">	Parentesco</td><td width="20%">	Documento</td>
					</tr>
					<tr>
						<td>1</td><td>	&nbsp;</td><td>	&nbsp;</td><td>	&nbsp;</td>
					</tr>
					<tr>
						<td>2</td><td>	&nbsp;</td><td>	&nbsp;</td><td>&nbsp;</td>
					</tr>
					<tr>
						<td>3</td><td>	&nbsp;</td><td>	&nbsp;</td><td>	&nbsp;</td>
					</tr>
					
		       </table><br>-->
		       
		       <p style="border: solid 1px black; padding: 10px 10px 10px 10px;" align="justify" > 
	        	<small>
	        	Quantidade de folhas entregues:___<br>
	        	Declaro estar ciente que a documentação entregue não é analisada no ato da entrega do requerimento e que a falta de qualquer documento acarretará no indeferimento do pedido.
	        	Declaro também estar ciente de todas as informações constantes na portaria vigente que regulamenta as bolsas de estudos nesta instituição.<br>
	        	Nestes termos, sendo a expressão da verdadem peço deferimento.<br>
	        	<span align="center">São Carlos, {{$hoje}}.<br><br>

	        	_____________________________<br>
	        	Assinatura</span>


	        	</small>
		       </p>
		       <p style="border: solid 1px black; padding: 10px 10px 10px 10px;"> 
	        	<small>
	        	<strong>Protocolo de recebimento</strong> <br>

	        	Recebemos e registramos a solicitação de bolsa sobre o número {{$bolsa->id}} contendo ___ páginas. <br>
	        	
	        	São Carlos, {{$hoje}}.<br><br>

	        	________________________ <br>
	        	{{Session::get('nome_usuario')}} - Servidor FESC


	        	</small>
		       </p>
	
        	</div>
        </div>
        <div style="page-break-before: always;"> </div>
        <div class="row" style="margin-bottom: 0;">
			<div class="col-xs-2" tyle="margin-bottom: 0;">
				<img src="{{asset('/')}}/img/logofesc.png" width="80"/>
			</div>
			<div class="col-xs-8" tyle="margin-bottom: 0;">
				<p>
					<small><small>
						<strong>
						FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong><br/>
						Rua São Sebastião, 2828, Vila Nery <br/>
						São Carlos - SP. CEP 13560-230<br/>
						Tel.: (16) 3372-1308 e 3372-1325
					</small></small>
				</p>
			</div>
			<div class="col-2" tyle="margin-bottom: 0;">
			<img src="/img/code39.php?code=PA{{$bolsa->id}}">
			</div>

			
		</div>

		<br/>
		<div class="title-block">
			<center>
            <h5> Parecer sobre solicitação de Bolsa / concessão de desconto.</h5></center>
        </div>
        <br/>

        <div class="row">
        	<div class="col-xs-12">
	        	
	        	
	        	<table width="100%">
		       		<tr>
						<td colspan="5" style="text-align: left; padding-left: 10px;">
	        				<strong>AVALIAÇÃO SOCIOECONÔMICA</strong> 
	        			</td>
					</tr>
					<tr>
						<td width="50%">Total de Renda Bruta Familiar</td><td>	&nbsp;</td>
					</tr>
					<tr>
						<td>Número Total de Membros no Grupo Familiar</td><td>	&nbsp;</td>
					</tr>
					<tr>
						<td>Renda Per Capita Obtida</td><td>	&nbsp;</td>
					</tr>
					
		       </table>
	        	
	        </div>
	    </div>
	    <br>
	    <div class="row">
        	<div class="col-xs-12">
	        	
	        	
	        	<table width="100%">
		       		<tr>
						<td colspan="5" style="text-align: left; padding-left: 10px;">
	        				<strong>ANÁLISE DA SOLICITAÇÃO</strong> 
	        			</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					
		       </table>
		       <BR>
		       <p style="border: solid 1px black; padding: 10px 10px 10px 10px"> 
		        <strong>ATRAVÉS DOS PONTOS ABORDADOS ACIMA, CONSIDERAMOS A SOLICITAÇÃO:</strong><br><br>
		        <small>
			        (&nbsp;&nbsp;) INDEFIRIDA <br>
			        (&nbsp;&nbsp;) APTA À BOLSA INTEGRAL <br>
			        (&nbsp;&nbsp;) APTA À BOLSA PARCIAL <br>
		    	</small>
		    	
		    	<br>
		    	<p align="center"> 
		    	<br><br><br><br><br><br>
		    	_____________ _____________ _____________ _____________ _____________<br>
		    	<small>Membros da Comissão de Avaliação de Bolsas<br><br>
		    	São Carlos, {{$hoje}}.</small>
		    	</p>

		       </p>
	        	
	        </div>
	    </div>

	</div>

	</div>

        	
	<script src="{{asset('/')}}/js/vendor.js">
	</script>
</body>

</html>

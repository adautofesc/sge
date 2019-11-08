<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/')}}/css/vendor.css"/>
<title>Carta de cobrança</title>
<style>
	.correio{
		margin-top:30rem;
	}
	.verso{
		margin-top:15rem;
	}
	.cabecalho{
		line-height: 0.9rem;
		margin-left:-4rem;
	}
	.texto{
		text-indent: 4em;
		text-align: justify;
	}
	.data{
		
		text-align: right;
	}
	.header{
		font-size: 14pt;

	}
	.espacamento{
		margin-top:5rem;
	}
	.centraliza{
		text-align: center;
	}
	.borda{
		border: 1px solid black;
	}

	.quadrados{
		list-style-image: url('{{asset('/img/square.png')}}')
		
	}
	
</style>
</head>

<body>
	@foreach($devedores as $devedor)
	<div class="container correio" style="width:50rem;page-break-after:always;">
		
			<div class="row">
				<div class="col-xs-10">
				<img src="{{asset('/')}}/img/logofesc.png" width="100px" />
				</div>
				
				<div class="col-xs-2 centraliza" >
						<img src="{{asset('/img/carimbo_fesc_carta.png')}}" alt="carimbo fesc" width="120px;">
						<br> {{date('d/m/Y')}}
					
				</div>
				
			</div>
			<div class="row">
					<div class="col-xs-12 header">
					A/C: <strong>{{strtoupper($devedor->nome)}}</strong><br>
						{{$devedor->endereco->logradouro}}, {{$devedor->endereco->numero}}, {{$devedor->endereco->complemento}}<br>
						{{$devedor->endereco->getBairro()}}, {{$devedor->endereco->cidade}} - {{$devedor->endereco->estado}}<br>
						CEP {{$devedor->endereco->cep}}
					</div>
			</div>

			<div class="row verso">
					<div class="col-xs-2">
					<img src="{{asset('/')}}/img/logofesc.png" width="80" />
					</div>
					<div class="col-xs-8">
					<p>
					<strong>FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong><br/>
					Rua São Sebastião, 2828, Vila Nery <br/>
					São Carlos - SP. CEP 13560-230<br/>
					Tel.: (16) 3372-1308 e 3372-1325
					</p>
					</div>
					<div class="col-xs-2">
						WWW.FESC.COM.BR
					</div>
					
				</div>
				<div class="row espacamento">
						<div class="col-xs-12"><!--
								<table style="height: 150px;" width="767" class="borda">
										<tbody>
										<tr style="height: 18px;">
										<td style="width: 757px; text-align: center; height: 18px;" colspan="3" class="borda"><em><strong>Para uso dos correios</strong></em></td>
										</tr>
										<tr style="height: 19.5px;">
										<td style="width: 248px; height: 115px;" rowspan="4">
										<ul class="quadrados">
										<li >01 - Mudou-se</li>
										<li>02 - Endere&ccedil;o Insuficiente</li>
										<li>03 - N&atilde;o existe o n&ordm; indicado</li>
										<li>04 - Falecido</li>
										<li>05 - Desconhecido</li>
										<li>06 - Recusado</li>
										</ul>
										</td>
										<td style="width: 249px; height: 113.5px;" rowspan="4">
										<ul class="quadrados">
										<li>07 - Ausente</li>
										<li>08 - N&atilde;o Procurado</li>
										<li>10 - Objeto danificado</li>
										<li>11 - Ed. Desconhecido na localidade</li>
										<li>12 - Falta Complemento</li>
										<li>13 - Caixa Postal Cancelada</li>
										</ul>
										</td>
										<td style="width: 248px; text-align: center; height: 19.5px;">Reintegrado ao servi&ccedil;o postal em:</td>
										</tr>
										<tr style="height: 31px;">
										<td style="width: 248px; text-align: center; height: 31px;">____/_____/_____</td>
										</tr>
										<tr style="height: 31px;">
										<td style="width: 248px; text-align: center; height: 31px;"><small>&nbsp;R&uacute;brica do respons&aacute;vel</small></td>
										</tr>
										<tr style="height: 32px;">
										<td style="width: 248px; text-align: center; height: 32px;">Matr&iacute;cula______________&nbsp;</td>
										</tr>
										</tbody>
										</table>-->
										<img src="{{asset('/img/pcorreios.png')}}" width="400">
						</div>
				</div>
			
	</div>
	<div class="container" style="width:50rem;page-break-after:always;">
		
		<div class="row">
			<div class="col-xs-2">
			<img src="{{asset('/')}}/img/logofesc.png" width="50" />
			</div>
			<div class="col-xs-9">
			<p class="cabecalho"><small>
			<strong>FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong><br/>
			Rua São Sebastião, 2828, Vila Nery <br/>
			São Carlos - SP. CEP 13560-230<br/>
			Tel.: (16) 3372-1308 e 3372-1325</small>
			</p>
			</div>
			<div class="col-xs-1">
					<strong>DAE/FESC</strong>
			</div>
			
		</div>
        <div class="row header">
        	<div class="col-xs-12">
	        	<p class="data espacamento" style=""> 
	        	São Carlos, {{date('d')}} de {{ (new \App\classes\Data())->mes()}} de {{date('Y')}}
				</p>
				<p class="texto espacamento">
					Prezado(a) Senhor(a) <strong>{{strtoupper($devedor->nome)}}</strong>
				</p>
				<p class="texto">
					Informamos que, de acordo com os registros da Secretaria Escolar da Fundação Educacional São Carlos, consta, em seu nome, o(s) débito(s) abaixo relacionado(s):
				</p>
				<table class="table table-sm table-bordered ">
					<thead class="thead-default">
						<th>Referencia</th>
					</thead>
					
					@foreach($devedor->pendencias as $pendencia)
					<tr>
						<td>
							{{$pendencia}}
						</td>
					
					</tr>
				@endforeach
					
				
				</table>
				
				<p class="texto">
						Totalizando o valor de <strong>R$ {{number_format($devedor->divida,2,',','.')}}</strong>. Não incluindo multas e juros.
				</p>
				<p class="texto">
						Caso já tenha efetuado o pagamento, pedimos desculpas pelo transtorno e solicitamos que apresente o(s) comprovante(s) na Secretaria Escolar da Fundação Educacional São Carlos, para que possamos regularizar sua situação.
				</p>
				<p class="texto">
						Ressaltamos que o não atendimento da presente comunicação poderá <strong>acarretar na inscrição do(s) débito(s) pendente(s) na Dívida Ativa da Fundação Educacional São Carlos</strong>, com a consequente cobrança mediante procedimento administrativo e, se necessário, judicial.
				</p>
				<p class="centraliza espacamento">
					Atenciosamente <br>
					<img src="{{asset('/img/Assintura_Reginaldo.jpg')}}" alt="assinatura" width="100px" ><br>
					<small>Reginaldo de Godoy<br>
					Contador</small>
					
				</p>


		    
		       
        	</div>
	        
		</div>
		
  
	</div>
	@endforeach
        	
	<script src="{{asset('/')}}/js/vendor.js">
	</script>
</body>

</html>

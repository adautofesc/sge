<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/')}}/css/vendor.css"/>
<title>Documento Oficial - Fesc</title>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-2">
			<img src="{{asset('/')}}/img/logofesc.png" width="100"/>
			</div>
			<div class="col-xs-10">
			<p>
			<strong>FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong><br/>
			Rua São Sebastião, 2828, Vila Nery <br/>
			São Carlos - SP. CEP 13560-230<br/>
			Tel.: (16) 3372-1308 e 3372-1325
			</p>
			</div>
			
		</div>
		<br/>
		<div class="title-block">
			<center>
            <h3 class="title"> Relatório de Boletos Vencidos</h3></center>
        </div>
        <br/>
        <div class="row">
        	<div class="col-xs-12">
	        	<p> 
	        	Relação de <strong>{{count($boletos)}}</strong> boletos vencidos não pagos até a data de <strong>{{date('d/m/Y - H:i')}}</strong>
		       </p>
		    
		       <table>
		       	<thead>
		       		<th width="100px">Boleto</th>	
		       		<th width="120px">Vencimento </th>
		       		<th>Cod.</th>
		       		<th>Nome da pessoa</th>
		       		<th>valor</th>
		       	</thead>
		       	<tbody>
		       		@foreach($boletos as $boleto)
		       		<tr>
		       			<td>{{$boleto->id}}</td>
		       			<td>{{\Carbon\Carbon::parse($boleto->vencimento)->format('d/m/Y')}}</td>
		       			<td><a href="{{asset('/secretaria/atender').'/'.$boleto->aluno->id}}">{{$boleto->aluno->id}}</a></td>
		       			<td>{{$boleto->aluno->nome}}</td>
		       			<td>R$ {{number_format($boleto->valor, 2, ',', '')}}</td>
		       		</tr>
		       		@endforeach
		       	</tbody>
        	</div>
	        
        </div>
  
	</div>
        	
	<script src="{{asset('/')}}/js/vendor.js">
	</script>
</body>

</html>
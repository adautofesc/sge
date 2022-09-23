<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
<title>Documento Oficial - Fesc</title>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-2">
			<img src="{{asset('/img/logofesc.png')}}" width="100"/>
			</div>
			<div class="col-xs-10">
			<p>
			<strong>FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong><br/>
			Rua São Sebastião, 2828, Vila Nery <br/>
			São Carlos - SP. CEP 13560-230<br/>
			Tel.: (16) 3362-0580 e 3362-0581
			</p>
			</div>
			
		</div>
		<br/>
		<div class="title-block">
			<center>
			
            <h3 class="title"> Relatório de Matrículas por programa</h3></center>
           
        </div>
        <br/>
        <div class="row">
        	<div class="col-xs-12">
	        	<p> 
	        	Relação de matrículas por programa no ano de <strong>{{$ano}}</strong>
		       </p>
		    
		       <table class="table">
		       	<thead>
		       		<th width="100px">Programa</th>	
		       		<th width="120px">Matriculas</th>
		       		
		       	</thead>
		       	<tbody>
		       		@foreach($programas as $programa)
		       		<tr>
		       			<td>{{$programa->nome}}</td>
		       			<td>{{count($matriculas[$programa->id])}}</td>
		       			
		       		</tr>
					   @endforeach
					<tr>
						<td><strong>Total</strong></td>
					<td><strong>{{$total}}</strong></td>
						
					</tr>
					   
		       	</tbody>
        	</div>
	        
        </div>
  
	</div>
        	
	<script src="{{asset('/js/vendor.js')}}">
	</script>
</body>

</html>

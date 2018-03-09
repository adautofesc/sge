<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="{{ asset('css/vendor.css')}}">
	<title>Consulta OnLine de Boletos</title>
</head>
<body>
	<div class="jumbotron">
	  <h1>Meu Boleto</h1>
	  <p>...</p>
	  <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
	</div>
	<h3> Imprima aqui a segunda via de seu boleto </h3>
	<form method="POST">
		{{csrf_field()}}
		<div class="input-group">
		  <label class="col-sm-2 form-control-label text-xs-right">CPF</label>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
		</div>
	
	<button type="submit">Acessar</button>
</body>
</html>
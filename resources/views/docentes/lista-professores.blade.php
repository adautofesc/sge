<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="{{ asset('css/vendor.css')}}">
	<title>SGE - Turmas do Professor</title>
</head>
<body>
	<h3> Lista de turmas por professor. </h3>
	<form method="POST">
		{{csrf_field()}}
	<select name="professor" required>
		<option>Selecione um professor</option>
		@if(isset($professores))
		@foreach($professores as $professor)
		<option value="{{$professor->id}}">{{$professor->nome}}</option>
		@endforeach
		@endif
	</select>
	<button type="submit">Acessar</button>
</body>
</html>
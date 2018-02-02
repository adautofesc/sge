<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="{{ asset('css/vendor.css')}}">
	<title>SGE - Turmas Disponíveis</title>
</head>
<body>
	<h3> Turmas disponíveis para 1º semestre de 2018 </h3>
	@if(isset($professor))
		<h4> Prof. {{$professor}} </h4>
	@endif
	<ol>
		@foreach($turmas as $turma)
		<li> {{$turma->curso->nome}} -
		@if(isset($turma->disciplina->nome)) 
			{{$turma->disciplina->nome}}  
		@endif
		dias: {{implode(', ',$turma->dias_semana)}} - 
		das {{$turma->hora_inicio}} às {{$turma->hora_termino}} Local: 
		{{$turma->local->sigla}} Cod.({{$turma->id}}). Prof.{{$turma->professor->nome_simples}} - {{$turma->vagas}} Vagas

		</li>
		@endforeach
	</ol>

</body>
</html>
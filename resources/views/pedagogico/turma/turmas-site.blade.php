<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="{{ asset('css/vendor.css')}}">
	<title>SGE - Turmas Disponíveis</title>
</head>
<body>
	<h3> Turmas disponíveis para 1º semestre de 2018 </h3>
	<br>
	<h5>Novas matrículas podem ser efetuadas a partir de 20/02.</h5>
	<br>
	@if(isset($professor))
		<h4> Prof. {{$professor}} </h4>
	@endif
	<table class="table table-striped">
		<thead>
			<th scope="col">#</th>
			<th scope="col">Turma</th>
			<th scope="col-xs-1 col-sm-1 col-md-1 col-lg-1"">Curso/Disciplina</th>
			<th scope="col">Dia(s)</th>
			<th scope="col">Horários</th>
			<th scope="col">Professor</th>
			<th scope="col">Local</th>
			<th scope="col">Vagas</th>
			<th scope="col">Restam</th>
		</thead>
		<tbody>
			@php $i=0
			@endphp
			@foreach($turmas as $turma)
			@php $i++
			@endphp
			 <tr>
			 	<td>{{$i}}</td>
			 	<td>{{$turma->id}}</td>
			 	<td>
			 		{{$turma->curso->nome}} 
			@if(isset($turma->disciplina->nome)) 
				- {{$turma->disciplina->nome}}
			@endif
			 	</td>
			 	<td>{{implode(', ',$turma->dias_semana)}}</td>
			 	<td>{{$turma->hora_inicio}} às {{$turma->hora_termino}}</td>
			 	<td>Prof. {{$turma->professor->nome_simples}}</td>
			 	<td>{{$turma->local->sigla}}</td>
			 	<td>{{$turma->vagas}}</td>
			 	<td>
			 		@if($turma->vagas-$turma->matriculados<0)
			 			0
			 		@else
			 			{{$turma->vagas-$turma->matriculados}}
			 		@endif


			 		</td>
			 	
			 </tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>
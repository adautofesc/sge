<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="{{ asset('css/vendor.css')}}">
	<title>FESC - Turmas Disponíveis</title>
</head>
<body>
<h3> {{count($turmas)}} Turmas com vagas disponíveis</h3>
	


	<p class="small">Consultado em {{date('d/m/Y H:i')}}. 
		Turmas UATI para pessoas a partir de 40 anos. 
		EMG somente para funcionários públicos municipais.</p>
	
	@if(isset($professor))
		<h4> Prof. {{$professor}} </h4>
	@endif
	<table class="table table-striped table-condensed">
		<thead>
		
			<th scope="col">Turma</th>
			<th scope="col-xs-1 col-sm-1 col-md-1 col-lg-1"">Curso/Disciplina</th>
			<th scope="col">Programa</th>
			<th scope="col">Dia(s)</th>
			<th scope="col">Horários</th>
			<th scope="col">Professor</th>
			<th scope="col">Local</th>
			<th scope="col">Vagas</th>
			<th scope="col">Restam</th>
		</thead>
		<tbody>
			
			@foreach($turmas as $turma)
			@if($turma->vagas-$turma->matriculados>0)
		
			
			 <tr>
			 	
			 	<td>{{$turma->id}}</td>
				 <td>{{$turma->nome_curso}}</td>
				 <td>{{$turma->programa->sigla}}</td>
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
			@endif
			@endforeach
		</tbody>
	</table>

</body>
</html>
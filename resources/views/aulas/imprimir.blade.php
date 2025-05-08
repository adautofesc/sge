<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
<title>Relatório de conteúdosde turma</title>
<style type="text/css">
	label{
		font-weight: bold;
		
	
	}
	table th{
		text-align: right;
	}
	@media print {
            .hide-onprint { 
                display: none;
            }

			.folha {
				page-break-after: always;
			}
            
		  
        }


</style>
</head>

<body>
	@foreach($turmas as $turma)
	@php
	$i=1;
	@endphp
	<div class="container folha">
		<div class="row">
			<div class="col-xs-2 col-sm-2">
			<img src="{{asset('/img/logofesc.png')}}" width="80"/>
			</div>
			<div class="col-xs-10 col-sm-10">
             <small>   
			<p>
			<strong>FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong><br/>
			Rua São Sebastião, 2828, Vila Nery <br/>
			São Carlos - SP. CEP 13560-230<br/>
			Tel.: (16) 3362-0580 e 3362-0581
			</p>
        </small>
			</div>
			
		</div>
		<br/>
		<div class="title-block">
			<center>
            <h3 class="title"> Relatório de conteúdo</h3>
			<h5 class="title"><small>Turma {{$turma->id}} {{$turma->getNomeCurso()}}</small>
            </h5></center>
        </div>
		<br><br>
		
		<div class="row">
			<table class="table table-condensed table-sm">
				<tr>
					<td><strong>Aula</strong></td>
					<td><strong>Data</strong></td><td>
						<strong>Dado</strong></td>
					<td><strong>Conteúdo</strong></td>
				</tr>
				@foreach($conteudo->where('turma', $turma->id) as $cont)
				<tr>
					<td>{{$i++}}</td>
					<td>{{\App\classes\Data::converteParaUsuario($cont->data)}}</td>
					<td>{{$cont->dado}}</td>
					<td>{{$cont->valor}}</td>
				</tr>
				
				@endforeach
				
			</table>
		</div>
	</div>
	@endforeach
        
		
		
        

        	
	<script src="{{asset('/js/vendor.js')}}">
	</script>
</body>


</html>

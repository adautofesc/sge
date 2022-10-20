<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
<title>Ficha Técnica - impressão - SGE - Fesc</title>
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
	@foreach($fichas as $ficha)
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
            <h3 class="title"> Ficha Técnica {{$ficha->id}}</h3>
			<h5 class="title"><small>Estado: {{$ficha->status}}</small>
            </h5></center>
        </div>
		<br><br>
		<div class="row">
			<table class="table table-condensed table-sm">
				<tr>
					<th>Professor</th>
					<td>{{$ficha->getDocente();}}</td>
					<th>Programa</th>
					<td>{{$ficha->getPrograma()->nome}}</td>
				</tr>
				<tr>
					<th >Curso/atividade</th>
					<td colspan="3">{{$ficha->curso}} </td>
				</tr>
				<tr>
					<th >Objetivo</th>
					<td colspan="3">{{$ficha->objetivo}} </td>
				</tr>
				<tr>
					<th >Curso/atividade</th>
					<td colspan="3">{{$ficha->conteudo}} </td>
				</tr>
				<tr>
					<th >Requisitos</th>
					<td colspan="3">{{$ficha->requisitos}} </td>
				</tr>
				<tr>
					<th >Recursos necessários</th>
					<td colspan="3">{{$ficha->materiais}} </td>
				</tr>
				<tr>
					<th>Dias Semana</th>
					<td>{{$ficha->dias_semana}}</td>
					<th>Valor</th>
					<td>R$ {{$ficha->getValor()}}</td>
				</tr>
				<tr>
					<th>Início</th>
					<td>{{$ficha->data_inicio->format('d/m/y')}}</td>
					<th>Término</th>
					<td>{{$ficha->data_termino->format('d/m/y')}}</td>
				</tr>
				<tr>
					<th>Entrada</th>
					<td>{{$ficha->hora_inicio}}</td>
					<th>Saída</th>
					<td>{{$ficha->hora_termino}}</td>
				</tr>
				<tr>
					<th>Idade mínima</th>
					<td>{{$ficha->idade_minima}}</td>
					<th>Idade máxima</th>
					<td>{{$ficha->idade_maxima}}</td>
				</tr>
				<tr>
					<th>Lotação mínima</th>
					<td>{{$ficha->lotacao_minima}}</td>
					<th>Lotação máxima</th>
					<td>{{$ficha->lotacao_maxima}}</td>
				</tr>
				<tr>
					<th>Carga</th>
					<td>{{$ficha->carga}}</td>
					<th>Periodicidade</th>
					<td>{{$ficha->periodicidade}}</td>
				</tr>
				<tr>
					<th>Local</th>
					<td>{{$ficha->getLocal()}}</td>
					<th>Sala</th>
					<td>{{$ficha->getSala()}} </td>
				</tr>
				<tr>
					<th >Mais informações</th>
					<td colspan="3">{{$ficha->obs}} </td>
				</tr>
				
				
			</table>
		</div>
	</div>
	@endforeach
        
		
		
        

        	
	<script src="{{asset('/js/vendor.js')}}">
	</script>
</body>


</html>

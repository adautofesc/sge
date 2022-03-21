<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
<title>SGE - Relatório de jornada dos educadores - Fesc</title>
<style type="text/css">
	@media print {
            .hide-onprint { 
                display: none;
            }
             .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
        		float: left;
  				}
		   .col-sm-12 {
		        width: 100%;
		   }
		   .col-sm-11 {
		        width: 91.66666667%;
		   }
		   .col-sm-10 {
		        width: 83.33333333%;
		   }
		   .col-sm-9 {
		        width: 75%;
		   }
		   .col-sm-8 {
		        width: 66.66666667%;
		   }
		   .col-sm-7 {
		        width: 58.33333333%;
		   }
		   .col-sm-6 {
		        width: 50%;
		   }
		   .col-sm-5 {
		        width: 41.66666667%;
		   }
		   .col-sm-4 {
		        width: 33.33333333%;
		   }
		   .col-sm-3 {
		        width: 25%;
		   }
		   .col-sm-2 {
		        width: 16.66666667%;
		   }
		   .col-sm-1 {
		        width: 8.33333333%;
		   }
		   table{
				font-size: 11px;
			}
        }
.dropdown-menu li a{
	text-decoration: none;
	color:black;
	margin-left: 1rem;
	line-height: 2rem;
}

</style>
</head>

<body>
	<div class="container">
		<div class="row hide-onprint">
			<div class="col-xs-12" style="margin-top: 20px;margin-bottom: 50px;">
				<form class="inline-form" method="GET">
			</div>
		</div>
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
			Tel.: (16) 3372-1308 e 3372-1325
			</p>
        </small>
			</div>
			
		</div>
		<br/>
		<div class="title-block">
			<center>
            <h3 class="title"> Relatório de Jornada dos Educadores</h3>
			<h5 class="title"> Relatório geral 2022
				
            </h5></center>
        </div>
        <br>
        <br>
    
        <br/>
		@foreach($educadores as $educador)
        <div class="row">
            <div class="col-sm-12">
				
				<p><strong>{{$educador->nome}}: <small>{{$educador->carga}}h contratuais</small></strong></p>
                <table class="table table-striped table-condensed table-sm table-bordered">
					
                    <thead >
                        <th>&nbsp;</th>
						<th>Início</th>
						<th>Término</th>
						<th>Atividade</th>
						<th>Local</th>
						<th>Carga (h)</th>
                    </thead>
                    <tbody>
						@foreach($dias as $dia)
						<tr>
							@if(isset($educador->jornadas{$dia}))
							<td rowspan="{{count($educador->jornadas{$dia})+1}}">{{$dia}}</td>
							@else
							<td rowspan="2">{{$dia}}</td>
							@endif							
							<td>
								@if(isset($educador->jornadas{$dia}[0]))
									{{$educador->jornadas{$dia}[0]->inicio}}
								@endif
							</td>
							<td>
								@if(isset($educador->jornadas{$dia}))
									{{$educador->jornadas{$dia}{0}->termino}}
								@endif
							</td>
							<td>
								@if(isset($educador->jornadas{$dia}))
								{{$educador->jornadas{$dia}{0}->descricao}}</td>
								@else
								Sem atividades neste dia
								@endif
							</td>
							<td>
								@if(isset($educador->jornadas{$dia}))
									{{$educador->jornadas{$dia}{0}->local}}
								@endif
							</td>
							<td>
								@if(isset($educador->jornadas{$dia}))
								{{$educador->jornadas{$dia}{0}->carga}}</td>
								@endif
							@php
								if(isset($educador->jornadas{$dia}))
									$carga[$dia] = $educador->jornadas{$dia}{0}->carga;
								else
									$carga[$dia] = 0;
							@endphp
						</tr>
						@if(isset($educador->jornadas{$dia}))
						@for($i=1;$i<count($educador->jornadas{$dia});$i++)
						<tr>						
							<td>{{$educador->jornadas{$dia}{$i}->inicio}}</td>
							<td>{{$educador->jornadas{$dia}{$i}->termino}}</td>
							<td>{{$educador->jornadas{$dia}{$i}->descricao}}</td>
							<td>{{$educador->jornadas{$dia}{$i}->local}}</td>
							<td>{{$educador->jornadas{$dia}{$i}->carga}}</td>
							@php
								$carga{$dia} += $educador->jornadas{$dia}{$i}->carga;
							@endphp
						</tr>
						@endfor
						@endif

						<tr>
							<th colspan="4" align="right">Total/dia</th>
							<th>{{$carga[$dia]}}</th>
						</tr>
						@endforeach

						





						<tr>
							<th colspan="4">Horas efetivas totais</th>
							<th>{{$educador->carga_ativa->floatDiffInHours(\Carbon\Carbon::Today())}}</th>
						</tr>
						
                    	
                    	
                    	
                	</tbody>
                </table>
				
             </div>
        </div>
		@endforeach





		<div class="row">
            <div class="col-sm-12">
				<p><strong>Fulano : <small>40h contratuais</small></strong></p>
                <table class="table table-striped table-condensed table-sm table-bordered">
					
                    <thead >
                        <th>&nbsp;</th>
						<th>Início</th>
						<th>Término</th>
						<th>Atividade</th>
						<th>Carga (h)</th>
                    </thead>
                    <tbody>
						<tr>
							<td rowspan="3">Segunda</td>
							<td>08:00</td>
							<td>10:00</td>
							<td>Aula na turma 123</td>
							<td>2</td>
						</tr>
						<tr>
							
							<td>10:00</td>
							<td>12:00</td>
							<td>Aula na turma 123</td>
							<td>2</td>
						</tr>
						<tr>
							<th colspan="3" align="right">Total/dia</th>
							<th>4</th>
						</tr>

						<tr>
							<td rowspan="3">Terça</td>
							<td>08:00</td>
							<td>10:00</td>
							<td>Aula na turma 123</td>
							<td>2</td>
						</tr>
						<tr>
							
							<td>10:00</td>
							<td>12:00</td>
							<td>Aula na turma 123</td>
							<td>2</td>
						</tr>
						<tr>
							<th colspan="3" align="right">Total/dia</th>
							<th>4</th>
						</tr>
						<tr>
							<th colspan="4">Horas totais</th>
							<th>8</th>
						</tr>
						
                    	
                    	
                    	
                	</tbody>
                </table>
				
             </div>
        </div>
		
        

        	
	<script src="{{asset('js/vendor.js')}}">
	</script>
</body>
<script type="text/javascript">

</script>

</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
<title>SGE - Relatório de jornada por programa</title>
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
.posicao{	
	font-size: 11px;
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
            <h3 class="title"> Relatório de Jornada por Programa: {{strtoupper($programa)}}</h3>
			<h5 class="title"> Posição atual<br><br> <span class="posicao">emitido em {{date("d/m/Y H:i")}}</span>
				
            </h5></center>
        </div>
        <br>
        <br>
    
        <br/>
		@foreach($educadores as $educador)
        <div class="row">
            <div class="col-sm-12">
				
				<p><strong>{{$educador->nome}}: <small>{{$educador->carga}}h contratuais</small></strong></p>
                <table class="table table-condensed table-striped table-sm table-bordered">
					
                    <thead >
                        <th>Atividade </th>
						<th title="Vagas / Ocupação">Demanda</th>
						<th>Dias</th>
						<th>Início</th>
						<th>Termino</th>
						<th>Carga (h/s)</th>
						
                    </thead>
                    <tbody>
					
						@foreach($educador->turmas as $turma)
						<tr>
							<td>Turma {{$turma->id}} - {{$turma->curso->nome}}</td>
							<td>{{$turma->vagas}}/{{$turma->matriculados}}</td>
							<td>{{implode(', ',$turma->dias_semana)}}</td>				
							<td>{{$turma->hora_inicio}}</td>
							<td>{{$turma->hora_termino}}</td>
							<td>{{floor($turma->carga_semanal->floatDiffinMinutes(\Carbon\Carbon::Today())/60)}}:{{str_pad($turma->carga_semanal->floatDiffinMinutes(\Carbon\Carbon::Today())%60,2,'0',STR_PAD_LEFT)}}</td>
						</tr>
						@endforeach
						<tr>
							<th colspan="5">Carga total em aulas</th>
							<th>{{floor($educador->carga_aula->floatDiffinMinutes(\Carbon\Carbon::Today())/60)}}:{{str_pad($educador->carga_aula->floatDiffinMinutes(\Carbon\Carbon::Today())%60,2,'0',STR_PAD_LEFT)}}</th>
						</tr>

						@foreach($educador->jornadas as $jornada)
						<tr>
							<td colspan="2">{{$jornada->tipo}}</td>
							<td>{{implode(', ',$jornada->dias_semana)}}</td>
							<td>{{$jornada->hora_inicio}}</td>
							<td>{{$jornada->hora_termino}}</td>
							<td>{{floor($jornada->carga_semanal->floatDiffinMinutes(\Carbon\Carbon::Today())/60)}}:{{str_pad($jornada->carga_semanal->floatDiffinMinutes(\Carbon\Carbon::Today())%60,2,'0',STR_PAD_LEFT)}}</td>


						</tr>

						@endforeach		

						<tr>
							<th colspan="5">
								Jornada HTP: {{floor($educador->carga_htp->floatDiffinMinutes(\Carbon\Carbon::Today())/60)}}:{{str_pad($educador->carga_htp->floatDiffinMinutes(\Carbon\Carbon::Today())%60,2,'0',STR_PAD_LEFT)}}
							| Jornada projeto: {{floor($educador->carga_projeto->floatDiffinMinutes(\Carbon\Carbon::Today())/60)}}:{{str_pad($educador->carga_projeto->floatDiffinMinutes(\Carbon\Carbon::Today())%60,2,'0',STR_PAD_LEFT)}}
							| Jornada Uso Livre: {{floor($educador->carga_uso->floatDiffinMinutes(\Carbon\Carbon::Today())/60)}}:{{str_pad($educador->carga_uso->floatDiffinMinutes(\Carbon\Carbon::Today())%60,2,'0',STR_PAD_LEFT)}}
							| Jornada Outros: {{floor($educador->carga_outros->floatDiffinMinutes(\Carbon\Carbon::Today())/60)}}:{{str_pad($educador->carga_outros->floatDiffinMinutes(\Carbon\Carbon::Today())%60,2,'0',STR_PAD_LEFT)}}
							</th>
							<th>
								{{floor($educador->carga_jornada->floatDiffinMinutes(\Carbon\Carbon::Today())/60)}}:{{str_pad($educador->carga_jornada->floatDiffinMinutes(\Carbon\Carbon::Today())%60,2,'0',STR_PAD_LEFT)}}

							</th>
						</tr>

						<tr>
							<th colspan="5">Carga Total</th>
							<th>{{floor($educador->carga_ativa->floatDiffinMinutes(\Carbon\Carbon::Today())/60)}}:{{str_pad($educador->carga_ativa->floatDiffinMinutes(\Carbon\Carbon::Today())%60,2,'0',STR_PAD_LEFT)}}</th>


						</tr>
						
                    	
                    	
                    
                	</tbody>
                </table>
				
             </div>
        </div>
		<hr>
		@endforeach
		
        

        	
	<script src="{{asset('js/vendor.js')}}">
	</script>
</body>
<script type="text/javascript">

</script>

</html>

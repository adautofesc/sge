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
			Tel.: (16) 3362-0580 e 3362-0581
			</p>
        </small>
			</div>
			
		</div>
		<br/>
		<div class="title-block">
			<center>
            <h3 class="title"> Relatório de Jornada dos Educadores</h3>
			<h5 class="title"> Relatório geral {{$ano}} <br><br> <span class="posicao">Posição em 01/12/{{$ano}} - emitido em {{date("d/m/Y H:i")}}</span>
				
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
                        <th>Dia</th>
						<th>Início</th>
						<th>Término</th>
						<th>Atividade</th>
						<th>Local</th>
						<th>Carga (h)</th>
                    </thead>
                    <tbody>
						@foreach($dias as $dia)
						<tr>
							@if(isset($educador->jornadas[$dia]))
							<td rowspan="{{count($educador->jornadas[$dia])+1}}">
							@else
							<td rowspan="2">
							@endif	
							@switch($dia)
								@case('seg')
									Segunda
									@break
								@case('ter')
									Terça
									@break
								@case('qua')
									Quarta
									@break
								@case('qui')
									Quinta
									@break
								@case('sex')
									Sexta
									@break
								@case('sab')
									Sábado
									@break
								@default
									ND
									
							@endswitch
							</td>						
							<td>
								@if(isset($educador->jornadas[$dia]))
									{{$educador->jornadas[$dia]->first()->inicio}}
								@endif
							</td>
							<td>
								@if(isset($educador->jornadas[$dia]))
									{{$educador->jornadas[$dia]->first()->termino}}
								@endif
							</td>
							<td>
								@if(isset($educador->jornadas[$dia]))
								{{$educador->jornadas[$dia]->first()->descricao}}</td>
								@else
								Sem atividades neste dia
								@endif
							</td>
							<td>
								@if(isset($educador->jornadas[$dia]))
									{{$educador->jornadas[$dia]->first()->local}}
								@endif
							</td>
							<td>
								@if(isset($educador->jornadas[$dia]))
								{{floor($educador->jornadas[$dia]->first()->carga/60)}}:{{str_pad($educador->jornadas[$dia]->first()->carga%60,2,'0',STR_PAD_LEFT)}}
								@endif
							</td>
							
						</tr>
						@if(isset($educador->jornadas[$dia]))
						@for($i=1;$i<count($educador->jornadas[$dia]);$i++)
						<tr>						
							<td>{{$educador->jornadas[$dia]->skip($i)->take(1)->first()->inicio}}</td>
							<td>{{$educador->jornadas[$dia]->skip($i)->take(1)->first()->termino}}</td>
							<td>{{$educador->jornadas[$dia]->skip($i)->take(1)->first()->descricao}}</td>
							<td>{{$educador->jornadas[$dia]->skip($i)->take(1)->first()->local}}</td>
							
							<td>{{floor($educador->jornadas[$dia]->skip($i)->take(1)->first()->carga/60)}}:{{str_pad($educador->jornadas[$dia]->skip($i)->take(1)->first()->carga%60,2,'0',STR_PAD_LEFT)}}</td>

							
						</tr>
						@endfor
						@endif

						<tr>
							<th colspan="4" align="right">Total/dia</th>
							<th>{{floor($educador->carga_semanal->$dia/60)}}:{{str_pad($educador->carga_semanal->$dia%60,2,'0',STR_PAD_LEFT)}}</th>
						</tr>
						@endforeach

						





						<tr>
							<th colspan="5">Horas efetivas totais</th>
							<th>{{floor($educador->carga_ativa->floatDiffinMinutes(\Carbon\Carbon::Today())/60)}}:{{str_pad($educador->carga_ativa->floatDiffinMinutes(\Carbon\Carbon::Today())%60,2,'0',STR_PAD_LEFT)}}</th>
						</tr>
						
                    	
                    	
                    	
                	</tbody>
                </table>
				
             </div>
        </div>
		@endforeach
		
        

        	
	<script src="{{asset('js/vendor.js')}}">
	</script>
</body>
<script type="text/javascript">

</script>

</html>

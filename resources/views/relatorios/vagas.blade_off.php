<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
<title>SGE - Relatório de alunos - Fesc</title>
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


</style>
</head>

<body>
	<div class="container">
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
            <h3 class="title"> Relatório de Ocupação de vagas</h3>
			<h5 class="title"> Ano: <small>{{$ano}}</small>
            </h5></center>
        </div>
        <br>
        <br>
    
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-condensed">
                    <thead >
                        <th width="30rem">Programa</th>
						<th width="10rem">Turmas</th>
						<th width="10rem">Vagas</th>
                        <th width="10rem">Ocupadas</th>
                        <th width="10rem">% Ocupação</th>
                      
                    </thead>
                    <tbody>
                    	
                    	<tr>
							<td>Universidade Aberta da Terceira Idade</td>
							<td>{{$turmas['3']}}</td>
							<td>{{$vagas['3']}}</td>
							<td>{{$ocupacao['3']}}</td>
							@if($vagas['3']>0)
							<td>{{number_format(($ocupacao['3']*100)/$vagas['3'],2)}}</td>
							@else 
							<td>0</td>
							@endif
					
                    		
						</tr>
						<tr>
							<td>Universidade Aberto do Trabalhador</td>
							<td>{{$turmas['1']}}</td>
							<td>{{$vagas['1']}}</td>
							<td>{{$ocupacao['1']}}</td>
							@if($vagas['1']>0)
							<td>{{number_format(($ocupacao['1']*100)/$vagas['1'],2)}}</td>
							@else 
							<td>0</td>
							@endif
					
                    		
						</tr>
						<tr>
							<td>Programa de Inclusão Digital</td>
							<td>{{$turmas['2']}}</td>
							<td>{{$vagas['2']}}</td>
							<td>{{$ocupacao['2']}}</td>
							@if($vagas['2']>0)
							<td>{{number_format(($ocupacao['2']*100)/$vagas['2'],2)}}</td>
							@else 
							<td>0</td>
							@endif
					
                    		
						</tr>
						<tr>
							<td>Escola Municipal de Governo</td>
							<td>{{$turmas['4']}}</td>
							<td>{{$vagas['4']}}</td>
							<td>{{$ocupacao['4']}}</td>
							@if($ocupacao['4']>0)
							<td>{{number_format(($ocupacao['4']*100)/$vagas['4'],2)}}</td>
							@else 
							<td>0</td>
							@endif
					
                    		
						</tr>
						<tr>
							<td>Centro Esportivo</td>
							<td>{{$turmas['12']}}</td>
							<td>{{$vagas['12']}}</td>
							<td>{{$ocupacao['12']}}</td>
							@if($vagas['12']>0)
							<td>{{number_format(($ocupacao['12']*100)/$vagas['12'],2)}}</td>
							@else 
							<td>0</td>
							@endif
					
                    		
						</tr>
						<tr>
							<th>Total</th>
							<td>{{array_sum($turmas)}}</td>
							<td>{{array_sum($vagas)}}</td>
							<td>{{array_sum($ocupacao)}}</td>
							@if(array_sum($vagas)>0)
							<td>{{number_format((array_sum($ocupacao)*100)/array_sum($vagas),2)}}</td>
							@else 
							<td>0</td>
							@endif
					
                    		
						</tr>
						
                	</tbody>
                </table>
				<small>Gerador atualizado em 17/10/22</small>
             </div>
        </div>
		
		
        

        	
	<script src="{{asset('/js/vendor.js')}}">
	</script>
</body>


</html>

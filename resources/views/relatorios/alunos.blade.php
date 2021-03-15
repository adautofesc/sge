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
				
               
              
                <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Local
                            </button>

                            <ul class="dropdown-menu" >
								<li><a href="#"  data-value="84" tabIndex="-1"><input type="checkbox" @if(isset($r->local) && in_array('84',$r->local)) checked @endif name="local[]" value="84"/>&nbsp;<small>FESC 1</small></a></li>
								<li><a href="#"  data-value="85" tabIndex="-1"><input type="checkbox" @if(isset($r->local) && in_array('85',$r->local)) checked @endif name="local[]" value="85"/>&nbsp;<small>FESC 2</small></a></li>
								<li><a href="#"  data-value="86" tabIndex="-1"><input type="checkbox" @if(isset($r->local) && in_array('86',$r->local)) checked @endif name="local[]" value="86"/>&nbsp;<small>FESC 3</small></a></li>
								@foreach($locais as $local)
							<li>
								<a href="#"  data-value="{{$local->id}}" tabIndex="-1" title="{{$local->nome}}">
									<input type="checkbox" 
									@if(isset($r->local) && in_array($local->id,$r->local)) checked @endif
									name="local[]" value="{{$local->id}}" />
									<small>&nbsp;{{$local->sigla}}</small>			
								</a>
							</li>

							
								@endforeach
							 
					        </ul>

                </div>
               <button class="btn btn-success" type="submit">Gerar</button>
				<a href="/relatorios/alunos" class="btn btn-primary" >Limpar</a>
				<a href="#" class="btn btn-primary" onclick="print();">Imprimir</a>
			
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
            <h3 class="title"> Relatório de Alunos </h3>
			<h5 class="title"> Locais: <small>
				@if(isset($r->local))
					@php 
					
					$nomes = $locais->whereIn('id',$r->local);
					foreach($nomes as $nome){
						echo $nome->sigla.', ';
					}
					if(in_array('84',$r->local))
						echo 'FESC 1, ';
					if(in_array('85',$r->local))
						echo 'FESC 2, ';
					if(in_array('86',$r->local))
						echo 'FESC 3, ';
					@endphp
				@else
				Todos
				@endif
            		 </small>
            </h5></center>
        </div>
        <br>
        <br>
    
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-condensed">
                    <thead >
                        <th width="30rem">Semestre/Ano</th>
						<th width="10rem">CE</th>
                        <th width="10rem">EMG</th>
                        <th width="10rem">PID</th>
                        <th width="10rem">UATI</th>
                        <th width="10rem">UNIT</th>
                        <th width="10rem">TOTAL(unico)</th>
                    </thead>
                    <tbody>
                    	
                    	<tr>
							<th>1 semestre 2018</th>
							<td>{{count($alunos[2018][1]['ce'])}}</td>
							<td>{{count($alunos[2018][1]['emg'])}}</td>
							<td>{{count($alunos[2018][1]['pid'])}}</td>
							<td>{{count($alunos[2018][1]['uati'])}}</td>
							<td>{{count($alunos[2018][1]['unit'])}}</td>
							<td><strong>{{count($alunos[2018][1]['totais'])}}</strong></td>
                    		
						</tr>
						<tr>
							<th>2 semestre 2018</th>
							<td>{{count($alunos[2018][2]['ce'])}}</td>
							<td>{{count($alunos[2018][2]['emg'])}}</td>
							<td>{{count($alunos[2018][2]['pid'])}}</td>
							<td>{{count($alunos[2018][2]['uati'])}}</td>
							<td>{{count($alunos[2018][2]['unit'])}}</td>
							<td><strong>{{count($alunos[2018][2]['totais'])}}</strong></td>
                    		
						</tr>
						<tr>
							<th>Total 2018</th>
							<td>{{count($alunos[2018][0]['ce'])}}</td>
							<td>{{count($alunos[2018][0]['emg'])}}</td>
							<td>{{count($alunos[2018][0]['pid'])}}</td>
							<td>{{count($alunos[2018][0]['uati'])}}</td>
							<td>{{count($alunos[2018][0]['unit'])}}</td>
							<td><strong>{{count($alunos[2018][0]['totais'])}}</strong></td>
                    		
						</tr>
						<tr>
							<th>1 semestre 2019</th>
							<td>{{count($alunos[2019][1]['ce'])}}</td>
							<td>{{count($alunos[2019][1]['emg'])}}</td>
							<td>{{count($alunos[2019][1]['pid'])}}</td>
							<td>{{count($alunos[2019][1]['uati'])}}</td>
							<td>{{count($alunos[2019][1]['unit'])}}</td>
							<td><strong>{{count($alunos[2019][1]['totais'])}}</strong></td>
                    		
						</tr>
						<tr>
							<th>2 semestre 2019</th>
							<td>{{count($alunos[2019][2]['ce'])}}</td>
							<td>{{count($alunos[2019][2]['emg'])}}</td>
							<td>{{count($alunos[2019][2]['pid'])}}</td>
							<td>{{count($alunos[2019][2]['uati'])}}</td>
							<td>{{count($alunos[2019][2]['unit'])}}</td>
							<td><strong>{{count($alunos[2019][2]['totais'])}}</strong></td>
                    		
						</tr>
						<tr>
							<th>Total 2019</th>
							<td>{{count($alunos[2019][0]['ce'])}}</td>
							<td>{{count($alunos[2019][0]['emg'])}}</td>
							<td>{{count($alunos[2019][0]['pid'])}}</td>
							<td>{{count($alunos[2019][0]['uati'])}}</td>
							<td>{{count($alunos[2019][0]['unit'])}}</td>
							<td><strong>{{count($alunos[2019][0]['totais'])}}</strong></td>
                    		
						</tr>
						<tr>
							<th>1 semestre 2020</th>
							<td>{{count($alunos[2020][1]['ce'])}}</td>
							<td>{{count($alunos[2020][1]['emg'])}}</td>
							<td>{{count($alunos[2020][1]['pid'])}}</td>
							<td>{{count($alunos[2020][1]['uati'])}}</td>
							<td>{{count($alunos[2020][1]['unit'])}}</td>
							<td><strong>{{count($alunos[2020][1]['totais'])}}</strong></td>
                    		
						</tr>
						<tr>
							<th>2 semestre 2020</th>
							<td>{{count($alunos[2020][2]['ce'])}}</td>
							<td>{{count($alunos[2020][2]['emg'])}}</td>
							<td>{{count($alunos[2020][2]['pid'])}}</td>
							<td>{{count($alunos[2020][2]['uati'])}}</td>
							<td>{{count($alunos[2020][2]['unit'])}}</td>
							<td><strong>{{count($alunos[2020][2]['totais'])}}</strong></td>
                    		
						</tr>
						<tr>
							<th>Total 2020</th>
							<td>{{count($alunos[2020][0]['ce'])}}</td>
							<td>{{count($alunos[2020][0]['emg'])}}</td>
							<td>{{count($alunos[2020][0]['pid'])}}</td>
							<td>{{count($alunos[2020][0]['uati'])}}</td>
							<td>{{count($alunos[2020][0]['unit'])}}</td>
							<td><strong>{{count($alunos[2020][0]['totais'])}}</strong></td>
                    		
                    	</tr>
                    	
                	</tbody>
                </table>
             </div>
        </div>
		
        

        	
	<script src="{{asset('/')}}/js/vendor.js">
	</script>
</body>
<script type="text/javascript">
	var options = [];

$( '.dropdown-menu a' ).on( 'click', function( event ) {

   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       $inp = $target.find( 'input' ),
       idx;

   if ( ( idx = options.indexOf( val ) ) > -1 ) {
      options.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
   } else {
      options.push( val );
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
      
   console.log( options );
   return false;
});
</script>

</html>

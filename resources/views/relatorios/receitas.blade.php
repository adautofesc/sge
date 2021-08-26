<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
<title>SGE - Relatório de receitas por programa - Fesc</title>
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
            <h3 class="title"> Relatório de receitas por programa </h3>
			<h5 class="title"> Ano: <small> {{$ano}} </small>
			
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
						<th width="10rem">Alunos</th>
                        <th width="10rem">Matrículas</th>
                        <th width="10rem">Valor</th>
                        
                    </thead>
                    <tbody>
                    	@foreach($programas as $programa)
                    	<tr>
							<th>{{$programa->nome}}</th>
							<td>{{$programa->pessoas}}</td>
							<td>{{$programa->matriculas}}</td>
							<td>R$ {{number_format($programa->valor, 2, ',', '.')}}</td>	
						</tr>
						@endforeach
						<tr>
							<th>Total</th>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>R$ {{number_format($valor_total, 2, ',', '.')}}</td>	
						</tr>

						
                    	
                	</tbody>
                </table>
             </div>
        </div>
		
        

        	
	<script src="{{asset('js/vendor.js')}}">
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

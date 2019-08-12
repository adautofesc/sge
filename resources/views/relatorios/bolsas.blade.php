<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/')}}/css/vendor.css"/>
<title>SGE - Relatório de bolsistas - Fesc</title>
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
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Tipo
                            </button>
                             <ul class="dropdown-menu">
					          <li><a href="#"  data-value="option1" tabIndex="-1"><input type="radio" name="tipo" value="Registros"/>&nbsp;Registros</a></li>
					          <li><a href="#"  data-value="option2" tabIndex="-1"><input type="radio" name="tipo" value="Resultados"/>&nbsp;Resultados</a></li>
					          <li><a href="#"  data-value="option3" tabIndex="-1"><input type="radio" name="tipo" value="Comparativo"/>&nbsp;Comparativo</a></li>
					       
					        </ul>
                </div>
                 <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Desconto
                            </button>
                   
                            <ul class="dropdown-menu" style="width: 400px;">
                            	<li> <a href="#">Caso não haja seleção todos serão usados todos</a></li>
                            @foreach($descontos as $desconto)
					          <li><a href="#"  data-value="{{$desconto->id}}" tabIndex="-1"><input type="checkbox" name="descontos" value="{{$desconto->id}}"/>&nbsp;{{$desconto->nome}}</a></li>
					        @endforeach
					        </ul>
                </div>
                <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Programa
                            </button>

                            <ul class="dropdown-menu" >
                            @foreach($programas as $programa)
					          <li><a href="#"  data-value="{{$programa->id}}" tabIndex="-1"><input type="checkbox" name="programas" value="{{$programa->id}}"/>&nbsp;{{$programa->sigla}}</a></li>
					        @endforeach
					        </ul>

                </div>
                <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Período
                            </button>

                            <ul class="dropdown-menu" >
                            @foreach($periodos as $periodo)
					          <li><a href="#"  data-value="{{$periodo->semestre.$periodo->ano}}" tabIndex="-1"><input type="checkbox" name="periodos" value="{{$periodo->semestre.$periodo->ano}}"/>&nbsp;{{$periodo->semestre.'º Sem. '.$periodo->ano}}</a></li>
					        @endforeach
					        </ul>

                </div>
               <button class="btn btn-success" type="submit">Gerar</button>
				<button class="btn btn-primary" type="reset">Limpar</button>
				<a href="#" class="btn btn-primary" onclick="print();">Imprimir</a>
			
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-sm-2">
			<img src="{{asset('/')}}/img/logofesc.png" width="80"/>
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
            <h3 class="title"> Relatório de bolsistas </h3>
            <h5 class="title"> Filtrado por Funcionários públicos municipais.
            		 
            </h5></center>
        </div>
        <br>
        <br>
        Total de bolsistas: <strong>XXX</strong> .
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <table>
                    <thead >
                        <th width="5%">ID</th>
                        <th width="50%">Nome</th>
                        <th width="30%">Data da solicitação</th>
                        <th width="15%">Matrícula ou curso:</th>
                    </thead>
                    <tbody>
                    
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
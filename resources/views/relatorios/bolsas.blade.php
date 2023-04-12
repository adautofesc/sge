<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
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
					          <li><a href="#"  data-value="option1" tabIndex="-1"><input type="radio" @if(isset($r->tipo) && $r->tipo == 'Registros') checked @endif name="tipo" value="Registros"/>&nbsp;Registros</a></li>
					          <li><a href="#"  data-value="option2" tabIndex="-1"><input type="radio" @if(isset($r->tipo) && $r->tipo == 'Resultados') checked @endif name="tipo" value="Resultados"/>&nbsp;Resultados</a></li>
					       
					       
					        </ul>
                </div>
                 <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Desconto
                            </button>
                   
                            <ul class="dropdown-menu" style="width: 400px;">
                            	<li> <a href="#">Caso não haja seleção todos serão usados todos</a></li>
                            @foreach($descontos as $desconto)
					          <li><a href="#"  data-value="{{$desconto->id}}" tabIndex="-1"><input type="checkbox" @if(isset($r->descontos) && in_array($desconto->id,$r->descontos)) checked @endif  name="descontos[]" value="{{$desconto->id}}"/>&nbsp;{{$desconto->nome}}</a></li>
					        @endforeach
					        </ul>
                </div>
                <!--
                <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Programa
                            </button>

                            <ul class="dropdown-menu" >
                            @foreach($programas as $programa)
					          <li><a href="#"  data-value="{{$programa->id}}" tabIndex="-1"><input type="checkbox" name="programas[]" value="{{$programa->id}}"/>&nbsp;{{$programa->sigla}}</a></li>
					        @endforeach
					        </ul>

                </div>-->
                <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Período
                            </button>

                            <ul class="dropdown-menu" >
                            @foreach($periodos as $periodo)
					          <li><a href="#"  data-value="{{$periodo->semestre.$periodo->ano}}" tabIndex="-1"><input type="checkbox"@if(isset($r->periodos) && in_array(($periodo->semestre.$periodo->ano),$r->periodos)) checked @endif  name="periodos[]" value="{{$periodo->semestre.$periodo->ano}}"/>&nbsp;{{$periodo->semestre.'º Sem. '.$periodo->ano}}</a></li>
					        @endforeach
					        </ul>

                </div>
                <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Estado
                            </button>

                            <ul class="dropdown-menu" >
                            
					          <li><a href="#"  data-value="ativa" tabIndex="-1"><input type="checkbox" @if(isset($r->status) && in_array('ativa',$r->status)) checked @endif name="status[]" value="ativa"/>&nbsp;Ativa</a></li>
					          <li><a href="#"  data-value="analisando" tabIndex="-1"><input @if(isset($r->status) && in_array('analisando',$r->status)) checked @endif type="checkbox" name="status[]" value="analisando"/>&nbsp;Analisando</a></li>
					          <li><a href="#"  data-value="cancelado" tabIndex="-1"><input type="checkbox" @if(isset($r->status) && in_array('cancelada',$r->status)) checked @endif name="status[]" value="cancelada"/>&nbsp;Cancelada</a></li>
					          <li><a href="#"  data-value="expirada" tabIndex="-1"><input type="checkbox" @if(isset($r->status) && in_array('expirada',$r->status)) checked @endif name="status[]" value="expirada"/>&nbsp;Expirada</a></li>
					       
					        </ul>

                </div>
               <button class="btn btn-success" type="submit">Gerar</button>
				<button class="btn btn-primary" type="reset">Limpar</button>
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
			Tel.: (16) 3362-0580 e 3362-0581
			</p>
        </small>
			</div>
			
		</div>
		<br/>
		<div class="title-block">
			<center>
            <h3 class="title"> Relatório de bolsistas </h3>
            <h5 class="title"> Filtros: 
            		 
            </h5></center>
        </div>
        <br>
        <br>

        @if(isset($r->tipo) && $r->tipo == 'Registros')
        Total de bolsas: <strong>{{count($bolsas)}}</strong> .
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <table class="table">
                    <thead >
                        <th width="22rem">ID</th>
                        <th width="12%">Pessoa</th>
                        <th width="40%">Nome</th>
                        <th width="20%">Solicitado em</th>
                        <th width="13%">Programa</th>
                        <th width="10%">Status</th>
                    </thead>
                    <tbody>
                    	@foreach($bolsas as $bolsa)
                    	<tr>
                    		<td><a href="/bolsas/analisar/{{$bolsa->id}}">{{$bolsa->id}}</a></td>
                    		<td><a href="/secretaria/atender/{{$bolsa->pessoa}}">{{$bolsa->pessoa}}</a></td>
                    		<td>{{$bolsa->nome}}</td>
                    		<td>{{$bolsa->created_at->format('d/m/y H:i')}}</td>
                    		<td>{{implode(', ', $bolsa->getPrograma()) }}</td>
                    		<td>{{$bolsa->status}}</td>
                    	</tr>
                    	@endforeach
                	</tbody>
                </table>
             </div>
        </div>
		@elseif(isset($r->tipo) && $r->tipo == 'Resultados')
		@php $total=0; @endphp
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <table class="table">
                    <thead >
                        <th width="22rem">Tipo</th>
                        <th width="12%">Quantidade</th>
                       
                    </thead>
                    <tbody>
                    	@foreach($bolsas as $bolsa)
                    	<tr>
						<td>{{$bolsa->desconto->nome}}</td>
						<td>{{$bolsa->numero}}</td>
						@php $total = $total+$bolsa->numero; @endphp
                    	</tr>
						@endforeach
						<tr>
							<td><strong>Total</strong></td>
						<td><strong>{{$total}}</strong></td>
						</tr>
                	</tbody>
                </table>
             </div>
        </div>
		@endif
        

        	
	<script src="{{asset('/js/vendor.js')}}">
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

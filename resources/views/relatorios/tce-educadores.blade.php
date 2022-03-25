<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
<title>SGE - Relatório Educadores {{$ano}} - Fesc</title>
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
.topo th{
	vertical-align: text-top;
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
	            <p><strong> RELATÓRIO DE EDUCADORES - TCE. REF.{{$ano}}</strong><br/>

        	</center>
        </div>
        <br>

       
        Total de educadores: <strong>{{count($educadores)}}</strong> .
        <br/>
        

        <div class="row">
            <div class="col-sm-12">
                <table >
                    <thead style="line-height:40px;">
                      	<th width="10px">Id</th>
                        <th width="40%">Educador</th>
                        <th >Nascimento</th>
                        <tr style="border-top: 1px solid gray; line-height:40px;" class="topo">
                    		<td>Turma</td>
                        	<td>Curso</td>
                        	<td>Local</td>
                        	<td>Dia(a)</td>
                        	<td >Horario</td>
                        	<td>Início</td>
                  
                        </tr>
                        

        
                    </thead>
                    
                    <tbody>
                    	@foreach($educadores as $educador)
                    		@php($carga=0)
	                    	<tr style="border-bottom: 1px solid gray; line-height:30px;" >
	                    		<td><strong>{{$educador->id}}</strong></td>
	                    		<td><strong>{{$educador->nome}}</strong></td>
	                    		<td><strong>{{\App\classes\Data::converteParaUsuario($educador->nascimento)}}</strong></td>
	                    	</tr>
	                    	@foreach($educador->turmas as $turma)

	                    	<tr >
	                    		<td>{{$turma->id}}</td>
	                    		<td>{{$turma->nome_curso}}</td>
	                    		<td>{{$turma->carga}}</td>
	                    		<td>{{$turma->local->sigla}}</td>
	                    		<td style="width:100px;">{{implode(', ',$turma->dias_semana)}}</td>
	                    		<td style="width:120px;">{{$turma->hora_inicio. ' às '.$turma->hora_termino}}</td>
	                    		<td style="width:100px;">{{$turma->data_inicio}}</td>
	                    		
	                    	</tr>
	                    	@php($carga = $carga+$turma->carga)
	                    	@endforeach
	                    	<tr>
	                    		<td>&nbsp;</td>
	                    		<td>Carga total efetiva</td>
	                    		<td offset="5">{{$carga}}</td>
	                    	</tr>



                    	@endforeach

                    
                	</tbody>
                </table>


       
                
         
             </div>
        </div>
        
        

        	
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

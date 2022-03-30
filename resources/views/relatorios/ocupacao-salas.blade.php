<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
<title>SGE - Relatório de ocupação de salas</title>
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
.dropdown-menu li label{
	text-decoration: none;
	color:black;
	margin-left: 1rem;
	line-height: 1rem;
	cursor: pointer;
}

</style>
</head>

<body>
	<div class="container">
		<div class="row hide-onprint">
			<div class="col-xs-12" style="margin-top: 20px;margin-bottom: 50px;">
				<form class="inline-form" method="GET">
				<div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Unidade
                            </button>
                             <ul class="dropdown-menu"  style="width: 400px;">
								<li><label  onclick="carregarSalas('84');"><input type="radio" name="local" value="84"/>&nbsp;FESC 1</label></li>
								<li><label  tabIndex="-1" onclick="carregarSalas('85');"><input type="radio" name="local" value="85"/>&nbsp;FESC 2</label></li>
								<li><label  tabIndex="-1" onclick="carregarSalas('86');"><input type="radio" name="local" value="86"/>&nbsp;FESC 3</label></li>
								@foreach($locais as $local)
									<li ><label onclick="carregarSalas({{$local->id}});"><input type="radio" name="local" value="{{$local->id}}" />&nbsp;{{$local->nome}}</label></li>
								@endforeach
								
					       
					        </ul>
                </div>
                 <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Selecione uma unidade
                            </button>
                   
                            <ul class="dropdown-menu" id="select-sala" style="width: 400px;">
                            	<li> <a href="#">Selecione uma unidade</a></li>
                           
					        </ul>
                </div>
                
               <button class="btn btn-success" type="submit">Gerar</button>
				<button class="btn btn-primary" type="reset">Limpar</button>
				<a href="#" class="btn btn-primary" onclick="print();">Imprimir</a>
			
			</div>
		</div>
	
		<br/>
	
        
        <div class="row">
            <div class="col-sm-12">
				<table class="table table-condensed  table-sm">
					<thead>
						<th>Dia\Sala</th>
						@foreach($salas as $sala)
						<th>{{$sala->nome}}</th>
						@endforeach
			
					</thead>
					<tbody>
						<tr>
							<th>Segunda</th>
							@foreach($salas as $sala)
								<td>
								@foreach($atividades as $atividade)                        
										@if($atividade->dia == 'seg' && $atividade->sala == $sala->id)
											{{$atividade->inicio}}/{{$atividade->termino}} : {{$atividade->descricao}}<br>
										@endif                        
								@endforeach                   
								</td>
							@endforeach
						</tr>
						<tr>
							<th>Terça</th>
							@foreach($salas as $sala)
								<td>
								@foreach($atividades as $atividade)                        
										@if($atividade->dia == 'ter' && $atividade->sala == $sala->id)
											{{$atividade->inicio}}/{{$atividade->termino}} : {{$atividade->descricao}}<br>
										@endif                        
								@endforeach                   
								</td>
							@endforeach
						</tr>
						<tr>
							<th>Quarta</th>
							@foreach($salas as $sala)
								<td>
								@foreach($atividades as $atividade)                        
										@if($atividade->dia == 'qua' && $atividade->sala == $sala->id)
											{{$atividade->inicio}}/{{$atividade->termino}} : {{$atividade->descricao}}<br>
										@endif                        
								@endforeach                   
								</td>
							@endforeach
						</tr>
						<tr>
							<th>Quinta</th>
							@foreach($salas as $sala)
								<td>
								@foreach($atividades as $atividade)                        
										@if($atividade->dia == 'qui' && $atividade->sala == $sala->id)
											{{$atividade->inicio}}/{{$atividade->termino}} : {{$atividade->descricao}}<br>
										@endif                        
								@endforeach                   
								</td>
							@endforeach
						</tr>
						<tr>
							<th>Sexta</th>
							@foreach($salas as $sala)
								<td>
								@foreach($atividades as $atividade)                        
										@if($atividade->dia == 'sex' && $atividade->sala == $sala->id)
											{{$atividade->inicio}}/{{$atividade->termino}} : {{$atividade->descricao}}<br>
										@endif                        
								@endforeach                   
								</td>
							@endforeach
						</tr>
						<tr>
							<th>Sab</th>
							@foreach($salas as $sala)
								<td>
								@foreach($atividades as $atividade)                        
										@if($atividade->dia == 'sab' && $atividade->sala == $sala->id)
											{{$atividade->inicio}}/{{$atividade->termino}} : {{$atividade->descricao}}<br>
										@endif                        
								@endforeach                   
								</td>
							@endforeach
						</tr>
			
						
					</tbody>
				</table>
                
             </div>
        </div>
		
        

        	
	<script src="{{asset('/js/vendor.js')}}">
	</script>
</body>
<script type="text/javascript">
	var options = [];


function carregarSalas(local){
        var salas;
        $("#select-sala").html('<option>Sem salas cadastradas</option>');
        $.get("{{asset('services/salas-api/')}}"+"/"+local)
                .done(function(data) 
                {
                    if(data.length>0){
                        $("#select-sala").html('');
                        let li_item = document.createElement("li");
                            li_item.className = "salas";
                        let a_item = document.createElement("a");
                       
                           
                        let li_check = document.createElement("input");
                            li_check.setAttribute('type', 'checkbox');
                            li_check.setAttribute('id', 'select-all');
                            li_check.setAttribute('value', '0');                                 
                        let li_text = document.createTextNode(' TODAS');

                        a_item.appendChild(li_check);
                        a_item.appendChild(li_text);
                        li_item.appendChild(a_item);

                        $("#select-sala").append(li_item);
						$("#dropdownMenu2").html('Salas disponíveis')

                    }
                        
                    $.each(data, function(key, val){
                        let li_item = document.createElement("li");
                            li_item.className = "salas";
                        let a_item = document.createElement("a");
                            a_item.setAttribute('href', '#');
                            a_item.setAttribute('data-value', val.id);
                            a_item.setAttribute('tabIndex', '-1');
                        let li_check = document.createElement("input");
                            li_check.setAttribute('type', 'checkbox');
                            li_check.setAttribute('name', 'salas[]');
                            li_check.setAttribute('value', val.id);
                        let li_text = document.createTextNode(' '+val.nome);

                        a_item.appendChild(li_check);
                        a_item.appendChild(li_text);
                        li_item.appendChild(a_item);
                        //console.log(li_item); <li><a href="#"  data-value="1" tabIndex="-1"><input type="checkbox"  name="salas[]" value="1"/>&nbsp;Nome da sala</a></li>

                        $("#select-sala").append(li_item);

                    });
					$('#select-all').on('click',function(event) {   
						
						if(this.checked) {
							// Iterate each checkbox
							$(':checkbox').each(function() {
								this.checked = true;                        
							});
						} else {
							$(':checkbox').each(function() {
								this.checked = false;                       
							});
						}
					}); 
					$( '.dropdown-menu a,#select-sala a' ).on( 'click', function( event ) {

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
                });
	
                
};//function carregar salas 
</script>

</html>

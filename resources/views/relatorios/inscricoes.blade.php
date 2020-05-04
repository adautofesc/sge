<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/')}}/css/vendor.css"/>
<title>Documento Oficial - Fesc</title>
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
            <h3 class="title"> Relatório de inscrições</h3>
            <h5 class="title"> Filtrado por 
            		 @foreach($filtros as $filtro=>$valor)
		                @if(count($filtros[$filtro]))
		                        <strong>{{$filtro}}</strong>,
		                @endif
		            @endforeach



            </h5></center>
        </div>
        <br>
        <br>
        
         <div class="row hide-onprint">
	        <br>
	        <div class="col-sm-9">
	            
	            Mostrando {{count($turmas)}} turmas 
	            <!--
	            <a href="?limparfiltro=1">
	                <i class="fa fa-remove" style="color:red"></i>
	                Limpar Filtros
	            </a> -->
	            @foreach($filtros as $filtro=>$valor)
	                @if(count($filtros[$filtro]))

	                    <a href="?removefiltro={{$filtro}}" title="Remover este filtro {{implode($valor,', ')}}">
	                        <i class="fa fa-remove" style="color:red"></i>
	                        {{$filtro}}
	                    </a>
	                @endif
	            @endforeach
	       

	        </div>
	        
	    
	    </div>
        <br/>
        <div class="row hide-onprint">
        <div class="col-sm-12">
            <div class=" card card-block rounded-s small">
                <div class="form-group row "> 
                    <!--
                    <div class="col-sm-3"> 
                        <div class="input-group rounded-s">
                            
                            <input type="text" class="form-control boxed rounded-s" name="buscar" placeholder="Buscar"> 

                        </div>
                    </div>
                -->
                
                    <div class="col-sm-12"> 
                        
                        <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Programa
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                @foreach($programas as $programa)

                                @if(isset($filtros['programa']) &&  array_search($programa->id,$filtros['programa']) !== false)
                                <a class="dropdown-item" href="?filtro=programa&valor={{$programa->id}}&remove=1">
                                    <i class="fa fa-check-circle-o icon"></i> {{$programa->sigla}}
                                </a>
                                @else
                                <a class="dropdown-item" href="?filtro=programa&valor={{$programa->id}}">
                                    <i class="fa fa-circle-o icon"></i> {{$programa->sigla}}
                                </a>
                                @endif
                                @endforeach 
                               
                            </div>
                        </div>
                    
                        <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Professor
                            </button>
                            <div class="dropdown-menu " style="height:30em;px;overflow-y:scroll;" aria-labelledby="dropdownMenu1"> 
                                @foreach($professores as $professor)
                                @if(isset($filtros['professor']) && array_search($professor->id,$filtros['professor']) !== false)
                                <a class="dropdown-item" href="?filtro=professor&valor={{$professor->id}}&remove=1">
                                    <i class="fa fa-check-circle-o icon"></i> {{$professor->nome_simples}}
                                </a> 
                                @else
                                <a class="dropdown-item" href="?filtro=professor&valor={{$professor->id}}">
                                    <i class="fa fa-circle-o icon"></i> {{$professor->nome_simples}}
                                </a> 
                                @endif
                                @endforeach
                            </div>
                        </div>
                    
                        <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Local
                            </button>
                            <div class="dropdown-menu" style="height:30em;px;overflow-y:scroll;" aria-labelledby="dropdownMenu1">
                                 @if(isset($filtros['local']) && array_search(84,$filtros['local']) !== false)
                               
                                    <a class="dropdown-item" href="?filtro=local&valor=84&remove=1" title="Remover filtro: Campus 1">
                                        <i class="fa fa-check-circle-o icon"></i> FESC 1
                                    </a>
                                 @else
                                    <a class="dropdown-item" href="?filtro=local&valor=84" title="Campus 1">
                                        <i class="fa fa-circle-o icon"></i> FESC 1
                                    </a>
                                 @endif
                                 @if(isset($filtros['local']) && array_search(85,$filtros['local']) !== false)
                               
                                    <a class="dropdown-item" href="?filtro=local&valor=85&remove=1" title="Remover filtro: Campus 2">
                                        <i class="fa fa-check-circle-o icon"></i> FESC 2
                                    </a>
                                 @else
                                    <a class="dropdown-item" href="?filtro=local&valor=85" title="Campus 2">
                                        <i class="fa fa-circle-o icon"></i> FESC 2
                                    </a>
                                 @endif
                                 @if(isset($filtros['local']) && array_search(86,$filtros['local']) !== false)
                               
                                    <a class="dropdown-item" href="?filtro=local&valor=86&remove=1" title="Remover filtro: Campus 3">
                                        <i class="fa fa-check-circle-o icon"></i> FESC 3
                                    </a>
                                 @else
                                    <a class="dropdown-item" href="?filtro=local&valor=86" title="Campus 3">
                                        <i class="fa fa-circle-o icon"></i> FESC 3
                                    </a>
                                 @endif

                                @foreach($locais as $local)
                                @if(isset($filtros['local']) && array_search($local->id,$filtros['local']) !== false)
                                <a class="dropdown-item" href="?filtro=local&valor={{$local->id}}&remove=1" title="Remover filtro: {{$local->nome}}" >
                                    <i class="fa fa-check-circle-o icon"></i> {{$local->sigla}}
                                </a>
                                @else
                                <a class="dropdown-item" href="?filtro=local&valor={{$local->id}}" title="{{$local->nome}}" >
                                    <i class="fa fa-circle-o icon"></i> {{$local->sigla}}
                                </a> 
                                @endif
                                @endforeach
                                
                            </div>
                        </div>
                        <!--
                        <div class="action dropdown "> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Dias
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                <a class="dropdown-item" href="?filtro=dias_semana&valor=seg" >
                                    <i class="fa fa-circle-o icon"></i>Segunda-feira
                                </a> 
                                <a class="dropdown-item" href="?filtro=dias_semana&valor=ter" >
                                    <i class="fa fa-circle-o icon"></i>Terça-feira
                                </a> 
                                <a class="dropdown-item" href="?filtro=dias_semana&valor=qua"> 
                                    <i class="fa fa-circle-o icon"></i>Quarta-feira
                                </a> 
                                <a class="dropdown-item" href="?filtro=dias_semana&valor=qui" >
                                    <i class="fa fa-circle-o icon"></i>Quinta-feira
                                </a> 
                                <a class="dropdown-item" href="?filtro=dias_semana&valor=sex" >
                                    <i class="fa fa-circle-o icon"></i>Sexta-feira
                                </a> 
                                <a class="dropdown-item" href="?filtro=dias_semana&valor=sab" >
                                    <i class="fa fa-circle-o icon"></i>Sábado
                                </a> 
                                <a class="dropdown-item" href="?filtro=dias_semana&valor=dom" >
                                    <i class="fa fa-circle-o icon"></i>Domingo
                                </a>
                                
                            </div>
                        </div>
                        <div class="action dropdown "> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Periodo
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                <div class="input-group rounded-s">
                            
                                    <input type="date" class="form-control boxed rounded-s" name="dt_inicio" placeholder="Data de início"> 

                                </div>
                                <div class="input-group rounded-s">
                            
                                    <input type="date" class="form-control boxed rounded-s"  name="dt_termino" placeholder="Data Termino"> 

                                </div>
                                <div class="input-group rounded-s">
                            
                                    <input type="submit" class="btn btn-primary" placeholder="Enviar" value ="Enviar"> 

                                </div>

                            </div>
                        </div>
                   -->
                	
                        <div class="action dropdown " style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Status
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                @if(isset($filtros['status']))

                                <a class="dropdown-item" href="?filtro=status&valor=inscricao{{array_search('inscricao',$filtros['status'])!==false?'&remove=1':''}}">
                                    <i class="fa fa-{{array_search('inscricao',$filtros['status'])!==false?'check-':''}}circle-o icon"></i>  Com matrículas abertas
                                </a>
                               
                                <a class="dropdown-item" href="?filtro=status&valor=espera{{array_search('espera',$filtros['status'])!==false?'&remove=1':''}}">
                                    <i class="fa fa-{{array_search('espera',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Aguardando / matrículas Suspensas
                                </a>
                                <a class="dropdown-item" href="?filtro=status&valor=iniciada{{array_search('iniciada',$filtros['status'])!==false?'&remove=1':''}}" >
                                    <i class="fa fa-{{array_search('iniciada',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Em andamento / matrícula aberta
                                </a>
                                <a class="dropdown-item" href="?filtro=status&valor=andamento{{array_search('andamento',$filtros['status'])!==false?'&remove=1':''}}" >
                                    <i class="fa fa-{{array_search('andamento',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Em andamento / matricula fechada
                                </a>
                                <a class="dropdown-item" href="?filtro=status&valor=encerrada{{array_search('encerrada',$filtros['status'])!==false?'&remove=1':''}}" >
                                    <i class="fa fa-{{array_search('encerrada',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Encerradas
                                </a>
                                <a class="dropdown-item" href="?filtro=status&valor=cancelada{{array_search('cancelada',$filtros['status'])!==false?'&remove=1':''}}" >
                                    <i class="fa fa-{{array_search('cancelada',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Canceladas 
                                </a>
                                
                                @else
                                <a class="dropdown-item" href="?filtro=status&valor=inscricao" >
                                    <i class="fa fa-circle-o icon"></i> Com matrículas Abertas
                                </a> 
                                <a class="dropdown-item" href="?filtro=status&valor=espera"  >
                                    <i class="fa fa-circle-o icon"></i>  Aguardando / matrículas Suspensas
                                </a>
                                <a class="dropdown-item" href="?filtro=status&valor=iniciada" >
                                    <i class="fa fa-circle-o icon"></i> Em andamento / matrícula aberta
                                </a>
                                <a class="dropdown-item" href="?filtro=status&valor=andamento" >
                                    <i class="fa fa-circle-o icon"></i> Em andamento / matricula fechada
                                </a>
                                <a class="dropdown-item" href="?filtro=status&valor=encerrada" >
                                    <i class="fa fa-circle-o icon"></i> Encerradas
                                </a>
                                <a class="dropdown-item" href="?filtro=status&valor=cancelada" >
                                    <i class="fa fa-circle-o icon"></i> Canceladas 
                                </a>
                                
                                @endif
                            </div>
                        </div>
                        <div class="action dropdown " style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Por datas
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                <small>Início da turma</small>
                                <input type="date" class="form-control boxed" name="data_inicio" style="margin-bottom: 5px; width:150px "> 
                                <small>Termino da turma</small>
                                <input type="date" class="form-control boxed" name="data_termino" style="margin-bottom: 5px; width:150px ">
                                <button type="button" name="inicio"  class="btn btn-sm btn-primary " onclick="addFiltroData()">Aplicar</button>
                            </div>
                        </div>



                        <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Período
                            </button>
                            <div class="dropdown-menu " style="height:10em;px;overflow-y:scroll;" aria-labelledby="dropdownMenu1"> 
                                @foreach($periodos as $periodo)
                                @if(isset($filtros['periodo']) && array_search($periodo->semestre.$periodo->ano,$filtros['periodo']) !== false)
                                <a class="dropdown-item" href="?filtro=periodo&valor={{$periodo->semestre.$periodo->ano}}&remove=1">
                                    <i class="fa fa-check-circle-o icon"></i> {{$periodo->semestre.'º Sem. '.$periodo->ano}}
                                </a> 
                                @else
                                <a class="dropdown-item" href="?filtro=periodo&valor={{$periodo->semestre.$periodo->ano}}">
                                    <i class="fa fa-circle-o icon"></i> {{$periodo->semestre.'º Sem. '.$periodo->ano}}
                                </a> 
                                @endif
                                @endforeach
                            </div>
                        </div>
                
         
                    </div>
                </div>
              
                
            </div>
            
        </div>
    </div>
        <div class="row ">
        <div class="col-xl-12">
            <small>
        	<table class="table table-striped table-condensed">
        		<thead>
        			<th  width="5%" >Turma</th>
        			<th>Curso</th>
                    <th>Início</th>
        			<th>Dia/Horário</th>
        			<th>Professor</th>
        			<th>Local</th>
        			<th>Vagas</th>
                    <th>Ocup.</th>
        		</thead>
        		<tbody>
        			 @foreach($turmas as $turma)
        			<tr>
        				<td>{{$turma->id}}</td>
        				<td >
        					@if(isset($turma->disciplina))
                            	
                                 {{$turma->disciplina->nome}}     
                                <small>{{$turma->curso->nome}}</small>
                            
                           @else
               
                                 {{$turma->curso->nome}}         
                            
                            @endif
                        </td>
                        <td>{{$turma->data_inicio}}</td>
        				<td>{{implode(', ',$turma->dias_semana)}} - {{$turma->hora_inicio}} ás {{$turma->hora_termino}}</td>
        				<td>{{$turma->professor->nome_simples}}</td>
        				<td>{{$turma->local->sigla}}</td>
        				<td>{{$turma->vagas}} </td>
                        <td>{{$turma->matriculados}}</td>
        			</tr>
        			@endforeach
        		</tbody>
        	</table>
        </small>

         
            <!-- /.card -->
        </div>
        <!-- /.col-xl-6 -->
        
        <!-- /.col-xl-6 -->
    </div>
        <footer class="align-bottom align-text-bottom">
        Assinatura
        </footer>
	</div>
        	
	<script src="{{asset('/')}}/js/vendor.js">
	</script>
    <script type="text/javascript">
        function addFiltroData(){
        
            inicio = document.getElementsByName("data_inicio")[0].value;
            termino = document.getElementsByName("data_termino")[0].value;
            window.location.href = './inscricoes/?filtro=pordata&valor=i'+inicio+'t'+termino;
        }
    </script>
</body>

</html>

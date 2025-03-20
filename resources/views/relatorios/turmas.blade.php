<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
<title>Relatório de Turmas - SGE Fesc</title>
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
            <h3 class="title"> Relatório de turmas</h3>
            <h5 class="title" style="font-size:11px"> Filtrado por 
            		 @foreach($filtros as $filtro=>$valor)
                        @if(count($filtros[$filtro]))
                                @switch($filtro)
                                    @case('pordata')
                                        <strong>datas</strong>: {{implode(',',$valor)}},                                        
                                        @break
                                    @case('professor')
                                        <strong>professorer</strong>: 
                                        @foreach($valor as $i)
                                            {{\App\Pessoa::getNome($i)}},
                                        @endforeach
                                        @break;
                                    @case('programa')
                                        <strong>programas</strong>: 
                                        @foreach($valor as $i)
                                            {{\App\Programa::getSigla($i)}},
                                        @endforeach
                                        @break;
                                    @case('local')
                                        <strong>locais</strong>: 
                                        @foreach($valor as $i)
                                            {{\App\Local::getSigla($i)}},
                                        @endforeach
                                        @break;
                                    
                                    @default
                                    <strong>{{$filtro}}</strong>: {{implode(', ',$valor)}},
                                @endswitch
                                
		                @endif
		            @endforeach



            </h5></center>
        </div>
        <br>
        <br>
        Total de vagas oferecidas: <strong>{{$vagas}}</strong> com <strong>{{$inscricoes}}</strong> inscrições ({{$porcentagem}}%).
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

	                    <a href="?removefiltro={{$filtro}}" title="Remover este filtro">
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
              
                    <div class="col-sm-12"> 
                        
                        <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                            <button class="btn btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Programa
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
                            <button class="btn btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Professor
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
                            <button class="btn btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Local
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
                        
                	
                        <div class="action dropdown " style="float: left; margin-right: 10px;"> 
                            <button class="btn btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Status
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu4"> 
                                @if(isset($filtros['status']))                             
                        
                                <a class="dropdown-item" href="?filtro=status&valor=lancada{{array_search('lancada',$filtros['status'])!==false?'&remove=1':''}}">
                                    <i class="fa fa-{{array_search('lancada',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Lançadas
                                </a>
                                <a class="dropdown-item" href="?filtro=status&valor=iniciada{{array_search('iniciada',$filtros['status'])!==false?'&remove=1':''}}" >
                                    <i class="fa fa-{{array_search('iniciada',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Iniciadas
                                </a>
                                <a class="dropdown-item" href="?filtro=status&valor=encerrada{{array_search('encerrada',$filtros['status'])!==false?'&remove=1':''}}" >
                                    <i class="fa fa-{{array_search('encerrada',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Encerradas
                                </a>
                                <a class="dropdown-item" href="?filtro=status&valor=cancelada{{array_search('cancelada',$filtros['status'])!==false?'&remove=1':''}}" >
                                    <i class="fa fa-{{array_search('cancelada',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Canceladas 
                                </a>
                                
                                @else
                        
                                <a class="dropdown-item" href="?filtro=status&valor=lancada"  >
                                    <i class="fa fa-circle-o icon"></i>  Lançadas
                                </a>
                                <a class="dropdown-item" href="?filtro=status&valor=iniciada" >
                                    <i class="fa fa-circle-o icon"></i> Iniciadas
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
                            <button class="btn btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Matrículas
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu4"> 
                                @if(isset($filtros['status_matriculas']))                             
                            
                                <a class="dropdown-item" href="?filtro=status_matriculas&valor=aberta{{array_search('aberta',$filtros['status_matriculas'])!==false?'&remove=1':''}}">
                                    <i class="fa fa-{{array_search('aberta',$filtros['status_matriculas'])!==false?'check-':''}}circle-o icon"></i> Aberta
                                </a>
                                <a class="dropdown-item" href="?filtro=status_matriculas&valor=fechada{{array_search('fechada',$filtros['status_matriculas'])!==false?'&remove=1':''}}" >
                                    <i class="fa fa-{{array_search('fechada',$filtros['status_matriculas'])!==false?'check-':''}}circle-o icon"></i> Fechada
                                </a>
                                <a class="dropdown-item" href="?filtro=status_matriculas&valor=rematricula{{array_search('rematricula',$filtros['status_matriculas'])!==false?'&remove=1':''}}" >
                                    <i class="fa fa-{{array_search('rematricula',$filtros['status_matriculas'])!==false?'check-':''}}circle-o icon"></i> Rematrícula
                                </a>
                                <a class="dropdown-item" href="?filtro=status_matriculas&valor=online{{array_search('online',$filtros['status_matriculas'])!==false?'&remove=1':''}}" >
                                    <i class="fa fa-{{array_search('online',$filtros['status_matriculas'])!==false?'check-':''}}circle-o icon"></i> Online 
                                </a>
                                <a class="dropdown-item" href="?filtro=status_matriculas&valor=presencial{{array_search('presencial',$filtros['status_matriculas'])!==false?'&remove=1':''}}" >
                                    <i class="fa fa-{{array_search('presencial',$filtros['status_matriculas'])!==false?'check-':''}}circle-o icon"></i> Presencial 
                                </a>
                                
                                @else
                        
                                <a class="dropdown-item" href="?filtro=status_matriculas&valor=aberta"  >
                                    <i class="fa fa-circle-o icon"></i>  Aberta
                                </a>
                                <a class="dropdown-item" href="?filtro=status_matriculas&valor=fechada" >
                                    <i class="fa fa-circle-o icon"></i> Fechadas
                                </a>
                                <a class="dropdown-item" href="?filtro=status_matriculas&valor=rematricula" >
                                    <i class="fa fa-circle-o icon"></i> Rematrícula
                                </a>
                                <a class="dropdown-item" href="?filtro=status_matriculas&valor=online" >
                                    <i class="fa fa-circle-o icon"></i> Online 
                                </a>
                                <a class="dropdown-item" href="?filtro=status_matriculas&valor=online" >
                                    <i class="fa fa-circle-o icon"></i> Presencial 
                                </a>
                                
                                @endif
                            </div>
                        
                        
                        </div>
                        
                        <div class="action dropdown" style="float: left; margin-right: 10px;" >

                            <button class="btn btn-sm rounded-s btn-secondary  dropdown-toggle" type="button" id="dropdownMenu5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Período
                            </button>
                            <div class="dropdown-menu "  aria-labelledby="dropdownMenu4"> 
                                @foreach($periodos as $periodo)
                                @if(isset($filtros['periodo']) && array_search($periodo->semestre.$periodo->ano,$filtros['periodo']) !== false)
                                <a class="dropdown-item" onclick="window.location.replace('?filtro=periodo&valor={{$periodo->semestre.$periodo->ano}}&remove=1');">
                                    <i class="fa fa-check-circle-o icon"></i> {{$periodo->semestre>0?$periodo->semestre.'º Sem. '.$periodo->ano:' '.$periodo->ano}}
                                </a> 
                                @else
                                <a class="dropdown-item" onclick="window.location.replace('?filtro=periodo&valor={{$periodo->semestre.$periodo->ano}}');">
                                    <i class="fa fa-circle-o icon"></i>  {{$periodo->semestre>0?$periodo->semestre.'º Sem. '.$periodo->ano:' '.$periodo->ano}}
                                </a> 
                                @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="action dropdown " style="float: left; margin-right: 10px;"> 
                            <button class="btn btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Por datas
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                <small  style="margin: 5px">Início da turma</small>
                                <input type="date" class="form-control boxed" name="data_inicio" style="margin-left: 5px; width:150px "> 
                                <small  style="margin: 5px">Termino da turma</small>
                                <input type="date" class="form-control boxed " name="data_termino" style="margin-left: 5px; width:150px ">
                                <button type="button" name="inicio"  class="btn btn-sm btn-primary" style="margin: 5px" onclick="addFiltroData()">Aplicar</button>
                            </div>
                        </div>
                        <a href="/relatorios/planilha-turmas" class="btn btn-sm btn-secondary"  title="Exporta os dados para um arquivos XLS">Exportar</a>
                    
         
                    </div>

            </div>
        </div>
            
        </div>
    </div>
        <div class="row ">
        <div class="col-xl-12">
        	<table class="table table-striped table-condensed">
        		<thead>
        			<th class="col-md-1 col-sm-1" >Turma</th>
        			<th class="col-md-3 col-sm-3">Curso</th>
        			<th class="col-md-2 col-sm-2">Dia/Horário</th>
                    <th class="col-md-1 col-sm-1">Período</th>
        			<th class="col-md-2 col-sm-2">Programa/Prof.</th>
        			<th class="col-md-1 col-sm-1">Local</th>
                    <th class="col-md-1 col-sm-1">Vagas</th>
                    <th class="col-md-1 col-sm-1">Inscritos</th>
        		</thead>
        		<tbody>
        			 @foreach($turmas as $turma)
        			<tr>
        				<td class="col-md-1 col-sm-1">{{$turma->id}}</td>
        				<td class="col-md-3 col-sm-3">
                            Estado: {{$turma->status}}<br>
        					@if(isset($turma->disciplina))	
                                 {{$turma->disciplina->nome}}     
                                <small>{{$turma->curso->nome}}</small>                            
                           @else
               
                                 {{$turma->curso->nome}}         
                            
                            @endif
                        </td>
        				<td class="col-md-2 col-sm-2">{{implode(', ',$turma->dias_semana)}} <br> {{$turma->hora_inicio}} ás {{$turma->hora_termino}}</td>
                        <td class="col-md-1 col-sm-1">{{$turma->data_inicio}}<br>{{$turma->data_termino}}</td>
        				<td class="col-md-2 col-sm-2">{{$turma->programa->sigla}}<br>{{$turma->professor->nome_simples}}</td>
        				<td class="col-md-1 col-sm-1">{{$turma->local->sigla}}<br>{{isset($turma->sala->nome)?$turma->sala->nome:''}}</td>
                        <td class="col-md-1 col-sm-1">{{$turma->vagas}}</td>
                        <td class="col-md-1 col-sm-1">{{$turma->matriculados}}</td>
        			</tr>
        			@endforeach
        		</tbody>
        	</table>

         
            <!-- /.card -->
        </div>
        <!-- /.col-xl-6 -->
        
        <!-- /.col-xl-6 -->
    </div>
        <footer class="align-bottom align-text-bottom">
        Assinatura
        </footer>
	</div>
        	
	<script src="{{asset('/js/vendor.js')}}">
	</script>
    <script type="text/javascript">
        function addFiltroData(){
        
            inicio = document.getElementsByName("data_inicio")[0].value;
            termino = document.getElementsByName("data_termino")[0].value;
            window.location.href = '/relatorios/turmas/?filtro=pordata&valor=i'+inicio+'t'+termino;
        }
    </script>
</body>

</html>

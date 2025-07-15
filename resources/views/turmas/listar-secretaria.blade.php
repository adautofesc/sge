@extends('layout.app')
@section('pagina')

<div class="title-block">
    <h3 class="title"> Todas as turmas</h3>
    <div class="row">
        <br>
        @include('inc.errors')
        <div class=" card-block col-sm-9">
            
            Mostrando {{count($turmas)}} turmas. Filtros:  

            <!--
            <a href="?limparfiltro=1">
                <i class="fa fa-remove" style="color:red"></i>
                Limpar Filtros
            </a> -->
            @foreach($filtros as $filtro=>$valor)
                @if(count($filtros[$filtro]))

                    <a href="?removefiltro={{$filtro}}" class="badge badge-primary" style="color:white;text-decoration: none;" title="Remover este filtro">
                        <i class="fa fa-remove" ></i>
                        {{$filtro}}: {{ implode(',',$valor) }}
                    </a>
                @endif
            @endforeach
       

        </div>
        
    
    </div>
    <form>
    <div class="row ">
        <div class="col-sm-12">
            <div class=" card card-block rounded small" style="height:4rem;">
                <div class="form-group row "> 
                    <!--
                    <div class="col-sm-3"> 
                        <div class="input-group rounded-s">
                            
                            <input type="text" class="form-control boxed rounded-s" name="buscar" placeholder="Buscar"> 

                        </div>
                    </div>
                -->
                
                    <div class="col-sm-8"> 
                        
                        <div class="action dropdown "> 
                            <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Programa
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                @foreach($programas as $programa)

                                @if(isset($filtros['programa']) &&  array_search($programa->id,$filtros['programa']) !== false)
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=programa&valor={{$programa->id}}&remove=1')">
                                    <i class="fa fa-check-circle-o icon"></i> {{$programa->sigla}}
                                </label>
                                @else
                                <label class="dropdown-item"  onclick="window.location.replace('?filtro=programa&valor={{$programa->id}}')">
                                    <i class="fa fa-circle-o icon"></i> {{$programa->sigla}}
                                </label>
                                @endif
                                @endforeach 
                               
                            </div>
                        </div>
                        <div class="action dropdown "> 
                            <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Professor
                            </button>
                            <div class="dropdown-menu" style="height:30em;px;overflow-y:scroll;" aria-labelledby="dropdownMenu2"> 
                                @foreach($professores as $professor)
                                @if(isset($filtros['professor']) && array_search($professor->id,$filtros['professor']) !== false)
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=professor&valor={{$professor->id}}&remove=1')">
                                    <i class="fa fa-check-circle-o icon"></i> <strong>{{$professor->nome_simples}}</strong>
                                </label> 
                                @else
                                <label class="dropdown-item"  onclick="window.location.replace('?filtro=professor&valor={{$professor->id}}')">
                                    <i class="fa fa-circle-o icon"></i> {{$professor->nome_simples}}
                                </label> 
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="action dropdown "> 
                            <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Local
                            </button>
                            <div class="dropdown-menu" style="height:30em;px;overflow-y:scroll;" aria-labelledby="dropdownMenu3">
                                @if(isset($filtros['local']) && array_search(84,$filtros['local']) !== false)
                                    <label class="dropdown-item" onclick="window.location.replace('?filtro=local&valor=84&remove=1')" title="FESC 1" >
                                        <i class="fa fa-check-circle-o icon"></i>FESC 1
                                    </label>
                                @else
                                    <label class="dropdown-item" onclick="window.location.replace('?filtro=local&valor=84')" title="FESC 1" >
                                        <i class="fa fa-circle-o icon"></i>FESC 1
                                    </label> 
                                @endif

                                @if(isset($filtros['local']) && array_search(85,$filtros['local']) !== false)
                                    <label class="dropdown-item" onclick="window.location.replace('?filtro=local&valor=85&remove=1')" title="FESC 2" >
                                        <i class="fa fa-check-circle-o icon"></i>FESC 2
                                    </label>
                                @else
                                    <label class="dropdown-item" onclick="window.location.replace('?filtro=local&valor=85')" title="FESC 2" >
                                        <i class="fa fa-circle-o icon"></i>FESC 2
                                    </label> 
                                @endif

                                @if(isset($filtros['local']) && array_search(86,$filtros['local']) !== false)
                                    <label class="dropdown-item" onclick="window.location.replace('?filtro=local&valor=86&remove=1')" title="FESC 3" >
                                        <i class="fa fa-check-circle-o icon"></i>FESC 3
                                    </label>
                                @else
                                    <label class="dropdown-item" onclick="window.location.replace('?filtro=local&valor=86')" title="FESC 3" >
                                        <i class="fa fa-circle-o icon"></i>FESC 3
                                    </label> 
                                @endif

                                @if(isset($filtros['local']) && array_search(118,$filtros['local']) !== false)
                                    <label class="dropdown-item" onclick="window.location.replace('?filtro=local&valor=118&remove=1')" title="FESC VIRTUAL" >
                                        <i class="fa fa-check-circle-o icon"></i>FESC VIRTUAL
                                    </label>
                                @else
                                    <label class="dropdown-item" onclick="window.location.replace('?filtro=local&valor=118')" title="FESC VIRTUAL" >
                                        <i class="fa fa-circle-o icon"></i>FESC VIRTUAL
                                    </label> 
                                @endif
                                
                                @foreach($locais as $local)
                                @if(isset($filtros['local']) && array_search($local->id,$filtros['local']) !== false)
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=local&valor={{$local->id}}&remove=1')" title="Remover filtro: {{$local->nome}}" >
                                    <i class="fa fa-check-circle-o icon"></i>{{$local->sigla}}
                                </label>
                                @else
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=local&valor={{$local->id}}')" title="{{$local->nome}}" >
                                    <i class="fa fa-circle-o icon"></i>{{$local->sigla}}
                                </label> 
                                @endif
                                @endforeach
                                
                            </div>
                        </div>
                        
                        <div class="action dropdown "> 
                            <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Status
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu4"> 
                                @if(isset($filtros['status']))                             
                               
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=lancada{{array_search('lancada',$filtros['status'])!==false?'&remove=1':''}}');">
                                    <i class="fa fa-{{array_search('lancada',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Lançadas
                                </label>
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=iniciada{{array_search('iniciada',$filtros['status'])!==false?'&remove=1':''}}');">
                                    <i class="fa fa-{{array_search('iniciada',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Iniciadas
                                </label>
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=encerrada{{array_search('encerrada',$filtros['status'])!==false?'&remove=1':''}}');">
                                    <i class="fa fa-{{array_search('encerrada',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Encerradas
                                </label>
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=cancelada{{array_search('cancelada',$filtros['status'])!==false?'&remove=1':''}}');">
                                    <i class="fa fa-{{array_search('cancelada',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Canceladas 
                                </label>
                                
                                @else
                        
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=lancada');">
                                    <i class="fa fa-circle-o icon"></i>  Lançadas
                                </label>
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=iniciada');">
                                    <i class="fa fa-circle-o icon"></i> Iniciadas
                                </label>
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=encerrada');">
                                    <i class="fa fa-circle-o icon"></i> Encerradas
                                </label>
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status&valor=cancelada');">
                                    <i class="fa fa-circle-o icon"></i> Canceladas 
                                </label>
                                
                                @endif
                            </div>

                        </div>
                        <div class="action dropdown "> 
                            <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Matrículas
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu4"> 
                                @if(isset($filtros['status_matriculas']))                             
                               
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status_matriculas&valor=aberta{{array_search('aberta',$filtros['status_matriculas'])!==false?'&remove=1':''}}');">
                                    <i class="fa fa-{{array_search('aberta',$filtros['status_matriculas'])!==false?'check-':''}}circle-o icon"></i> Aberta
                                </label>
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status_matriculas&valor=fechada{{array_search('fechada',$filtros['status_matriculas'])!==false?'&remove=1':''}}');">
                                    <i class="fa fa-{{array_search('fechada',$filtros['status_matriculas'])!==false?'check-':''}}circle-o icon"></i> Fechada
                                </label>
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status_matriculas&valor=rematricula{{array_search('rematricula',$filtros['status_matriculas'])!==false?'&remove=1':''}}');">
                                    <i class="fa fa-{{array_search('rematricula',$filtros['status_matriculas'])!==false?'check-':''}}circle-o icon"></i> Rematrícula
                                </label>
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status_matriculas&valor=online{{array_search('online',$filtros['status_matriculas'])!==false?'&remove=1':''}}');">
                                    <i class="fa fa-{{array_search('online',$filtros['status_matriculas'])!==false?'check-':''}}circle-o icon"></i> Online 
                                </label>
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status_matriculas&valor=presencial{{array_search('presencial',$filtros['status_matriculas'])!==false?'&remove=1':''}}');">
                                    <i class="fa fa-{{array_search('presencial',$filtros['status_matriculas'])!==false?'check-':''}}circle-o icon"></i> Presencial 
                                </label>
                                
                                @else
                        
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status_matriculas&valor=aberta');">
                                    <i class="fa fa-circle-o icon"></i>  Aberta
                                </label>
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status_matriculas&valor=fechada');">
                                    <i class="fa fa-circle-o icon"></i> Fechadas
                                </label>
                                
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status_matriculas&valor=rematricula_presencial');">
                                    <i class="fa fa-circle-o icon"></i> Rematrícula Presencial
                                </label>

                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status_matriculas&valor=rematricula');">
                                    <i class="fa fa-circle-o icon"></i> Rematrícula Geral
                                </label>

                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status_matriculas&valor=online');">
                                    <i class="fa fa-circle-o icon"></i> Online 
                                </label>
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=status_matriculas&valor=presencial');">
                                    <i class="fa fa-circle-o icon"></i> Presencial 
                                </label>
                                
                                @endif
                            </div>

                        </div>
                        
                        <div class="action dropdown" >

                            <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Período
                            </button>
                            <div class="dropdown-menu "  aria-labelledby="dropdownMenu5"> 
                                @foreach($periodos as $periodo)
                                @if(isset($filtros['periodo']) && array_search($periodo->semestre.$periodo->ano,$filtros['periodo']) !== false)
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=periodo&valor={{$periodo->semestre.$periodo->ano}}&remove=1');" style="text-decoration: none;">
                                    <i class="fa fa-check-circle-o icon"></i> {{$periodo->semestre>0?$periodo->semestre.'º Sem. '.$periodo->ano:' '.$periodo->ano}}
                                </label> 
                                @else
                                <label class="dropdown-item" onclick="window.location.replace('?filtro=periodo&valor={{$periodo->semestre.$periodo->ano}}');" style="text-decoration: none;">
                                    <i class="fa fa-circle-o icon"></i>  {{$periodo->semestre>0?$periodo->semestre.'º Sem. '.$periodo->ano:' '.$periodo->ano}}
                                </label> 
                                @endif
                                @endforeach
                            </div>
                        </div>

                
         
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-sm" style="float:left;">
                            <input type="hidden" name="filtro" value="busca">
                            <input type="text" class="form-control" name="valor" id ="busca" placeholder="Buscar por turma" onkeypress="enter(event)" title="Você pode procurar pelo código da turma, nome do curso/disciplina, nome do professor, sigla do programa ou dia da semana (os 3 primeiros caracteres de cada dia, separado por virgula).">
                            <i class="input-group-addon fa fa-search" onclick="buscar()" style="cursor:pointer;"></i>
                        </div>
                    </div>
                </div>
              
                
            </div>
            
        </div>
    </div>
    

</form>
</div>



<form name="item" class="form-inline">
	<section class="section">
    <div class="row ">
            
        <div class="col-xl-12">
            <div class="card sameheight-item">
                <div class="card-block">
                    <!-- Nav tabs -->
                    <div class="row">
                        <div class="col-xs-4">
                                {{ $turmas->links() }}
                        </div>
                            
                        <div class="col-xs-8 text-xs-right">
                                
                                <a href="/turmas/cadastrar" class="btn btn-success-outline  btn-sm rounded-s" ><i class="fa fa-asterisk"></i> Nova Turma</a>&nbsp;&nbsp;
                            <div class="action dropdown pull-right "> 
                                <button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenuAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Alterar Selecionadas
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuAction"> 
                                    <label class="dropdown-item btn btn-sm btn-primary" href="#" style="line-height: 20px;text-decoration: none; color:white">
                                    Abertura de Matriculas
                                    </label>
                                    <a class="dropdown-item" style="line-height: 30px; text-decoration: none;" href="#" onclick="alterarStatusMatricula('aberta')"  title="Abrir matrículas presenciais e online">
                                        <i class="fa fa-circle-o icon"></i> Abrir Matrículas Geral
                                    </a> 
                                    <a class="dropdown-item" style="line-height: 30px; text-decoration: none;" href="#" onclick="alterarStatusMatricula('presencial')" title="Abrir matrículas somente para modalidade presencial">
                                        <i class="fa fa-circle-o icon"></i> Abrir Matrículas Presenciais
                                    </a> 
                                    <a class="dropdown-item" style="line-height: 30px; text-decoration: none;" href="#" onclick="alterarStatusMatricula('online')"  title="Abrir matrículas somente para modalidade online">
                                        <i class="fa fa-circle-o icon"></i> Abrir Matrículas Online
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatusMatricula('fechada')" title="Encerra todas formas matrículas" style="line-height: 30px; text-decoration: none">
                                        <i class="fa fa-circle-o icon"></i> Fechar Matrículas
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="alterarStatusMatricula('rematricula_presencial')" title="Abrir apenas para alunos anteriores, somente presencial" style="line-height: 30px; text-decoration: none">
                                        <i class="fa fa-circle-o icon"></i> Abrir para Rematrícula Presencial
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="alterarStatusMatricula('rematricula')" title="Abrir apenas para alunos anteriores presencial ou online" style="line-height: 30px; text-decoration: none">
                                        <i class="fa fa-circle-o icon"></i> Abrir para Rematrícula Geral
                                    </a>

                                    <label class="dropdown-item btn btn-sm btn-primary" href="#" style="line-height: 20px;text-decoration: none; color:white">
                                    Alterar status para:
                                     </label>
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('lancada')"  title="Se a turma ainda não começou" style="line-height: 30px;text-decoration: none;">
                                        <i class="fa fa-clock-o icon"></i> Lançada
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('iniciada')" title="Se a turma já começou" style="line-height: 30px;text-decoration: none;">
                                        <i class="fa fa-check-circle-o icon"></i> Iniciar
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('encerrada')" title="Se a turma acabou" style="line-height: 30px;text-decoration: none;" >
                                        <i class="fa fa-minus-circle icon"></i> Encerrar
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('cancelada')" title="Se a turma não aconteceu" style="line-height: 30px;text-decoration: none;">
                                        <i class="fa fa-ban icon"></i> Cancelar 
                                    </a>
                                   
                                    
                                </div>
                            </div>
                            <div class="action dropdown pull-right "> 
                                <button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenuAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Ferramentas
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuAction"> 
                                    <a class="dropdown-item" href="#" onclick="alterarlote('relancar')" style="line-height: 30px;text-decoration: none;">
                                        <i class="fa fa-retweet icon"></i> Relançar Turmas
                                    </a>
                                <a class="dropdown-item" href="#" onclick="alterarlote('requisitos')" style="line-height: 30px;text-decoration: none;">
                                        <i class="fa fa-sign-in icon"></i> Alterar requisitos
                                    </a>
                                 <a class="dropdown-item" href="#" onclick="getDados();" style="line-height: 30px;text-decoration: none;">
                                    <i class="fa fa-group icon"></i> Dados da(s) turma(s)
                                </a>
                                 <a class="dropdown-item" href="#" onclick="getListas();" style="line-height: 30px;text-decoration: none;">
                                    <i class="fa fa-print icon"></i> Imprimir listas
                                </a>
                                <a class="dropdown-item" href="#" onclick="exportar();" style="line-height: 30px;text-decoration: none;">
                                    <img src="/img/excel.png" width="17px;"> Exportar alunos ativos
                                </a>
                                <a class="dropdown-item" href="#" onclick="exportarSMS();" style="line-height: 30px;text-decoration: none;" title="Exporta os alunos das turmas selecionadas para o envio de SMS">
                                    <i class="fa fa-comments-o icon"></i> Exportar TXT para SMS
                                </a>
                                <a class="dropdown-item" href="/relatorios/planilha-turmas"  style="line-height: 30px;text-decoration: none;" title="Exporta turmas atuais para uma planilha XLS">
                                    <img src="/img/excel.png" width="17px;"> Exportar para planilha
                                </a>
                                
                                </div>
                            </div>
                        </div>
                        

                    </div>
                    
                    <div class="tab-content tabs-bordered">
                        <!-- Tab panes ******************************************************************************** -->
                        
                                <section class="example">
                                    <div class="table-flip-scroll">

                                        <ul class="item-list striped">
                                            <li class="item item-list-header hidden-sm-down">
                                                <div class="item-row">
                                                    <div class="item-col fixed item-col-check">
                                                        <label class="item-check">
                                                        <input type="checkbox" class="checkbox" onchange="selectAllItens(this);">
                                                        <span></span>
                                                        </label> 
                                                    </div>
                                                    
                                                    <div class="item-col item-col-header item-col-title">
                                                        <div> <span>Curso</span> </div>
                                                    </div>
                                                    <div class="item-col item-col-header item-col-sales">
                                                        <div> <span>Professor/Unidade</span> </div>
                                                    </div>

                                                    <div class="item-col item-col-header item-col-sales">
                                                        <div> <span>Vagas/Ocup</span> </div>
                                                    </div>
                                                    <div class="item-col item-col-header item-col-sales">
                                                        <div> <span>Valor</span> </div>
                                                    </div>

                                                    <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                                                </div>
                                            </li>
                                            @foreach($turmas as $turma)


                                                                                  
                                            <li class="item">
                                                <div class="item-row">
                                                    <div class="item-col fixed item-col-check"> 


                                                        <label class="item-check" >
                                                        <input type="checkbox" class="checkbox" name="turma" value="{{$turma->id}}">
                                                        <span></span>
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="item-col fixed pull-left item-col-title">
                                                    <div class="item-heading">Curso/atividade</div>
                                                    <div class="">
                                                        
                                                             <div href="#" style="margin-bottom:5px;" class="color-primary">
                                                                @switch($turma->status_matriculas)
                                                                    @case('aberta')
                                                                        <span  class="badge badge-pill badge-success" style="font-size: 0.8rem">
                                                                            <i class="fa fa-sign-in icon" title="Matriculas abertas"></i> Inscrições abertas
                                                                        </span>
                                                                        @break
                                                                    @case('online')
                                                                    @case('presencial')
                                                                    @case('rematricula')
                                                                    @case('rematricula_presencial')
                                                                        <span  class="badge badge-pill badge-info" style="font-size: 0.8rem">
                                                                            <i class="fa fa-sign-in  icon" title="Matriculas {{$turma->status_matriculas}} abertas"></i> Inscrições abertas p/{{$turma->status_matriculas}}
                                                                        </span>
                                                                        
                                                                        @break
                                                                    @default
                                                                        
                                                                @endswitch
                                                                <br/>
                                                        
                                                                <strong>Turma {{$turma->id}}  </strong> 
                                                                @switch($turma->status)
                                                                    @case('lancada')
                                                                        <span class="text-info">
                                                                        Lançada
                                                                        @break
                                                                    @case('iniciada')
                                                                        <span class="text-success">
                                                                        Iniciada
                                                                        @break
                                                                    @case('encerrada')
                                                                        <span class="text-mute">
                                                                        Encerrada
                                                                        @break
                                                                    @case('cancelada')
                                                                        <span class="text-danger">
                                                                        Cancelada
                                                                        @break
                                                                        
                                                                       
                                                                    @default
                                                                    <span>
                                                                    {{$turma->status}}
                                                                        
                                                                @endswitch
                                                                   
                            
                                                                     
                                                                    </span>
                                                                     <small>Início em 


                                                                {{$turma->data_inicio}}.</small></div> 

                                                       @if(isset($turma->disciplina))
                                                        <a href="{{asset('turmas/'.$turma->id)}}"  title="Abrir dados da turma">
                                                            <h4 class="item-title"> {{$turma->disciplina->nome}}</h4>       
                                                            <small>{{$turma->curso->nome}}</small>
                                                        </a>
                                                       @else
                                                        <a href="{{asset('turmas/'.$turma->id)}}"   title="Abrir dados da turma">
                                                            <h4 class="item-title"> {{$turma->curso->nome}}</h4>           
                                                        </a>
                                                        @endif
                                                         {{implode(', ',$turma->dias_semana)}} - {{$turma->hora_inicio}} ás {{$turma->hora_termino}}
                                                    </div>
                                                </div>
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Professor(a)</div>
                                                        <div> {{$turma->professor->nome_simples}}
                                                            <div>{{$turma->local->sigla}}</div>
                                                            <div title="Sala"><small>{{isset($turma->sala->nome)?$turma->sala->nome:''}}</small></div>
                                                        </div>
                                                    </div>
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Vagas</div>
                                                        <div>{{$turma->vagas}} / {{$turma->matriculados}} </div>
                                                    </div>
                                                     
                                                   
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Valor</div>
                                                        <div>
                                                            @if($turma->pacote)
                                                                Confira o valor <br> do pacote
                                                            @else
                                                                R$ {{number_format($turma->valor,2,',','.')}}<br>
                                                                Em {{$turma->getParcelas()}}X <br>
                                                                    @if($turma->getParcelas()>0)
                                                                    R$ {{number_format($turma->valor/$turma->getParcelas(),2,',','.')}}
                                                                    @endif
                                                            @endif   
                                                    </div>
                                                  

                                                    <div class="item-col fixed item-col-actions-dropdown">
                                                        <div class="item-actions-dropdown">
                                                            <a class="item-actions-toggle-btn"> 
                                                                <span class="inactive">
                                                                    <i class="fa fa-cog"></i>
                                                                </span> 
                                                                <span class="active">
                                                                    <i class="fa fa-chevron-circle-right"></i>
                                                                </span>
                                                            </a>
                                                            <div class="item-actions-block">
                                                                <ul class="item-actions-list">                                     
                                                                    <li>
                                                                         <a class="remove" title="Cancelar" href="#" onclick=cancelar({{$turma->id}})> <i class="fa fa-ban "></i> </a>
                                                                    </li>
                                                                    <li>
                                                                         <a class="remove" href="#" title="Apagar" onclick=apagar({{$turma->id}})> <i class="fa fa-trash-o "></i> </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="edit" title="Editar" href="#" onclick="editar({{$turma->id}})"> <i class="fa fa-pencil"></i> </a>
                                                                    </li>
                                                                     <li>
                                                                        <a href="/chamada/{{$turma->id}}/0/pdf" class="edit" target="_blank"> <i class="fa fa-print"></i> </a>
                                                                    </li>
                                                                </ul>
                                                                
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                           
                                            @endforeach
                                        </ul>
                                    </div>
                                </section>
                            
                    </div>
                </div>
                <!-- /.card-block -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-xl-6 -->
        
        <!-- /.col-xl-6 -->
    </div>
</section>
{{ $turmas->links() }}

</form>
@endsection
@section('scripts')
<script>
function apagar(turma){
    if(confirm("Deseja mesmo apagar essa turma?"))
        $(location).attr('href','{{route('turmas')}}/apagar/'+turma);

}
function abrir(turma){
    if(confirm("Deseja mesmo abrir as matrículas dessa turma?"))
        $(location).attr('href','{{route('turmas')}}/status/inscricao/'+turma);

}
function suspender(turma){
    if(confirm("Deseja mesmo suspender as matrículas dessa turma?"))
      $(location).attr('href','{{route('turmas')}}/status/espera/'+turma);

}
function iniciar(turma){
    if(confirm("Deseja mesmo iniciar o período letivo essa turma?"))
       $(location).attr('href','{{route('turmas')}}/status/iniciada/'+turma);

}
function editar(turma){
        $(location).attr('href','{{route('turmas')}}/editar/'+turma);

}
function cancelar(turma){
    if(confirm("Deseja mesmo cancelar essa turma?"))
        $(location).attr('href','{{route('turmas')}}/status/cancelada/'+turma);

}
function alterarStatus(status){
     var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente alterar as turmas selecionadas?'))
            $(location).attr('href','{{route('turmas')}}/status/'+status+'/'+selecionados);

    
}
function alterarStatusMatricula(status){
     var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente alterar as turmas selecionadas?'))
            $(location).attr('href','{{route('turmas')}}/status-matriculas/'+status+'/'+selecionados);

    
}
function alterarlote(status){
     var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente '+status+' as turmas selecionadas?'))
            $(location).attr('href','{{route('turmas')}}/alterar/'+status+'/'+selecionados);

    
}
function getDados(){
    var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
            $(location).attr('href','/relatorios/dados-turmas/'+selecionados);

}
function getListas(){
    var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
            $(location).attr('href','/listas/'+selecionados);

}
function exportar(){
    var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
            $(location).attr('href','/relatorios/alunos-turmas?turmas='+selecionados);

}
function exportarSMS(){
    var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
            $(location).attr('href','/relatorios/alunos-turmas-sms?turmas='+selecionados);

}
function enter(e){
    if (e.which == 13 || e.keyCode == 13 || e.key == 13) {
        buscar();
    }

}
function buscar(){
    query = $('#busca').val();
    $(location).attr('href','/turmas?filtro=busca&valor='+query);

}


</script>



@endsection
 @extends('layout.app')
@section('pagina')

<div class="title-block">
    <h3 class="title"> Turmas - gerenciamento pedagógico</h3>






    <div class="row">
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

                    <a href="?removefiltro={{$filtro}}" style="text-decoration:none;" title="Remover este filtro">
                        <i class="fa fa-remove" style="color:red"></i>
                        {{$filtro}}
                    </a>
                @endif
            @endforeach
       

        </div>
        <div class="col-sm-3">
            Ordenar por: <strong>Curso</strong>

        </div>
    
    </div>
    <form>
        <div class="row " >
            <div class="col-sm-12" >
                <div class=" card card-block rounded-s small" style="height:4rem;">
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
                                    <a class="dropdown-item" href="?filtro=programa&valor={{$programa->id}}&remove=1">
                                        <i class="fa fa-check-circle-o icon"></i>{{$programa->sigla}}
                                    </a>
                                    @else
                                    <a class="dropdown-item" href="?filtro=programa&valor={{$programa->id}}">
                                        <i class="fa fa-circle-o icon"></i>{{$programa->sigla}}
                                    </a>
                                    @endif
                                    @endforeach 
                                
                                </div>
                            </div>
                            <div class="action dropdown "> 
                                <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Professor
                                </button>
                                <div class="dropdown-menu" style="height:30em;px;overflow-y:scroll;" aria-labelledby="dropdownMenu1"> 
                                    @foreach($professores as $professor)
                                    @if(isset($filtros['professor']) && array_search($professor->id,$filtros['professor']) !== false)
                                    <a class="dropdown-item" href="?filtro=professor&valor={{$professor->id}}&remove=1">
                                        <i class="fa fa-check-circle-o icon"></i>{{$professor->nome_simples}}
                                    </a> 
                                    @else
                                    <a class="dropdown-item" href="?filtro=professor&valor={{$professor->id}}">
                                        <i class="fa fa-circle-o icon"></i>{{$professor->nome_simples}}
                                    </a> 
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="action dropdown "> 
                                <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Local
                                </button>
                                <div class="dropdown-menu" style="height:30em;px;overflow-y:scroll;" aria-labelledby="dropdownMenu1">
                                    @if(isset($filtros['local']) && array_search(84,$filtros['local']) !== false)
                                        <a class="dropdown-item" href="?filtro=local&valor=84&remove=1" title="FESC 1" >
                                            <i class="fa fa-check-circle-o icon"></i>FESC 1
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="?filtro=local&valor=84" title="FESC 1" >
                                            <i class="fa fa-circle-o icon"></i>FESC 1
                                        </a> 
                                    @endif

                                    @if(isset($filtros['local']) && array_search(85,$filtros['local']) !== false)
                                        <a class="dropdown-item" href="?filtro=local&valor=85&remove=1" title="FESC 2" >
                                            <i class="fa fa-check-circle-o icon"></i>FESC 2
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="?filtro=local&valor=85" title="FESC 2" >
                                            <i class="fa fa-circle-o icon"></i>FESC 2
                                        </a> 
                                    @endif

                                    @if(isset($filtros['local']) && array_search(86,$filtros['local']) !== false)
                                        <a class="dropdown-item" href="?filtro=local&valor=86&remove=1" title="FESC 3" >
                                            <i class="fa fa-check-circle-o icon"></i>FESC 3
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="?filtro=local&valor=86" title="FESC 3" >
                                            <i class="fa fa-circle-o icon"></i>FESC 3
                                        </a> 
                                    @endif

                                    @if(isset($filtros['local']) && array_search(118,$filtros['local']) !== false)
                                        <a class="dropdown-item" href="?filtro=local&valor=118&remove=1" title="FESC VIRTUAL" >
                                            <i class="fa fa-check-circle-o icon"></i>FESC VIRTUAL
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="?filtro=local&valor=118" title="FESC VIRTUAL" >
                                            <i class="fa fa-circle-o icon"></i>FESC VIRTUAL
                                        </a> 
                                    @endif
                                    
                                    @foreach($locais as $local)
                                    @if(isset($filtros['local']) && array_search($local->id,$filtros['local']) !== false)
                                    <a class="dropdown-item" href="?filtro=local&valor={{$local->id}}&remove=1" title="{{$local->nome}}" >
                                        <i class="fa fa-check-circle-o icon"></i>{{$local->sigla}}
                                    </a>
                                    @else
                                    <a class="dropdown-item" href="?filtro=local&valor={{$local->id}}" title="{{$local->nome}}" >
                                        <i class="fa fa-circle-o icon"></i>{{$local->sigla}}
                                    </a> 
                                    @endif
                                    @endforeach
                                    
                                </div>
                            </div>
  
                    <div class="action dropdown "> 
                        <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Status
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu4"> 
                            @if(isset($filtros['status']))                             
                           
                            <a class="dropdown-item" href="?filtro=status&valor=espera{{array_search('lancada',$filtros['status'])!==false?'&remove=1':''}}">
                                <i class="fa fa-{{array_search('espera',$filtros['status'])!==false?'check-':''}}circle-o icon"></i> Lançadas
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
                    <div class="action dropdown "> 
                        <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Matrículas
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
                            <a class="dropdown-item" href="?filtro=status_matriculas&valor=presencial" >
                                <i class="fa fa-circle-o icon"></i> Presencial 
                            </a>
                            
                            @endif
                        </div>

                    </div>
                            <div class="action dropdown" >

                                    <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Período
                                    </button>
                                    <div class="dropdown-menu "  aria-labelledby="dropdownMenu5"> 
                                        @foreach($periodos as $periodo)
                                        @if(isset($filtros['periodo']) && array_search($periodo->semestre.$periodo->ano,$filtros['periodo']) !== false)
                                        <a class="dropdown-item" href="?filtro=periodo&valor={{$periodo->semestre.$periodo->ano}}&remove=1" style="text-decoration: none;">
                                            <i class="fa fa-check-circle-o icon"></i> {{$periodo->semestre.'º Sem. '.$periodo->ano}}
                                        </a> 
                                        @else
                                        <a class="dropdown-item" href="?filtro=periodo&valor={{$periodo->semestre.$periodo->ano}}" style="text-decoration: none;">
                                            <i class="fa fa-circle-o icon"></i> {{$periodo->semestre.'º Sem. '.$periodo->ano}}
                                        </a> 
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                @if(in_array('18', Auth::user()->recursos))
                                    <a href="/secretaria/turmas/" class="btn btn-primary btn-sm rounded-s" title="Ver essa lista em modo Secretaria"><i class="fa fa-stack-overflow"></i> Modo Secretaria</a>
                                @endif
            
                        </div>
                    </div>
                
                    
                </div>
                
            </div>
        </div>
    

    </form>




</div>


@include('inc.errors')

<form name="item" class="form-inline" method="post">
	<section class="section">  
    <div class="row ">
        <div class="col-xl-12 ">
            <div class="card sameheight-item">
                <div class="card-block">
                        <div class="row">
                                <div class="col-xs-7">
                                        {{ $turmas->links() }}
                                </div>
                                    
                                <div class="col-xs-5 text-xs-right">
                                    <div class="action dropdown pull-right "> 
                                        <button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenuAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Com os selecionados...
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuAction"> 
                                            </a>
                                             <a class="dropdown-item" href="#" onclick="getDados();" style="line-height: 30px;text-decoration: none;">
                                                <i class="fa fa-group icon"></i> Dados da(s) turma(s)
                                            </a>
                                             <a class="dropdown-item" href="#" onclick="getListas('branco');" style="line-height: 30px;text-decoration: none;">
                                                <i class="fa fa-print icon"></i> Imprimir listas em branco
                                            </a>
                                            <a class="dropdown-item" href="#" onclick="getListas('preenchidas');" style="line-height: 30px;text-decoration: none;">
                                                <i class="fa fa-print icon"></i> Imprimir listas preenchidas
                                            </a>
                                            <a class="dropdown-item" href="#" onclick="exportar();" style="line-height: 30px;text-decoration: none;">
                                                <img src="/img/excel.png" width="17px;"> Exportar alunos ativos
                                            </a>
                                        </div>
                                     </div>
                                </div>
        
                            </div>
                    <div class="tab-content tabs-bordered">
                        <!-- Tab panes ******************************************************************************** -->
                        <div class="tab-pane fade in active" id="todos">
                            <section class="example">
                                <div class="table-flip-scroll">
                                    <ul class="item-list striped">
                                        <li class="item item-list-header hidden-sm-down">
                                            <div class="item-row">
                                                <div class="item-col fixed item-col-check">
                                                    <label class="item-check" id="select-all-items">
                                                    <input type="checkbox" class="checkbox">
                                                    <span></span>
                                                    </label> 
                                                </div>
                                                
                                                <div class="item-col item-col-header item-col-title">
                                                    <div> <span>Curso</span> </div>
                                                </div>
                                                <div class="item-col item-col-header item-col-sales">
                                                    <div> <span>Professor/Local</span> </div>
                                                </div>

                                                <div class="item-col item-col-header item-col-sales">
                                                    <div> <span>Vagas/Ocup.</span> </div>
                                                </div>
                                                <div class="item-col item-col-header item-col-sales">
                                                    <div> <span>Carga</span> </div>
                                                </div>
                                                <div class="item-col item-col-header item-col-sales">
                                                    <div> <span>Valor</span> </div>
                                                </div>

                                                <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                                            </div>
                                        </li>
                                        @foreach($turmas->all() as $turma)
                                        <li class="item">
                                            <div class="item-row ">
                                                <div class="item-col fixed item-col-check"> 

                                                    <label class="item-check" id="select-all-items">
                                                    <input type="checkbox" class="checkbox" name="turma" value="{{$turma->id}}">
                                                    <span></span>
                                                    </label>
                                                </div>
                                                
                                                <div class="item-col fixed pull-left item-col-title">
                                                    <div class="item-heading">Curso/atividade</div>
                                                    <div class="">
                                                        
                                                            <div href="#" style="margin-bottom:5px;" class="color-primary">Turma {{$turma->id}}  
                                                               @if($turma->status == 'andamento' || $turma->status == 'iniciada' )
                                                                   <span  class="badge badge-pill badge-success" style="font-size: 0.8rem">
                                                               @elseif($turma->status == 'espera' || $turma->status == 'lancada' || $turma->status == 'inscricao' )
                                                                    <span  class="badge badge-pill badge-info" style="font-size: 0.8rem">
                                                               @elseif($turma->status == 'cancelada')
                                                                    <span  class="badge badge-pill badge-danger" style="font-size: 0.8rem">
                                                               @else
                                                                    <span  class="badge badge-pill badge-secondary" style="font-size: 0.8rem">
                                                               @endif
                                                                    <i class="fa fa-{{$turma->icone_status}} icon"></i> {{$turma->status}}
                                                                   </span>
                                                                    <small>Início em 


                                                               {{$turma->data_inicio}}.</small></div> 

                                                      @if(isset($turma->disciplina))
                                                       <a href="{{asset('turmas/dados-gerais/'.$turma->id)}}"  title="Abrir dados da turma">
                                                           <h4 class="item-title"> {{$turma->disciplina->nome}}</h4>       
                                                           <small>{{$turma->curso->nome}}</small>
                                                       </a>
                                                      @else
                                                       <a href="{{asset('turmas/dados-gerais/'.$turma->id)}}"   title="Abrir dados da turma">
                                                           <h4 class="item-title"> {{$turma->curso->nome}}</h4>           
                                                       </a>
                                                       @endif
                                                        {{implode(', ',$turma->dias_semana)}} - {{$turma->hora_inicio}} ás {{$turma->hora_termino}}
                                                   </div>
                                                </div>
                                                <div  class="item-col item-col-sales">
                                                    <div class="item-heading">Professor(a)/local</div>
                                                    <div> {{$turma->professor->nome_simples}}
                                                        <div>{{$turma->local->sigla}}</div>
                                                        <div title="Sala"><small>{{isset($turma->sala->nome)?$turma->sala->nome:''}}</small></div>
                                                    </div>
                                                </div>
                                                <div class="item-col item-col-sales">
                                                    <div class="item-heading">Vagas</div>
                                                    <div>{{$turma->vagas}}/{{$turma->matriculados}}</div>
                                                </div>
                                                <div class="item-col item-col-sales">
                                                    <div class="item-heading">Carga</div>
                                                    <div>{{$turma->carga}}hs</div>
                                                </div>
                                                 
                                               
                                                <div class="item-col item-col-sales">
                                                    <div class="item-heading">Valor</div>
                                                    <div>                                                    
                                                        @if($turma->pacote)
                                                        Confira o valor <br> do pacote
                                                    @else
                                                        R$ {{number_format($turma->valor,2,',','.')}}<br>
                                                        Em {{$turma->parcelas}}X <br>
                                                            @if($turma->parcelas>0)
                                                            R$ {{number_format($turma->valor/$turma->parcelas,2,',','.')}}
                                                            @endif
                                                    @endif
                                                    </div>
                                                </div>

                                                <div class="item-col fixed item-col-actions-dropdown">
                                                    <div class="item-actions-dropdown">
                                                        <a class="item-actions-toggle-btn"> <span class="inactive">
                                                <i class="fa fa-cog"></i>
                                            </span> <span class="active">
                                            <i class="fa fa-chevron-circle-right"></i>
                                            </span> </a>
                                                        <div class="item-actions-block">
                                                            <ul class="item-actions-list">                                     
                                                                
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
function getListas(tipo){
    var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        if(tipo=='preenchidas')
            $(location).attr('href','/docentes/frequencia/listar/'+selecionados);
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

</script>



@endsection
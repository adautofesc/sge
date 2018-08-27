 @extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Relatório de turmas & alunos.</h3>
    <div class="row">
        <br>
        <div class="col-sm-9">
            
            Mostrando {{count($turmas)}} turmas.  

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
        <div class="col-sm-3">
            Ordenar por: <strong>Curso</strong>
            <a href="#" title="Exportar dados">
                        <i class="fa fa-export" style="color:red"></i>
                        
                    </a>

        </div>
    
    </div>
    <form>
    <div class="row ">
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
                
                    <div class="col-sm-8"> 
                        
                        <div class="action dropdown "> 
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Programa
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
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Professor
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
                            <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Local
                            </button>
                            <div class="dropdown-menu" style="height:30em;px;overflow-y:scroll;" aria-labelledby="dropdownMenu1">
                                 @if(isset($filtros['local']) && array_search(84,$filtros['local']) !== false)
                               
                                    <a class="dropdown-item" href="?filtro=local&valor=84&remove=1" title="Remover filtro: Campus 1">
                                        <i class="fa fa-check-circle-o icon"></i>FESC 1
                                    </a>
                                 @else
                                    <a class="dropdown-item" href="?filtro=local&valor=84" title="Campus 1">
                                        <i class="fa fa-circle-o icon"></i>FESC 1
                                    </a>
                                 @endif
                                 @if(isset($filtros['local']) && array_search(85,$filtros['local']) !== false)
                               
                                    <a class="dropdown-item" href="?filtro=local&valor=85&remove=1" title="Remover filtro: Campus 2">
                                        <i class="fa fa-check-circle-o icon"></i>FESC 2
                                    </a>
                                 @else
                                    <a class="dropdown-item" href="?filtro=local&valor=85" title="Campus 2">
                                        <i class="fa fa-circle-o icon"></i>FESC 2
                                    </a>
                                 @endif
                                 @if(isset($filtros['local']) && array_search(86,$filtros['local']) !== false)
                               
                                    <a class="dropdown-item" href="?filtro=local&valor=86&remove=1" title="Remover filtro: Campus 3">
                                        <i class="fa fa-check-circle-o icon"></i>FESC 3
                                    </a>
                                 @else
                                    <a class="dropdown-item" href="?filtro=local&valor=86" title="Campus 3">
                                        <i class="fa fa-circle-o icon"></i>FESC 3
                                    </a>
                                 @endif


                                <!--

                                <a class="dropdown-item" href="?filtro=local&valor=85" title="Campus 2">
                                    <i class="fa fa-circle-o icon"></i>FESC 2
                                </a>
                                <a class="dropdown-item" href="?filtro=local&valor=86" title="Campus 3">
                                    <i class="fa fa-circle-o icon"></i>FESC 3
                                </a>
                            -->
                                @foreach($locais as $local)
                                @if(isset($filtros['local']) && array_search($local->id,$filtros['local']) !== false)
                                <a class="dropdown-item" href="?filtro=local&valor={{$local->id}}&remove=1" title="Remover filtro: {{$local->nome}}" >
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
                        <div class="action dropdown "> 
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
                                    <i class="fa fa-circle-o icon"></i>Com matrículas Abertas
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
                
         
                    </div>
                </div>
              
                
            </div>
            
        </div>
    </div>
    

</form>
</div>

@include('inc.errors')

<form name="item" class="form-inline">
	<section class="section">
    <div class="row ">
        <div class="col-xl-12">
            <div class="card sameheight-item">
                <div class="card-block">
                    <!-- Nav tabs -->
                    <div class="row">
                        <div class="col-xs-12 text-xs-right">
                            <div class="action dropdown pull-right "> 
                                <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Com os selecionados...
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('inscricao')">
                                        <i class="fa fa-circle-o icon"></i>Abrir Matrículas
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('espera')">
                                        <i class="fa fa-clock-o icon"></i> Suspender Matrículas
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('andamento')" >
                                        <i class="fa fa-check-circle icon"></i> Iniciada / parar matrículas
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('iniciada')" >
                                        <i class="fa fa-check-circle-o icon"></i> Iniciada / c/matrículas abertas 
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('encerrada')" >
                                        <i class="fa fa-minus-circle icon"></i> Encerrar Turmas
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('cancelada')" >
                                        <i class="fa fa-ban icon"></i> Cancelar Turmas
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
                                                        
                                                             <div href="#" style="margin-bottom:5px;" class="color-primary">Turma {{$turma->id}}- <i class="fa fa-{{$turma->icone_status}}" title=""></i><small> {{$turma->status. ' - Começa em  ' .$turma->data_inicio}}</small></div> 

                                                       @if(isset($turma->disciplina))
                                                        <a href="{{asset('secretaria/turma/'.$turma->id)}}" target="_blank" class="" title="Ver inscritos na turma">
                                                            <h4 class="item-title"> {{$turma->disciplina->nome}}</h4>       
                                                            <small>{{$turma->curso->nome}}</small>
                                                        </a>
                                                       @else
                                                        <a href="{{asset('secretaria/turma/'.$turma->id)}}" target="_blank" class="" title="Ver descrição em outra janela">
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
                                                        </div>
                                                    </div>
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Vagas</div>
                                                        <div>{{$turma->vagas}} / {{$turma->matriculados}} </div>
                                                    </div>
                                                     
                                                   
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Valor</div>
                                                        <div>R$ {{$turma->valor}} </div>
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


</script>



@endsection
@extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">

                <h3 class="title"> Nova matrícula </h3>

                <p class="title-description"> {{$pessoa->nome}}</p>
            </div>
        </div>
    </div>
    <div class="items-search col-md-3">
        <div class="header-block header-block-search hidden-sm-down">
               <div class="input-group input-group-sm" style="float:right;">
                   <input type="text" class="form-control" name="busca" placeholder="Buscar por turma">
                   <i class="input-group-addon fa fa-search" onclick="document.forms[1].alert());" style="cursor:pointer;"></i>
               </div>
         
       </div>

   </div>
</div>


@include('inc.errors')

<div class="card card-block">
    <!-- Nav tabs -->
    <div class="card-title-block">
        <h3 class="title"> Esta é sua programação atual: </h3>
    </div>
   <!-- Tab panes -->
    <div class="row">
     
        <div class="col" >
            <div class="title">Seg.</div>
            @foreach($turmas_atuais as $turma_atual)
            @if(in_array('seg',$turma_atual->dias_semana))
            <div class="box-placeholder turma{{$turma_atual->id}}" href="#{{$turma_atual->id}}">{{$turma_atual->hora_inicio}} ~ {{$turma_atual->hora_termino}} - {{$turma_atual->curso->nome}} - <small>{{$turma_atual->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Ter.</div>
            @foreach($turmas_atuais as $turma_atual)
            @if(in_array('ter',$turma_atual->dias_semana))
            <div class="box-placeholder turma{{$turma_atual->id}}">{{$turma_atual->hora_inicio}} ~ {{$turma_atual->hora_termino}} - {{$turma_atual->curso->nome}} - <small>{{$turma_atual->professor->nome_simples}}</small></div>
            @endif
            @endforeach
            
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Qua.</div>
            @foreach($turmas_atuais as $turma_atual)
            @if(in_array('qua',$turma_atual->dias_semana))
            <div class="box-placeholder turma{{$turma_atual->id}}">{{$turma_atual->hora_inicio}} ~ {{$turma_atual->hora_termino}} - {{$turma_atual->curso->nome}} - <small>{{$turma_atual->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Qui.</div>
            @foreach($turmas_atuais as $turma_atual)
            @if(in_array('qui',$turma_atual->dias_semana))
            <div class="box-placeholder turma{{$turma_atual->id}}">{{$turma_atual->hora_inicio}} ~ {{$turma_atual->hora_termino}} - {{$turma_atual->curso->nome}} - <small>{{$turma_atual->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Sex.</div>
            @foreach($turmas_atuais as $turma_atual)
            @if(in_array('sex',$turma_atual->dias_semana))
            <div class="box-placeholder turma{{$turma_atual->id}}">{{$turma_atual->hora_inicio}} ~ {{$turma_atual->hora_termino}} - {{$turma_atual->curso->nome}} - <small>{{$turma_atual->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Sab.</div>
            @foreach($turmas_atuais as $turma_atual)
            @if(in_array('sab',$turma_atual->dias_semana))
            <div class="box-placeholder turma{{$turma_atual->id}}">{{$turma_atual->hora_inicio}} ~ {{$turma_atual->hora_termino}} - {{$turma_atual->curso->nome}} - <small>{{$turma_atual->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
</div>
                    
<form name="item" class="form-inline" method="post" action="./confirmacao">
	<section class="section">
    <div class="row">
    </div>
    <div class="row ">
        <div class="col-xl-12">
            <div class="card sameheight-item">
                <div class="card-block" id="turmas">
                    <section class="example">
                        <div class="table-flip-scroll">
                            <ul class="item-list striped" id="itens-programa">
                                <li class="item item-list-header hidden-sm-down">
                                    <div class="item-row ">
                                        <div class="item-col fixed item-col-check">
                                            
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
                                @if($turma->verificaRequisitos($pessoa->id))                                       
                                <li class="item">
                                    @if($turma->matriculados>=$turma->vagas)
                                    <div class="item-row" style="color:red">
                                    @else
                                    <div class="item-row">
                                    @endif
                                        <div class="item-col fixed item-col-check"> 


                                            <label class="item-check" >
                                            <input type="checkbox" class="checkbox" name="turmas[]" value="{{$turma->id}}">
                                            <span></span>
                                            </label>
                                        </div>
                                        
                                        <div class="item-col fixed pull-left item-col-title">
                                        <div class="item-heading">Curso/atividade</div>
                                        <div class="">
                                            
                                                <div href="#" style="margin-bottom:5px;" class="color-primary">Turma {{$turma->id}} - <i class="fa fa-{{$turma->icone_status}}" title=""></i><small> {{$turma->status}} <br> De {{$turma->data_inicio}} a {{$turma->data_termino}}</small></div> 

                                        
                                        @if(isset($turma->disciplina))
                                                <a href="{{asset('/cursos/disciplinas/disciplina').'/'.$turma->disciplina->id}}" target="_blank" class="" title="Ver descrição em outra janela">
                                                    <h4 class="item-title"> {{$turma->disciplina->nome}}</h4>       
                                                    <small>{{$turma->curso->nome}}</small>
                                                </a>
                                            @else
                                                <a href="{{asset('/cursos/curso').'/'.$turma->curso->id}}" target="_blank" class="" title="Ver descrição em outra janela">
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
                                            <div class="item-heading">Vagas/Ocup</div>
                                            <div>{{$turma->vagas}} / {{$turma->matriculados}} </div>
                                        </div>
                                        
                                    
                                        <div class="item-col item-col-sales">
                                            <div class="item-heading">Valor</div>
                                            <div>R$ {{number_format($turma->valor,2,',','.')}}<br>
                                                Em {{$turma->parcelas}}X <br>
                                                    @if($turma->parcelas>0)
                                                    R$ {{number_format($turma->valor/$turma->parcelas,2,',','.')}}
                                                    @endif
                                            </div>
                                        </div>

                                        <div class="item-col fixed item-col-actions-dropdown">
                                            &nbsp;
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach
                                
                                
                            </ul>
                        </div>
                    </section> 
                    
                </div>
                <!-- /.card-block -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-xl-6 -->
        
        <!-- /.col-xl-6 -->
    </div>
</section>
<input type="hidden" name="pessoa" value="{{$pessoa->id}}">
<input type="hidden" name="turmas_anteriores" value="{{$str_turmas}}">
<div class="card-block">
	<button type="submit" class="btn btn-primary" href="matricula_confirma_cursos.php">Avançar</button>
	
	<button type="reset" class="btn btn-secondary" onclick="recomecar();" >Limpar</button>
</div>
{{ csrf_field() }}
</form>
@endsection
@section('scripts')
<script>


</script>



@endsection
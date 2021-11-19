<section class="example">
        <div class="table-flip-scroll">
            <ul class="item-list striped" id="itens">
                <li class="item item-list-header hidden-sm-down">
                    <div class="item-row ">
                        <div class="item-col fixed item-col-check">
                            
                        </div>
                        
                        <div class="item-col item-col-header item-col-title">
                            <div> <span>Cursos</span> </div>
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
                @if($turma->verificaRequisitos($pessoa) && $turma->matriculados<$turma->vagas)                               
                <li class="item">       
                    <div class="item-row">
                        <div class="item-col fixed item-col-check"> 
                            <label class="item-check" >
                            <input type="checkbox" class="checkbox" name="turma" value="{{$turma->id}}" onclick="addItem({{$turma->id}});">
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
                            <div> {{$turma->sigla_programa}}<br>{{$turma->professor->nome_simples}}
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

                @foreach($turmas as $turma)
                @if(!$turma->verificaRequisitos($pessoa) || $turma->matriculados>=$turma->vagas)                               
                <li class="item" style="background-color: #ebebeb" title="Turma sem vagas ou aluno não atende aos pré-requisitos">       
                    <div class="item-row">
                        <div class="item-col fixed item-col-check"> 
                            <label class="item-check" >
                            
                            <span></span>
                            </label>
                        </div>
                    
                        
                        <div class="item-col fixed pull-left item-col-title">
                        <div class="item-heading">Curso/atividade</div>
                        <div class="">
                            
                                 <div href="#" style="margin-bottom:5px;" class="color-primary">Turma {{$turma->id}} - <i class="fa fa-{{$turma->icone_status}}" title=""></i><small> {{$turma->status}} <br> De {{$turma->data_inicio}} a {{$turma->data_termino}}</small></div> 

                           
                           @if(isset($turma->disciplina))
                                <a href="{{asset('/cursos/disciplinas/disciplina').'/'.$turma->disciplina->id}}" target="_blank" >
                                    <h4 class="item-title"> {{$turma->disciplina->nome}}</h4>       
                                    <small>{{$turma->curso->nome}}</small>
                                </a>
                            @else
                                <a href="{{asset('/cursos/curso').'/'.$turma->curso->id}}" target="_blank" >
                                    <h4 class="item-title"> {{$turma->curso->nome}}</h4>           
                                </a>
                            @endif
                                                       
                             {{implode(', ',$turma->dias_semana)}} - {{$turma->hora_inicio}} ás {{$turma->hora_termino}}
                        </div>
                    </div>
                        <div class="item-col item-col-sales">
                            <div class="item-heading">Professor(a)</div> 
                            <div>{{$turma->sigla_programa}}<br> {{$turma->professor->nome_simples}}
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




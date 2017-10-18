@foreach($programas as $programa)
<!-- tab {{$programa->sigla}} ********************************************************-->
<div class="tab-pane fade in {{$programa->id==1?'active':''}}"  id="{{$programa->sigla}}">
    <h4>{{$programa->nome}}</h4>
    <section class="example">
        <div class="table-flip-scroll">
            <ul class="item-list striped" id="itens-{{$programa->sigla}}">
                <li class="item item-list-header hidden-sm-down">
                    <div class="item-row">
                        <div class="item-col fixed item-col-check">
                            
                        </div>
                        
                        <div class="item-col item-col-header item-col-title">
                            <div> <span>Curso</span> </div>
                        </div>
                        <div class="item-col item-col-header item-col-sales">
                            <div> <span>Professor/Unidade</span> </div>
                        </div>

                        <div class="item-col item-col-header item-col-sales">
                            <div> <span>Vagas</span> </div>
                        </div>
                        <div class="item-col item-col-header item-col-sales">
                            <div> <span>Valor</span> </div>
                        </div>

                        <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                    </div>
                </li>
                @foreach($turmas->all() as $turma)
                @if($turma->programa->id==$programa->id)                                            
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
                            
                                 <div href="#" style="margin-bottom:5px;" class="color-primary">Turma {{$turma->id}} - <i class="fa fa-{{$turma->icone_status}}" title=""></i><small> {{$turma->texto_status}}</small></div> 

                           
                            <a href="{{asset('pedagogico/curso').'/'.$turma->curso->id}}" target="_blank"class="">
                                <h4 class="item-title"> {{$turma->curso->nome}}</h4></a>
                             {{implode(', ',$turma->dias_semana)}} - {{$turma->hora_inicio}} ás {{$turma->hora_termino}}
                        </div>
                    </div>
                        <div class="item-col item-col-sales">
                            <div class="item-heading">Professor(a)</div>
                            <div> {{$turma->professor->nome_simples}}
                                <div>{{$turma->local->unidade}}</div>
                            </div>
                        </div>
                        <div class="item-col item-col-sales">
                            <div class="item-heading">Vagas</div>
                            <div>{{$turma->vagas}}</div>
                        </div>
                         
                       
                        <div class="item-col item-col-sales">
                            <div class="item-heading">Valor</div>
                            <div>R$ {{$turma->valor}} </div>
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
@endforeach


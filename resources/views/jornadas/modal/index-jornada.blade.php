<div class="row">
    <div class="col-xs-10 text-xs">
        {{ $jornadas->links() }}
    </div>
    <div class="col-xs-2 text-xs-right">

        
        <div class="action dropdown pull-right "> 
            <!-- <a href="#" class="btn btn-sm rounded-s btn-secondary" title="Exportar para excel"><img src="/img/excel.svg" alt="excel" width="20px"></a> -->
            <button class="btn btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Com os selecionados...
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 

                <a class="dropdown-item" href="#" onclick="alterarStatus('aprovar')">
                    <label><i class="fa fa-check-circle-o icon text-success"></i> Aprovar</label>
                </a> 
                <a class="dropdown-item" href="#" onclick="alterarStatus('negar')">
                    <label><i class="fa fa-ban icon text-danger"></i> Negar</label>
                </a> 
                <a class="dropdown-item" href="#" onclick="alterarStatus('analisando')">
                    <label><i class="fa fa-clock-o icon text-warning"></i><span> Analisando</span></label>
                </a> 
                <a class="dropdown-item" href="#" onclick="alterarStatus('cancelar')">
                    <label><i class="fa fa-minus-circle icon text-danger"></i> <span> Cancelar</span></label>
                </a> 
                <a class="dropdown-item" href="#" onclick="alterarStatus('apagar')">
                    <label><i class="fa fa-times-circle icon text-danger"></i> <span> Excluir</span></label>
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
                                <div class="item-col item-col-header codigo">
                                    <div> <span>Id<span> </div>
                                </div>

                                <div class="item-col item-col-title item-col-header pessoa">
                                    <div> <span>Pessoa</span> </div>
                                </div>
                                <div class="item-col item-col-header pedidoem">
                                    <div> <span>Data</span> </div>
                                </div>

                                <div class="item-col item-col-header ">
                                    <div class="action dropdown pull-right "> 
                                        <div id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;">
                                            <i class="fa fa-filter"></i> <span >Tipo</span> 
                                        </div>   
                                    </div>
                                </div>
                                <div class="item-col item-col-header ">
                                    <div> <span>Status</span> </div>
                                </div>

                                <div class="item-col item-col-header fixed item-col-actions-dropdown">&nbsp; </div>
                            </div>
                        </li>
                        @foreach($jornadas as $jornada)


                                                              
                        <li class="item">
                            <div class="item-row">


                                <div class="item-col fixed item-col-check" > 
                                    <label class="item-check" >
                                    <input type="checkbox" class="checkbox" name="turma" value="{{$jornada->id}}">
                                    <span></span>
                                    </label>
                                </div>


                                <div class="item-col item-col codigo">
                                    <div class="item-heading">id</div>
                                    <div > <a href="./analisar/{{$jornada->id}} ">{{$jornada->id}} </a></div>
                                </div>
                    
                                
                                <div class="item-col item-col-title pessoa">
                                    <div class="item-heading">Pessoa</div>
                                    <div>{{$jornada->id}}</div> 
                                </div>


                                <div class="item-col item-col pedidoem" >
                                    <div class="item-heading">Data</div>
                                    <div> 
                                        <small>{{$jornada->id}}</small>
                                    </div>
                                </div>



                                <div class="item-col item-col">
                                    <div class="item-heading">Tipo</div>
                                 
                                    <div><small>{{$jornada->id}}</small></div>
                                 
                                </div>
                                 
                               
                                <div class="item-col item-col">
                                    <div class="item-heading">Status</div>
                                    <div> @if($jornada->status == 'analisando')
                                        <span class="badge badge-pill badge-warning">
                                        @elseif($jornada->status == 'ativa')
                                        <span class="badge badge-pill badge-success">
                                        @elseif($jornada->status == 'indeferida')
                                        <span class="badge badge-pill badge-danger">
                                        @elseif($jornada->status == 'cancelada')
                                        <span class="badge badge-pill badge-danger">
                                        @elseif($jornada->status == 'expirada')
                                        <span class="badge badge-pill badge-secondary">
                                        @else
                                        <span>
                                        @endif
                                        {{$jornada->status}}</span>
                                    </div>
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
                                                 <a class="edit" title="Aprovar" href="#" onclick="alterarStatusIndividual('aprovar','{{$jornada->id}}')"> <i class="fa fa-check-circle-o "></i> </a>
                                                </li>
                                                <li>
                                                 <a class="remove" title="Negar" href="#" onclick="alterarStatusIndividual('negar','{{$jornada->id}}')"> <i class="fa fa-ban "></i> </a>
                                                </li>
                                                <li>
                                                 <a class="edit" title="Colocar para análise" href="#" onclick="alterarStatusIndividual('analisando','{{$jornada->id}}')"> <i class="fa fa-clock-o "></i> </a>
                                                </li>
                                                <li>
                                                 <a class="remove" title="Cancelar" href="#" onclick="alterarStatusIndividual('cancelar','{{$jornada->id}}')"> <i class="fa fa-minus-circle "></i> </a>
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
<div class="tab-pane fade" id="clinicos">
    <div class="row"> 
            <div class="col-xs-6">
                <a href="/pessoa/atestado/cadastrar/{{$pessoa->id}}" class="btn btn-primary btn-sm rounded-s"> Adicionar Atestado</a>
                
                                                       
            </div>                                           
            <div class="col-xs-6 text-xs-right">                                        
                <a href="{{asset('/pessoa/editar/dadosclinicos/').'/'.$pessoa->id}}" class="btn btn-primary btn-sm rounded-s"> Editar </a>
            </div>
        </div> 

    <section class="card card-block">
            
            <div class="form-group row"> 
                    <label class="col-sm-4 form-control-label text-xs-right">Atestados médicos</label>
                    <div class="col-sm-8">
                        
                        @if(isset($atestados))
                        @foreach($atestados as $atestado)
                        <div class="row">
                            
                            <div class="col-sm-1" style="width: 3rem"><strong>{{$atestado->id}}</strong></div>
                            <div class="col-sm-2">
                                <span  
                                @switch($atestado->status)
                                @case('aprovado')
                                    class="badge badge-pill badge-success"
                                @break;
                                @case('analisando')
                                    class="badge badge-pill badge-warning"
                                @break;
                                @case('negado')
                                    class="badge badge-pill badge-danger"
                                @break;
                                @default
                                    class="badge badge-pill badge-secondary"
                                @break;
                                @endswitch

                            
                                 style="font-size: 0.8rem">{{$atestado->status}}</span></div>
                            <div class="col-sm-3">Atestado de {{$atestado->tipo}}</div>
                            <div class="col-sm-2">Emissão: {{\Carbon\Carbon::parse($atestado->emissao)->format('d/m/Y')}}</div>
                            <div class="col-sm-3">
                                <a href="/pessoa/atestado/analisar/{{$atestado->id}}" title="Análise do atestado"><i class="fa fa-pencil-square-o text-success"></i></a>
                                <a href="/pessoa/atestado/editar/{{$atestado->id}}" title="Editar atestado"><i class="fa fa-pencil text-secondary"></i></a>
                                <a href="#" onclick="desativarAtestado('{{$atestado->id}}')" title="Apagar atestado"><i class="fa fa-times text-danger"></i></a>
                            </div>
                              
                                
                                
                                
                        
                        </div>
                        
                        
                            
                            <br>
                        @endforeach
                        @endif
                        

                    </div>


             


            </div>
            <div class="form-group row"> 
                <label class="col-sm-4 form-control-label text-xs-right">Necesssidades especiais</label>
                <div class="col-sm-8"> 
                    <ul>

                    @foreach($pessoa->dadosClinicos->where('dado','necessidade_especial') as $necessidade)
                    <li>{{$necessidade->valor}} <a href="#" onclick="desativarDado('{{$necessidade->id}}')" title="Apagar necessidade" >
                        <i class="fa fa-times text-danger"></i>
                    </a></li>

                    @endforeach
                    
                    </ul>
                </div>
            </div>
            <div class="form-group row"> 
                    <label class="col-sm-4 form-control-label text-xs-right">Medicamentos uso contínuo</label>
                    <div class="col-sm-8"> 
                        <ul>
                            @foreach($pessoa->dadosClinicos->where('dado','medicamento') as $medicamento)
                            <li>{{$medicamento->valor}} 
                                
                            </li>
                            @endforeach
                        </ul>
                    </div>
            </div>
            <div class="form-group row"> 
                    <label class="col-sm-4 form-control-label text-xs-right">Alergias</label>
                    <div class="col-sm-8"> 
                        <ul>
                            @foreach($pessoa->dadosClinicos->where('dado','alergia') as $alergia)
                            <li>{{$alergia->valor}} 
                                
                            </li>
                            @endforeach
                        </ul>
                    </div>
            </div>
            <div class="form-group row"> 
                    <label class="col-sm-4 form-control-label text-xs-right">Doença crônica</label>
                    <div class="col-sm-8"> 
                        <ul>
                            @foreach($pessoa->dadosClinicos->where('dado','doenca') as $doenca)
                            <li>{{$doenca->valor}} 
                                
                            </li>
                            @endforeach
                        </ul>
                    </div>
            </div>
   </section>

</div>
<script>
    function desativarAtestado(id){
    if(confirm("Deseja mesmo arquivar esse atestado?")){
        $(location).attr('href', '{{asset('/pessoa/atestado/arquivar')}}/'+id);
    }

}
</script>
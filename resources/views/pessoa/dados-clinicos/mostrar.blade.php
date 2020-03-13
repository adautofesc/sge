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
                        <a href="#" onclick="desativarAtestado('{{$atestado->id}}')" title="Apagar Atestado" class="btn btn-danger btn-sm">
                            <i class="fa fa-times"></i>
                        </a>
                        <a href="/pessoa/atestado/editar/{{$atestado->id}}" title="Editar Atestado" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil"></i>
                        </a> 
                        @if(file_exists('documentos/atestados/'.$atestado->id.'.pdf'))
                            
                                <a href="/download/{{str_replace('/','-.-', 'documentos/atestados/'.$atestado->id.'.pdf')}}" target="_blank"><i class="fa fa-file"></i></a>
                             
                        @endif
                            Atestado nº {{$atestado->id}}
                         - emitido em
                            {{\Carbon\Carbon::parse($atestado->emissao)->format('d/m/Y')}}
                            <br>
                        @endforeach
                        @endif

                    </div>


             


            </div>
            <div class="form-group row">
                <label class="col-sm-4 form-control-label text-xs-right">Justificativas de ausência</label>
                <div class="col-sm-6">                 
                    <input type="text" class="form-control boxed" placeholder="Se não tiver, não preencha." maxlength="150" name="doenca" value="">
                    <br>
                    <ul>
                        @foreach($pessoa->dadosClinicos->where('dado','justificativa') as $dado)
                        <li>{{$dado->valor}} 
                            <a href="#" onclick="desativarDado('{{$dado->id}}')" title="Apagar dado" >
                                <i class="fa fa-times text-danger"></i>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                        
                </div>
                <div class="col-sm-2">
                    <button name="btn_sub" value='1' class="btn btn-primary" onclick="cadastrar('doenca',{{$pessoa}})">Adicionar</button>
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
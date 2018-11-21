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
                    <label class="col-sm-4 form-control-label text-xs-right">Necesssidades especiais</label>
                    <div class="col-sm-8"> 
                        @if(isset($pessoa['necessidade_especial']))
                        {{ $pessoa['necessidade_especial'] }}
                        @else
                        <p>Não possui</p>
                        @endif
                    </div>
            </div>
            <div class="form-group row"> 
                    <label class="col-sm-4 form-control-label text-xs-right">Medicamentos uso contínuo</label>
                    <div class="col-sm-8"> 
                        @if(isset($pessoa['medicamentos_continuos']))
                        {{ $pessoa['medicamentos_continuos'] }}
                        @else
                        <p>Não possui</p>
                        @endif
                    </div>
            </div>
            <div class="form-group row"> 
                    <label class="col-sm-4 form-control-label text-xs-right">Alergias</label>
                    <div class="col-sm-8"> 
                        @if(isset($pessoa['alergias']))
                        {{ $pessoa['alergias'] }}
                        @else
                        <p>Não possui</p>
                        @endif
                    </div>
            </div>
            <div class="form-group row"> 
                    <label class="col-sm-4 form-control-label text-xs-right">Doença crônica</label>
                    <div class="col-sm-8"> 
                        @if(isset($pessoa['doenca_cronica']))
                        {{ $pessoa['doenca_cronica'] }}
                        @else
                        <p>Não possui</p>
                        @endif
                    </div>
            </div>
            <div class="form-group row"> 
                    <label class="col-sm-4 form-control-label text-xs-right">Atestados médicos</label>
                    <div class="col-sm-8">
                        @if(isset($atestados))
                        @foreach($atestados as $atestado)
                        <a href="#" onclick="desativarAtestado('{{$atestado->id}}')" title="Apagar Atestado" class="btn btn-danger btn-sm">
                            <i class="fa fa-times"></i>
                        </a> 
                        @if(file_exists('documentos/atestados/'.$atestado->id.'.pdf'))
                            
                                <a href="{{'/documentos/atestados/'.$atestado->id.'.pdf'}}" target="_blank"><i class="fa fa-file"></i></a>
                             
                        @endif
                            Atestado nº {{$atestado->id}}
                         - emitido em
                            {{\Carbon\Carbon::parse($atestado->emissao)->format('d/m/Y')}}
                            <br>
                        @endforeach
                        @endif

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
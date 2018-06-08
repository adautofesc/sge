<div class="tab-pane fade" id="contato">
    <div class="row"> 
                                                       
            <div class="col-xs-12 text-xs-right">                                        
                <a href="{{asset("/pessoa/editar/contato/")."/".$pessoa->id}}" class="btn btn-primary btn-sm rounded-s"> Editar </a>
            </div>
        </div> 


  <section class="card card-block">
    <div class="form-group row">
        <label class="col-sm-2 form-control-label text-xs-right">E-mail</label>
        <div class="col-sm-4"> 
            @if(isset($pessoa['email']))
             {{ $pessoa['email'] }}
            @endif                                    
        </div>  
    </div>
    <div class="form-group row">
        <label class="col-sm-2 form-control-label text-xs-right">Celular</label>
        <div class="col-sm-4"> 
            @if(isset($pessoa['telefone_celular']))
             {{ $pessoa['telefone_celular'] }}
            @endif 
        </div>
        <label class="col-sm-2 form-control-label text-xs-right">Telefone de um contato</label>
        <div class="col-sm-4"> 
            @if(isset($pessoa['telefone_contato']))
             {{ $pessoa['telefone_contato'] }}
            @endif 
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 form-control-label text-xs-right">Logradouro</label>
        <div class="col-sm-10"> 
            @if(isset($pessoa['logradouro']))
             {{ $pessoa['logradouro'] }}
            @endif 
        </div>  
    </div>
    <div class="form-group row">
        <label class="col-sm-2 form-control-label text-xs-right">Número</label>
        <div class="col-sm-4"> 
            @if(isset($pessoa['end_numero']))
             {{ $pessoa['end_numero'] }}
            @endif 
        </div>  
        <label class="col-sm-2 form-control-label text-xs-right">Complemento</label>
        <div class="col-sm-4"> 
            @if(isset($pessoa['end_complemento']))
             {{ $pessoa['end_complemento'] }}
            @endif 
            
        </div>  
    </div>
    <div class="form-group row">
        <label class="col-sm-2 form-control-label text-xs-right">Bairro</label>
        <div class="col-sm-4"> 
            @if(isset($pessoa['bairro']))
             {{ $pessoa['bairro'] }}
            @endif 
        </div>  
        <label class="col-sm-2 form-control-label text-xs-right">CEP</label>
        <div class="col-sm-4"> 
            @if(isset($pessoa['cep']))
             {{ $pessoa['cep'] }}
            @endif 
        </div>  
    </div>
    <div class="form-group row">
        <label class="col-sm-2 form-control-label text-xs-right">Cidade</label>
        <div class="col-sm-4"> 
            @if(isset($pessoa['cidade']))
             {{ $pessoa['cidade'] }}
            @endif 
        </div>  
        <label class="col-sm-2 form-control-label text-xs-right">Estado</label>
        <div class="col-sm-4"> 
            @if(isset($pessoa['estado']))
             {{ $pessoa['estado'] }}
            @endif 
        </div>  
    </div>

  </section> 
</div>
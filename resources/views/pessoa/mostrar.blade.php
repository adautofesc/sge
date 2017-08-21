@extends('layout.app')
@section('pagina')


<div class="title-block">
    <h3 class="title"> {{$pessoa['nome']}}<span class="sparkline bar" data-type="bar"></span> </h3>
</div>

<div class="subtitle-block">
    <h3 class="subtitle"> Dados Gerais </h3>
</div>

<div class="card card-block">
    
    
    <div class="form-group row">
        
        <label class="col-sm-2 form-control-label text-xs-right">Nascimento</label>
        <div class="col-sm-3">
            {{$pessoa['idade']}}
        </div>
        @if(isset($pessoa['telefone']))
        <label class="col-sm-2 form-control-label text-xs-right">Telefone</label>
        <div class="col-sm-3"> 
            {{$pessoa['telefone']}}
        </div>
        @endif
    </div>
        
    
    <div class="form-group row"> 
        <label class="col-sm-2 form-control-label text-xs-right">Gênero</label>
        <div class="col-sm-10"> 
            {{$pessoa['genero']}}
        </div>
    </div>
    @if(isset($pessoa['nome_registro']))
    <div class="form-group row"> 
        <label class="col-sm-2 form-control-label text-xs-right">Nome Registro</label>
        <div class="col-sm-10"> 
            {{$pessoa['nome_registro']}}
        </div>
    </div>    
    @endif    
    <div class="form-group row">
         @if(isset($pessoa['rg']))
        <label class="col-sm-2 form-control-label text-xs-right">RG</label>
        <div class="col-sm-3"> 
            {{$pessoa['rg']}}
        </div>
        @endif
        @if(isset($pessoa['cpf']))
        <label class="col-sm-2 form-control-label text-xs-right">CPF</label>
        <div class="col-sm-3"> 
            {{ $pessoa['cpf'] }}
        </div>
        @endif
        
        
    </div>                                
</div>
<div class="subtitle-block">
    <h3 class="subtitle"> Dados de contato </h3>
</div>
<div class="card card-block">
    <div class="form-group row">
        <label class="col-sm-2 form-control-label text-xs-right">E-mail</label>
        <div class="col-sm-4"> 
            Fulano@provedor.com.br 
        </div>  
    </div>
    <div class="form-group row">
        <label class="col-sm-2 form-control-label text-xs-right">Telefone alternativo</label>
        <div class="col-sm-4"> 
            (16) 3373 - 4844 
        </div>
        <label class="col-sm-2 form-control-label text-xs-right">Telefone de um contato</label>
        <div class="col-sm-4"> 
                (16) 3373 - 4844 
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 form-control-label text-xs-right">Logradouro</label>
        <div class="col-sm-10"> 
            Rua São Sebastião
        </div>  
    </div>
    <div class="form-group row">
        <label class="col-sm-2 form-control-label text-xs-right">Número</label>
        <div class="col-sm-4"> 
            2828
        </div>  
        <label class="col-sm-2 form-control-label text-xs-right">Complemento</label>
        <div class="col-sm-4"> 
            
        </div>  
    </div>
    <div class="form-group row">
        <label class="col-sm-2 form-control-label text-xs-right">Bairro</label>
        <div class="col-sm-4"> 
            Vila Nery
        </div>  
        <label class="col-sm-2 form-control-label text-xs-right">CEP</label>
        <div class="col-sm-4"> 
            13560-000
        </div>  
    </div>
    <div class="form-group row">
        <label class="col-sm-2 form-control-label text-xs-right">Cidade</label>
        <div class="col-sm-4"> 
            São Carlos
        </div>  
        <label class="col-sm-2 form-control-label text-xs-right">Estado</label>
        <div class="col-sm-4"> 
            São Paulo
        </div>  
    </div>
</div>


<div class="subtitle-block">
<h3 class="subtitle"> Dados Clínicos</h3>
</div>
<div class="card card-block">
    <div class="form-group row"> 
            <label class="col-sm-4 form-control-label text-xs-right">Necesssidades especiais</label>
            <div class="col-sm-8"> 
                Não
            </div>
    </div>
    <div class="form-group row"> 
            <label class="col-sm-4 form-control-label text-xs-right">Medicamentos uso contínuo</label>
            <div class="col-sm-8"> 
                Não 
            </div>
    </div>
    <div class="form-group row"> 
            <label class="col-sm-4 form-control-label text-xs-right">Alergias</label>
            <div class="col-sm-8"> 
                Intolerância a lactose
            </div>
    </div>
    <div class="form-group row"> 
            <label class="col-sm-4 form-control-label text-xs-right">Doença crônica</label>
            <div class="col-sm-8"> 
                Nenhuma 
            </div>
    </div>
</div>
<div class="subtitle-block">
    <h3 class="subtitle">Finalizando cadastro</h3>
</div>
<div class="card card-block">
    <div class="form-group row"> 
        <label class="col-sm-2 form-control-label text-xs-right">
            Observações
        </label>
        <div class="col-sm-10"> 
            Cadastrado em 03/01/2017 por Fulano
            Ultima atualização em 03/03/2017 por Ciclano
        </div>
    </div>  
    
</div>



@endsection
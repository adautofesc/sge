 @extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Matrículas gravadas com sucesso</h3>
</div>

@include('inc.errors')
<div class="subtitle-block">
    <h3 class="subtitle"><small>De: </small> {{$nome}}</h3>
</div>

<form name="item" method="post">
<div class="card card-primary">

    <div class="card-header">
        <div class="header-block">
        <p class="title" style="color:white"> Plano Financeiro / Descontos / Pendencias e Observações</p>
        </div>
    </div>


    <div class="card-block">
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Valor
            </label>
            <div class="col-sm-2"> 
                <div class="input-group">
                    <span class="input-group-addon">R$</span> 
                    <input type="number" class="form-control boxed" readonly="true" value='{{ str_replace(',', '.', $matricula->valor->valor) }}' name='valor_matricula' required ();"> 
                    
                </div>
            </div>

    

        </div>
       <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Desconto
            </label>
            <div class="col-sm-6"> 
                <select name="fdesconto" class="c-select form-control boxed" onchange="desconto(this);">
                    <option value="0" selected>Sem Bolsa (Valor Integral) </option>
                    @foreach($descontos as $desconto)
                    @if($desconto->id==$matricula->desconto)
                    <option value="{{$desconto->id}}" selected="selected">{{$desconto->nome}}</option>
                    @else
                    <option value="{{$desconto->id}}">{{$desconto->nome}}</option>
                    @endif

                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Valor
            </label>

            <div class="col-sm-2">
                <div class="input-group">
                    <span class="input-group-addon">% </span> 
                    <input type="number" class="form-control boxed" placeholder="" name="porcentagem" id="porcentagem" readonly> 
                </div>
            </div>
            <div class="col-sm-2">
                <div class="inline-form input-group">
                    <span class="input-group-addon">R$</span> 
                    <input type="number" class="form-control boxed" placeholder="" name="valor" id="valor" readonly value="{{$matricula->valor_desconto}}"> 
                </div>
            </div>
        </div>
        

        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Dividir em
            </label>
            <div class="col-sm-2"> 
                <div class="input-group">
                    
                    <input type="number" class="form-control boxed" value='{{$matricula->valor->parcelas}}' name='nparcelas' readonly="true" id="nparcelas" required onchange="aplicarPlano({{ str_replace(',', '.', $matricula->valor->valor) }});"> 
                    <span class="input-group-addon">Vezes</span> 
                </div>
            </div>

        </div>
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right"></label>
            <div class="col-sm-2"> 
                
                <div>
                    <label>
                    <input class="radio" type="radio" name="status" value="ativa" {{ $matricula->status === "ativa" ? 'Checked="checked"' : "" }}>
                    <span>Ativa</span>
                    </label>
                </div>
            </div>
            <div class="col-sm-2"> 
                
                <div>
                    <label>
                    <input class="radio" type="radio" name="status" value="pendente" {{ $matricula->status === "pendente" ? 'Checked="checked"' : "" }}>
                    <span>Pendente</span>
                    </label>
                </div>
            </div>
            <div class="col-sm-2"> 
                
                <div>
                    <label>
                    <input class="radio" type="radio" name="status" value="cancelada" {{ $matricula->status === "cancelada" ? 'Checked="checked"' : "" }}>
                    <span>Cancelada</span>
                    </label>
                </div>
            </div>
            <div class="col-sm-2"> 
                
                <div>
                    <label>
                    <input class="radio" type="radio" name="status" value="espera" {{ $matricula->status === "espera" ? 'Checked="checked"' : "" }}>
                    <span>Espera <small>(Aguardando começar aula)</small></span>
                    </label>
                </div>
            </div>
                
                

                
                
        </div>
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Observações
            </label>
            <div class="col-sm-4"> 
                <textarea rows="4" class="form-control boxed" name="obs" maxlength="150">{{$matricula->obs}}</textarea> 
            </div>
            <div class="col-sm-6 ">
            <p class="subtitle-block"> Saldo: <b id="parcelas">{{$matricula->valor->parcelas}}</b> parcela(s) de <small>R$</small> <b><span id="saldo_final_parcelado">{{number_format(($matricula->valor->valor-$matricula->valor_desconto)/$matricula->parcelas,2,',','.')}}</span></b> = <small>R$</small> <b><span id="saldo_final">{{number_format(($matricula->valor->valor-$matricula->valor_desconto),2,',','.')}}</span></b></p>
            </div>

        </div> 
        <input type="hidden" name="valorcursointegral" value="{{$matricula->valor->valor}}" >
        <input type="hidden" name="valordesconto" value="{{$matricula->valor_desconto}}" >
        <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right"></label>
            <div class="col-sm-10 col-sm-offset-2"> 
                <input type="hidden" name="id" value="{{$matricula->id}}">
                <button type="submit" name="btn"  class="btn btn-primary">Salvar</button>
                <button type="reset" name="btn"  class="btn btn-primary">Restaurar</button>
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
                {{csrf_field()}}

            
                <!--
                <button type="submit" class="btn btn-primary">Cadastrar e escolher disciplinas obrigatórias</button> 
                -->
            </div>
       </div>
    </div>
</div>

@endsection
@section('scripts')
<script>

function desconto(item){
    console.log(item.value);

    if(item.value==0){
       $('#porcentagem').val(0)
       tipo=0;
        $('#valor').val(0);
        valor_desc=0;
        $("input[name=valordesconto]").val(0);

    }
    @foreach($descontos as $desconto)
    if(item.value=={{$desconto->id}}){
        tipo='{{$desconto->tipo}}';
        valor_desc={{$desconto->valor}};
    }
    @endforeach

    if(tipo=="p"){
        $('#porcentagem').val(valor_desc);
        $('#valor').val(0);}
    else{
        $('#porcentagem').val(0)
        $('#valor').val(valor_desc);
    }
    aplicarPlano({{ str_replace(',', '.', $matricula->valor->valor) }});


}
function aplicarPlano(valor){
    if($('#nparcelas').val()<1){
        alert('Numero de parcelas inválido.');
        
    }
    else{
        saldo=valor;
        saldo=saldo-(saldo*$('#porcentagem').val()/100);
        saldo=saldo-$('#valor').val();
        $('#saldo_final_parcelado').html(parseFloat(Math.round(saldo/$('#nparcelas').val() * 100) / 100).toFixed(2)); 
        $('#saldo_final').html(saldo+',00'); 
        if(valor>saldo)
            $("input[name=valordesconto]").val(valor-saldo);
        $('#parcelas').html($('#nparcelas').val());
    }

    
    


}


</script>
@endsection
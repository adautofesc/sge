 @extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Matrículas gravadas com sucesso</h3>
</div>

@include('inc.errors')
<div class="subtitle-block">
    <h3 class="subtitle"><small>De: </small> {{$nome}}</h3>
</div>

<form name="item" method="POST" action="gravar">
<div class="card card-success">

    <div class="card-header">
        <div class="header-block">
        <p class="title" style="color:white"> Plano Financeiro / Descontos / Pendencias e Observações</p>
        </div>
    </div>


    <div class="card-block">
       <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Desconto
            </label>
            <div class="col-sm-6"> 
                <select name="fdesconto" class="c-select form-control boxed" onchange="desconto(this);">
                    <option value="0" selected>Selecione para ativar</option>
                    @foreach($descontos as $desconto)
                    <option value="{{$desconto->id}}">{{$desconto->nome}}</option>
                    @endforeach
                   

                </select>
            </div>
            <div class="col-sm-2">
                <div class="input-group">
                    <span class="input-group-addon">% </span> 
                    <input type="number" class="form-control boxed" placeholder="" name="porcentagem" id="porcentagem" readonly> 
                </div>
            </div>
            <div class="col-sm-2">
                <div class="inline-form input-group">
                    <span class="input-group-addon">R$</span> 
                    <input type="number" class="form-control boxed" placeholder="" name="valor" id="valor" readonly> 
                </div>
            </div>
        </div>
        

        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Dividir em
            </label>
            <div class="col-sm-2"> 
                <div class="input-group">
                    
                    <input type="number" class="form-control boxed" value='{{$matricula->parcelas}}' name='nparcelas' id="nparcelas" required onchange="aplicarPlano({{ str_replace(',', '.', $matricula->valor) }});"> 
                    <span class="input-group-addon">Vezes</span> 
                </div>
            </div>
            <label class="col-sm-2 form-control-label text-xs-right">
                Dia de vencimento
            </label>
            <div class="col-sm-2"> 
                <input type="number" class="form-control boxed" value='7' name='dvencimento' required>  
            </div>

            <div class="col-sm-2">
                <buttom class="btn btn-primary" onclick="aplicarPlano('',{{ str_replace(',', '.', $matricula->valor) }});" >Aplicar</buttom>
            </div>

        </div>
        <div class="subtitle-block">
        </div>
        <div class="subtitle-block">
            <p>Saldo: <b id="parcelas">{{$matricula->parcelas}}</b> parcela(s) de <small>R$</small> <b><span id="saldo_final_parcelado">{{number_format($matricula->valor/$matricula->parcelas,2,',','.')}}</span></b> = <small>R$</small> <b><span id="saldo_final">{{number_format($matricula->valor,2,',','.')}}</span></b></p>
        </div>
        <input type="hidden" name="valorcursointegral" value="{{$matricula->valor}}" >
        <input type="hidden" name="valordesconto" value="0" >

    </div>
</div>

@endsection
@section('scripts')
<script>

function desconto(item){
    console.log(item.value);

    if(item.value==0){
       $('#porcentagem').val(0)
        $('#valor').val(0);
        valor_desc=0;

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
    aplicarPlano({{ str_replace(',', '.', $matricula->valor) }});


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
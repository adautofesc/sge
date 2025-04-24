@extends('layout.app')
@section('pagina')
<div class="title-block">
	@if($vencido)
	<h3 class="title"> Solicitando 2ª via do boleto {{$boleto->id}} <span class="sparkline bar" data-type="bar"></span> </h3>
	@else
    <h3 class="title"> Registrando boleto {{$boleto->id}} no banco para impressão.<span class="sparkline bar" data-type="bar"></span> </h3>
    @endif
</div>
@include('inc.errors')
<form name="item" action="https://mpag.bb.com.br/site/mpag/" method="POST">
	<input type="hidden" name="idConv" value="318737">
	<input type="hidden" name="refTran" value="2838669{{str_pad($boleto->id,10,'0',STR_PAD_LEFT)}}">
	<input type="hidden" name="valor" value="{{preg_replace( '/[^0-9]/is', '',$boleto->valor)}}">
	<input type="hidden" name="qtdPontos" value="">
	<input type="hidden" name="dtVenc" value="{{\Carbon\Carbon::parse($boleto->vencimento)->format('dmY')}}">
	@if($vencido)
	<input type="hidden" name="tpPagamento" value="21">

	@else
	<input type="hidden" name="dtVenc" value="{{\Carbon\Carbon::parse($boleto->vencimento)->format('dmY')}}">
	@endif
	
	<input type="hidden" name="cpfCnpj" value="{{$pessoa->cpf}}">
	<input type="hidden" name="indicadorPessoa" value="1">
	<input type="hidden" name="valorDesconto" value="">
	<input type="hidden" name="dataLimiteDesconto" value="">
	<input type="hidden" name="tpDuplicata" value="DS">
	<input type="hidden" name="urlRetorno" value="/financeiro/boletos/retorno-direto">
	<input type="hidden" name="urlInforma" value="">
	<input type="hidden" name="nome" value="{{$pessoa->nome}}">
	<input type="hidden" name="endereco" value="{{$pessoa->logradouro.' '.$pessoa->end_numero.' '.$pessoa->end_complemento.' '.$pessoa->bairro}}">
	<input type="hidden" name="cidade" value="{{$pessoa->cidade}}">
	<input type="hidden" name="uf" value="{{$pessoa->estado}}">
	<input type="hidden" name="cep" value="{{preg_replace( '/[^0-9]/is', '',$pessoa->cep)}}">
	<input type="hidden" name="msgLoja" value="{!!$lancamentos!!}">

    <div class="card card-block">
    	<div class="row">
			<div class="col-sm-12">
				<h5>Boleto alterado para "emitido" no sistema.</h5>			
			</div>
			
       </div>
	   <div class="row">
			<div class="col-sm-12">
				<small>Para registrar o boleto, <b>após avançar</b>, clique no ícone:</small>
				<br>
				<img src="https://mpag.bb.com.br/site/mpag/img/imgBoletoBancario.gif" alt="selo BB">		
			</div>
	   </div>
		
   </div>			            
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-2">
				<input type="hidden" name="boleto" value="{{$boleto->id}}">
				<button type="submit" name="btn"  class="btn btn-primary">Avançar</button>
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
				<!-- 
				<button type="submit" class="btn btn-primary"> Cadastrar</button> 
				-->
			</div>
       </div>
    </div>
    {{csrf_field()}}
</form>
        
@endsection

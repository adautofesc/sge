@extends('perfil.layout')
@section('titulo')
    Meus Boletos - Perfil FESC
@endsection

@section('style')
    <style>

    </style>
@endsection
@section('body')
<div class="card mb-3">
                      
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12">
          <h5 class="mb-0">Meus Boletos</h5>
          
          <p class="text-secondary"><small>Aqui estão seus boletos para pagamento e pagos</small></p>
          <p class="alert alert-info"><small>NESTE MOMENTO apenas os boletos emitidos ao banco poderão ser impressos e pagos. O registro dos boletos podem demorar ate 24 horas. Nos finais de semana o prazo pode ser maior.</small></p>
          <hr>
          @if($errors->any())
            @foreach($errors->all() as $erro)
                <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" >×</button>       
                        <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
                </div>
            @endforeach
          @endif
        </div> 
      </div>
      <div class="row lista">
                                
        <div class="col-xl-5 " style="line-height:40px !important; padding-left: 30px;">
          <small><b>Boleto</b></small>  
        </div>
        <div class="col-xl-2" style="line-height:40px !important;">
          <small><b>Vencimento</b></small> 
        </div>
        <div class="col-xl-2" style="line-height:40px !important;">
          <small><b>Valor</b></small>   
        </div>
        <div class="col-xl-2" style="line-height:40px !important;">
          <small><b>Estatus</b></small> 
        </div>
        <div class="col-xl-1" style="line-height:40px !important;">
          <img src="{{asset('img/impressora.png')}}">
        </div>
        
      </div>
      <hr>
      @foreach($boletos as $boleto)
      <div class="row lista">
                                
        <div class="col-xl-5 " style="line-height:40px !important; padding-left: 30px;">
            <small>Boleto nº <b>{{$boleto->id}}</b></small>
        </div>
        <div class="col-xl-2" style="line-height:40px !important;">
            <div><small>{{\Carbon\Carbon::parse($boleto->vencimento)->format('d/m/y')}}</small></div>
        </div>
        <div class="col-xl-2" style="line-height:40px !important;">
            <div title="Vencimento"><small>R$ {{$boleto->valor}}</small></div>
        </div>
        <div class="col-xl-2" style="line-height:40px !important;">
            @if($boleto->status == 'pago')
            <div class="badge badge-pill badge-success">pago</div>
            @elseif($boleto->status == 'emitido')
            <div class="badge badge-pill badge-info">emitido</div>
            @elseif($boleto->status == 'impresso')
            <div class="badge badge-pill badge-primary">impresso</div>
            @elseif($boleto->status == 'cancelar')
            <div class="badge badge-pill badge-warning">cancelar</div>
            @elseif($boleto->status == 'cancelado')
            <div class="badge badge-pill badge-danger">cancelado</div>
            @else
            <div class="badge badge-pill badge-secondary">{{$boleto->status}}</div>

            @endif
        </div>
        <div class="col-xl-1" style="line-height:40px !important;">
        @if($boleto->status == 'emitido')
        <a href="/perfil/boleto/{{$boleto->id}}" title="imprimir"> <img src="{{asset('img/impressora.png')}}"></a>
        @endif
        </div>
        
      </div>
      <hr>
      @endforeach
     

      
      
    </div>

  </div>

@endsection

@section('scripts')
<script>
function cancelar(){
  if(confirm("Confirmar saída do programa de parceria?"))
    window.location.replace('/perfil/parceria/cancelar');
}
 </script>   
@endsection
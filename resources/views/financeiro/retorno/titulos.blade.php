@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Análise do Retorno</h3>
            <p class="title-description">
              Arquivo: 
              <a href="{{asset('financeiro/boletos/retorno/original')}}/{{substr($arquivo,9)}}" title="Clique para ver os dados originais" target="_blank">
                {{$arquivo}} 
              </a>
            </p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-7 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Titulos</p>
                    </div>
                </div>
                <div class="card-block">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Id</th>
                          <th scope="col">Data</th>
                          <th scope="col">Valor Pago</th>
                          <th scope="col">Estado do titulo</th>
                        </tr>
                      </thead>
                      <tbody>
                     @foreach($titulos as $titulo)
                        <tr>
                          <th scope="row">{{$titulo['id']}}</th>
                          <td>{{$titulo['data']}}</td>
                          <td>{{$titulo['valor']}}</td>
                          <td>{{$titulo['boleto_status']}}</td>
                        </tr>
                    @endforeach
                      </tbody>
                    </table>

                 

                </div>
            </div>
        </div>
         <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Análise</p>
                    </div>
                </div>
                <div class="card-block">
                    <h2>Arquivo {{$id}}</h2>
                    @if($processado)
                   <h5 class="alert alert-danger">Arquivo ja processado</h5>
                
                   @endif
                   <b>Títulos processados:</b> {{count($titulos)}} 
                   <br>
                   <b>Liquidado:</b> R$ {{number_format($liquidado,2,',','.')}}
                   <br> 
                   <b>Acréscimos:</b> R$ {{number_format($acrescimos,2,',','.')}} 
                   <br> 
                   <b>Descontos/Abatimentos:</b> R$ {{number_format($descontos,2,',','.')}} 
                   <br>
                   <b>Taxas:</b> R$ {{number_format($taxas,2,',','.')}} 
                   <br>
                   <br>
                   <b>Total:</b> R$ {{number_format($total,2,',','.')}} 

                </div>
               
                <div class="card-block">
                    @if($processado == false)
                    <a class="btn btn-primary" href="#" onclick="processar('{{substr($arquivo,9)}}');">Processar</a>
                    @endif
                    <a class="btn btn-primary" href="#" onclick="reprocessar('{{substr($arquivo,9)}}');">Reprocessar</a>
                    <a class="btn btn-primary" href="#" onclick="descartar('{{substr($arquivo,9)}}');">Descartar</a>
                    <a class="btn btn-primary" href="{{asset('/financeiro/boletos/retorno/arquivos')}}">Arquivos</a>


                </div>
                

               
            </div>
        </div>

    </div>
</section>

@endsection
@section('scripts')
<script type="text/javascript">
    function processar(item){
        if(confirm('Tem certeza que quer processar esse arquivo? TODOS títulos serão processados')){
            window.location.replace("{{asset('/financeiro/boletos/retorno/processar/')}}/"+item);
        }
    }
    function reprocessar(item){
        if(confirm('Tem certeza que quer REPROCESSAR o arquivo? Os títulos pagos não serão processados.')){
            window.location.replace("{{asset('/financeiro/boletos/retorno/reprocessar/')}}/"+item);

        }
    }
    function descartar(item){
        if(confirm('Tem certeza que quer DESCARTAR esse arquivo? (ele será dado como processado)')){
            window.location.replace("{{asset('/financeiro/boletos/retorno/marcar-processado/')}}/"+item);

        }
    }
</script>
@endsection

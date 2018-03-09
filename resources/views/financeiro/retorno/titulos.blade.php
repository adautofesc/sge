@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Análise do Retorno</h3>
            <p class="title-description">Arquivo: {{$arquivo}} </p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Arquivos</p>
                    </div>
                </div>
                <div class="card-block">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Id</th>
                          <th scope="col">Data</th>
                          <th scope="col">Valor Pago</th>
                        </tr>
                      </thead>
                      <tbody>
                     @foreach($titulos as $titulo)
                        <tr>
                          <th scope="row">{{$titulo['id']}}</th>
                          <td>{{$titulo['data']}}</td>
                          <td>{{$titulo['valor']}}</td>
                        </tr>
                    @endforeach
                      </tbody>
                    </table>

                 

                </div>
            </div>
        </div>
         <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Análise</p>
                    </div>
                </div>
                <div class="card-block">
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
                @if(substr($arquivo,-4) == '.ret')
                <div class="card-block">
                    <form method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="arquivo" value="{{$arquivo}}">
                        <button class="btn btn-warning" onclick="processar();return false;">Processar Arquivo</button>
                        <button class="btn btn-primary" onclick="descartar('{{$arquivo}}');return false;  ">Descartar</button>
                        </form>

                </div>
                @endif

               
            </div>
        </div>

    </div>
</section>

@endsection
@section('scripts')
<script type="text/javascript">
    function processar(){
        if(confirm('Tem certeza que quer processar esse arquivo?')){
            $(form).submit();
        }
    }
    function descartar(){
        if(confirm('Tem certeza que quer DESCARTAR esse arquivo? (ele será dado como processado)')){
            alert('Recurso em desenvolvimento, contate o suporte para a exclusão do arquivo.');
        }
    }
</script>
@endsection

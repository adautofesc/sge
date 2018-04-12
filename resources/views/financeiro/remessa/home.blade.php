@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Módulo de geração de remessa</h3>
            <p class="title-description">Geração e download do arquivo</p>
        </div>
    </div>
</div>
@include('inc.errors')
<section class="section">
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">ATENÇÃO</p>
                    </div>
                </div>
                <div class="card-block">
                
                    <p> A geração do arquivo de remessa deve ser realizado logo após a impressão dos boletos ou no final do dia (se houver boletos emitidos). </p>
                    <p> Após a geração do arquivo, os boletos impressos ficam com o <i>status</i> de emitido.</p>
                    <div>
                        <a href="#" onclick="gerarRemessa();" class="btn btn-warning-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Gerar arquivo de Remessa</a>
                    </div>
                    <div>
                        <a href="{{asset('financeiro/boletos/remessa/listar-arquivos')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Fazer download de arquivos anteriores.</a>
                    </div>
                    <!--
                    <div>
                        <a href="{{asset('financeiro/boletos/imprimir-lote')}}" data-toggle="modal" data-target="#confirm-modal" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Impressão de boletos em lote</a>
                    </div>
                    -->

                </div>
            </div>
        </div>

    </div>
</section>

@endsection
@section('scripts')
<script type="text/javascript">
    function gerarRemessa(){
        if(confirm("Tem certeza que deseja gerar um arquivo de remessa?")){
            window.location.replace("{{asset('financeiro/boletos/remessa/gerar')}}");
        }
    }

</script>
@endsection

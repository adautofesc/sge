@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Remessas geradas</h3>
            <p class="title-description">Download de arquivos anteriores</p>
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
                    @foreach($arquivos as $arquivo)
    
                    <div>
                        <a href="{{asset('/financeiro/boletos/remessa/download')}}/{{$arquivo}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-cloud-download "></i>
                        &nbsp;&nbsp;{{substr($arquivo,6,2)}}/{{substr($arquivo,4,2)}}/{{substr($arquivo,0,4)}} - {{substr($arquivo,8,2)}}:{{substr($arquivo,10,2)}}</a>
                    </div>
                    @endforeach
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

@extends('layout.app')
@section('titulo') Módulo de geração de remessa @endsection
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Módulo de geração de remessa</h3>
            <p class="title-description">Geração e download do arquivo</p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-success">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Arquivo Gerado</p>
                    </div>
                </div>
                <div class="card-block">
                    <p>{{ceil($boletos->currentPage()*100/$boletos->lastPage())}}% processado... Total restante: {{$boletos->total()}}</p>
                
             
                    <div>
                        <a href="{{asset('/financeiro/boletos/remessa/download')}}/{{$arquivo}}"  class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Fazer download do arquivo</a>
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
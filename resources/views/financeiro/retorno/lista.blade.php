@extends('layout.app')
@section('pagina')
@include('inc.errors')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Arquivos de retorno</h3>
            <p class="title-description">Lista de arquivos encontrados. </p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-8 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Arquivos</p>
                    </div>
                </div>
                <div class="card-block">
                    <p>O dia não pode ser verificado com precisão. Verifique na análise do arquivo.</p>
                    @foreach($arquivos as $arquivo)
    
                    <div>
                        <a href="{{asset('/financeiro/boletos/retorno/processar/')}}/{{$arquivo}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-sign-in "></i>
                        &nbsp;&nbsp;{{   '"'.substr($arquivo,strpos($arquivo, date('Y'))-4,2).'" /'
                                        .substr($arquivo,strpos($arquivo, date('Y'))-2,2).'/'
                                        .substr($arquivo,strpos($arquivo, date('Y')),4). ' -    '
                                        .$arquivo}}</a>
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
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Opções</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="{{asset('/financeiro/boletos/retorno/upload')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-cloud-upload "></i>
                        &nbsp;&nbsp;Fazer upload de arquivos</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/retorno/escolha-arquivo" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-bolt "></i>
                        &nbsp;&nbsp;Processar arquivos</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/retorno/processados" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-thumbs-o-up "></i>
                        &nbsp;&nbsp;Arquivos processados</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/retorno/com-erro" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-thumbs-o-down "></i>
                        &nbsp;&nbsp;Arquivos com erro</a>
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

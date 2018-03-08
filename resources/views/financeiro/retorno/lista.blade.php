@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Retornos disponíveis</h3>
            <p class="title-description">Lista de retornos não processados</p>
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
                        <a href="{{asset('/financeiro/boletos/retorno/processar/')}}/{{$arquivo}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-sign-in "></i>
                        &nbsp;&nbsp;{{   substr($arquivo,strpos($arquivo, date('Y'))-4,2).'/'
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

    </div>
</section>

@endsection

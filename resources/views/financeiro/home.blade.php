@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Departamento de Tesouraria da FESC</h3>
            <p class="title-description">Receitas, despesas, balancetes e relatórios</p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Opções</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/retorno/home" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-file-text "></i>
                        &nbsp;&nbsp;Retornos</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/lancamentos/home" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-calendar "></i>
                        &nbsp;&nbsp;Parcelas (lançamentos)</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/home" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-barcode "></i>
                        &nbsp;&nbsp;Boletos</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/remessa/home" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-file-text-o "></i>
                        &nbsp;&nbsp;Remessas</a>
                    </div>
                              
                </div>
            </div>
        </div>
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Relatórios</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="{{asset('/')}}financeiro/relatorios/boletos" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-file-text-o "></i>
                        &nbsp;&nbsp;Boletos vencidos e não pagos</a>
                    </div>           
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

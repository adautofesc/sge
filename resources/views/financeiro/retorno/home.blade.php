@extends('layout.app')
@section('titulo')Retorno Bancário @endsection
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Retorno Bancário</h3>
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
                        <a href="{{asset('/financeiro/boletos/retorno/upload')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-cloud-upload "></i>
                        &nbsp;&nbsp;Fazer upload de arquivos</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/home" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-bolt "></i>
                        &nbsp;&nbsp;Processar arquivos</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/remessa/home" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-thumbs-o-up "></i>
                        &nbsp;&nbsp;Arquivos processados</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/retorno/home" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-thumbs-o-down "></i>
                        &nbsp;&nbsp;Arquivos com erro</a>
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
                    Nenhuma opção disponível no momento              
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

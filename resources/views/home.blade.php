@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Bem vindo !!!</h3>
            <p class="title-description">{{ $dados['data']}}</p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-xl-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Departamentos disponíveis:</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="/secretaria/atender" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-bar-chart-o "></i>
                        &nbsp;&nbsp;Administrativo</a></div>
                    <div>
                        <a href="/pessoa/cadastrar" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-th-large "></i>
                        &nbsp;&nbsp;Docentes</a></div>
                    <div><a href="/pessoa/listar" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-usd"></i>&nbsp;&nbsp;Financeiro</a></div>
                    <div><a href="/pessoa/listar" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-users"></i>&nbsp;&nbsp;Gestão Pessoal</a></div>
                    <div><a href="/pessoa/listar" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-th-list"></i>&nbsp;&nbsp;Pedagógico</a></div>
                    <div><a href="{{asset("/secretaria")}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-stack-overflow"></i>&nbsp;&nbsp;Secretaria</a></div>

                
            </div>
        </div>  

    </div>
</section>

@endsection
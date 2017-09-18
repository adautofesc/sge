@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Departamento de Secretaria da FESC</h3>
            <p class="title-description">Olá, suas opções estão disponíveis abaixo.</p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-xl-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Matrículas</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="/secretaria/atender" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Atendimento</a>
                    </div>
                    <div>
                        <a href="/pessoa/cadastrar" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-plus-circle "></i>
                        &nbsp;&nbsp;Cadastrar</a>
                    </div>
                    <div>
                        <a href="/pessoa/listar" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class="fa fa-group"></i>
                        &nbsp;&nbsp;Lista de Cadastrados</a>
                    </div>
                </div>                
            </div>
        </div>
        <div class="col-xl-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Turmas</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="/pedagogico/turmas" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Liberação de Matrículas</a>
                    </div>
                    <div>
                        <a href="/secretaria/atender" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Lista de espera</a>
                    </div>
                    <div>
                        <a href="#" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-plus-circle "></i>
                        &nbsp;&nbsp;Relatórios</a>
                    </div>
                
                </div>                
            </div>
        </div>  
    </div>
</section>

@endsection
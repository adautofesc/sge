@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-12">
            <h3 class="title">Departamento de Gestão Pessoal</h3>
            <p class="title-description">Controle de ponto, folha de pagamento, controle de usuários e recursos </p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Geral</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="{{asset('/gestaopessoal/atendimento')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Atendimento</a>
                    </div>
                    <div>
                        <a href="{{asset('/pessoa/cadastrar')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-plus-circle "></i>
                        &nbsp;&nbsp;Cadastrar Pessoa</a>
                    </div>
                    <div>
                        <a href="{{asset('/admin/listarusuarios')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class="fa fa-group"></i>
                        &nbsp;&nbsp;Lista de Usuários</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Ponto</p>
                    </div>
                </div>
                <div class="card-block">
                   <p>Nenhuma opção disponível</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Folha de pagamento</p>
                    </div>
                </div>
                <div class="card-block">
                    <p>Nenhuma opção disponível</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
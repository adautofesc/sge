@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Setor de Desenvolvimento</h3>
            <p class="title-description">Configurações e rotinas de ajustes</p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Configurações</p>
                    </div>
                </div>
                <div class="card-block">
                    Nenhuma opção disponível no momento              
                </div>
            </div>
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Rotinas de ajuste</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="/dev/curso-matriculas" title="Atualiza o código do curso de todas matriculas para a que está em sua inscrição." target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Cod. curso das matrículas</a>
                    </div>             
                </div>
            </div>
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Rotinas adminstrativas</p>
                    </div>
                </div>
                <div class="card-block">
                     <div>
                        <a href="/secretaria/relatorios/turmas"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Alunos 1º Semestre de 2018</a>
                    </div>            
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
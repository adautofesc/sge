@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Departamento Administrativo da FESC</h3>
            <p class="title-description">Adminstração, Compras, Contratos</p>
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
                    <div>
                        <a href="administrativo/locais"  target="_self" class="btn btn-primary-outline col-xs-12 text-xs-left" title="Locais de atendimento/parcerias">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Locais/Salas</a>
                    </div> 
                    <div>
                        <a href="agendamento-salas"  target="_self" class="btn btn-primary-outline col-xs-12 text-xs-left" title="Locais de atendimento/parcerias">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Agendamento de salas</a>
                    </div>              
                </div>
            </div>
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Relatórios TCE</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="/relatorios/tce-alunos/2018"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left" title="Relatório contendo todos os alunos, indicando os respectivos cursos, cargas horárias previstas e efetivamente realizadas">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Alunos 2018</a>
                    </div>
                    <div>
                        <a href="/relatorios/tce-educadores/2018"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left" title="Relatório contendo todos os Educadores, os respectivos cursos, cargas horárias previstas e efetivamente realizadas em 2018;">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Educadores 2018</a>
                    </div>
                    <div>
                        <a href="/relatorios/tce-turmas/2018"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left" title="Relatório de todas as turmas do Exercício de 2018, contendo todos os cursos ministrados pela FESC, com indicação dos horários e professores">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Turmas 2018</a>
                    </div>
                    <div>
                        <a href="/relatorios/tce-turmas-alunos/2018"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left" title="Relatório de todas as turmas do Exercício de 2018, contendo todos os cursos ministrados pela FESC, com indicação dos horários, professores e alunos matriculados">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Turmas/Alunos 2018</a>
                    </div>      
                </div>
            </div>
        </div>
        
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Relatórios</p>
                    </div>
                </div>
                <div class="card-block">
                     <div>
                        <a href="/relatorios/turmas"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Relatório de Turmas</a>
                    </div>
                    <div>
                        <a href="/relatorios/inscricoes"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Relatório de Inscrições</a>
                    </div> 
                    <div>
                        <a href="/relatorios/bolsas/"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Relatório de Bolsas</a>
                    </div>         
                </div>
            </div>
        </div>

        <div class="col-md-4 center-block">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="header-block">
                            <p class="title" style="color:white">Cursos / Atividades</p>
                        </div>
                    </div>
                    <div class="card-block">
                        <div>
                            <a href="{{asset('/pedagogico/cadastrarcurso')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                            <i class=" fa fa-plus-circle "></i>
                            &nbsp;&nbsp;Cadastrar</a>
                        </div>
                        <div>
                            <a href="{{asset('pedagogico/cursos')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                            <i class=" fa fa-toggle-right  "></i>
                            &nbsp;&nbsp;Cursos/atividades</a></div>
                        
                        <div>
                            <a href="{{asset('pedagogico/disciplinas')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                            <i class=" fa fa-toggle-down "></i>
                            &nbsp;&nbsp;Disciplinas</a>
                        </div>
                        <div>
                            <a href="{{asset('pedagogico/cursos/requisitos')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                            <i class=" fa fa-check-square-o "></i>
                            &nbsp;&nbsp;Requisitos</a>
                        </div>
                        <div>
                            <p class="btn btn-secondary col-xs-12 text-xs-left">
                            <i class=" fa fa-file-text-o "></i>
                            &nbsp;&nbsp;Projetos</p>
                        </div>
                                   
                    </div>
                </div>  
            </div>

    </div>
</section>

@endsection
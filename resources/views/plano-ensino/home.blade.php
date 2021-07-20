@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Planos de ensino</h3>
            <p class="title-description">Ferramenta para criação e gerenciamento</p>
        </div>
    </div>
</div>
<section class="section">
 @include('inc.errors')
    <div class="row">
        <div class="col-md-7 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Planos de ensino &nbsp;&nbsp;</p>

                        
                    </div>
                </div>

                <div class="card-block">
                    
                    <table class="table table-striped table-condensed">
                    
                        <thead class="row">
                            <th class="col-sm-1 col-xs-1"><small>Cód.</small></th>
                            <th class="col-sm-2 col-xs-2"><small>Dia(s)</small></th>
                            <th class="col-sm-2 col-xs-2"><small>Inicio</small></th>
                            <th class="col-sm-5 col-xs-5"><small>Curso/Disciplina</small></th>
                            <th class="col-sm-2 col-xs-2"><small>Opções</small></th>
                        </thead>
                    
                        <tbody>
                           
                        </tbody>
                    </table>
                    
                                   
                </div>     
            </div>
        </div> 
        <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Opções</p>
                    </div>
                </div>
                <div class="card-block">
                    <!--
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;<a href="#"> Listas de Frequência Anteriores</a>
                    </div>
                -->
                    <div class="btn btn-sm rounded-s btn-success col-xs-5 text-xs-left">
                        <i class=" fa fa-plus "></i> 
                        &nbsp;&nbsp;<a href="/planos-ensino/cadastrar" >Novo plano</a>
                    </div>
                    <!--
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Planos de ensino  
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Planejamento de aula
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Solicitação de equipamentos
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Solicitação de sala de aula extra
                    </div>
                -->
                </div>   
            </div>
        </div>
        
        <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Formulários</p>
                    </div>
                </div>
                <div class="card-block">

                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/formularios/formulario_turmas.doc')}}"  title="Formulário de definição de Turmas e horários">Formulário de Horário</a>
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/formularios/inscricao.doc')}}"  title="Inscrição para os cursos de parceria.">Formulário de Inscrição em Turmas</a>
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/usolivre.pdf')}}" >Formulário de cadastro no Uso Livre</a>
                    </div>
    
                
                </div>   
            </div>
        </div> 

    </div>
</section>

@endsection
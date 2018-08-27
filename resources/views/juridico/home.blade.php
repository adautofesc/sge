@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Departamento Jurídico da FESC</h3>
            <p class="title-description">Leis, portarias, sindicâncias e ouvidoria</p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Leis da Fundação</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;<a href="/documentos/estatuto.pdf" target="_blank">Estatuto</a>
                    </div>
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;<a href="/documentos/regimento2008.pdf" target="_blank">Regimento Interno</a>
                    </div>
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;<a href="http://www.saocarlos.sp.gov.br/index.php/servidor/manual-do-servidor.html" target="_blank">Manual do Servidor</a>
                    </div> 
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;<a href="/documentos/LEI6890.71.pdf" target="_blank">Lei 6.841/71 de Criação da FESC </a>
                    </div>
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;<a href="/documentos/LEI14260.07.pdf" target="_blank">Lei 14.260/07 de Concessão de bolsas </a>
                    </div>
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;<a href="/documentos/LEI14841.08.pdf" target="_blank">Lei 14.841/08 de Organização da FESC </a>
                    </div>
                         
                </div>
            </div>  
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Portarias</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;indisponível.
                    </div>
                    <!--
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;2016
                    </div>  
                   -->               
                </div>
            </div>  
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Ouvidoria</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Indisponível.
                    </div>
                    <!--
                        <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Registrar ocorrência
                    </div>
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Acompanhar processo
                    </div>   
                    -->             
                </div>
            </div>  
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Bolsas de estudos</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>                        
                        <a href="/juridico/bolsas/liberacao" class="col-xs-12 text-xs-left">
                        <i class=" fa fa-folder-open"></i>
                        &nbsp;&nbsp;Liberação de Bolsas</a>
                    </div>
                 
                </div>
            </div>  
        </div>
    </div>

</section>

@endsection
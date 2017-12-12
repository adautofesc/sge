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
                        &nbsp;&nbsp;Estatuto
                    </div>
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Regimento Interno
                    </div>
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Comissão de Ética Pública
                    </div> 
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Estatudo do SPM SC
                    </div>   
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Lei de Acesso à Informação
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
                        &nbsp;&nbsp;2017
                    </div>
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;2016
                    </div>  
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;2015
                    </div> 
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Anteriores
                    </div>               
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
                        &nbsp;&nbsp;Registrar ocorrência
                    </div>
                    <div>                        
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Acompanhar processo
                    </div>                
                </div>
            </div>  
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Recursos de sistema</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>                        
                        <a href="/juridico/documentos" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-file"></i>
                        &nbsp;&nbsp;Contratos e Termos</a>
                    </div>
                 
                </div>
            </div>  
        </div>
    </div>
</section>

@endsection
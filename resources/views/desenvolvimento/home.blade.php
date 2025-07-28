@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Setor de Desenvolvimento</h3>
            <p class="title-description">Uso de API's</p>
        </div>
    </div>
</div>
<section class="section">
    
    <div class="row">
        
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
                    <div>
                        <a href="/pedagogico/turmas/atualizar-inscritos" title="Atualiza o quantidade de vagas e inscritos nas turmas" target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Atualizar vagas</a>
                    </div>
                    <div>
                        <a href="/secretaria/ativar_matriculas_em_espera" class="btn btn-danger-outline col-xs-12 text-xs-left" title="Ativar matriculas que estao em espera. Necessita de credencial.">
                        <i class=" fa fa-play-circle "></i>
                        &nbsp;&nbsp;Ativar Matrículas</a>
                    </div>  
                    <div>
                        <a href="{{route('turmas.expiradas')}}" class="btn btn-danger-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-minus-square "></i>
                        &nbsp;&nbsp;Encerrar Expiradas</a>
                    </div>           
                </div>
            </div>
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Tokens de autorização</p>
                    </div>
                </div>
                <div class="card-block">
                     <div>
                        <a href="#"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Gerar Token</a>
                    </div> 
                    <div>
                        <a href="#"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Apagar Token</a>
                    </div>
                   
                             
                </div>
            </div>
        </div>

        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Tokens de autorização</p>
                    </div>
                </div>
                <div class="card-block">
                     <div>
                        <a href="#"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Gerar Token</a>
                    </div> 
                    <div>
                        <a href="#"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Apagar Token</a>
                    </div>
                   
                             
                </div>
            </div>
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">API Catraca</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="/api/gerar-token"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Gerar API</a>
                    </div> 
                    <div>
                        <a href="/api/apagar-token"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Apagar API</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>



@endsection
@section('scripts')



@endsection
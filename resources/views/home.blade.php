@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title"> Painel inicial</h3>
            <p class="title-description"> Lista de recursos disponíveis</p>
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
                                            <div><a href="matricula_cursos_disponiveis.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-plus-circle "></i>  Nova Matrícula</a></div>
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-check-square-o"></i> Efetivar Matrícula</a></div>
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-times-circle"></i> Cancelar Matrícula</a></div>
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-times"></i> Cancelar curso</a></div>
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-print"></i> Impressão</a></div>
                                        </div>
                                        
                                    </div>
                                </div>  
                                <div class="col-xl-4 center-block"> 
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <div class="header-block">
                                                <p class="title" style="color:white">Financeiro</p>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-usd "></i>  Extrato</a></div>
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-barcode"></i> 2a Via de Boleto</a></div>
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-money"></i> Pagamento</a></div>
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-fire-extinguisher"></i> Resolução de problemas</a></div>
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-reply"></i> Estorno</a></div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-xl-4 center-block"> 
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <div class="header-block">
                                                <p class="title" style="color:white">Acadêmico</p>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-archive "></i>  Histórico</a></div>
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-external-link"></i> Declarações</a></div>
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-heart"></i> Entrega de atestado</a></div>
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-certificate"></i> Certificados</a></div>
                                            <div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-book"></i> Relação de Faltas</a></div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </section>

@endsection
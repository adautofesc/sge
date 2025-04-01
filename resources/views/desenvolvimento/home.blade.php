@extends('layout.app')
@section('pagina')
<style>
    #area-chart,
#line-chart,
#bar-chart,
#stacked,
#pie-chart{
  min-height: 250px;
}
.stat{
    display: inline-block;
    margin-left: 10px;
    vertical-align: middle;
}
.stats-container a {
    color: #4f5f6f;
}

.stat-icon {

    display: inline-block;
    font-size: 26px;
    text-align: center;
    vertical-align: middle;
    width: 50px;
    line-height: 3rem;
    border-radius: 5%;
    background-color: #f5f5f5;
}
.blue{
    background-color: #007bff;
}


</style>
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
        <div class="col-md-6 center-block">
            
            
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Opções</p>
                    </div>
                </div>
                <div class="card-block">
                    <div class="card-block">
                        <div class="row row-sm stats-container">
                            <a href="/dev/testar-classe" title="Executa classe de teste painelController.">
                                <div class="col-6 col-sm-6 stat-col">
                                    <div class="stat-icon">
                                        <i class="fa fa-flask"></i>
                                    </div>
                                    <div class="stat">
                                        <div class="value"> Testar </div>
                                        <div class="name"> Metodo de teste</div>
                                    </div>
                                    <div class="progress stat-progress">
                                        <div class="progress-bar" style="width: 25%;"></div>
                                    </div>
                                </div>
                            </a>
                            
                            <a href="/dev/teste-pix" title="Executa classe de teste painelController.">
                                <div class="col-6 col-sm-6 stat-col">
                                    <div class="stat-icon">
                                        <i class="fa fa-flask"></i>
                                    </div>
                                    <div class="stat">
                                        <div class="value"> PIX </div>
                                        <div class="name">Testar Boleto PIX</div>
                                    </div>
                                    <div class="progress stat-progress">
                                        <div class="progress-bar" style="width: 25%;"></div>
                                    </div>
                                </div>
                            </a>

                            <a href="/dev/testar-classe" title="Executa classe de teste painelController.">
                                <div class="col-6 col-sm-6 stat-col">
                                    <div class="stat-icon">
                                        <i class="fa fa-flask"></i>
                                    </div>
                                    <div class="stat">
                                        <div class="value"> Testar </div>
                                        <div class="name"> Metodo de teste</div>
                                    </div>
                                    <div class="progress stat-progress">
                                        <div class="progress-bar" style="width: 25%;"></div>
                                    </div>
                                </div>
                            </a>

                            <a href="/dev/testar-classe" title="Executa classe de teste painelController.">
                                <div class="col-6 col-sm-6 stat-col">
                                    <div class="stat-icon">
                                        <i class="fa fa-flask"></i>
                                    </div>
                                    <div class="stat">
                                        <div class="value"> Testar </div>
                                        <div class="name"> Metodo de teste</div>
                                    </div>
                                    <div class="progress stat-progress">
                                        <div class="progress-bar" style="width: 25%;"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                


                    <div>
                        
                        <a href="/dev/gerar-dias-nao-letivos" title="Cadastrar dias não letivos" target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                            <i class=" fa fa-arrow-right "></i>
                            &nbsp;&nbsp;Cadastrar dias não letivos</a>
                        <a href="/dev/add-recesso" title="Cadastrar recesso de dias não letivos" target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                                <i class=" fa fa-arrow-right "></i>
                                &nbsp;&nbsp;Cadastrar recesso</a>
                    </div>    
                            
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
                        <p class="title" style="color:white">Rotinas adminstrativas</p>
                    </div>
                </div>
                <div class="card-block">
                     <div>
                        <a href="/secretaria/relatorios/turmas"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Alunos 1º Semestre de 2018</a>
                    </div> 
                    <div>
                        <a href="/relatorios/alunos-posto/"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Alunos por unidade</a>
                    </div>
                    <div>
                        <a href="/relatorios/faixasuati/"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Faixas insc. UATI</a>
                    </div>   
                    <div>
                        <a href="/dev/importar-status-boletos"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Processar arquivo de dívida ativa.</a>
                    </div>               
                </div>
            </div>
        </div>

    </div>
    
</section>
<section>
    <div class="row">
        <div class="col-md-12">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</section>


@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
<script type="text/javascript">
const labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
  ];

  const data = {
    labels: labels,
    datasets: [{
      label: 'My First dataset',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [0, 10, 5, 2, 20, 30, 45],
    }]
  };

  const configChart = {
    type: 'bar',
    data: data,
    options: {}
  };

  const myChart = new Chart(
    document.getElementById('myChart'),
    configChart
  );


    

</script>


@endsection
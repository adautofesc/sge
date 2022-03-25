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
                    <div>
                        <a href="/dev/testar-classe" title="Executa classe de teste painelController." target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Metodo de teste </a>
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
                        <a href="/dev/importar-status-boletos"  target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Processar arquivo de dívida ativa.</a>
                    </div>               
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="calendar-base">
          
              <div class="year">2017</div>
              <!-- year -->
          
              <div class="triangle-left"></div>
              <!--triangle -->
              <div class="triangle-right"></div>
              <!--  triangle -->
          
              <div class="months">
                <span class="month-hover">Jan</span>
                <span class="month-hover">Fev</span> 
                <span class="month-hover">Mar</span> 
                <strong class="month-color">Abr</strong>
                <span class="month-hover">Mai</span>
                <span class="month-hover">Jun</span>
                <span class="month-hover">Jul</span> 
                <span class="month-hover">Ago</span> 
                <span class="month-hover">Set</span> 
                <span class="month-hover">Out</span> 
                <span class="month-hover">Nov</span> 
                <span class="month-hover">Dez</span>
              </div><!-- months -->
              <hr class="month-line" />
          
              <div class="days">DOM SEG TER QUA QUI SEX SAB</div>
              <!-- days -->
          
              <div class="num-dates">
          
                <div class="first-week"><span class="grey">26 27 28 29 30 31</span> 01</div>
                <!-- first week -->
                <div class="second-week">02 03 04 05 06 07 08</div>
                <!-- week -->
                <div class="third-week"> 09 10 11 12 13 14 15</div>
                <!-- week -->
                <div class="fourth-week"> 16 17 18 19 20 21 22</div>
                <!-- week -->
                <div class="fifth-week"> 23 24 25 26 <strong class="white">27</strong> 28 29</div>
                <!-- week -->
                <div class="sixth-week"> 30 <span class="grey">01 02 03 04 05 06</span></div>
                <!-- week -->
              </div>
              <!-- num-dates -->
              <div class="event-indicator"></div>
              <!-- event-indicator -->
              <div class="active-day"></div>
              <!-- active-day -->
              <div class="event-indicator two"></div>
              <!-- event-indicator -->
          
            </div>
            <!-- calendar-base -->
            <div class="calendar-left ">
          
              <div class="hamburger">
                <div class="burger-line"></div>
                <!-- burger-line -->
                <div class="burger-line"></div>
                <!-- burger-line -->
                <div class="burger-line"></div>
                <!-- burger-line -->
              </div>
              <!-- hamburger -->
          
          
              <div class="num-date">27</div>
              <!--num-date -->
              <div class="day">THURSDAY</div>
              <!--day -->
              <div class="current-events">Current Events
                <br/>
                <ul>
                  <li>Day 09 Daily CSS Image</li>
                </ul>
                <span class="posts">See post events</span></div>
              <!--current-events -->
          
              <div class="create-event">Create an Event</div>
              <!-- create-event -->
              <hr class="event-line" />
              <div class="add-event"><span class="add">+</span></div>
              <!-- add-event -->
          
            </div>
            <!-- calendar-left -->
          
    </div>
    <!-- row -->

    
</section>
<section>
    <div class="row">
        <div class="col-md-12">
            <div id="placeholder" style="width:600px;height:300px">

            </div>
        </div>
    </div>
</section>


@endsection
@section('scripts')
<script type="text/javascript">
    function gerarBoletos(){
        if(confirm("Tem certeza que deseja gerar os boletos desse mês?")){
            window.location.replace("{{asset('financeiro/boletos/gerar-boletos')}}");
        }
    }
    function gerarCarnes(){
        if(confirm("Tem certeza que deseja gerar os carnês de todos alunos?")){
            window.location.replace("{{asset('financeiro/carne/gerar')}}");
        }
    }
    function gerarImpressao(){
        if(confirm("Os boletos foram todos impressos?")){
            window.location.replace("{{asset('financeiro/boletos/confirmar-impressao')}}");
        }
    }
    function gt(time) {
        let hora = time.substring(0,2);
        let minuto = time.substring(2,2);
        let tempo = new Date(2022,3,25,hora,minuto,0).getTime();
       
        
        return tempo ;
    }
    minimo = new Date(2022,3,25,6,0,0).getTime();
    maximo = new Date(2022,3,25,22,59,0).getTime();

    var data = [ 
        { label: "Aula", data: [ [1,gt('11:00')],[2,gt('15:00')]] },
    
        ];
    var options = {

        series: {
            bars: { show: true },
            
        },
        yaxis : {
            minTickSize : [ 1, "hour" ],
            min: minimo,
            max: maximo,
            
            show: true,
            mode : "time",
            timeformat : "%H:%M"
        }
    };
  
    var plot = $("#placeholder").plot(data, options).data("plot");
    

</script>
@endsection
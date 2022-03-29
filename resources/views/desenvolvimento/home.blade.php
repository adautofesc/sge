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
        let hora = time.substring(0,2)-3;
        let minuto = time.substring(5,3);
        let tempo = new Date(1970,0,1,hora,minuto,0).getTime();
        console.log(time+'->'+tempo);
       
        
        return tempo ;
    }

    function msToTime(duration) {
        var milliseconds = Math.floor((duration % 1000) / 100),
            seconds = Math.floor((duration / 1000) % 60),
            minutes = Math.floor((duration / (1000 * 60)) % 60),
            hours = Math.floor((duration / (1000 * 60 * 60)) % 24);

        hours = (hours < 10) ? "0" + hours : hours;
        minutes = (minutes < 10) ? "0" + minutes : minutes;
        seconds = (seconds < 10) ? "0" + seconds : seconds;

        return hours + ":" + minutes;
    }

    minimo = new Date(1970,0,1,4,0,0).getTime();
    maximo = new Date(1970,0,1,20,0,0).getTime();
    

    var data = [ 
        { label: "Aula",
          link:"#",
          data: [ [1,gt('10:00'),gt('12:00'),"teste"],[1,gt('13:00'),gt('15:00'),"teste2"]] ,
         
        },
        { label: "Atividade",
        link:"#1",
          data: [ [6,gt('12:00'),gt('19:30'),"Desc/turma",""]] ,
          
        },
        { label: "HTP",
        link:"#1",
          data: [ [3,gt('08:00'),gt('09:30'),"Desc/turma",""]] ,
          
        },

       
    
        ];
    var options = {

        series: {
            bars: {
                show: true,
                align:'center',
                
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.8
                    }, {
                        opacity: 0.8
                    }]
                },
                
               
            }
            
        },
        yaxis : {
            //minTickSize : [ 1, "hour" ],
            //TickSize : [ 1, "hour" ],
            
            axis: 2,
            show: true,
            mode : "time",
            timeformat : "%H:%M",
            ticks: 20,
            min: minimo,
            max: maximo
        },
        xaxis :{
            show : true,
            position: "top",
            tickLength:2,
            ticks: [
     
                [1, "Segunda"], 
                [2, "Terça"], 
                [3, "Quarta"],
                [4,"Quinta"],
                [5,"Sexta"],
                [6,"Sábado"],
                [7,""]],
       
          
            
           
        },
        
        grid: {
            
            hoverable: true,
            clickable: true,            
            borderWidth:0
        },
        legend: {
            show: false
        },
        tooltip: true,
        tooltipOpts: {
            //content: "início: %y %s"
           content: function(label, x, y, flotItem){
                //console.log(flotItem.seriesIndex);
                return "%s das %y às "+msToTime(data[flotItem.seriesIndex].data[0][2]);
            },
            //content: "Orders <b>%y</b> for <span>"+y+"</span>",
        }
    };
  
    var plot = $("#placeholder").plot(data, options).data("plot");

    $("#placeholder").bind("plotclick", function (event, pos, flotItem) {
        if (flotItem) { 
            //window.location = links[item.dataIndex];
            //window.open(links[dataIndex, '_blank']);
            console.log(data[flotItem.seriesIndex].data[flotItem.dataIndex][3]);
           // here you can write location = "http://your-doamin.com";
        }
    });

    $("#placeholder").bind("plothover", function(event, pos, item) {
        if(item)
            $("#placeholder").css("cursor","pointer","important");
        else
            $("#placeholder").css("cursor","default", "important");
    });
 

    //console.log(data[0].data[0][2]);
    

</script>

@endsection
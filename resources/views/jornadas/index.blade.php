@extends('layout.app')
@section('titulo')Jornada de trabalho @endsection
@section('pagina')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    @media (min-width: 767px){
        .codigo{
            max-width: 50px; }
        .pessoa{
            max-width: 300px; }
        .curso{
            max-width: 300px; }
            
            
        }
    @media (max-width: 766px){
        .pessoa{
            font-size: 20px;
        }
    }   
</style>



<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="#">Jornada</a></li>
</ol>

<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Jornadas de Trabalho 
                    <!--
-->
                    <div class="action dropdown">
                        <button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Opções... </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 5px, 0px);" x-out-of-boundaries="">
                            <a class="dropdown-item" href="#" style="text-decoration: none; font-weight: 550;"><i class="fa fa-bar-chart-o icon"></i>Gráfico</a>
                            @if($mostrar)
                            <a class="dropdown-item" href="/jornadas/{{$docente->id}}" style="text-decoration: none; font-weight: 550;"><i class="fa fa-eye icon text-success"></i>Exibir ativos</a>
                            @else
                            <a class="dropdown-item" href="?mostrar=todos" style="text-decoration: none; font-weight: 550;"><i class="fa fa-eye icon"></i>Exibir todos</a>
                            @endif
                        </div>
                    </div>
                </h3>
                <p class="title-description">
                     <strong>Prof.:</strong> {{$docente->nome}} <br>
                     <strong class="badge badge-pill badge-primary">{{$carga_efetiva->floatDiffInHours(\Carbon\Carbon::Today())}}h</strong> Efetivas | <strong class="badge badge-pill badge-primary">{{isset($carga_horaria->carga)?$carga_horaria->carga:'00'}}h</strong> Carga Semanal </p>
            </div>
        </div>
    </div>

    <div class="items-search col-md-3">
        <div class="header-block header-block-search hidden-sm-down">
           <form action="/fichas/pesquisa" method="GET">
            {{csrf_field()}}
               <div class="input-group input-group-sm" style="float:right;">
                   <input type="text" class="form-control" name="curso" placeholder="Buscar por curso">
                   <i class="input-group-addon fa fa-search" onclick="document.forms[1].submit();" style="cursor:pointer;"></i>
               </div>
           </form>
       </div>

   </div>
</div>

@include('inc.errors')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card card-block">
                <div class="card-title-block">
                    <h3 class="title"> Horário semanal </h3>
                    <section id="grafico">
                        <div id="placeholder" style="width:35rem;height:25rem;">
    
    
                        </div>
                        <div id="legendContainer"></div>    
                    
                    </section>
                    
                   
                </div>
                   
                


            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card card-block">
                <div class="title">Distribuição da carga</div>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</div>
<form name="item" class="form-inline">
    <section class="section">
    <div class="row ">
        <div class="col-xl-12">
            <div class="card sameheight-item">
                <div class="card-block">
                    <!-- Nav tabs -->
                    <div class="row">
                        <div class="col-xs-7 text-xs">
                            {{ $jornadas->links() }}
                        </div>
                        <div class="col-xs-5 text-xs-right">

                            <a href="/jornadas/{{$docente->id}}/cadastrar" class="btn btn-primary btn-sm rounded-s"> Cadastrar nova </a>
                            &nbsp;
                            <div class="action dropdown pull-right "> 
                                <button class="btn btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Com os selecionadas...
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
              
                                    <a class="dropdown-item" href="#" onclick="excluirSelecionados()">
                                        <label><i class="fa fa-times-circle icon text-danger"></i> <span> Excluir</span></label>
                                    </a> 
                                    
                                </div>
                             </div>
                            
                        </div>

                    </div>
                    <table class="table">
                        <thead>
                            <th>
                                <div class="item-col item-col-header fixed item-col-check"> 
                                    <label class="item-check" id="select-all-items">
                                        <input type="checkbox" class="checkbox" name="jornada" onchange="selecionarTodasJornadas(this);"><span></span>
                                    </label>
                                </div>    
                            </th>
                            <th class="tb_id">
                                Id
                            </th>
                            <th class="tb_docente">
                                Docente
                            </th>     
                            <th class="tb_inicio">
                                Datas
                            </th>
                            <th class="tb_dias">
                                Dias
                            </th>
                            <th class="tb_horario">
                                Horários
                            </th>
                            <th class="tb_horario">
                                Local
                            </th>
                            <th class="tb_tipo">
                                Tipo
                            </th>
                            <th class="tb_status">
                                Estado
                            </th>
                            <th class="tb_opt">
                                Opções
                            </th>
                        </thead>
                        <tbody>
                            @foreach($jornadas as $jornada)
                            <tr>
                                <td>
                                    <div class="item-col item-col-header fixed item-col-check"> 
                                        <label class="item-check" id="select-all-items">
                                            <input type="checkbox" class="checkbox" name="jornada" value="{{$jornada->id}}"><span></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="/jornadas/visualizar/{{$jornada->id}}">Jornada<br>#{{$jornada->id}}</a>
                                </td>
                                <td>
                                    {{$jornada->getPessoa()->nome_simples}}
                                </td>
                                
                            
                                <td>
                                    {{$jornada->inicio->format('d/m/Y')}} <br>{{$jornada->termino?$jornada->termino->format('d/m/Y'):'Em andamento'}}
                                </td>
                                <td>
                                    @foreach($jornada->dias_semana as $dia)
                                    {{$dia}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    {{$jornada->hora_inicio}} <br>{{$jornada->hora_termino}}
                                </td>
                                <td>
                                    {{$jornada->getLocal()->sigla}}
                                </td>
                                <td>
                                    {{$jornada->tipo}}
                                </td>
                                <td>
                                    @switch($jornada->status)
                                        @case('ativa')
                                            <span class="badge badge-pill badge-success">
                                            @break
                                        @case('solicitada')
                                            <span class="badge badge-pill badge-primary">
                                            @break
                                        @case('encerrada')
                                            <span class="badge badge-pill badge-secondary">
                                            @break
                                        @case('negada')
                                            <span class="badge badge-pill badge-warning">
                                            @break
                                        @default
                                            <span class="badge badge-pill badge-primary">
                                            @break
                                    @endswitch                                
                                        {{$jornada->status}}</span>                                  
                                </td>

                                <td>
                                    <h5>
                                    <a href="/jornadas/{{$docente->id}}/editar/{{$jornada->id}}" title="Editar jornada"> <i class="fa fa-edit "></i></a>
                                    <a href="#" onclick="excluir({{$jornada->id}})" title="Excluir jornada"><i class="fa fa-times-circle text-danger"></i> </a>
                                    </h5>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>



                    
                    
                           
                </div>
                <!-- /.card-block -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-xl-6 -->
        
        <!-- /.col-xl-6 -->
    </div>

{{ $jornadas->links() }}

</form>
</section>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    const data_doughnut = {
  labels: [
    @if(isset($carga['turma'])) 'Turma', @endif
    @if(isset($carga['HTP'])) 'HTP', @endif
    @if(isset($carga['Projeto'])) 'Projeto', @endif 
    @if(isset($carga['Uso Livre'])) 'Uso Livre', @endif
    @if(isset($carga['Coordenação'])) 'Coordenação', @endif
    @if(isset($carga['Intervalo entre turmas'])) 'Intervalo entre turmas', @endif
    @if(isset($carga['Home Office'])) 'Home Office', @endif
    @if(isset($carga['Translado'])) 'Translado', @endif

    @if(isset($carga['Aula'])) 'Atribuídas', @endif

 

  ],
  datasets: [{
    label: 'My First Dataset',
    data: [
        @if(isset($carga['turma']))'{{($carga['turma']->floatDiffInMinutes(\Carbon\Carbon::Today()))/60}}', @endif
        @if(isset($carga['HTP']))'{{($carga['HTP']->floatDiffInMinutes(\Carbon\Carbon::Today()))/60}}', @endif
        @if(isset($carga['Projeto'])) '{{($carga['Projeto']->floatDiffInMinutes(\Carbon\Carbon::Today()))/60}}', @endif
        @if(isset($carga['Uso Livre'])) '{{($carga['Uso Livre']->floatDiffInMinutes(\Carbon\Carbon::Today()))/60}}', @endif
        @if(isset($carga['Coordenação'])) '{{($carga['Coordenação']->floatDiffInMinutes(\Carbon\Carbon::Today()))/60}}', @endif
        @if(isset($carga['Intervalo entre turmas'])) '{{($carga['Intervalo entre turmas']->floatDiffInMinutes(\Carbon\Carbon::Today()))/60}}', @endif
        @if(isset($carga['Home Office'])) '{{($carga['Home Office']->floatDiffInMinutes(\Carbon\Carbon::Today()))/60}}', @endif
        @if(isset($carga['Aula'])) '{{($carga['Aula']->floatDiffInMinutes(\Carbon\Carbon::Today()))/60}}', @endif
        @if(isset($carga['Translado'])) '{{($carga['Translado']->floatDiffInMinutes(\Carbon\Carbon::Today()))/60}}', @endif

  ],
        
    backgroundColor: [
        @if(isset($carga['turma'])) 'rgb(135, 192, 65)', @endif
        @if(isset($carga['HTP'])) 'rgb(255, 205, 86)', @endif
        @if(isset($carga['Projeto'])) 'rgb(54, 162, 235)', @endif      
        @if(isset($carga['Uso Livre'])) 'rgb(146, 84, 145)', @endif
        @if(isset($carga['Coordenação'])) 'rgb(78, 89, 152)', @endif
        @if(isset($carga['Intervalo entre turmas'])) 'rgb(95, 168, 208)', @endif
        @if(isset($carga['Home Office'])) 'rgb(60, 106, 131)', @endif
        @if(isset($carga['Translado'])) 'rgb(192, 192, 192)', @endif 
        @if(isset($carga['Aula'])) 'rgb(220, 63, 48)', @endif
     
    ],
    hoverOffset: 4
  }]
};

  const config_graph = {
    type: 'doughnut',
    data: data_doughnut,
    options: {
        
    }
  };

  const myChart = new Chart(
    document.getElementById('myChart'),
    config_graph
  );

 //************************************************ fim grafico doughnuts


//----------------------- Gráfio de horários https://www.flotcharts.org/


function gt(time) {
        let hora = time.substring(0,2)-3;
        let minuto = time.substring(5,3);
        let tempo = new Date(1970,0,1,hora,minuto,0).getTime();
        //console.log(time+'->'+tempo);
       
        
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
    

    var data = [ /*
        { label: "Aula",
          link:"#",
          data: [ [1,gt('10:00'),gt('12:00'),"teste"],[1,gt('13:00'),gt('15:00'),"teste2"]] ,
         
        },*/
     
        @if(isset($carga['turma']))
        {    

            label: "Aula ",
            color: '#87c041',
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if(substr($horax[3],0,5)=='Turma')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        @endif
        @if(isset($carga['HTP']))

        {            
            label: "HTP ",
            color: '#ffc234',
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='HTP')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        @endif
        @if(isset($carga['Uso Livre']))

        {            
            label: "Uso Livre ",
            color: '#925491',
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='Uso Livre')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        @endif
        @if(isset($carga['Home Office']))

        {            
            label: "Home Office ",
            color: '#3c6a83',
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='Home Office')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        @endif
        @if(isset($carga['Translado']))
        {            
            label: "Translado ",
            color: "#c0c0c0",
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='Translado')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        @endif
        @if(isset($carga['Aula']))
        {            
            label: "Atribuídas ",
            color: "#f11400",
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='Aula')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        @endif
        @if(isset($carga['Projeto']))
        {            
            label: "Projeto ",
            color:"#36A2EB",
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='Projeto')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        @endif
        @if(isset($carga['Coordenação']))
        {            
            label: "Coordenação ",
            color: "#4e5998",
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='Coordenação')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        @endif
        @if(isset($carga['Intervalo entre turmas']))
     

        {            
            label: "Intervalo ",
            color:"#5fa8d0",
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='Intervalo entre turmas')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        @endif
       
    
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
            //ticks: 20,
            //min: minimo,
            //max: maximo
            //tickLength:0,
        },
        xaxis :{
            show : true,
            position: "top",
            tickLength:0,
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
            container:$("#legendContainer"),    
            noColumns: 4,
           
        },
        tooltip: true,
        tooltipOpts: {
            //content: "início: %y %s"
           content: function(label, x, y, flotItem){
                //console.log(flotItem.seriesIndex);
                return '<strong>'+data[flotItem.seriesIndex].data[flotItem.dataIndex][3]+'</strong>'
                +" <br> %y às "+ msToTime(data[flotItem.seriesIndex].data[flotItem.dataIndex][2])
                + '<br>Local: '+data[flotItem.seriesIndex].data[flotItem.dataIndex][4];
            },
            //content: "Orders <b>%y</b> for <span>"+y+"</span>",
        }
    };
  
    var plot = $("#placeholder").plot(data, options).data("plot");

    $("#placeholder").bind("plotclick", function (event, pos, flotItem) {
        if (flotItem) { 
            //window.location = links[item.dataIndex];
            //window.open(links[dataIndex, '_blank']);
            if(data[flotItem.seriesIndex].data[flotItem.dataIndex][3].substring(0,5) == 'Turma')
                window.location = "/docentes/frequencia/nova-aula/"+data[flotItem.seriesIndex].data[flotItem.dataIndex][3].substring(6);
            else
                console.log(data[flotItem.seriesIndex].data[flotItem.dataIndex][3]);
           // here you can write location = "http://your-doamin.com";
        }
    });

    $("#placeholder").bind("plothover", function(event, pos, item) {
        if(item && data[item.seriesIndex].data[item.dataIndex][3].substring(0,5) == 'Turma' )
            $("#placeholder").css("cursor","pointer","important");
        else
            $("#placeholder").css("cursor","default", "important");
    });

 //************************************************** fim grafico horarios

 function carregarSalas(local){
	var salas;
	$("#select_sala").html('<option>Sem salas cadastradas</option>');
	$.get("{{asset('services/salas-api/')}}"+"/"+local)
 				.done(function(data) 
 				{
 					$.each(data, function(key, val){
						console.log(val.nome);
 						salas+='<option value="'+val.id+'">'+val.nome+'</option>';
 					});
 					//console.log(namelist);
 					$("#select_sala").html(salas);
				 });
				 
}


function selecionarTodasJornadas(campo){
	$("input:checkbox[name=jornada]").each(
		function(){
			$(this).prop("checked", campo.checked)
		}
	);
}

function excluirSelecionados(){
    itens ='';
    if(confirm("Deseja mesmo apagar os itens selecionados?")){
        $("input:checkbox[name=jornada]:checked").each(function () {
            itens+=this.value+',';
        });
        excluirJornada(itens);
    }
}

function excluir(id){
    if(confirm("Deseja mesmo excluir a jornada "+id+"?")){
        excluirJornada(id);
    }
}

function excluirJornada(id){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/jornadas/{{$docente->id}}/excluir",
        data: { id }
        
    })
	.done(function(msg){
		location.reload(true);
	})
    .fail(function(msg){
        alert('Falha ao excluir ficha: '+msg.statusText);
    });
}

function encerrarJornada(){
    encerramento = $("#data_encerramento").val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/jornada/encerrar",
        data: { jornada,encerramento }
        
    })
	.done(function(msg){
		location.reload(true);
	})
    .fail(function(msg){
        alert('Falha ao encerrar jornada: '+msg.statusText);
    });
}






</script>



@endsection
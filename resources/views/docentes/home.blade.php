@extends('layout.app')
@section('pagina')
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('docentes.modal.add_jornada')
@include('docentes.modal.exclusao_jornada')
<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Departamento de Docência da FESC</h3>
            <p class="title-description"><strong>Prof.:</strong> {{$docente->nome}} | <strong>{{$carga_ativa->floatDiffInHours(\Carbon\Carbon::Today())}}h/{{isset($carga->valor)?$carga->valor:'00'}}h</strong>  </p>
        </div>
    </div>
</div>
@include('inc.errors')
<section class="section">

    <div class="row">
        <div class="col-md-6">
            <div class="card">
            <div class="card card-block">
                <div class="card-title-block">
                    <h3 class="title"> Horário semanal </h3>
                </div>
                <section>
                <table class="table table-striped table-bordered table-sm">
                    
                    <thead>
                        <tr>
                        <th>Hora</th>
                        <th>Segunda</th>
                        <th>Terça</th>
                        <th>Quarta</th>
                        <th>Quinta</th>
                        <th>Sexta</th>
                        <th>Sábado</th>
                       </tr>
                    </thead>
                    <tbody>
                        @for($i=6;$i<24;$i++)
                            @if(isset($horarios['seg'][str_pad($i, 2, 0, STR_PAD_LEFT)]) || isset($horarios['ter'][str_pad($i, 2, 0, STR_PAD_LEFT)]) || isset($horarios['qua'][str_pad($i, 2, 0, STR_PAD_LEFT)]) || isset($horarios['qui'][str_pad($i, 2, 0, STR_PAD_LEFT)]) || isset($horarios['sex'][str_pad($i, 2, 0, STR_PAD_LEFT)]) || isset($horarios['sab'][str_pad($i, 2, 0, STR_PAD_LEFT)]))
                            <tr>
                                <th title="Atividades com início entre {{str_pad($i, 2, 0, STR_PAD_LEFT)}}:00 às {{str_pad($i, 2, 0, STR_PAD_LEFT)}}:59"><small>{{str_pad($i, 2, 0, STR_PAD_LEFT)}}h</small> </th>
                                @foreach($dias as $dia)
                                    <td>
                                       @if(isset($horarios[$dia][str_pad($i, 2, 0, STR_PAD_LEFT)])) 
                                            @foreach($horarios[$dia][str_pad($i, 2, 0, STR_PAD_LEFT)] as $horario) 

                                                @if(!isset($horario->tipo))
                                                
                                                &nbsp;&nbsp;<small><a  title="{{$horario->hora_inicio}} -> {{$horario->hora_termino}} | {{$horario->getNomeCurso()}} | {{$horario->local->sigla}} | {{$horario->nome_sala}}" href="/docentes/frequencia/nova-aula/{{$horario->id}}">{{$horario->id}}</a></small>
                                                @elseif(isset($horario->tipo))
                                                
                                                &nbsp;&nbsp;<small><span  title="{{$horario->hora_inicio}} -> {{$horario->hora_termino}} - {{$horario->getLocal()->sigla}}"> {{$horario->tipo}}  </span></small>

                                                @else
                                                
                                                
                                                @endif
                                                
                                            @endforeach
                                        @endif  
                                    </td>                        
 
                                @endforeach
                            </tr>

                            @endif
                        
                        @endfor
                        
                          
                        
                    </tbody>

                </table>
                </section>

                <section>
                    <div id="placeholder" style="width:29rem;height:25rem">


                    </div>
                    <div id="legendContainer"></div>    
                
                </section>


            </div>
            </div>

        </div>
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Jornadas de trabalho</p>
                    </div>
                </div>
                <div class="card-block">
                    <table class="table table-sm table-striped">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Dia(s)</th>
                            <th>Início</th>
                            <th>Termino</th>
                            <th>Tipo</th>
                            <th>Local</th>
                            <th>&nbsp;</th>
                        </tr>
                        
                        @foreach($jornadas as $jornada)
                        <tr>
                            <td><small>
                                @switch($jornada->status)
                                    @case('analisando')
                                        <i class="fa fa-clock-o"></i>
                                        @break
                                    @case('ativa')
                                        <i class="fa fa-check text-success"></i>
                                        @break
                                    @default
                                        
                                @endswitch</small></td>
                            <td><small>{{implode(',',$jornada->dias_semana)}}</small></td>
                            <td><small>{{$jornada->hora_inicio}}</small></td>
                            <td><small>{{$jornada->hora_termino}}</small></td>
                            <td><small>{{$jornada->tipo}}</small></td>
                            <td><small>{{$jornada->getLocal()->sigla}}</small></td>
                            <td>
                                @if(in_array('17', Auth::user()->recursos))
                                <small><a href="#" data-toggle="modal" data-target="#modal-exclusao-jornada" title="Excluir Jornada" onclick="atribJornada('{{$jornada->id}}')">
                                            <i class="fa fa-times text-danger"></i>
                                        </a>
                                </small>
                                @else
                                &nbsp;
                                @endif
                            </td>

                        </tr>
                    
                        @endforeach
                    
                    </table>
                   
                    <p>&nbsp;</p>
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="#" data-toggle="modal" data-target="#modal-add-jornada" class="btn btn-sm btn-primary">Adicionar</a>
                            
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Listas de Frequência &nbsp;&nbsp;</p>

                        <div class="action dropdown pull-right" >

                            <button class="btn  rounded-s btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Semestre de início
                            </button>
                            <div class="dropdown-menu "  aria-labelledby="dropdownMenu5"> 
                                @foreach($semestres as $semestre)
                                @if(isset($semestre_selecionado) && array_search($semestre->semestre.$semestre->ano,[$semestre_selecionado]) !== false)
                                <a class="dropdown-item" href="/docentes/{{$docente->id}}/{{$semestre->semestre.$semestre->ano}}" style="text-decoration: none;">
                                    <i class="fa fa-check-circle-o icon"></i> {{$semestre->semestre>0?$semestre->semestre.'º Sem. '.$semestre->ano:' '.$semestre->ano}}
                                </a> 
                                @else
                                <a class="dropdown-item" href="/docentes/{{$docente->id}}/{{$semestre->semestre.$semestre->ano}}" style="text-decoration: none;">
                                    <i class="fa fa-circle-o icon"></i> {{$semestre->semestre>0?$semestre->semestre.'º Sem. '.$semestre->ano:' '.$semestre->ano}}
                                </a> 
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-block">
                    
                    <table class="table table-striped table-condensed">
                    
                        <thead class="row">
                            <tr>
                            <th class="col-sm-1 col-xs-1"><small>Cód.</small></th>
                            <th class="col-sm-2 col-xs-2"><small>Dia(s)</small></th>
                            <th class="col-sm-2 col-xs-2"><small>Inicio</small></th>
                            <th class="col-sm-5 col-xs-5"><small>Curso/Disciplina</small></th>
                            <th class="col-sm-2 col-xs-2"><small>Opções</small></th>
                        </tr>
                        </thead>
                    
                        <tbody>
                            @foreach($turmas as $turma)
                            <tr class="row">
                                <td class="col-sm-1 col-xs-1" title="Status: {{$turma->status}}" ><small>{{$turma->id}}</small></td>
                            <td class="col-sm-2 col-xs-2"title="Inicio: {{$turma->data_inicio}}"><small>{{implode(', ',$turma->dias_semana)}}<br>{{$turma->data_inicio}}</small></td>
                                <td class="col-sm-2 col-xs-2"><small>{{$turma->hora_inicio}}h<br>{{$turma->hora_termino}}h</small></td>
                                <td class="col-sm-5 col-xs-5">
                                    @if(substr($turma->data_inicio,6,4)<2020)
                                    
                                    
                                    <small>
                                    <a href="/chamada/{{$turma->id}}/0/url/ativos"  title="Chamada de alunos ativos (modelo planilha)">
                                        
                                        {{$turma->getNomeCurso()}}

                                    </a>
                                    
                                    </small>
                                   
                                    @else
                                    <small>
                                    <a href="/docentes/frequencia/nova-aula/{{$turma->id}}" title="Chamada OnLine.">
                                        
                                        {{$turma->getNomeCurso()}}

                                    </a>
                                    
                                    </small>
                                    @endif
                                </td>
                            
                                <td class="col-sm-2 col-xs-2">
                                    @if(substr($turma->data_inicio,6,4)<2020)
                                        <a href="/chamada/{{$turma->id}}/0/url/todos"  title="Chamada modelo planilha, com alunos desistentes/transferidos">       
                                            <i class=" fa fa-indent "></i></a>
                                        &nbsp;
                                        @if(isset($turma->disciplina->id))
                                            <a href="/plano/{{$turma->professor->id}}/1/{{$turma->disciplina->id}}" title="Plano de ensino" >
                                                <i class=" fa fa-clipboard "></i>
                                            </a>
                                        @else
                                            <a href="/plano/{{$turma->professor->id}}/0/{{$turma->curso->id}}" title="Plano de ensino" >
                                                <i class=" fa fa-clipboard "></i>
                                            </a>
                                        @endif


                                    @else
                                        <a href="/docentes/frequencia/listar/{{$turma->id}}"  title="Relatório de frequência.">
                                            <i class=" fa fa-indent "></i></a>
                                        &nbsp;
                                        <a href="/docentes/frequencia/preencher/{{$turma->id}}"  title="Chamada completa">
                                            <i class=" fa fa-list "></i></a>
                                        &nbsp;
                                        <a href="/lista/{{$turma->id}}" title="Impressão de lista em branco" >
                                            <i class=" fa fa-print "></i></a>&nbsp;
                                    @endif


                                    
                                    

                                
                                   
                                    

                                

                                    
                                </td>
                            </tr>
                            @endforeach
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
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/download/{{str_replace('/','-.-', 'documentos/oficios/calendario_2020.pdf')}}" >Calendário</a>
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
@section('scripts')
<script>
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

let jornada = 0;
function atribJornada(id){
   jornada = id;
}

function excluirJornada(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/jornada/excluir",
        data: { jornada }
        
    })
	.done(function(msg){
		location.reload(true);
	})
    .fail(function(msg){
        alert('Falha ao excluir jornada: '+msg.statusText);
    });
}



//----------------------- Gráfio de horários


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
     
      
        {            
            label: "Aula",
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if(substr($horax[3],0,5)=='Turma')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },

        {            
            label: "HTP",
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='HTP')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        {            
            label: "Translado",
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='Translado')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        {            
            label: "Disponível",
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='Aula')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        {            
            label: "Projeto",
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='Projeto')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
        {            
            label: "Coordenação",
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='Coordenação')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
        },
     

        {            
            label: "Intervalo",
            data: [ 
              @foreach($ghoras_turmas as $horax)
                @if($horax[3]=='Intervalo entre turmas')
                    [{{$horax[0]}},gt('{{$horax[1]}}'),gt('{{$horax[2]}}'),'{{$horax[3]}}','{{$horax[4]}}'],
                @endif
              @endforeach
            ] ,
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
 

    //console.log(data[0].data[0][2]);
</script>
@endsection
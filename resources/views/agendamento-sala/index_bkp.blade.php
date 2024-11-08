@extends('layout.app')
@section('titulo')Salas - Programação de horário. @endsection
@section('pagina')
<style>
    
@media (min-width: 767px){
    .sala{

        width: 150px;
        color:red;
        overflow: hidden;
       
        border: 1px solid #D9E2E8;
    }
    .hora{
       
	   overflow: hidden;
        text-align: center;
       
        
        border: 1px solid #D9E2E8;
       
            
    }
   
        
        
    }
@media (max-width: 766px){
    .pessoa{
        font-size: 20px;
    }
    .hora{
        color:red;
        font-size: 0.7em;
    }
}
.evento{
    background-color: aquamarine;

    overflow: hidden;
    color:green;
    border: 1px solid gray;
    
}
.aula-pid{
    background-color: blue;
}
.aula-unit{
    background-color: red;
}
.aula-uati{
    background-color: orange;
}
.aula-ce{
    background-color: green;
}
    
</style>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="#">Bolsas</a></li>
 
</ol>

<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">

                <h3 class="title"> {{date('d/m/Y')}}</h3>

                <p class="title-description"> Análise e visualização de bolsas </p>
            </div>
        </div>
    </div>


    <div class="items-search">
        <form class="form-inline" method="GET>
        {{csrf_field()}}
            <div class="input-group"> 
                <input type="text" class="form-control boxed rounded-s" name="codigo" placeholder="Procurar p/ código.">
                <span class="input-group-btn">
                    <button class="btn btn-secondary rounded-s" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>
</div>
@include('inc.errors')
<form name="item" class="form-inline">
    <section class="section">
    <div class="row ">
        <div class="col-xl-12">
            <div class="card sameheight-item">
                <div class="card-block">
                    <!-- Nav tabs -->
                   
                    <!-- Tabela com as salas -->
                    <div class="row">
                        <table width="100%" style="overflow:hidden; table-layout:fixed;" >
                            <thead>
                                <th class="sala">Sala</th>
                                @for($i=6;$i<24;$i++)
                                <th colspan="60" class="hora" >{{str_pad($i,2,'0',STR_PAD_LEFT)}}h</th>
                                @endfor
                            </thead>
                            <tbody>
                                @for($sala=1;$sala<31;$sala++)
                                <tr>
                                    <td class="sala text-primary"> Sala {{$sala}}</td>
                                    @for($i=6;$i<24;$i++)
                                        @php 
                                        
                                        $eventos_hora = $eventos->where('sala',$sala)->where('hinicio',$i)->sortBy('inicio'); 
                                        echo '<!-- eventos na hora '.$i.': '.count($eventos_hora).' -->';
                                        
                                        @endphp
                                        @if(count($eventos_hora)>0)

                                            @if($eventos_hora->first()->inicio->format('i') > 0 && $id ==0)
                                                <td colspan="{{$eventos_hora->first()->inicio->format('i')}}" class="hora">&nbsp;</td>
                                            @endif

                                            @foreach($eventos_hora as $id => $evento)
                                            
                                                @php
                                                    // adiona espaço entre eventos que começam na mesma hora        
                                                    if($evento->inicio->format('i') != $eventos_hora->first()->inicio->format('i')){
                                                        if($evento->inicio->diff($eventos_hora{$id-1}->termino)->format('%i') > 0 )
                                                        
                                                        echo '<td colspan="'.$evento->inicio->diff($eventos_hora{$id-1}->termino)->format('%i').'" class="hora">&nbsp;</td>';
                                                        
                                                    }
                                                       
                                                @endphp
                                           
                                                    

                                                    <td colspan="{{$evento->tempo->format('%h')*60+$evento->tempo->format('%i')}}" 
                                                        class="evento" 
                                                        title="{{$evento->inicio->format('H:i').' as '.$evento->termino->format('H:i').' - '.$evento->nome}}">
                                                        

                                                        
                                                    </td>
                                                    
                                                    
                                                    
                                            
                                            @endforeach
                                            @php 
                                                if($eventos_hora->last()->termino->format('i') >0)
                                                    $i = $eventos_hora->last()->termino->format('H');
                                                else 
                                                    $i = $eventos_hora->last()->termino->format('H')+1;
                                            
                                            @endphp
                                            @if($eventos_hora->last()->termino->format('i')>0)
                                                <td colspan="{{60-$evento->termino->format('i')}}" class="hora">&nbsp;</td>
                                            @endif

                                        @else
                                        <td colspan ="60" class="hora">&nbsp;</td>
                                        @endif
                                        
                                        
                                    @endfor
                                </tr>
                                @endfor
                            </tbody>
                        </table>


                    </div>
                </div>
                <!-- /.card-block -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-xl-6 -->
        
        <!-- /.col-xl-6 -->
    </div>



</form>
</section>
@endsection
@section('scripts')
<script>
function alterarStatusIndividual(status,id){
     
        if(id=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente alterar as bolsas selecionadas?'))
            $(location).attr('href','./status/'+status+'/'+id);

    
}

function alterarStatus(status){
     var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados==''){
            alert('Nenhum item selecionado');
            return false;
        }
        if(status ==  'aprovar' || status ==  'negar' )
            $(location).attr('href','./analisar/'+selecionados);
        else
            if(confirm('Deseja realmente alterar as bolsas selecionadas?'))
                $(location).attr('href','./status/'+status+'/'+selecionados);

        return false;

    
}


</script>



@endsection
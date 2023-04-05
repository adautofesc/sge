@extends('layout.app')
@section('titulo')Gerenciador de eventos @endsection
@section('pagina')
<link rel="stylesheet" href="{{asset('/css/calendario.evento.css')}}" >
<style>
@media (min-width: 767px){
    .codigo{
        max-width: 50px; }
    .pessoa{
        max-width: 300px; }
    .pedidoem{
        max-width: 80px; }
    }
@media (max-width: 766px){
    .pessoa{
        font-size: 20px;
    }
}

</style>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Home</a></li>
</ol>

<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">

                <h3 class="title"> Gerenciador de eventos</h3>
                <p class="title-description"> Auxilia no gerenciamento de salas </p>
            </div>
        </div>
    </div>


    <!--<div class="items-search">
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
    </div>-->
    <div class="items-search col-md-3">
        <div class="header-block header-block-search hidden-sm-down">
           <form role="search">
            {{csrf_field()}}
               <div class="input-group input-group-sm" style="float:right;">
                   <input type="text" class="form-control" name="codigo" placeholder="Buscar por codigo">
                   <i class="input-group-addon fa fa-search" onclick="document.forms[0].submit();" style="cursor:pointer;"></i>
               </div>
           </form>
       </div>

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
                    <div class="panel panel-default">
                        <div class="panel-heading"></div> 
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row" first-day="1">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="locale">Select language:</label>
                                                <select id="locale" class="form-control language-select">
                                                    <option value="ar">AR</option> 
                                                    <option value="en">EN</option> 
                                                    <option value="de">DE</option>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-sm-4 header-center">
                                            <div class="btn-group">
                                                <a class="btn btn-outline btn-primary btn-sm">⇐ Anterior</a>
                                                <button class="btn btn-outline btn-default btn-sm today-button ">⇓ Hoje</button> 
                                                <a class="btn btn-outline btn-primary btn-sm">Próximo ⇒</a>
                                            </div>
                                        </div> 
                                        <div class="col-sm-4">
                                            <div class="title">March 2023</div>
                                        </div>
                                    </div> 
                                    <div class="full-calendar-body">
                                        <div class="weeks">
                                            <strong class="week">Dom</strong>
                                            <strong class="week">Seg</strong>
                                            <strong class="week">Ter</strong>
                                            <strong class="week">Qua</strong>
                                            <strong class="week">Qui</strong>
                                            <strong class="week">Sex</strong>
                                            <strong class="week">Sab</strong>
                                        </div> 
                                        <div class="dates">
                                            @foreach($mes as $dia)
                                                @if($dia->weekday == '0')
                                                    <div class="week-row">
                                                        <div class="day-cell weekend {{$dia->class}}">
                                                @else
                                                    
                                                    <div class="day-cell {{$dia->class}}">
                                                   

                                                @endif
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div style="display: none;">
                                                                        <span class="label label-success"> Add Event</span>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-sm-6">
                                                                    <p class="day-number" title="{{$dia->title}}">{{$dia->number}}</p>
                                                                </div>
                                                            </div> 
                                                            <div class="event-box">

                                                                <!--
                                                                <div class="panel no-margin panel-danger ">
                                                                    <div class="panel-heading event-title">Event 1</div>
                                                                </div>-->
                                                               

                                                            </div>
                                                        </div><!-- end day -->
                                                @if($dia->weekday == '6')
                                                    </div>
                                                @endif
                                            @endforeach

                                            


                                            
                                            
                                        
                                        </div><!-- callendar dates -->
                                    </div><!-- callendar full-c.body -->
                                </div><!-- callendar col -->
                            </div><!-- callendar row -->
                        </div><!-- callendar panel-body -->
                    </div><!-- callendar panel -->
                                                
                    <div class="tab-content tabs-bordered">

                        <!-- Tab panes ******************************************************************************** -->
                        
                                <section class="example">
                                    <div class="table-flip-scroll">

                                        <ul class="item-list striped">
                                            <li class="item item-list-header hidden-sm-down">
                                                <div class="item-row">
                                                    <div class="item-col fixed item-col-check">
                                                        <label class="item-check">
                                                        <input type="checkbox" class="checkbox" onchange="selectAllItens(this);">
                                                        <span></span>
                                                        </label> 
                                                    </div>
                                                    <div class="item-col item-col-header codigo">
                                                        <div> <span>Id<span> </div>
                                                    </div>
                    
                                                    <div class="item-col item-col-title item-col-header pessoa">
                                                        <div> <span>Pessoa</span> </div>
                                                    </div>
                                                    <div class="item-col item-col-header pedidoem">
                                                        <div> <span>Data</span> </div>
                                                    </div>

                                                    <div class="item-col item-col-header ">
                                                        <div class="action dropdown pull-right "> 
                                                            <div id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;">
                                                                <i class="fa fa-filter"></i> <span >Tipo</span> 
                                                            </div>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2" id="filtro2" style="padding-left:10px;"> 
                                                                
                                                                    <label>
                                                                        <input class="checkbox" type="checkbox" onclick="parado();">
                                                                        <span>Option one</span>
                                                                    </label>
                                                                    <br>
                                                                    <label>
                                                                        <input class="checkbox" type="checkbox" onclick="parado();">
                                                                        <span>Option two</span>
                                                                    </label>
                                                                    <br>
                                                                    <button class="btn btn-sm btn-primary rounded-s">Aplicar</button>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item-col item-col-header ">
                                                        <div> <span>Status</span> </div>
                                                    </div>

                                                    <div class="item-col item-col-header fixed item-col-actions-dropdown">&nbsp; </div>
                                                </div>
                                            </li>
                                            @foreach($eventos as $evento)


                                                                                  
                                            <li class="item">
                                                <div class="item-row">


                                                    <div class="item-col fixed item-col-check" > 
                                                        <label class="item-check" >
                                                        <input type="checkbox" class="checkbox" name="turma" value="{{$evento->id}}">
                                                        <span></span>
                                                        </label>
                                                    </div>


                                                    <div class="item-col item-col codigo">
                                                        <div class="item-heading">id</div>
                                                        <div > </div>
                                                    </div>
                                        
                                                    
                                                    <div class="item-col item-col-title pessoa">
                                                        <div class="item-heading">Pessoa</div>
                                                        <div></div> 
                                                    </div>


                                                    <div class="item-col item-col pedidoem" >
                                                        <div class="item-heading">Data</div>
                                                        <div> 
                                                            <small>data</small>
                                                        </div>
                                                    </div>



                                                    <div class="item-col item-col">
                                                        <div class="item-heading">Tipo</div>
                                                     
                                                        <div><small></small></div>
                                                     
                                                    </div>
                                                     
                                                   
                                                    <div class="item-col item-col">
                                                        <div class="item-heading">Status</div>
                                                        <div> @if($evento->status == 'analisando')
                                                            <span class="badge badge-pill badge-warning">
                                                            @elseif($evento->status == 'ativa')
                                                            <span class="badge badge-pill badge-success">
                                                            @elseif($evento->status == 'indeferida')
                                                            <span class="badge badge-pill badge-danger">
                                                            @elseif($evento->status == 'cancelada')
                                                            <span class="badge badge-pill badge-danger">
                                                            @elseif($evento->status == 'expirada')
                                                            <span class="badge badge-pill badge-secondary">
                                                            @else
                                                            <span>
                                                            @endif
                                                            {{$evento->status}}</span>
                                                        </div>
                                                    </div>


                                                    <div class="item-col fixed item-col-actions-dropdown">
                                                        <div class="item-actions-dropdown">
                                                            <a class="item-actions-toggle-btn"> 
                                                                <span class="inactive">
                                                                    <i class="fa fa-cog"></i>
                                                                </span> 
                                                                <span class="active">
                                                                    <i class="fa fa-chevron-circle-right"></i>
                                                                </span>
                                                            </a>
                                                            <div class="item-actions-block">
                                                                <ul class="item-actions-list">
                                                                    <li>
                                                                     <a class="edit" title="Aprovar" href="#" onclick="alterarStatusIndividual('aprovar','{{$evento->id}}')"> <i class="fa fa-check-circle-o "></i> </a>
                                                                    </li>
                                                                    <li>
                                                                     <a class="remove" title="Negar" href="#" onclick="alterarStatusIndividual('negar','{{$evento->id}}')"> <i class="fa fa-ban "></i> </a>
                                                                    </li>
                                                                    <li>
                                                                     <a class="edit" title="Colocar para análise" href="#" onclick="alterarStatusIndividual('analisando','{{$evento->id}}')"> <i class="fa fa-clock-o "></i> </a>
                                                                    </li>
                                                                    <li>
                                                                     <a class="remove" title="Cancelar" href="#" onclick="alterarStatusIndividual('cancelar','{{$evento->id}}')"> <i class="fa fa-minus-circle "></i> </a>
                                                                    </li>
                                                                    
                                                                
                                                                </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                           
                                            @endforeach
                                        </ul>
                                    </div>
                                </section>
                            
                    </div>
                </div>
                <!-- /.card-block -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-xl-6 -->
        
        <!-- /.col-xl-6 -->
    </div>

links

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

function parado(){
    console.log('parei');
    //$('#filtro2').css('display','inline');
    $('#dropdownMenu2').trigger('click');
}


</script>



@endsection
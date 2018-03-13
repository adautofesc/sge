 @extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Todas as turmas ativas</h3>
</div>
@include('inc.errors')

<form name="item" class="form-inline">
	<section class="section">
    <div class="row ">
        <div class="col-xl-12">
            <div class="card sameheight-item">
                <div class="card-block">
                    <!-- Nav tabs -->
                    <div class="row">
                        <div class="col-xs-6 text-xs">
                            <div class="title-block ">
                                <a class="btn btn-primary" href="{{route('turma.cadastrar')}}">Cadastrar</a>
                            </div>
                        </div>
                    </div>
                    
                    <ul class="nav nav-tabs nav-tabs-bordered ">
                        <li class="nav-item"> <a href="" class="nav-link active" data-target="#todos" data-toggle="tab" aria-controls="todos" role="tab">Todos</a> </li>
                         @foreach($programas as $programa)
                            <li class="nav-item">
                                <a href="" class="nav-link" data-target="#{{$programa->sigla}}" aria-controls="{{$programa->sigla}}" data-toggle="tab" role="tab">{{$programa->sigla}}</a> 
                            </li>
                         @endforeach
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabs-bordered">
                        <!-- Tab panes ******************************************************************************** -->
                        <div class="tab-pane fade in active" id="todos">
                        	<h4>Todos os programas</h4>
                            <section class="example">
                                <div class="table-flip-scroll">
                                    <ul class="item-list striped">
                                        <li class="item item-list-header hidden-sm-down">
                                            <div class="item-row">
                                                <div class="item-col fixed item-col-check">
                                                    <label class="item-check" id="select-all-items">
                                                    <input type="checkbox" class="checkbox">
                                                    <span></span>
                                                    </label> 
                                                </div>
                                                
                                                <div class="item-col item-col-header item-col-title">
                                                    <div> <span>Curso</span> </div>
                                                </div>
                                                <div class="item-col item-col-header item-col-sales">
                                                    <div> <span>Professor/Local</span> </div>
                                                </div>

                                                <div class="item-col item-col-header item-col-sales">
                                                    <div> <span>Vagas/Ocup.</span> </div>
                                                </div>
                                                <div class="item-col item-col-header item-col-sales">
                                                    <div> <span>Valor</span> </div>
                                                </div>

                                                <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                                            </div>
                                        </li>
                                        @foreach($turmas->all() as $turma)
                                        <li class="item">
                                            <div class="item-row ">
                                                <div class="item-col fixed item-col-check"> 

                                                    <label class="item-check" id="select-all-items">
                                                    <input type="checkbox" class="checkbox" name="turma" value="{{$turma->id}}">
                                                    <span></span>
                                                    </label>
                                                </div>
                                                
                                                <div class="item-col fixed pull-left item-col-title">
                                                    <div class="item-heading">Curso/atividade</div>
                                                    <div class="">
                                                        
                                                             <div href="#" style="margin-bottom:5px;" class="color-primary">Turma {{$turma->id}} - <i class="fa fa-{{$turma->icone_status}}" title=""></i><small> {{$turma->texto_status}}</small></div> 

                                                       
                                                        @if(isset($turma->disciplina))
                                                        <a href="{{asset('lista').'/'.$turma->id}}" target="_blank"class="">
                                                            <h4 class="item-title"> {{$turma->disciplina->nome}}</h4>       
                                                            <small>{{$turma->curso->nome}}</small>
                                                        </a>
                                                       @else
                                                        <a href="{{asset('lista').'/'.$turma->id}}" target="_blank" class="">
                                                            <h4 class="item-title"> {{$turma->curso->nome}}</h4>           
                                                        </a>
                                                        @endif

                                                         {{implode(', ',$turma->dias_semana)}} - {{$turma->hora_inicio}} ás {{$turma->hora_termino}}
                                                    </div>
                                                </div>
                                                <div  class="item-col item-col-sales">
                                                    <div class="item-heading">Professor(a)/local</div>
                                                    <div> {{$turma->professor->nome_simples}}
                                                        <div>{{$turma->local->sigla}}</div>
                                                    </div>
                                                </div>
                                                <div class="item-col item-col-sales">
                                                    <div class="item-heading">Vagas</div>
                                                    <div>{{$turma->vagas}}/{{$turma->matriculados}}</div>
                                                </div>
                                                 
                                               
                                                <div class="item-col item-col-sales">
                                                    <div class="item-heading">Valor</div>
                                                    <div>R$ {{$turma->valor}} </div>
                                                </div>

                                                <div class="item-col fixed item-col-actions-dropdown">
                                                    <div class="item-actions-dropdown">
                                                        <a class="item-actions-toggle-btn"> <span class="inactive">
                                                <i class="fa fa-cog"></i>
                                            </span> <span class="active">
                                            <i class="fa fa-chevron-circle-right"></i>
                                            </span> </a>
                                                        <div class="item-actions-block">
                                                            <ul class="item-actions-list">                                     
                                                                <li>
                                                                     <a class="remove" title="Cancelar" href="#" onclick=cancelar({{$turma->id}})> <i class="fa fa-ban "></i> </a>
                                                                </li>
                                                                <li>
                                                                     <a class="remove" href="#" title="Apagar" onclick=apagar({{$turma->id}})> <i class="fa fa-trash-o "></i> </a>
                                                                </li>
                                                                <li>
                                                                    <a class="edit" title="Editar" href="#" onclick="editar({{$turma->id}})"> <i class="fa fa-pencil"></i> </a>
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
                        @foreach($programas as $programa)
                            <!-- tab {{$programa->sigla}} ********************************************************-->
                            <div class="tab-pane fade" id="{{$programa->sigla}}">
                                <h4>{{$programa->nome}}</h4>
                                <section class="example">
                                    <div class="table-flip-scroll">

                                        <ul class="item-list striped">
                                            <li class="item item-list-header hidden-sm-down">
                                                <div class="item-row">
                                                    <div class="item-col fixed item-col-check">
                                                        <label class="item-check" >
                                                        <input type="checkbox" class="checkbox" onchange="selectAllItens(this);">
                                                        <span></span>
                                                        </label> 
                                                    </div>
                                                    
                                                    <div class="item-col item-col-header item-col-title">
                                                        <div> <span>Curso</span> </div>
                                                    </div>
                                                    <div class="item-col item-col-header item-col-sales">
                                                        <div> <span>Professor/Unidade</span> </div>
                                                    </div>

                                                    <div class="item-col item-col-header item-col-sales">
                                                        <div> <span>Vagas/Ocup.</span> </div>
                                                    </div>
                                                    <div class="item-col item-col-header item-col-sales">
                                                        <div> <span>Valor</span> </div>
                                                    </div>

                                                    <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                                                </div>
                                            </li>
                                            @foreach($turmas->all() as $turma)
                                            @if($turma->programa->id==$programa->id)                                            
                                            <li class="item">
                                                <div class="item-row">
                                                    <div class="item-col fixed item-col-check"> 


                                                        <label class="item-check" id="select-all-items">
                                                        <input type="checkbox" class="checkbox" name="turma" value="{{$turma->id}}">
                                                        <span></span>
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="item-col fixed pull-left item-col-title">
                                                    <div class="item-heading">Curso/atividade</div>
                                                    <div class="">
                                                        
                                                             <div href="#" style="margin-bottom:5px;" class="color-primary">Turma {{$turma->id}} - <i class="fa fa-{{$turma->icone_status}}" title=""></i><small> {{$turma->texto_status}}</small></div> 

                                                       @if(isset($turma->disciplina))
                                                         <a href="{{asset('pedagogico/turmas/inscritos').'/'.$turma->id}}" target="_blank"class="">
                                                            <h4 class="item-title"> {{$turma->disciplina->nome}}</h4>       
                                                            <small>{{$turma->curso->nome}}</small>
                                                        </a>
                                                       @else
                                                        <a href="{{asset('pedagogico/turmas/inscritos').'/'.$turma->id}}" target="_blank"class="">
                                                            <h4 class="item-title"> {{$turma->curso->nome}}</h4>           
                                                        </a>
                                                        @endif
                                                         {{implode(', ',$turma->dias_semana)}} - {{$turma->hora_inicio}} ás {{$turma->hora_termino}}
                                                    </div>
                                                </div>
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Professor(a)</div>
                                                        <div> {{$turma->professor->nome_simples}}
                                                            <div>{{$turma->local->sigla}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Vagas</div>
                                                        <div>{{$turma->vagas}}/{{$turma->matriculados}}</div>
                                                    </div>
                                                     
                                                   
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Valor</div>
                                                        <div>R$ {{$turma->valor}} </div>
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
                                                                     <a class="remove" title="Cancelar" href="#" onclick=cancelar({{$turma->id}})> <i class="fa fa-ban "></i> </a>
                                                                </li>
                                                                <li>
                                                                     <a class="remove" href="#" title="Apagar" onclick=apagar({{$turma->id}})> <i class="fa fa-trash-o "></i> </a>
                                                                </li>
                                                                <li>
                                                                    <a class="edit" title="Editar" href="#" onclick="editar({{$turma->id}})"><i class="fa fa-pencil"></i> </a>
                                                                </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </section>
                            </div>
                            @endforeach
                    </div>
                </div>
                <!-- /.card-block -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-xl-6 -->
        
        <!-- /.col-xl-6 -->
    </div>
</section>

</form>
@endsection
@section('scripts')
<script>
function apagar(turma){
    if(confirm("Deseja mesmo apagar essa turma?"))
        $(location).attr('href','{{route('turmas')}}/apagar/'+turma);

}
function abrir(turma){
    if(confirm("Deseja mesmo abrir as matrículas dessa turma?"))
        $(location).attr('href','{{route('turmas')}}/status/2/'+turma);

}
function suspender(turma){
    if(confirm("Deseja mesmo suspender as matrículas dessa turma?"))
      $(location).attr('href','{{route('turmas')}}/status/1/'+turma);

}
function iniciar(turma){
    if(confirm("Deseja mesmo iniciar o período letivo essa turma?"))
       $(location).attr('href','{{route('turmas')}}/status/5/'+turma);

}
function editar(turma){
        $(location).attr('href','{{route('turmas')}}/editar/'+turma);

}
function cancelar(turma){
    if(confirm("Deseja mesmo cancelar essa turma?"))
        $(location).attr('href','{{route('turmas')}}/status/0/'+turma);

}
function abrirSelecionadas(){
     var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente abrir as matrículas das turmas selecionadas?'))
            $(location).attr('href','{{route('turmas')}}/status/2/'+selecionados);

    
}
function suspenderSelecionadas(){
   var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente abrir as matrículas das turmas selecionadas?'))
            $(location).attr('href','{{route('turmas')}}/status/1/'+selecionados);

}
function iniciarSelecionadas(){
    var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente abrir as matrículas das turmas selecionadas?'))
            $(location).attr('href','{{route('turmas')}}/status/4/'+selecionados);

}
function cancelarSelecionadas(){
    var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente abrir as matrículas das turmas selecionadas?'))
            $(location).attr('href','{{route('turmas')}}/status/0/'+selecionados);

}

</script>



@endsection
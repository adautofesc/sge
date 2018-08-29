@extends('layout.app')
@section('titulo')Liberação de Bolsas de estudo @endsection
@section('pagina')

<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">

                <h3 class="title"> Comissão de avaliação de Bolsas </h3>

                <p class="title-description"> Análise e visualização de bolsas </p>
            </div>
        </div>
    </div>


    <div class="items-search">
        <form class="form-inline" method="POST">
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
                    <div class="row">
                        <div class="col-xs-12 text-xs-right">
                            <div class="action dropdown pull-right "> 
                                <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Com os selecionados...
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('aprovar')">
                                        <i class="fa fa-circle-o icon"></i> Aprovar
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('negar')">
                                        <i class="fa fa-circle-o icon"></i> Negar
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('excluir')">
                                        <i class="fa fa-circle-o icon"></i> Excluir
                                    </a> 
                                    
                                </div>
                             </div>
                        </div>

                    </div>
                    
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
                                                    
                                                    <div class="item-col item-col-header item-col-title">
                                                        <div> <span>Pessoa</span> </div>
                                                    </div>
                                                    <div class="item-col item-col-header item-col-sales">
                                                        <div> <span>Data</span> </div>
                                                    </div>

                                                    <div class="item-col item-col-header item-col-sales">
                                                        <div> <span>Curso</span> </div>
                                                    </div>
                                                    <div class="item-col item-col-header item-col-sales">
                                                        <div> <span>Status</span> </div>
                                                    </div>

                                                    <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                                                </div>
                                            </li>
                                            @foreach($bolsas as $bolsa)


                                                                                  
                                            <li class="item">
                                                <div class="item-row">
                                                    <div class="item-col fixed item-col-check"> 


                                                        <label class="item-check" >
                                                        <input type="checkbox" class="checkbox" name="turma" value="{{$bolsa->id}}">
                                                        <span></span>
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="item-col fixed pull-left item-col-title">
                                                    <div class="item-heading">Pessoa</div>
                                                    <div class="">
                                                        
                                                             <div href="#" style="margin-bottom:5px;">{{$bolsa->getNomePessoa()}}</div> 

                            
                                                    </div>
                                                </div>
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Data</div>
                                                        <div> 
                                                            <div>{{$bolsa->created_at->format('d/m/Y')}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Curso</div>
                                                        <div>{{$bolsa->getNomeCurso()}}</div>
                                                    </div>
                                                     
                                                   
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Status</div>
                                                        <div> {{$bolsa->status}} </div>
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
                                                                     <a class="remove" title="Cancelar" href="#" onclick=cancelar({{$bolsa->id}})> <i class="fa fa-ban "></i> </a>
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
</section>
{{ $bolsas->links() }}

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
        $(location).attr('href','{{route('turmas')}}/status/inscricao/'+turma);

}
function suspender(turma){
    if(confirm("Deseja mesmo suspender as matrículas dessa turma?"))
      $(location).attr('href','{{route('turmas')}}/status/espera/'+turma);

}
function iniciar(turma){
    if(confirm("Deseja mesmo iniciar o período letivo essa turma?"))
       $(location).attr('href','{{route('turmas')}}/status/iniciada/'+turma);

}
function editar(turma){
        $(location).attr('href','{{route('turmas')}}/editar/'+turma);

}
function cancelar(turma){
    if(confirm("Deseja mesmo cancelar essa turma?"))
        $(location).attr('href','{{route('turmas')}}/status/cancelada/'+turma);

}
function alterarStatus(status){
     var selecionados='';
        $("input:checkbox[name=turma]:checked").each(function () {
            selecionados+=this.value+',';

        });
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente alterar as bolsas selecionadas?'))
            $(location).attr('href','./status/'+status+'/'+selecionados);

    
}


</script>



@endsection
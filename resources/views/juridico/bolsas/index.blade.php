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
                    <div class="row">
                        <div class="col-xs-12 text-xs-right">
                            <div class="action dropdown pull-right "> 
                                <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Com os selecionados...
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('aprovar')">
                                        <i class="fa fa-check-circle-o icon"></i> Aprovar
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('negar')">
                                        <i class="fa fa-ban icon"></i> Negar
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('analisando')">
                                        <i class="fa fa-clock-o icon"></i> Analisando
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('cancelar')">
                                        <i class="fa fa-minus-circle icon"></i> Cancelar
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('apagar')">
                                        <i class="fa fa-times-circle icon"></i> Excluir
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
                                                    <div class="item-col item-col-header " >
                                                        <div> <span>Id<span> </div>
                                                    </div>
                    
                                                    <div class="item-col col-md-4 item-col-header " >
                                                        <div> <span>Pessoa</span> </div>
                                                    </div>
                                                    <div class="item-col item-col-header ">
                                                        <div> <span>Data</span> </div>
                                                    </div>

                                                    <div class="item-col item-col-header ">
                                                        <div> <span>Curso</span> </div>
                                                    </div>
                                                    <div class="item-col item-col-header ">
                                                        <div> <span>Status</span> </div>
                                                    </div>

                                                    <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                                                </div>
                                            </li>
                                            @foreach($bolsas as $bolsa)


                                                                                  
                                            <li class="item">
                                                <div class="item-row">
                                                    <div class="item-col fixed item-col-check" > 
                                                        <label class="item-check" >
                                                        <input type="checkbox" class="checkbox" name="turma" value="{{$bolsa->id}}">
                                                        <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="item-col item-col-sales" >
                                                        <div class="item-heading">id</div>
                                                        <div style="width:20px;"> <a class="btn btn-primary btn-sm" href="./analisar/{{$bolsa->id}} ">{{$bolsa->id}} </a></div>
                                                    </div>
                                        
                                                    
                                                    <div class="item-col fixed pull-left item-col-title">
                                                    <div class="item-heading">Pessoa</div>
                                                    <div class="">
                                                        
                                                             <div>{{$bolsa->getNomePessoa()}}</div> 

                            
                                                    </div>
                                                </div>
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Data</div>
                                                        <div> 
                                                            <div><small>{{$bolsa->created_at->format('d/m/Y')}}</small></div>
                                                        </div>
                                                    </div>
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Matricula</div>
                                                     
                                                        <div><small>{{$bolsa->desconto_str->nome}}</small></div>
                                                     
                                                    </div>
                                                     
                                                   
                                                    <div class="item-col item-col-sales">
                                                        <div class="item-heading">Status</div>
                                                        <div> <small>{{$bolsa->status}}</small></div>
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
                                                                     <a class="edit" title="Aprovar" href="#" onclick="alterarStatusIndividual('aprovar','{{$bolsa->id}}')"> <i class="fa fa-check-circle-o "></i> </a>
                                                                    </li>
                                                                    <li>
                                                                     <a class="remove" title="Negar" href="#" onclick="alterarStatusIndividual('negar','{{$bolsa->id}}')"> <i class="fa fa-ban "></i> </a>
                                                                    </li>
                                                                    <li>
                                                                     <a class="edit" title="Colocar para análise" href="#" onclick="alterarStatusIndividual('analisando','{{$bolsa->id}}')"> <i class="fa fa-clock-o "></i> </a>
                                                                    </li>
                                                                    <li>
                                                                     <a class="remove" title="Cancelar" href="#" onclick="alterarStatusIndividual('cancelar','{{$bolsa->id}}')"> <i class="fa fa-minus-circle "></i> </a>
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

{{ $bolsas->links() }}

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
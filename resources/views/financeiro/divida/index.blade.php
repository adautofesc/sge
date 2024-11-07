@extends('layout.app')
@section('titulo')Dívida Ativa @endsection
@section('pagina')
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
.table{
    margin-top:5px;
}
    
</style>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="../">Financeiro</a></li>
  <li class="breadcrumb-item"><a>Dívida Ativa</a></li>
 
</ol>

<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">

                <h3 class="title"> Dívidas Ativas</h3>

                <p class="title-description"> Gerenciamento de dívidas anteriores </p>
            </div>
        </div>
    </div>

    <div class="items-search col-md-3">
        <div class="header-block header-block-search hidden-sm-down">
           <form action="?" method="GET">
            {{csrf_field()}}
               <div class="input-group input-group-sm" style="float:right;">
                   <input type="text" class="form-control" name="buscar" placeholder="Buscar">
                   <i class="input-group-addon fa fa-search" onclick="document.forms[1].submit();" style="cursor:pointer;"></i>
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
                    <div class="row">
                        <div class="col-xs-6 text-xs">
                             {{$dividas->links()}}
                            
                        </div>
                        <div class="col-xs-6 text-xs-right">

                            
                            <div class="action dropdown pull-right "> 
                                <!-- <a href="#" class="btn btn-sm rounded-s btn-secondary" title="Exportar para excel"><img src="/img/excel.svg" alt="excel" width="20px"></a> -->
                                <button class="btn btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Com os selecionados...
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('aprovar')">
                                        <label><i class="fa fa-check-circle-o icon text-success"></i> Aprovar</label>
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('negar')">
                                        <label><i class="fa fa-ban icon text-danger"></i> Negar</label>
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('analisando')">
                                        <label><i class="fa fa-clock-o icon text-warning"></i><span> Analisando</span></label>
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('cancelar')">
                                        <label><i class="fa fa-minus-circle icon text-danger"></i> <span> Cancelar</span></label>
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('apagar')">
                                        <label><i class="fa fa-times-circle icon text-danger"></i> <span> Excluir</span></label>
                                    </a> 
                                    
                                </div>
                             </div>
                             <div class="action dropdown pull-right "> 
                                <!-- <a href="#" class="btn btn-sm rounded-s btn-secondary" title="Exportar para excel"><img src="/img/excel.svg" alt="excel" width="20px"></a> -->
                                <button class="btn btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Ações
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                
                                    <a class="dropdown-item" href="/financeiro/boletos/divida-ativa" >
                                        <label><i class="fa fa-check-circle-o icon text-success"></i> Inscrever</label>
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('negar')">
                                        <label><i class="fa fa-ban icon text-danger"></i> Cobrar </label>
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('analisando')">
                                        <label><i class="fa fa-clock-o icon text-warning"></i><span> Protestar</span></label>
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('cancelar')">
                                        <label><i class="fa fa-minus-circle icon text-danger"></i> <span> Executar</span></label>
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('apagar')">
                                        <label><i class="fa fa-times-circle icon text-danger"></i> <span> Renegociar</span></label>
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('apagar')">
                                        <label><i class="fa fa-times-circle icon text-danger"></i> <span> Remitir</span></label>
                                    </a> 
                                    <a class="dropdown-item" href="#" onclick="alterarStatus('apagar')">
                                        <label><i class="fa fa-times-circle icon text-danger"></i> <span> Excluir</span></label>
                                    </a> 
                                    
                                </div>
                             </div>
                            
                        </div>

                    </div>
                    

                    <!-- Tab panes ******************************************************************************** -->
                    
                    
                         <table class="table table-striped">
                             <thead>
                                 <th><input type="checkbox" name="" id=""></th>
                                 <th style="max-width: 10px;">Cod</th>
                                 <th>Ano</th>
                                 <th>Pessoa</th>
                                 <th>Consolidado</th>
                                 <th>Status</th>
                                 <th>Opções</th>
                             </thead>
                             <tbody>
                                 @foreach($dividas as $divida)
                                 <tr>
                                     <td><input type="checkbox" name="" id=""></td>
                                     <td>{{$divida->id_divida}}</td>
                                     <td>{{$divida->ano}}</td>
                                     <td><a href="/secretaria/atender/{{$divida->pessoa}}">{{$divida->getNomePessoa()}}</a></td>
                                     <td>R$ {{number_format($divida->valor_consolidado,2,',','.') }} </td>
                                     <td>{{$divida->status}}</td>
                                     <td><i class="fa fa-cog"></i> </td>
                                 </tr>
                                 @endforeach
                                
                             </tbody>
                         </table>
                       
                                        
                    

                    {{$dividas->links()}}
                
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

function parado(){
    console.log('parei');
    //$('#filtro2').css('display','inline');
    $('#dropdownMenu2').trigger('click');
}


</script>



@endsection
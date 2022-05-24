@extends('layout.app')
@section('titulo')Matrículas @endsection
@section('pagina')

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="../">secretaria</a></li>
  <li  class="breadcrumb-item active">matricula(s)</li>
</ol>  
@include('inc.errors')

    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
    
                    <h3 class="title"> Relação de matrículas</h3>
    
                    <p class="title-description"> Visualização de dados de {{$matriculas->count()}} matrículas do total de {{$matriculas->total()}}</p>
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
                            <div class="col-xs-10 text-xs">
                                {{ $matriculas->links() }}
                            </div>
                            <div class="col-xs-2 text-xs-right">
    
                                
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
                                
                            </div>
    
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm">
                                    <thead>
                                        <th> <input type="checkbox" name="" id=""> </th>
                                        <th>Matricula</th>
                                        <th>Pessoa</th>
                                        <th>Matriculado em</th>
                                        <th>Atualizado em</th>
                                        <th>Parcelas</th>
                                        <th>Status</th>
                                        <th>Bolsa</th>
                                        <th>&nbsp;</th>
                                    </thead>
                                    <tbody>
                                        @foreach($matriculas as $matricula)
                                        <tr>
                                            <td><input type="checkbox" name="" id=""></td>
                                            <td>{{$matricula->id}}</td>
                                            <td><a href="/secretaria/atender/{{$matricula->pessoa}}">{{$matricula->pessoa_obj->nome}}</a></td>
                                            <td>{{$matricula->created_at->format('d/m/Y H:i')}}</td>
                                            <td>{{$matricula->updated_at->format('d/m/Y H:i')}}</td>
                                            <td>{{$matricula->getParcelas()}}/{{$matricula->lancamentos}}</td>
                                            <td>{{$matricula->status}}</td>
                                            <td>sim</td>
                                            <td><a href="#"><i class="fa fa-cog"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>





                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection
@section('scripts')
<script>


</script>
@endsection
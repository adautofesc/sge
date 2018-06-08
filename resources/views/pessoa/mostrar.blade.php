@extends('layout.app')
@section('pagina')

<!-- ********************************************************************************** tab -->
 <div class="title-block">
    <h3 class="title">Visualização de informações<span ></span> </h3>
</div> @include('inc.errors')  

 @if(isset($pessoa['id']))
<div class="subtitle-block">
    <h3 class="subtitle"><small>Dados de: </small> {{$pessoa['nome']}}</h3>
</div>


    <section class="section">
    <div class="row ">
        <div class="col-xl-12">
            <div class="card sameheight-item">
                <div class="card-block">
                    <!-- Nav tabs     sameheight-container(row)  -->
                    
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item"> <a href="" class="nav-link active" data-target="#geral" data-toggle="tab" aria-controls="geral" role="tab">Dados Gerais</a> </li>
                        <li class="nav-item"> <a href="" class="nav-link" data-target="#academicos" aria-controls="academicos" data-toggle="tab" role="tab">Acadêmicos</a> </li>
                        <li class="nav-item"> <a href="" class="nav-link" data-target="#clinicos" aria-controls="clinicos" data-toggle="tab" role="tab">Clínicos</a> </li>
                        <li class="nav-item"> <a href="" class="nav-link" data-target="#contato" aria-controls="contato" data-toggle="tab" role="tab">Contato</a> </li>
                        <li class="nav-item"> <a href="" class="nav-link" data-target="#financeiros" aria-controls="financeiros" data-toggle="tab" role="tab">Financeiros</a> </li>
                        <li class="nav-item"> <a href="" class="nav-link" data-target="#obs" aria-controls="obs" data-toggle="tab" role="tab">Obs</a> </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabs-bordered">

                        <!-- Geral ****************************************************************************************** -->
                        @include('pessoa.dados-gerais.mostrar')

                        <!-- Acadêmicos ************************************************************************************* -->
                        @include('pessoa.dados-academicos.mostrar')

                        <!-- // Contato *********************************************************************************** -->
                        @include('pessoa.dados-contato.mostrar')

                        <!-- Clinicos *********************************************************************************** -->    
                        @include('pessoa.dados-clinicos.mostrar')

                        <!-- Financeiros ******************************************************************************** -->
                        @include('pessoa.dados-financeiros.mostrar')
                        
                        
                        <div class="tab-pane fade" id="obs">
                            <div class="row">                     
                                <div class="col-xs-12 text-xs-right">                                        
                                    <a href="{{asset('/pessoa/editar/observacoes/').'/'.$pessoa->id}}" class="btn btn-primary btn-sm rounded-s"> Editar </a>
                                </div>
                            </div>
                            <section class="card card-block">
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">
                                    Observações
                                </label>
                                <div class="col-sm-10"> 
                                    <textarea rows="4" class="form-control boxed" name="obs" readonly="true">@if(isset($pessoa['obs'])){{ $pessoa['obs'] }} @else Sem dados no momento
                                    @endif
                                    </textarea> 
                                </div>
                            </div>

                            </section>
            @endif
                         
                        </div>

                            
                        
                    </div>
                </div><!-- /.card-block -->
                
            </div><!-- /.card -->
            
        </div><!-- /.col-xl-6 -->
     
    </div><!-- /.row -->
</section>


@endsection
@section('scripts')
<script>
function remVinculo(id){
    if(confirm("Deseja mesmo apagar esse vínculo?")){
        $(location).attr('href', '{{asset('/pessoa/removervinculo')}}/'+id);
    }
}
</script>



@endsection
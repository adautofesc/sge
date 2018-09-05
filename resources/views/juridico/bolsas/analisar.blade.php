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
</div>
@include('inc.errors')
<section class="section">
    <div class="row ">
        <div class="col-xl-12">
            <div class="card sameheight-item">
                <div class="card-block">
                    <!-- Nav tabs -->
                    <div class="row">
                        <div class="col-xs-12 text-xs">
                            <div class="title-block">
                                <div class="row">
                                    <div class="col-md-6">

                                        <h3 class="title"> Solicitação de número 00000</h3>

                                        <p class="title-description"> Bolsa por não possuir condições socioeconômicas. </p>
                                        <br>
                                        <p><small> <strong>Nome: </strong>Pessoa da silva <strong>Tel.: </strong>(16) 0000-0000</small><br>
                                        <small> <strong>Solicitado em: </strong>10/10/1998 <strong>Matrícula: </strong> 7987</small><br>
                                        </p> 
                                    </div>

                                </div>
                                @include('inc.errors')
                                <form name="item" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                  
                                <div class="form-group row"> 
                                    <label class="col-sm-1 form-control-label text-xs-right">
                                        <small><strong>Estado</strong></small>
                                    </label>
                                    <div class="col-sm-6"> <small>
                                        <select name="desconto" class="c-select form-control-sm boxed" ">
                                            <option value="1">Aprovada</option>
                                            <option value="2">Negada</option>
                                            <option value="3">Bolsa para Funcionários Públicos (20%)</option>
                                            <option value="4">Bolsa Alunos de Parcerias</option>
                                            <option value="5">Bolsa Servidores Fesc</option>
                                        </select></small>
                                    </div>
                                </div>
                                <div class="form-group row"> 
                                    <label class="col-sm-1 form-control-label text-xs-right">
                                        <small><strong>Análise:</strong></small>
                                    </label>
                                    <div class="col-sm-6"> 
                                        <textarea rows="5" class="form-control" id="formGroupExampleInput7"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        if(selecionados=='')
            alert('Nenhum item selecionado');
        else
        if(confirm('Deseja realmente alterar as bolsas selecionadas?'))
            $(location).attr('href','./status/'+status+'/'+selecionados);

    
}


</script>



@endsection
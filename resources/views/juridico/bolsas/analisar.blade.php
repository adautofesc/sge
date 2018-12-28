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

                                        <h3 class="title"> Solicitação de número {{$bolsas}}</h3>

                                        @if(isset($bolsa))
                                        <p class="title-description"> {{$bolsa->desconto->nome}} </p>
                                        <br>
                                        <p><small> <strong>Nome: </strong>{{$bolsa->getNomePessoa()}} (<a href="/secretaria/atender/{{$bolsa->pessoa}}">{{$bolsa->pessoa}}</a>) <strong></small><br>
                                        <small> <strong>Solicitado em: </strong>{{$bolsa->created_at->format('d/m/Y')}} <strong>Alterada em: </strong>{{$bolsa->updated_at->format('d/m/Y')}} 
                                            <br>
                                            @foreach($bolsa->getMatriculas() as $matricula)
                                            <strong>Matrícula: </strong> {{$matricula->matricula}} <strong>Curso: </strong>{{$matricula->getNomeCurso()}}<br>
                                            @endforeach
                                            </small>
                                        </p> <small>
                                            @if(file_exists('documentos/bolsas/requerimentos/'.$bolsa->id.'.pdf'))
                                                <a href="/documentos/bolsas/requerimentos/{{$bolsa->id}}.pdf" title="Visualizar documentos;">
                                                    <i class=" fa fa-file-text "></i> Visualizar documentos do requerimento</a><br>
                                            @else
                                                <a href="/pessoa/bolsa/upload/{{$bolsa->id}}" title="Enviar requerimento">
                                                    <i class=" fa fa-cloud-upload "></i> Enviar requerimento digitalizado.</a><br>

                                            @endif
                                             @if(file_exists('documentos/bolsas/pareceres/'.$bolsa->id.'.pdf'))
                                                <a href="/documentos/bolsas/pareceres/{{$bolsa->id}}.pdf" title="Visualizar documentos;">
                                                    <i class=" fa fa-file-text "></i> Visualizar documentos do parecer.</a><br>
                                             @else
                                                <a href="/pessoa/bolsa/parecer/{{$bolsa->id}}" style="color:orange;" title="Enviar parecer">
                                                    <i class=" fa fa-cloud-upload"></i> Enviar parecer digitalizado.</a><br>
                                            @endif
                                            <i class=" fa fa-trash-o " style="color:red;"></i> <a href="#" onclick="alterarStatusIndividual('apagar',{{$bolsa->id}})" style="color:red">Excluir esta solicitação. </a><br><br>
                                        </small>
                                        @else
                                        <br>
                                        <p><small> <strong><i class="fa fa-list-ol"></i> Várias bolsas selecionadas </strong></small><br>
                                        <br>
                                        </p> 
                                        @endif
                                    </div>

                                </div>
                               
                                <form name="item" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <!--
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
                            -->
                                <div class="form-group row"> 
                                    <label class="col-sm-1 form-control-label text-xs-right">
                                        <small><strong>Análise:</strong></small></strong>
                                    </label>
                                    <div class="col-sm-6"> 
                                        <textarea rows="5" class="form-control" id="formGroupExampleInput7" maxlength="500" name="obs">@if(isset($bolsa)){{$bolsa->obs}}@else  Documentação confere. @endif</textarea>
                                    </div>
                                </div>




                                <div class="form-group"> <label class="control-label"><small><strong>Considerando a justificativa acima citada, a comissão considera a solicitação:</strong></small></label>
                                    <div> <label>
                                        <input class="radio" name="parecer" type="radio" value="ativa">
                                        <span>APTA A BOLSA INTEGRAL</span>
                                    </label> <label>
                                        <input class="radio" name="parecer" type="radio" value ="ativa">
                                        <span>APTA A BOLSA PARCIAL</span>
                                    </label> <label>
                                        <input class="radio" name="parecer" type="radio" value ="indeferida">
                                        <span>INDEFERIDA</span>
                                    </label> </div>
                                </div>
                                <input type="hidden" name="bolsas" value="{{$bolsas}}">





                                <div class="form-group row"> 
                                    <label class="col-sm-1 form-control-label text-xs-right">
                                        
                                    </label>
                                    <div class="col-sm-6"> 
                                        <button class="btn btn-primary" type="submit">Gravar</button>
                                        <button type="reset" name="btn"  class="btn btn-primary">Restaurar</button>
                                       <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
                                    </div>
                                </div>
                                </form>
                              

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
            $(location).attr('href','../status/'+status+'/'+id);

    
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
            $(location).attr('href','../status/'+status+'/'+selecionados);

    
}


</script>



@endsection
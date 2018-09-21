@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Bem vindo !!!</h3>
            <p class="title-description">{{ $dados['data']}}</p>
        </div>
    </div>
</div>


<section class="section">
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Comunicados & portarias</p>
                    </div>
                </div>
                <div class="card-block">
                    <small>
                    <table class="table">
                        <thead>
                            <th>Link</th>
                            <th>Data</th>
                            <th>Descrição</th>
                        </thead>
                        <tr>
                            <td><a href="/documentos/oficios/2018004.pdf"><i class="fa fa-file-text-o"></i></a></td>
                            <td>22/05/18</td>
                            <td>Calendário Escolar</td>
                        </tr>
                        

                    </table>
                    </small>
                </div>
            </div> 


        </div>
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Períodos de Matrículas/rematrículas Of.6/18</p>
                    </div>
                </div>
                <div class="card-block">

                    <div class="text-xs-left">
                        <small>
                        <table class="table">
                            <tr>
                                <td>04/06</td>
                                <td>à</td>
                                <td>15/06</td>
                                <td>Rematrícula geral*</td>
                            </tr>
                            <tr>
                                <td>11/06</td>
                                <td></td>
                                <td></td>
                                <td>Matrículas UniTrabalhador</td>
                            </tr>
                            <tr>
                                <td>18/06</td>
                                <td></td>
                                <td></td>
                                <td>Matrículas PID</td>

                               
                            </tr>
                            <tr>
                                <td>02/07</td>
                                <td></td>
                                <td></td>
                                <td>Matrículas UATI</td>

                               
                            </tr>
                            <tr>
                                <td>04/06</td>
                                <td></td>
                                <td></td>
                                <td>Pedidos de Bolsas</td>

                               
                            </tr>                                                     
                           
                        </table>
                        *exceto piscina.
                    </small>
                    </div>
 
                </div>
            </div> 


        </div>


    </div>
    @if(unserialize(Session('recursos_usuario'))->contains('recurso','18'))
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-warning">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Pendências de alunos</p>
                    </div>
                </div>
                <div class="card-block">
                    <small>
                    <table class="table">
                        <thead>
                            <th>Pessoa</th>
                            <th>Pendência</th>
                            <th>Apagar</th>
                        </thead>

                        @foreach($pendencias as $pendencia)
                        <tr>
                            <td><a href="/secretaria/atender/{{$pendencia->pessoa}}">{{$pendencia->pessoa}}</a></td>
                            <td>{{$pendencia->valor}}</td>
                            <td> <a href="#" class="close" onclick="apagaErro({{$pendencia->id}});" >&times;</a> </td>
                        </tr>
                        @endforeach
                        

                    </table>
                    </small>
                </div>
            </div> 
        </div>
    </div>
    @endif
</section>

@endsection
@section('scripts')
<script>
  

function apagaErro(id){

    if(confirm("Deseja excluir o aviso?")){
        $(location).attr('href','{{asset("/pessoa/apagar-atributo")}}/'+id);
    }

}
</script>
@endsection
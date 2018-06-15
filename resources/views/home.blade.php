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
<div class="alert alert-info">
    22/06 - 17hs. Festa Junina da FESC<br>
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
    <div class="row">
        <!--
        <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Departamentos disponíveis:</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="/administrativo/" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-bar-chart-o "></i>
                        &nbsp;&nbsp;Administrativo</a></div>
                    <div>
                        <a href="/docentes/" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-th-large "></i>
                        &nbsp;&nbsp;Docentes</a></div>
                    <div><a href="/financeiro" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-usd"></i>&nbsp;&nbsp;Financeiro</a></div>
                    <div><a href="/gestaopessoal" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-users"></i>&nbsp;&nbsp;Gestão Pessoal</a></div>
                    <div><a href="/pedagogico" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-th-list"></i>&nbsp;&nbsp;Pedagógico</a></div>
                    <div>
                        <a href="{{asset("/secretaria")}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-stack-overflow"></i>&nbsp;&nbsp;Secretaria</a>
                    </div>
 
                </div>
            </div> 


        </div>
    -->
        



        </div>

    </div>
</section>

@endsection
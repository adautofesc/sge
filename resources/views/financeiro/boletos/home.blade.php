@extends('layout.app')
@section('titulo') Gerador de Boletos @endsection
@section('pagina')
@include('inc.errors')
<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Gerador de Boletos</h3>
            <p class="title-description">Módulo gerenciador de Boletos</p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">ATENÇÃO</p>
                    </div>
                </div>
                <div class="card-block">
                
                    <p> A geração de boleto consiste em relacionar todas parcelas em aberto de uma pessoa e gerar um registro de boleto para posterior impressão. </p>
                    <p><b>Após a impressão dos boletos deve-se realizar a confirmação de impressão</b></p>
                    <p> A Confirmação de impressão muda o <i>status</i> dos boletos para a geração do arquivo de remessa. </p>
                   <div>
                        <a href="#" onclick="gerarCarnes();" class="btn btn-danger-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Gerador completo de Carnês</a>
                    </div>

                    <div>
                        <a href="#" onclick="gerarBoletos();" class="btn btn-warning-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Gerar boleto unico com todas parcelas</a>
                    </div>
                  
                    <div>
                        <a href="{{asset('financeiro/boletos/imprimir-lote')}}" target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Impressão de boletos em lote</a>
                    </div>
                     <div>
                        <a href="{{asset('financeiro/boletos/lote-csv')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Gerar arquivo CSV com boletos.</a>
                    </div>
                    <div>
                        <a href="#" onclick="gerarImpressao()" class="btn btn-warning-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Confirmar impressão em lote</a>
                    </div>
                    <!--
                    <div>
                        <a href="{{asset('financeiro/boletos/imprimir-lote')}}" data-toggle="modal" data-target="#confirm-modal" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Impressão de boletos em lote</a>
                    </div>
                    -->

                </div>
            </div>
        </div>

    </div>
</section>

@endsection
@section('modal')
    <div class="modal fade" id="confirm-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="fa fa-warning"></i> Atenção
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h4>
                </div>
                <div class="modal-body">
                    <p>Os boletos foram impressos corretamente?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Sim</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
          
@endsection

@section('scripts')
<script type="text/javascript">
    function gerarBoletos(){
        if(confirm("Tem certeza que deseja gerar os boletos desse mês?")){
            window.location.replace("{{asset('financeiro/boletos/gerar-boletos')}}");
        }
    }
    function gerarCarnes(){
        if(confirm("Tem certeza que deseja gerar os carnês de todos alunos?")){
            window.location.replace("{{asset('financeiro/carne/gerar')}}");
        }
    }
    function gerarImpressao(){
        if(confirm("Os boletos foram todos impressos?")){
            window.location.replace("{{asset('financeiro/boletos/confirmar-impressao')}}");
        }
    }

</script>
@endsection
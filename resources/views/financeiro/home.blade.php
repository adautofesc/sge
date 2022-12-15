@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Departamento de Financeiro da FESC</h3>
            <p class="title-description">Receitas, despesas, balancetes e relatórios</p>
        </div>
    </div>
</div>
@include('inc.errors')
<section class="section">
    <div class="row">
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Boletos</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="/financeiro/carne/gerar" class="btn btn-primary-outline col-xs-12 text-xs-left" title="Gera os carnês, os PDF's e os arquivos de remessa">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Gerador Completo</a>
                    </div> 
                    <div>
                        <a href="/financeiro/carne/gerarBackground" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Gerar Carnês</a>
                    </div>  
                    <div>
                        <a href="/financeiro/carne/pdfs" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Gerar PDF's</a>
                    </div> 
                    <!--
                    <div>
                        <a href="{{asset('financeiro/boletos/imprimir-lote')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Gerar PDF's dos carnês</a>
                    </div>
                     <div>
                        <a href="{{asset('financeiro/boletos/lote-csv')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Gerar arquivo CSV com boletos.</a>
                    </div>-->
                    <div>
                        <a href="#" onclick="gerarImpressao()" class="btn btn-warning-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Confirmar impressão</a>
                    </div>
                   
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="Número do documento" id="boleto" maxlength="10" size="2">
                        <span class="input-group-btn">
                          <button class="btn btn-primary" type="button" onclick="consultarBoleto();">Consultar boleto</button>
                        </span>
                    </div><!-- /input-group -->
                              
                </div>
            </div>
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Retornos</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="{{asset('/financeiro/boletos/retorno/upload')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-cloud-upload "></i>
                        &nbsp;&nbsp;Fazer upload de arquivos</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/retorno/arquivos" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-bolt "></i>
                        &nbsp;&nbsp;Processar arquivos</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/retorno/processados" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-thumbs-o-up "></i>
                        &nbsp;&nbsp;Arquivos processados</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/retorno/com-erro" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-thumbs-o-down "></i>
                        &nbsp;&nbsp;Arquivos com erro</a>
                    </div>          
                </div>
            </div>
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Remessas</p>
                    </div>
                </div>
                <div class="card-block">
                
                    <p> A geração do arquivo de remessa deve ser realizado logo após a impressão dos boletos ou no final do dia (se houver boletos emitidos). </p>
                    <div>
                        <a href="#" onclick="gerarRemessa();" class="btn btn-warning-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-circle-right "></i>
                        &nbsp;&nbsp;Gerar arquivo de Remessa</a>
                    </div>
                    <div>
                        <a href="{{asset('financeiro/boletos/remessa/listar-arquivos')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-cloud-download "></i>
                        &nbsp;&nbsp;Arquivos gerados.</a>
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
    <div class="row">
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Relatórios</p>
                    </div>
                </div>
                <div class="card-block">
                        <div>
                            <a href="/relatorios/receita-anual-programa/{{date('Y')-1}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                            <i class=" fa fa-file-text-o "></i>
                            &nbsp;&nbsp;Receita Anual Por Programa</a>
                        </div>
                        <div>
                            <a href="{{asset('/')}}financeiro/cobranca/cartas" class="btn btn-primary-outline col-xs-12 text-xs-left">
                            <i class=" fa fa-envelope "></i>
                            &nbsp;&nbsp;Cartas de cobrança</a>
                        </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/relatorios/boletos" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-file-text-o "></i>
                        &nbsp;&nbsp;Boletos vencidos e não pagos</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/relatorios/cobranca-xls" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-table "></i>
                        &nbsp;&nbsp;Mala direta de cobrança (xls)</a>
                    </div>   
                    <div>
                        <a href="{{asset('/')}}financeiro/relatorios/cobranca-sms" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-comment"></i>
                        &nbsp;&nbsp;Enviar cobrança SMS</a>
                    </div>             
                </div>
            </div>
        </div>

    
        
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Dívida Ativa</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="{{asset('/')}}financeiro/divida-ativa/" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-list "></i>
                        &nbsp;&nbsp;Gerenciar</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/relatorios/boletos/0" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-file-text-o "></i>
                        &nbsp;&nbsp;Relatório de boletos abertos</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/relatorios/cobranca-xls/0" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-table "></i>
                        &nbsp;&nbsp;Mala direta de cobrança (xls)</a>
                    </div>   
                    <div>
                        <a href="{{asset('/')}}financeiro/relatorios/cobranca-sms/0" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-envelope"></i>
                        &nbsp;&nbsp;Mala direta SMS (txt)</a>
                    </div>             
                </div>
            </div>
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Pagamentos</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="{{asset('/')}}financeiro/pagamentos/" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-list "></i>
                        &nbsp;&nbsp;Gerenciamento</a>
                    </div>
                               
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
@section('scripts')
<script type="text/javascript">
    function consultarBoleto(){
        if($("#turma").val()!='')
            location.href = '/financeiro/boletos/informacoes/'+$("#boleto").val();
        else
            alert('Ops, faltou o número do boleto');
    }
    function abreMatricula(){
        if($("#matricula").val()!='')
            location.href = '/secretaria/matricula/'+$("#matricula").val();
        else
            alert('Ops, faltou o código da turma');
    }
    function gerarImpressao(){
        if(confirm("Os boletos foram todos impressos?")){
            window.location.replace("{{asset('financeiro/boletos/confirmar-impressao')}}");
        }
    }
</script>
@endsection

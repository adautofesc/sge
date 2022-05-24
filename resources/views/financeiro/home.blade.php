@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Departamento de Tesouraria da FESC</h3>
            <p class="title-description">Receitas, despesas, balancetes e relatórios</p>
        </div>
    </div>
</div>
@include('inc.errors')
<section class="section">
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Opções</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/retorno/home" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-file-text "></i>
                        &nbsp;&nbsp;Retornos</a>
                    </div>
                   
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/home" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-barcode "></i>
                        &nbsp;&nbsp;Boletos</a>
                    </div>
                    <div>
                        <a href="{{asset('/')}}financeiro/boletos/remessa/home" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-file-text-o "></i>
                        &nbsp;&nbsp;Remessas</a>
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
        <div class="col-md-6 center-block">
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

    </div>
    <div class="row">
        
        <div class="col-md-6 center-block">
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
                        &nbsp;&nbsp;Gerenciamento</a>
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
</script>
@endsection

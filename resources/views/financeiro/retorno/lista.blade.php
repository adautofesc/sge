@extends('layout.app')
@section('pagina')
@include('inc.errors')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Arquivos de retorno</h3>
            <p class="title-description">Lista de arquivos encontrados. </p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-8 center-block">
            @if(isset($processado))
            <div class="card card-warning">
            @elseif(isset($erro))
            <div class="card card-danger">
            @else
            <div class="card card-primary">
            @endif
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Arquivos 
                            @if(isset($processado))
                                PROCESSADOS
                                @elseif(isset($erro))
                                COM ERROS
                                @endif

                        </p>
                    </div>
                </div>
                <div class="card-block">
                    @if(isset($arquivos))
                    @foreach($arquivos as $arquivo)

                    @if(isset($arquivo->id))
                    <div>
                        <a href="{{asset('/financeiro/boletos/retorno/analisar/')}}/{{$arquivo->nome}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-sign-in "></i>                         
                            ID:{{$arquivo->id}} {{$arquivo->data}} <small> {{$arquivo->nome}} </small> </a>
                    </div>
                    @else
                    <div>
                        <div class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <a href="{{asset('/financeiro/boletos/retorno/original/')}}/{{$arquivo->nome}}">
                        <i class=" fa fa-sign-in "></i>                         
                            Arquivo com erro <small> {{$arquivo->nome}} </small> </a> 
                            @if(isset($erro)==false) 
                            <a href="#" onclick="removerArquivo('{{$arquivo->nome}}');"title="Remover" style="float:right;"><i class=" fa fa-remove text-danger"></i></a> 
                            @endif

                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endif

                    @if(isset($retornos))
                        @foreach($retornos as $retorno)
                        <div>
                            <a href="{{asset('/financeiro/boletos/retorno/analisar/')}}/{{substr($retorno->nome_arquivo,9)}}_PROC" class="btn btn-primary-outline col-xs-12 text-xs-left">
                            <i class=" fa fa-sign-in "></i>                         
                                ID:{{$retorno->id}} {{ \Carbon\Carbon::parse($retorno->data_processamento)->format('d/m/Y')}} <small> {{$retorno->nome_arquivo}}_PROC </small> </a>
                        </div>


                        @endforeach

                        {{$retornos->links()}}
                    @endif
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
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Opções</p>
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
                        &nbsp;&nbsp;Arquivos pendentes</a>
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
@section('scripts')
<script type="text/javascript">
    function removerArquivo(item){
        if(confirm("Deseja realmente marcar esse arquivo como erro?"))
            window.location.replace("{{asset('/financeiro/boletos/retorno/marcar-erro/')}}/"+item);
    }
</script>
@endsection

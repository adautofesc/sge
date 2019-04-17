@extends('layout.app')
@section('titulo')Histórico do Boleto @endsection
@section('pagina')


@include('inc.errors')
<form name="item" method="post" enctype="multipart/form-data">
{{csrf_field()}}
    <div class="card card-block">
    	<div class="subtitle-block">
            <h3 class="subtitle"><i class=" fa fa-barcode" style="color:black"></i> Histórico do boleto</h3>
            <small><STRONG>Todos os dados referentes ao boleto</STRONG></small>
        </div>
		<div class="form-group row"> 
            
            <div class="col-sm-12"> 
              @if(isset($boleto))
                <small>
               <strong>Boleto</strong> {{$boleto->id}}<br>
               <strong>Cedente:</strong> {{$pessoa->nome}} <strong>Cod.</strong> <a href="/secretaria/atender/{{$pessoa->id}}">{{$pessoa->id}}</a> <br>
               <strong>Data de vencimento:</strong> {{\Carbon\Carbon::parse($boleto->vencimento)->format('d/m/Y')}}<br>
               <strong>Valor:</strong> R$ {{$boleto->valor}}<br>
               <strong>Documento gerado em: </strong>{{\Carbon\Carbon::parse($boleto->created_at)->format('d/m/Y H:i')}}<br>
               <strong>Estado atual: </strong></small>


                @if($boleto->status == 'pago')
                <div class="badge badge-pill badge-success">pago</div>
                @elseif($boleto->status == 'emitido')
                <div class="badge badge-pill badge-info">emitido</div>
                @elseif($boleto->status == 'impresso')
                <div class="badge badge-pill badge-primary">impresso</div>
                @elseif($boleto->status == 'cancelar')
                <div class="badge badge-pill badge-warning">cancelar</div>
                @elseif($boleto->status == 'cancelado')
                <div class="badge badge-pill badge-danger">cancelado</div>
                @else
                <div class="badge badge-pill badge-secondary">{{$boleto->status}}</div>

                @endif
                <small>







               <br>
               <strong>Remessa: </strong>{{$boleto->remessa}}  
               <strong>Retorno:</strong> {{$boleto->retorno}}<br>
               @if($boleto->pagamento)
               <strong>Pagamento:</strong> {{\Carbon\Carbon::parse($boleto->pagamento)->format('d/m/Y')}}<br>
               @endif
                <br>

               <strong>Referências:</strong><br>
               <ol>
                   @foreach($boleto->getLancamentos() as $lancamento)
                   <li>R$ {{$lancamento->valor}} -> Parcela {{$lancamento->parcela}} da matrícula {{$lancamento->matricula}} referente à {{$lancamento->referencia}}
                   @endforeach
               </ol>
                <br>
               <strong>Histórico</strong><br>
               <ul>
               @foreach($pessoais as $pessoal)
                <li>{{\Carbon\Carbon::parse($pessoal->created_at)->format('d/m/Y H:i')}} - {{$pessoal->descricao}}</li>
               @endforeach
               @foreach($logs as $log)
                <li>{{\Carbon\Carbon::parse($log->data)->format('d/m/Y H:i')}} - {{$log->evento}}</li>
               @endforeach
                </ul>
               <br>

                </small>
              @else
              <small>
                <img src="/svg/si-glyph-document-warning.svg" class="svg-success" /><strong> Erro: </strong> Boleto não consta no banco de dados. Ele pode sido excluído ou não ter sido lançado. <br>
              </small>
              @endif


            </div>        
        </div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right"></label>
			<div class="col-sm-10 col-sm-offset-2"> 
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">voltar</button>
			</div>
       </div>
    </div>
</form>
 </div>
</section>
<style type="text/css">
  .svg-success{
    width: 2em;
    fill: #ef071e !important;

  }
</style>
@endsection
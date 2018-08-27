@extends('layout.app')
@section('titulo')Parcelas / Lançamentos @endsection
@section('pagina')
@include('inc.errors')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Geração de Parcelas</h3>
            <p class="title-description">Módulo de geração de parcelas</p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-danger">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">ATENÇÃO</p>
                    </div>
                </div>
                <div class="card-block">
                
                    <p> O sistema iniciará a geração de parcelas de cada uma das matrículas ativas. A parcela corresponde ao mês atual é resultado do número do mês, menos 1. No segundo semestre as parcelas de matriculas que não são do CE são subtraídas de 7.</p>
                    <p><b>Antes de gerar a parcela do mês atual, processar todos arquivos de retorno de datas anteriores.</b></p>
                    <p>Não há problemas em gerar mais de uma vez a mesma parcela, uma vez que o sistema verifica se a parcela já foi lançada antes de gerar uma nova. Porém não é uma pratica recomendada.</p>
                    <p><b>Após gerar as parcelas, deve-se gerar os boletos.</b></p>
                    <form method="GET" action="./gerar">
                        {{csrf_field()}}
                   <div class="form-group row" id="row_modulos" > 
                        <label class="col-sm-2 form-control-label text-xs-right">
                            Parcela
                        </label>
                        <div class="col-sm-4"> 
                            <input type="number" name="parcela" required="required" class="form-control boxed"  min="1" max="11" placeholder="" id="parcela"> 
                        </div>
                        <div class="col-sm-4"> 
                            <button type="submit" onclick="gerarParcelas();return false;" class="btn btn-danger" > Gerar</button>
                        </div>
                        
                    </div> 
                    </form>
                         
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
@section('scripts')
<script type="text/javascript">
    function gerarParcelas(){
        if(confirm("Tem certeza que deseja gerar as parcelas desse mês?")){
             window.location.replace("{{asset('financeiro/lancamentos/gerar')}}/"+$('#parcela').val());
        }
    }
    function gerarParcelasComBoletos(){
        if(confirm("Tem certeza que deseja gerar as parcelas e boletos desse mês?")){
            window.location.replace("{{asset('financeiro/lancamentos/gerar-parcelas-boletos')}}");
        }
    }

</script>
@endsection
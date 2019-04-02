@extends('layout.app')
@section('titulo')Cancelamento de Boleto @endsection
@section('pagina')


@include('inc.errors')
<form name="item" method="post" enctype="multipart/form-data">
{{csrf_field()}}
    <div class="card card-block">
    	<div class="subtitle-block">
            <h3 class="subtitle"><i class=" fa fa-minus-circle" style="color:red"></i> Cancelamento do boletos do usuário {{$pessoa->nome}}</h3>
            <small><STRONG>TODO CANCELAMENTO DE BOLETO É IDENTIFICADO.</STRONG></small>
        </div>
		<div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">Motivo do cancelamento</label>
            <div class="col-sm-7"> 
                <div>
                  
                    <select name="motivo" class="c-select form-control boxed" required>
                    <option selected="true"></option>
                    
                        <option>Valor incorreto (problemas com matrículas)</option>
                        <option>Valor incorreto (matrícula duplicada)</option>
                        <option>Valor incorreto (erro de sistema)</option>
                        <option >Boleto não registrado.</option>
                        <option>Alteração na matrícula</option>
                        <option>Cancelamento da matrícula</option>
                        <option>Bolsa concedida</option>
                        <option>Outro</option>
                    </select>
             
             
                </div>
            </div>        
        </div>
        <div class="form-group row"> 
            <div> 
                <label class="col-sm-2 form-control-label text-xs-right">
                    Outros
                </label>
                <div class="col-sm-7"> 
                    <input type="text" class="form-control boxed" name="motivo2" placeholder="Algum outro motivo específico?" > 
                </div>
            </div>        
        </div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right"></label>
			<div class="col-sm-10 col-sm-offset-2"> 
                <input type="hidden" name="pessoa" value="{{$pessoa->id}}">
                <button type="submit" name="btn"  class="btn btn-danger">GRAVAR CANCELAMENTO</button>
                <button type="reset" name="btn"  class="btn btn-primary">Limpar</button>
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
			</div>
       </div>
    </div>
</form>
 </div>
</section>
@endsection
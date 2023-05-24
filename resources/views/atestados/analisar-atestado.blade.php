@extends('layout.app')
@section('titulo')Análise de atestado @endsection
@section('pagina')

<div class="title-search-block">
    <div class="title-block">
        <h3 class="title">Alun{{$pessoa->getArtigoGenero($pessoa->genero)}}: {{$pessoa->nome}} 
            @if(isset($pessoa->nome_resgistro))
                ({{$pessoa->nome_resgistro}})
            @endif
           
        </h3>
        <p class="title-description"> <b> Cod. {{$pessoa->id}}</b> - Tel. {{$pessoa->telefone}} </p>
    </div>
</div>
@include('inc.errors')
<form name="item" method="post" enctype="multipart/form-data">
{{csrf_field()}}
    <div class="card card-block">
    	<div class="subtitle-block">
            <h3 class="subtitle"><i class=" fa fa-medkit "></i> Análise de Atestado número {{$atestado->id}}. </h3>
        </div>
        <div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Tipo de atestado:
			</label>
			<div class="col-sm-3"> 
                <strong>{{$atestado->tipo}}</strong>
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Emissão
			</label>
			<div class="col-sm-3"> 
                <strong>{{$atestado->emissao->format('d/m/Y')}}</strong>
				
			</div>
        </div>
        <div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Validade
			</label>
			<div class="col-sm-3">
                @if(isset($atestado->validade)) 
				    <strong>{{$atestado->validade->format('d/m/Y')}}</strong>                                 
                @else
                    <strong>Não definida / Não se aplica</strong>  
                @endif
			</div>
        </div>
		<div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Arquivo
            </label>
            <div class="col-sm-6">
            @if(file_exists('documentos/atestados/'.$atestado->id.'.pdf'))
                <embed src="/view-atestado/{{$atestado->id}}#navpanes=0" width="760" height="500" type='application/pdf' >
            @endif
                
            </div>
            
        </div>
        <div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Parecer
			</label>
			<div class="col-sm-3">
                <div>
                    <label>
                        <input class="radio" name="status" type="radio" value="aprovado">
                        <span class="text-success">Aprovado</span>
                    </label>
                    <label>
                        <input class="radio" name="status" type="radio" value="recusado">
                        <span class="text-danger">Recusado</span>
                    </label>
                    
                </div>
               
			</div>
        </div>
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Observações <br> <small>*Caso recusado</small>
            </label>
            <div class="col-sm-6">
                <textarea rows="3" name="obs" class="form-control"></textarea>
            </div>
            
        </div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right"></label>
			<div class="col-sm-10 col-sm-offset-2"> 
				<input type="hidden" name="atestado" value="{{$atestado->id}}">
                <button type="submit" name="btn"  class="btn btn-primary">Salvar</button>
                <button type="reset" name="btn"  class="btn btn-primary">Restaurar</button>
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
			</div>
       </div>

       <div class="subtitle-block">
        <h3 class="subtitle"><i class=" fa fa-medkit "></i> Histórico atestado número {{$atestado->id}}. </h3>
        </div>
        <div class="form-group row"> 
            <table class="table">
                <tr>
                    <th>Data</th>
                    <th>Evento</th>
                    <th>Responsável</th>
                </tr>
                @foreach($logs as $log)
                <tr>
                    <td>{{$log->data->format('d/m/Y H:i')}} </td>
                    <td>{{$log->evento}}</td>
                    <td>{{$log->getNomeResponsavel()}} </td>

                </tr>
            @endforeach
            </table>
        </div>
    </div>
</form>
@endsection
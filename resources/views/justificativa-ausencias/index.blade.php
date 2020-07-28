@extends('layout.app')
@section('titulo')Cadastro de atestado @endsection
@section('pagina')
@if($pessoa !=null)
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
            <h3 class="subtitle"><i class=" fa fa-medkit "></i> Cadastrar justificativa. </h3>
        </div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Início
			</label>
			<div class="col-sm-3"> 
				<input type="date" class="form-control boxed" name="inicio" placeholder="" required > 
            </div>
            <label class="col-sm-2 form-control-label text-xs-right">
				Termino
			</label>
			<div class="col-sm-3"> 
				<input type="date" class="form-control boxed" name="termino" placeholder="" required> 
			</div>
		</div>
		<div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Motivo
            </label>
            <div class="col-sm-6">  
                <select name="motivo" required>
                    <option>medico</option>
                    <option>viagem</option>
                    <option>pessoais</option>
                </select>
            </div>
        </div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right"></label>
			<div class="col-sm-10 col-sm-offset-2"> 
				<input type="hidden" name="pessoa" value="{{$pessoa->id}}">
                <button type="submit" name="btn"  class="btn btn-primary">Salvar</button>
                <button type="reset" name="btn"  class="btn btn-primary">Restaurar</button>
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
			</div>
       </div>
    </div>
</form>
@endif
<div class="card card-block">
    <div class="subtitle-block">
        <h3 class="subtitle"><i class=" fa fa-medkit "></i> Listagem justificativa. </h3>
    </div>
    <table class="table">
        <tr>
            <td>Cod</td>
            <td>início</td>
            <td>Termino</td>
            <td>Motivo</td>
            <td>Opções</td>
        </tr>
        @foreach($justificativas as $justificativa)
        <tr>
        <td>JA{{$justificativa->id}}</td>
            <td>{{date('d/m/y',strtotime($justificativa->inicio))}}</td>
            <td>{{date('d/m/y',strtotime($justificativa->termino))}}</td>
            <td>{{$justificativa->motivo}}</td>
            <td><a href="#apagar-item" onclick="excluir('{{$justificativa->id}}')"><i class="fa fa-trash"></i></a></td>
        </tr>
        @endforeach
    </table>
 
</div>
{{$justificativas->links()}}
@endsection
@section('scripts')
<script>
    $(".alert").delay(5000).slideUp(1000, function () {
        $(this).alert('close');
    });
function excluir(id){
    if(confirm('Deseja mesmo apagar este item?')){
        console.log('pagar item');
        resource = $.ajax('./apagar/'+id)
                        .done( function(){
                            location.reload();
                        })
                        .fail(function(){
                            alert('Erro ao processar a exclusão: '+resource.statusText);
                        });

        

    }
}
</script>
@endsection
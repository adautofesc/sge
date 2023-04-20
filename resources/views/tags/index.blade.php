@extends('layout.app')
@section('titulo')Cadastro Tag de acesso @endsection
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


<form name="item" method="post" action="/tags/{{$pessoa->id}}/criar" enctype="multipart/form-data">
    <input type="hidden" name="pessoa" value="{{$pessoa->id}}">

{{csrf_field()}}
    <div class="card card-block">
        @if($tag !== null)
        <div class="subtitle-block">
            <h3 class="subtitle"><i class=" fa fa-ticket "></i> Tag cadastrada </h3>
        </div>
        <div class="form-group row"> 
			<label class="col-sm-1 form-control-label text-xs-right">
				Tag
			</label>
			<div class="col-sm-3"> 
				<strong>{{$tag->tag}}</strong><br>
                {{$tag->data->format('d/m/Y H:i:s')}}
                <br>


            </div>
            
			<div class="col-sm-3"> 
                <a href="#" class="btn btn-sm btn-danger-outline" onclick="excluir('{{$tag->id}}','{{$tag->pessoa}}')"><i class="fa fa-times"></i> Excluir tag</a>

			</div>
		</div>
        @else
    	<div class="subtitle-block">
            <h3 class="subtitle"><i class=" fa fa-tag "></i> Cadastrar Tag. </h3>
        </div>
		<div class="form-group row"> 
			<label class="col-sm-1 form-control-label text-xs-right">
				Tag
			</label>
			<div class="col-sm-3"> 
				<input type="text" class="form-control boxed" name="tag" placeholder="" required > 
            </div>
            
			<div class="col-sm-3"> 
                <button type="submit" name="btn"  class="btn btn-primary">Salvar</button>

			</div>
		</div>
        @endif
	

		
    </div>
</form>
@endif
<div class="card card-block">
    <div class="subtitle-block">
        <h3 class="subtitle"><i class=" fa fa-ticket "></i> Registros de tags vinculadas </h3>
    </div>
    <table class="table table-sm">
        <tr>
            <td>Cod</td>
            @if($pessoa == null)
            <td>pessoa</td>
            @endif
            <td>evento</td>
            <td>data</td>
          
        </tr>
        @foreach($logs as $log)
            <tr>
            <td>{{$log->id}}</td>
            @if($pessoa == null)
                <td><a href="/secretaria/atender/{{$log->pessoa}}">{{$log->pessoa}}</a></td>
            @endif
            <td>{{$log->evento}}</td>
            <td>{{$log->data->format('d/m/Y H:i:s')}}</td>
            
            </tr>
        @endforeach
    </table>
 
</div>
{{$logs->links()}}
@endsection
@section('scripts')
<script>
    $(".alert").delay(5000).slideUp(1000, function () {
        $(this).alert('close');
    });
function excluir(id,pessoa){
    if(confirm('Deseja mesmo apagar este item?')){
        console.log('pagar item');
        resource = $.ajax('./apagar/'+id+'/'+pessoa)
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
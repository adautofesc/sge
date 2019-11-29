@extends('layout.app')
@section('titulo')Alunos importados @endsection
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Lista de pessoas INSCRITAS  
                <!--                
	                <div class="action dropdown"> 
	                	<button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mais ações...
	                	</button>
	                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
	                    	<a class="dropdown-item" href="#"><i class="fa fa-pencil-square-o icon"></i>Enviar e-mail</a> 
	                    	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirm-modal"><i class="fa fa-close icon"></i>Apagar</a>
	                    </div>
	                </div> 
                -->
                </h3>
                <p class="title-description"> Processamento realizado com sucesso!</p>
            </div>
        </div>
    </div>

</div>
@if(count($pessoas))

    {{csrf_field()}}
<div class="card items">
    <table class="table">
        <thead>
            <th>Status</th>
            <th>Nome</th>
        </thead>
        <tbody>
            @foreach($pessoas as $pessoa=>$nome)
            <tr>
                <td class="pull-right">
                    @if(in_array($pessoa,$cadastrados))
                    <i class=" fa fa-check-circle text-success"></i>
                    @else
                    <i class=" fa fa-times-circle text-danger"></i>
                    @endif

                </td>
                <td>{{$nome}}</td>
                
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

<div class="form-group row">
    <div class="col-sm-10 col-sm-offset-2">
        <a class="btn btn-primary" href="{{asset('/pedagogico')}}">Pedagógico</a> 
        <a class="btn btn-primary" href="{{asset('/pedagogico/turmas')}}">Turmas Pedagógico</a> 
        
        <!-- 
        <button type="submit" class="btn btn-primary"> Cadastrar</button> 
        -->
    </div>
</div>
</form>



@else
<h3 class="title-description"> Nenhuma pessoa para exibir / Formato de arquivo importado inválido.</p>
@endif

@endsection
 @extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Matrículas gravadas com sucesso</h3>
</div>

@include('inc.errors')
<div class="subtitle-block">
    <h3 class="subtitle"><small>De: </small> {{$nome}}</h3>
</div>

@foreach($matriculas as $matricula)
<div class="card card-success">

    <div class="card-header">
        <div class="header-block">
        <p class="title" style="color:white"> Matricula {{$matricula->id}} efetuada com sucesso!</p>
        </div>
    </div>


    <div class="card-block">
       <ul class="list-group">
           <li><a class="btn btn-primary small" href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}" target="_blank">Imprimir Termos de Matrícula</a></li>
           <li><a class="btn btn-primary small" href="{{asset('/secretaria/matricula/contrato/').'/'.$matricula->id}}" target="_blank">Imprimir Contrato</a></li>
           <li><a class="btn btn-primary small" href="#" target="_blank">Marcar como pendente</a></li>
           
       </ul>

    </div>
</div>
@endforeach

@endsection
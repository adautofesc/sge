 @extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Matrículas gravadas com sucesso</h3>
</div>

@include('inc.errors')
<div class="subtitle-block">
    <h3 class="subtitle"><small>De: </small> {{$nome}}</h3>
</div>

<form name="item" method="POST" action="gravar">
<div class="card card-success">

    <div class="card-header">
        <div class="header-block">
        <p class="title" style="color:white"> Matricula efetuada com sucesso!</p>
        </div>
    </div>


    <div class="card-block">
       <ul>
           <li>Imprimir Termos de Matrículas</li>
           <li>Imprimir Contrato</li>
           <li>Imprimir Boletos</li>
       </ul>

    </div>
</div>

@endsection
@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('titulo')Controle de alunos - SGE FESC @endsection

<style type="text/css">
	@media print {
            .hide-onprint { 
                display: none;
            }
           
        }
.dropdown-menu li label{
	text-decoration: none;
	color:black;
	margin-left: 1rem;
	line-height: 1.1rem;
}
.dropdown-menu li label:hover{
    cursor: pointer;
	background-color:lightgray;

}
</style>
@section('pagina')

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="../">secretaria</a></li>
  <li  class="breadcrumb-item active">Controle de alunos</li>
</ol>

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Departamento de Secretaria da FESC</h3>
            <p class="title-description">Ferramenta de gestão em lote de alunos</p>
        </div>
    </div>
</div>
<div class="row hide-onprint">
    <div class="col-xs-12" style="margin-bottom: 50px;">
        <form class="inline-form" method="GET">
            <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Período
                </button>

                <ul class="dropdown-menu" id="myDropdown" >
                @foreach($periodos as $periodo)
                  <li><label>
                      <input type="checkbox"
                        @if(isset($r->periodos) && in_array(($periodo->semestre.$periodo->ano),$r->periodos)) checked @endif
                        name="periodos[]" value="{{$periodo->semestre.$periodo->ano}}"/>
                       &nbsp;{{$periodo->semestre.'º Sem. '.$periodo->ano}}</label></li>
                @endforeach
                </ul>

            </div>
            <button class="btn btn-success" type="submit">Gerar</button>
			<button class="btn btn-primary" type="reset">Limpar</button>
        

@endsection
@section('scripts')
<script>
    $('#myDropdown').on('hide.bs.dropdown', function () {
    alert();
});
  
</script>
@endsection
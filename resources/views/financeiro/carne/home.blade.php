@extends('layout.app')
@section('titulo')
Gerador de carnês 
@endsection
@section('pagina')
<header>
    
      <style>
  .ui-progressbar {
    position: relative;
  }
  .progress-label {
    position: absolute;
    left: 50%;
    top: 4px;
    font-weight: bold;
    text-shadow: 1px 1px 0 #fff;
  }
  </style>
    
  </header>
  <body>

    <!-- conteúdo da página -->
    
@include('inc.errors')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Geração de Carnês</h3>
            <p class="title-description">Geração automática de lançamentos e boletos de matrículas ativas e pendentes.</p>
        </div>
    </div>
</div>
<br>

<a id="botao" href="/financeiro/carne/fase1" class="btn btn-primary">Iniciar geração</a>


    
  
  </body>
</html>
@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

@endsection

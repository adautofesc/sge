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
            <h3 class="title">Solicitação enviada</h3>
            
        </div>
    </div>
</div>

<p><strong>A geração dos carnês foi iniciada.</strong></p>
<p><small>
  @foreach($msg as $mensagem)
  {{$mensagem}}<br>
  @endforeach</small>
</p>
<p><strong>Aguarde uma hora</strong> até que todas as <strong>{{count($msg)}}</strong> pessoas tenham seus carnês gerados.</p>
<p><small>Desde 2023 a geração global de boletos ocorre de forma assíncrona, para melhorar o desempenho do sistema e contornar algumas limitações.</small></p>

<a id="botao" href="#" onclick="history.back()" class="btn btn-primary">Voltar</a>

  
  </body>
</html>
@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

@endsection

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
    left: 45%;
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
            <p class="title-description">Completo.</p>
        </div>
    </div>
</div>
<div class="card card-block">
      <div class="row">
        <div class="col-md-1" style="width: 40px"><em class="fa fa-check-square-o" style="font-size: 20pt; color: green;"></em></div>
        <div class="col-md-11">
            <h3 class="title">Geração concluída com sucesso.</h3>
            <p class="title-description">Verifique os arquivos gerados</p>
            <br>
        </div>
      </div>
      <div class="form-group row"> 
        <label class="col-sm-2 form-control-label text-xs-right">
          Download 
        </label>
        <div class="col-sm-5"> 
         
          <div class="input-group"><a href="/download/{{str_replace('/','-.-','/documentos/carnes/carnes_'.date('Ymd').'.zip')}}">Clique Aqui para baixar o Zip</a></div>
          
        </div>
      </div>
      <div class="form-group row"> 
        <label class="col-sm-2 form-control-label text-xs-right">
          PDF's
        </label>
        <div class="col-sm-5"> 
          @foreach($carnes as $carne)
          <div class="input-group"><a href="/download/{{str_replace('/','-.-','/documentos/carnes/'.$carne)}}">{{$carne}}</a></div>
          @endforeach
        </div>
      </div>
      <div class="form-group row"> 
        <label class="col-sm-2 form-control-label text-xs-right">
          Remessas
        </label>
        <div class="col-sm-5"> 
          @foreach($remessas as $remessa)
          <div class="input-group"><a href="/download/{{str_replace('/','-.-','/documentos/remessas/'.$remessa)}}">{{$remessa}}</a></div>
          @endforeach
        </div>
      </div>

</div>
    
  
  </body>
</html>
@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

@endsection

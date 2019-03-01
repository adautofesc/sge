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
     <script type="text/javascript">

      @if($matriculas->hasMorePages())
      var next = true;
      @else
      var next = false;

      @endif
      function loadNext(){
        if(next){
          setTimeout(mudar('{{$matriculas->nextPageUrl()}}'), 2000);
        }
        else{
          
                setTimeout(mudar('./fase2'), 20000);
        }

      }
      function mudar(url='#'){
        /*
        if(url=='')
          url = '#';*/
        //alert('chamado no goTo>'+url);
        window.location.replace(url);
      }
        

    </script>
    
  </header>
  <body onload="loadNext();">

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
<div class="card card-block">
      <div class="row">
        <div class="col-md-1" style="width: 40px"><img src="{{asset('/img/loading.gif')}}" with="25px" height="25px"></div>
        <div class="col-md-11">
            <h3 class="title">Fase 1 - geração dos lançamentos</h3>
            <p class="title-description">O débitos de cada matrícula estão sendo gerados</p>
            <br>
        </div>
      </div>
      <div class="form-group row"> 
        <label class="col-sm-2 form-control-label text-xs-right">
          Lançamentos
        </label>
        <div class="col-sm-5"> 
          <div class="input-group">
           <div id="progressbar"><div class="progress-label">{{ceil($matriculas->currentPage()*100/$matriculas->lastPage())}}%</div></div>
          </div>
        </div>
      </div>

       <div class="form-group row"> 
        <label class="col-sm-2 form-control-label text-xs-right">
          Boletos
        </label>
        <div class="col-sm-5"> 
          <div class="input-group">
           <div id="progressbar2"><div class="progress-label">Aguardando...</div></div>
          </div>
        </div>
      </div>
      <div class="form-group row"> 
        <label class="col-sm-2 form-control-label text-xs-right">
          Arquivo PDF
        </label>
        <div class="col-sm-5"> 
          <div class="input-group">
           <div id="progressbar3"><div class="progress-label">Aguardando...</div></div>
          </div>
        </div>
      </div>
      <div class="form-group row"> 
        <label class="col-sm-2 form-control-label text-xs-right">
          Arquivo CSV
        </label>
        <div class="col-sm-5"> 
          <div class="input-group">
           <div id="progressbar4"><div class="progress-label">Aguardando...</div></div>
          </div>
        </div>
      </div>
      <div class="form-group row"> 
        <label class="col-sm-2 form-control-label text-xs-right">
          Confirmando
        </label>
        <div class="col-sm-5"> 
          <div class="input-group">
           <div id="progressbar5"><div class="progress-label">Aguardando...</div></div>
          </div>
        </div>
      </div>
      <div class="form-group row"> 
        <label class="col-sm-2 form-control-label text-xs-right">
          Remessa
        </label>
        <div class="col-sm-5"> 
          <div class="input-group">
           <div id="progressbar6"><div class="progress-label">Aguardando...</div></div>
          </div>
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
  <script>
  $( function() {
    $( "#progressbar" ).progressbar({
      value: {{ceil($matriculas->currentPage()*100/$matriculas->lastPage())}}
    });
    $( "#progressbar2" ).progressbar({
      value: 0
    });
     $( "#progressbar3" ).progressbar({
      value: 0
    });
      $( "#progressbar4" ).progressbar({
      value: 0
    });
       $( "#progressbar5" ).progressbar({
      value: 0
    });
        $( "#progressbar6" ).progressbar({
      value: 0
    });
  } );
  </script>
@endsection

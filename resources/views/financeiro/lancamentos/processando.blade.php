<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <title>Gerando Lançamentos...</title>
    <style type="text/css">
    	body{
    		font-family: tahoma;
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
    			alert('Processamento completo')
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
  </head>
  <body onload="loadNext();">

    <!-- conteúdo da página -->
    <h1>Gerando lançamentos...</h1>
    <h5>Processando página {{$matriculas->currentPage()}} de {{$matriculas->lastPage()}}.</h5>
    <img src="{{asset('/img/loading.gif')}}" with="25px" height="25px">
  
  </body>
</html>
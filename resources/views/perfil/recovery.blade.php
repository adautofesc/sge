<!doctype html>
<html lang="br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="{{asset('fonts/icomoon/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Style -->
    <link rel="stylesheet" href="{{asset('css/login_perfil.css')}}">
    <style>
        .title{
            color:black;
        }
        #error{
          display: none;
        }
        .top{
          margin-top:2rem;
        }
        
    </style>

    <title>Login Perfil FESC</title>
  </head>
  <body>
  

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('{{asset('img/DJI_0063.webp')}}');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row  justify-content-center">
           
          <div class="col-md-7 top">
            <h3>Login em <strong>PefilFESC</strong></h3>
            <p class="mb-4">&nbsp;</p>
            <p class="mb-4"><strong> Sua senha pode ser modificada através de um link que acabamos de enviar para o e-mail "{{$email}}". <br></strong></p>           
            <p>Caso tiver algum problema para acessá-lo contate-nos pelo telefone: (16) 3362-0580</p>
            @if($errors->any())
            @foreach($errors->all() as $erro)
                <div class="alert alert-danger" >
                        <button type="button" class="close" data-dismiss="alert" >×</button>       
                        <p class="text-secondary"> {{$erro}}</p>
                </div>
            @endforeach
            @endif
           
           
              <input type="reset" value="Voltar" class="btn btn-block btn-primary" onclick="javascript:history.back(-2)">
              

            
          </div>
        </div>
      </div>
    </div>

    
  </div>
    
    

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
 

  </body>
</html>
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
    <div class="bg order-1 order-md-2" style="background-image: url('{{asset('img/fesc_high.jpg')}}');"></div>
    <div class="contents order-2 order-md-1">
      <div class="container">
        <div class="row top justify-content-center">    
          <div class="col-md-7">
            <h3>Login em <strong>PefilFESC</strong></h3>
            <p class="mb-4"> Estamos quase lá, agora insira sua senha.</p>
            <div id="error"  class="alert alert-danger hide" role="alert" >
              <strong>Falha</strong>: senha inválida.
            </div>
            @if($errors->any())
            @foreach($errors->all() as $erro)
                <div class="alert alert-danger" >
                        <button type="button" class="close" data-dismiss="alert" >×</button>       
                        <p class="text-secondary"> {{$erro}}</p>
                </div>
            @endforeach
        @endif
            <form method="POST" action="?">
              <div class="form-group first">
                <label for="username">Senha</label>
                <input type="password" class="form-control"  name="senha" id="senha" maxlength="20" max-size="20" minlength='6' required>
              </div> 
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Lembre me</span>
                  <input type="checkbox" readonly="readonly"/>
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="/perfil/recuperar-senha/{{$cpf}}" class="forgot-pass" title="Para recuperar a senha preencha o CPF">Esqueci a senha</a></span> 
              </div>
              <input type="submit" value="Acessar" class="btn btn-block btn-primary" >
              <input type="reset" value="Limpar" class="btn btn-block btn-secondary">
              @csrf

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
  <script>
    $(function() {
      $(document).on('click', '.close', function() {
          $(this).parent().hide('slow');
      })
    });
     

  </script>

  </body>
</html>
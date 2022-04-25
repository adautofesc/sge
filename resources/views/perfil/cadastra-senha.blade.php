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
            <p class="mb-4"> Cadastre uma senha para completar seu acesso.</p>
            @if($errors->any())
            @foreach($errors->all() as $erro)
                <div class="alert alert-danger" >
                        <button type="button" class="close" data-dismiss="alert" >×</button>       
                        <p class="text-secondary"> {{$erro}}</p>
                </div>
            @endforeach
        @endif
            <form method="POST" action="/perfil/cadastrar-senha">
              <div class="form-group first">
                <label for="username">Primeiro nome</label>
                <input type="text" class="form-control"  name="nome"  maxlength="11" max-size="11" required>
              </div>
              <div class="form-group first">
                <label for="username">RG</label>
                <input type="text" class="form-control" name="rg"  maxlength="14" max-size="14" required>
              </div>
              <div class="form-group first">
                <label for="username">E-mail</label>
                <input type="email" class="form-control" name="email"  maxlength="150" max-size="150" required>
              </div>

              <div class="form-group last mb-3">
                <label for="password">Senha</label>
                <input type="password" class="form-control" name="senha"  minlength="6" maxlength="20" max-size="20" required >
              </div>

              <div class="form-group last mb-3">
                <label for="password">Confirme sua senha</label>
                <input type="password" class="form-control"  name="contrasenha" minlength="6" maxlength="20" max-size="20" required >
              </div>
              
            
            
              <br>
              <input type="hidden" name="pessoa" value="{{$pessoa}}"/>
              <input type="submit" value="Cadastrar" class="btn btn-block btn-primary" id="submit">
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
   $('#submit').on('click',function (){
     document.preventDefault();
     let senha = $('input[name=senha]').val();
     console.log(senha);
     

   });

 </script>
  </body>
</html>
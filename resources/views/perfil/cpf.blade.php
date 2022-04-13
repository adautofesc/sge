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
        <div class="row  justify-content-center"> 
          <div class="col-md-7 top">
            <h3>Login em <strong>PefilFESC</strong></h3>
            <p class="mb-4"> Nesta área você poderá alterar seus dados, fazer consultas de faltas, emitir certificados, cadastrar atestados, realizar matrículas, rematrículas e cadastrar seu currículo para parcerias.</p>
            <p class="mb-4">Para iniciar seu acesso entre com seu CPF, mesmo que ainda não tenha cadastro.</p>           
            <div id="error"  class="alert alert-danger hide" role="alert" >
              <strong>Falha</strong>: <span id="error_msg">CPF inválido.</span>
            </div>
            @if($errors->any())
              @foreach($errors->all() as $erro)
                <div class="alert alert-danger" >
                  <button type="button" class="close" data-dismiss="alert" >×</button>       
                  <p class="text-secondary"> {{$erro}}</p>
                </div>
              @endforeach
            @endif
            <form action="/perfil/autentica" onsubmit="return false;" method="get">
              <div class="form-group first">
                <label for="username">CPF</label>
                <input type="text" class="form-control"  name="cpf" id="cpf" title="Preencha para acessar ou cadastrar" required>
              </div>
              <br>
              <input type="submit" value="Avançar" class="btn btn-block btn-primary" onclick="ValidaCPF();">
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
      $(function() {

            $('.btn-link[aria-expanded="true"]').closest('.accordion-item').addClass('active');
            $('.collapse').on('show.bs.collapse', function () {
            $(this).closest('.accordion-item').addClass('active');
            });

            $('.collapse').on('hidden.bs.collapse', function () {
            $(this).closest('.accordion-item').removeClass('active');
            });
});
function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
function ValidaCPF(x){
           if(getCookie('we-love-cookies') != 1){
            $('#error_msg').html('É necessário aceitar a utilização de cookies clicando em "aceito" na barra abaixo.');
            $('#error').show('slow');
            setTimeout(function() {
                $("#error").hide("slow", function(){
                    console.log('cookie error')
                });				
                }, 9000);			
            return false;
           }
            
            numero = document.getElementById("cpf").value;
            numero = numero.replace(/\D/g,'');
            
            if(numero.length<9 || numero.length>11){
                $('#error_msg').html('Erro de CPF')
                $('#error').show('slow');
                document.getElementById("cpf").focus();                
                		
                setTimeout(function() {
                $(".alert").hide("slow", function(){
                    console.log('cpf lenght error')
                });				
                }, 2000);			
    
                return false;
            }
            for(i=0;i<10;i++){               
              if(numero == ''+i+i+i+i+i+i+i+i+i+i+i){
                $('#error').show('slow');
                document.getElementById("cpf").focus();                
                		
                setTimeout(function() {
                  $(".alert").hide("slow", function(){
                      console.log('cpf repetition')
                  });				
                }, 2000);	
                return false;
              }
            }
            window.location.href = '/perfil/autentica/'+numero;
        }
  
  </script>
  <script type="text/javascript" id="cookieinfo"
      data-message="Nós usamos cookies e outras tecnologias semelhantes. Você aceita a utilização destes recursos?"
      data-linkmsg=""
      data-bg="#fb771a"
      data-fg="#FFF"
      data-divlink="#000"
      data-close-text="Aceito" 
      data-divlinkbg="#ffffff"
      src="{{asset('/js/cookies.js')}}">
</script>
  </body>
</html>
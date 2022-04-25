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
        body{
          background-color: #f6f7fc;
        }
        .top{
          margin-top:2rem;
        }
        
        .fixo{
          position : fixed;
        }
        
    </style>

    <title>Login Perfil FESC</title>
  </head>
  <body>
  

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('{{asset('img/DJI_0063.webp')}}');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row top justify-content-center">
           
          <div class="col-md-7">
            
            <h3>Cadastro <strong>PefilFESC</strong></h3>
            <p class="mb-4"> Cadastre-se para matrículas, rematrículas, parcerias e consultas diversas.</p>
            @if($errors->any())
            @foreach($errors->all() as $erro)
                <div class="alert alert-danger" >
                        <button type="button" class="close" data-dismiss="alert" >×</button>       
                        <p class="text-secondary"> {{$erro}}</p>
                </div>
            @endforeach
        @endif
        <form method="POST" id="cadastro" action="/perfil/cadastrar-pessoa/{{$cpf}}" onsubmit="event.preventDefault(); return valida()">
            
          <div class="form-group first"> 
                <label >Nome/social</label>
                <input type="text" class="form-control" placeholder="Preencha o nome completo, sem abreviações." name="nome" required> 
            </div>

            <div class="form-group first"> 
              <label >Genero</label><br>
              <div class="form-control">
              <label >
                <input class="radio" name="genero" type="radio" value="M" required>
                <span>Masculino</span>&nbsp;
            </label>
            <label>
                <input class="radio" name="genero" type="radio" value="F" >
                <span>Feminino</span>&nbsp;
            </label>     
            <label>
                <input class="radio" name="genero" type="radio" value="Z" >
                <span>Não Binário</span>
            </label>  </div>
            </div> 

            <div class="form-group first"> 
              <label >Nascimento</label>
              <input type="date" class="form-control boxed" placeholder="dd/mm/aaaa" name="nascimento" required> 
            </div>
            <div class="form-group first"> 
              <label >Celular</label>
              <input type="tel" class="form-control boxed" placeholder="Somente numeros" name="telefone" minlength="11" maxlength="11">  
            </div>
          
            
            <div class="form-group first"> 
              <label >RG</label>
              <input type="text" class="form-control boxed"  name="rg" maxlength="10" required>   
            </div>
            <div class="form-group first"> 
              <label >CPF</label>
              <input type="text" class="form-control boxed"  name="cpf" value="{{$cpf}}" readonly="true" maxlength="14" required>
   
            </div>
            <div class="form-group first"> 
              <label >E-Mail</label>
              <input type="email" class="form-control boxed" name="email" required> 
   
            </div>
            <div class="form-group first"> 
              <label >CEP</label>
              <input type="text" class="form-control boxed" placeholder="00000-000" name="cep"  onkeyup="mycep();" required minlength="8" maxlength="9">
   
            </div>
            <div class="form-group first"> 
              <label >Logradouro</label>
              <input type="text" class="form-control boxed" placeholder="Rua, avenida, etc" name="rua" required> 
   
            </div>
            <div class="form-group first"> 
              <label >Numero</label>
              <input type="text" class="form-control " placeholder="Número" name="numero_endereco" maxlenght="4" required>  
            </div>
            <div class="form-group first"> 
              <label >Complemento</label>
              <input type="text" class="form-control boxed" placeholder="" name="complemento_endereco">   
            </div>
            
            <div class="form-group first"> 
              <label >Bairro</label>
              <input id="bairro" type="text" class="form-control boxed"  name="bairro_str" required>
            </div>

            <div class="form-group first"> 
              <label >Cidade</label>
              <input type="text" class="form-control boxed" placeholder="" name="cidade" value="São Carlos"> 
   
            </div>
            <div class="form-group first"> 
              <label >Estado</label>
              <select  class="form-control boxed"  name="estado" required> 
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espirito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MT">Mato Grosso</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP" selected="selected">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
            </select>
   
            </div>

              <div class="form-group last mb-3">
                <label for="password">Senha</label>
                <input type="password" class="form-control" name="senha" id="password" minlength="6" required>
              </div>
              <div class="form-group last mb-3">
                <label for="password">Redigite a senha</label>
                <input type="password" class="form-control" name="contrasenha" minlength="6" required>
              </div>
              <br>
              <input type="submit" value="Cadastrar" class="btn btn-block btn-primary" >
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

            $('.btn-link[aria-expanded="true"]').closest('.accordion-item').addClass('active');
            $('.collapse').on('show.bs.collapse', function () {
            $(this).closest('.accordion-item').addClass('active');
            });

            $('.collapse').on('hidden.bs.collapse', function () {
            $(this).closest('.accordion-item').removeClass('active');
            });



});

  </script>
  <script>
    function mycep(){
    var cep = $('[name=cep]').val();
    $('[name=rua]').val('Carregando dados a partir do CEP...');
    if(cep.length == 8 || cep.length==9){
        
        $.get("https://viacep.com.br/ws/"+cep+"/json/"+"/")
                .done(function(data) 
                {
                    if(!data.logradouro){
                        console.log(data);
                        $('[name=rua]').val('CEP não localizado');
                    }
                    else {
                        $('[name=rua]').val(data.logradouro);
                        $('[name=bairro_str]').val(data.bairro);
                        $('[name=bairro]').val(0);
                        $('[name=cep]').val(data.cep);
                        $('[name=cidade]').val(data.localidade);
                        $('[name=estado]').val(data.uf);
                    
                    }
                  

                })
                .fail(function() {
                    console.log('erro ao conectar com viacep');
                    $("#cepstatus").html('Erro ao conectar ao serviço de consulta de CEP');
                    $('[name=rua]').val('');

                });
    }

   
}
function valida(){
    
    if($('[name=senha]').val() == '123456'){
        alert('Senha não permitida, aumente a segurança inserindo letras.');
        $('[name=senha]').val('');
        $('[name=contrasenha]').val('');
        return false;

    }
        

    if($('[name=senha]').val() == $('[name=contrasenha]').val() ){
        
        $('#cadastro')[0].submit();
    }
    else{
        alert('Senha e contrasenha precisam ser iguais');
        $('[name=senha]').val('');
        $('[name=contrasenha]').val('');

        return false;

    }

        
}
</script>
 
  </body>
</html>
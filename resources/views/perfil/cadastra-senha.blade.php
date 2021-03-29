<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perfil Pessoal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        body, .row{
            background-color:WhiteSmoke;
        }
        h1 {margin-top:2rem;
            font-size:14pt;
            font-weight: bold;}
        .description{
            margin-top:2rem;
            font-size:12pt;
        }
        .form{
            margin-top:2rem;
        }
        .button{
            margin-top:.1rem;
        }
        .container-fluid{
            margin-top:5rem;
            background-color:white;
        
            
        }
        .col-md-5{
            background-color:white;
            -webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.38);
            -moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.38);
            box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.38);
            
        }
        
        
        
        
    </style>
   
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-md-center" >
            <div class="col-md-5">
                <h1>
                <img src="{{asset('img/chave.svg')}}" width="24px" alt="icone de chave">
                    Perfil FESC
                </h1>
                <noscript>
                    <!-- referência a arquivo externo -->
                    <div class="alert alert-danger"> Ative o javascript ou acesse o site de outro navegador.</div>
                </noscript>
                <p class="description">
                  
                    Agora complete os dados abaixo para cadastrar uma senha de acesso.

                </p>
                @if($errors->any())
                    @foreach($errors->all() as $erro)
                        <div class="alert alert-danger" onload="console.log('erro:{{$erro}}')">
                                <button type="button" class="close" data-dismiss="alert" >×</button>       
                                <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
                        </div>
                    @endforeach
                @endif

                <form method="POST" action="/perfil/cadastrar-senha">
                    
                    <div class="col-md-7 form-group form">
                        <label for="nome">Qual seu primeiro nome?</label>
                        <input type="text" class="form-control form-control-sm" name="nome"  maxlength="11" max-size="11" required>
                    </div>
                    <div class="col-md-7 form-group form">
                        <label for="rg">Qual seu RG? <small>Somente números</small></label>
                        <input type="number" class="form-control form-control-sm" name="rg"  maxlength="11" max-size="11" required>
                    </div>
                    <div class="col-md-7 form-group form">
                        <label for="senha">Agora digite uma senha. <small>De 6 a 20 caracteres</small> </label>
                        <input type="password" class="form-control form-control-sm" name="senha"  minlength="6" maxlength="20" max-size="20" required>
                    </div>
                    <div class="col-md-7 form-group form">
                        <label for="contrasenha">Confirme sua senha. </label>
                        <input type="password" class="form-control form-control-sm" name="contrasenha" minlength="6" maxlength="20" max-size="20" required>
                    </div>
                    <input type="hidden" name="pessoa" value="{{$pessoa}}"/>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-info" type="submit" name="btn" value="1">Continuar</button> 
					<button type="reset" name="btn"  class="btn btn-secondary">Limpar</button>
                	<button type="cancel" name="btn" class="btn btn-secondary" onclick="history.back(-2);return false;">Cancelar</button>
                    @csrf
                </form>
                <p>
                &nbsp;
                </p>
            

            </div>
        </div>     
    </div>
        
   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>

</html>
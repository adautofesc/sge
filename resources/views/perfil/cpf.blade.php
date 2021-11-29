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
        .col-md-8{
            background-color:white;
            -webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.38);
            -moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.38);
            box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.38);
            
        }
        
        
        
        
    </style>
    <script>
        function ValidaCPF(){
            
            numero = document.getElementById("cpf").value;
            
            if(numero.length<9 || numero.length>11 || numero=='11111111111'){
                alert("CPF Inválido");
                return false;
            }
            else{
                window.location.href = '/perfil/autentica/'+numero;
                //document.forms[0].submit();

            }


            
            //
        }
            
       
    </script>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-md-center" >
            <div class="col-md-8">
                <p class="text-center" >
                    <img src="{{asset('/img/matriculas_2021_01.jpg')}}" width="450rem">
                </p>
                <noscript>
                    <!-- referência a arquivo externo -->
                    <div class="alert alert-danger"> Ative o javascript ou acesse o site de outro navegador.</div>
                </noscript>
                <p class="description">
                    Bem-vindo! <br>
                    Esta área é dedicada à alunos, parceiros e colaboradores.<br>
                    Nela você poderá alterar seus dados, fazer consultas de faltas, emitir certificados, realizar matrículas, rematrículas e cadastrar seu currículo para parcerias.<br>
                </p>
                <p>
                    Caso desejar visualizar a lista de vagas disponíveis, <a href="https://vagas.fesc.com.br" target="_blank">clique aqui.</a>
                </p>
                @if($errors->any())
                    @foreach($errors->all() as $erro)
                        <div class="alert alert-danger" onload="console.log('pau')">
                                <button type="button" class="close" data-dismiss="alert" >×</button>       
                                <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
                        </div>
                    @endforeach
                @endif
                <form method="GET" action="/rematricula/autentica" onsubmit="return false;">
                <div class="row">
                    <div class="col-sm-5">
                        <label for="RegraValida">Para começar, digite seu CPF. <br><small>(somente números)</small></label>
                        <input type="number" class="form-control form-control-sm" name="cpf" id="cpf" maxlength="11" max-size="11">
                    </div>
                    
                    <div class="col-sm-7 align-self-end"><button onclick="ValidaCPF();" class="btn btn-info"> Continuar</button></div>
                </div>
                    
                    
                

                    
                    </form>
                <p>&nbsp;</p>
               
            

            </div>
        </div>     
    </div>
        
   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>

</html>
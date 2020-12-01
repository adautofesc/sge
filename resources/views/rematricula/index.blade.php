<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rematricula FESC 2021</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
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
    </style>
    <script>
        function ValidaCPF(){
            numero = $( "input[name=cpf]" ).val();
            if(numero.length<9 || numero.length>11 || numero=='11111111111'){
                alert("CPF Inválido");
                return false;
            }
            else{
                window.location.href = '/rematricula/autentica/'+numero;
                //document.forms[0].submit();

            }
            console.log(numero)

            
            //
        }
            
       
    </script>
</head>
<body>
    <div class="container">
        <h1><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bootstrap-reboot" fill="orange" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M1.161 8a6.84 6.84 0 1 0 6.842-6.84.58.58 0 0 1 0-1.16 8 8 0 1 1-6.556 3.412l-.663-.577a.58.58 0 0 1 .227-.997l2.52-.69a.58.58 0 0 1 .728.633l-.332 2.592a.58.58 0 0 1-.956.364l-.643-.56A6.812 6.812 0 0 0 1.16 8zm5.48-.079V5.277h1.57c.881 0 1.416.499 1.416 1.32 0 .84-.504 1.324-1.386 1.324h-1.6zm0 3.75V8.843h1.57l1.498 2.828h1.314L9.377 8.665c.897-.3 1.427-1.106 1.427-2.1 0-1.37-.943-2.246-2.456-2.246H5.5v7.352h1.141z"/>
          </svg>
          Rematrícula FESC 2021</h1>
          <noscript>
            <!-- referência a arquivo externo -->
            <div class="alert alert-danger"> Ative o javascript ou acesse o site de outro navegador.</div>
           </noscript>
        <div class="description">
            Agora você pode se rematricular nas disciplinas que fazia, sem sair de casa.<br>
            Basta preencher os campos abaixo e escolher as disciplinas que deseja continuar.<br>
            O contrato só será validado depois de entregue assinado na secretaria.
            
            
        </div>
        @if($errors->any())
            @foreach($errors->all() as $erro)
                <div class="alert alert-danger" onload="console.log('pau')">
                        <button type="button" class="close" data-dismiss="alert" >×</button>       
                        <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
                </div>
            @endforeach
        @endif

        <form method="GET" action="/rematricula/autentica" onsubmit="return false;">
            
            <div class="col-md-3 form-group form">
                <label for="RegraValida">CPF (somente números)</label>
                <input type="number" class="form-control form-control-sm" name="cpf" maxlength="11" max-size="11">
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Continuar" onclick="ValidaCPF();" class="btn btn-info">
           

    </div>
   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rematricula FESC 2021: autenticação</title>
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
</head>
<body>
    <div class="container">
        <h1><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-check" fill="#6aa6e3" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zm4.854-7.85a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
          </svg> 
          Autenticação</h1>
        <div class="description">
            Caro aluno(a), recisamos confirmar sua identidade.<br>
            Poderia por favor preencher os campos abaixo para podermos continuar?
            
            
        </div>
        @if($errors->any())
            @foreach($errors->all() as $erro)
                <div class="alert alert-danger" onload="console.log('pau')">
                        <button type="button" class="close" data-dismiss="alert" >×</button>       
                        <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
                </div>
            @endforeach
        @endif
        <form method="POST">
            {{ csrf_field() }}
            
            <div class="col-md-3 form-group form">
                <label for="RegraValida">Primeiro nome</label>
                <input type="text" class="form-control form-control-sm" name="nome" maxlength="50" max-size="50" required>
            </div>
            <div class="col-md-3 form-group form">
                <label for="RegraValida">RG<small> (somente números)</small></label>
                <input type="text" class="form-control form-control-sm" name="rg" maxlength="11" max-size="11" required>
            </div><!--
            <div class="col-md-3 form-group form">
                <label for="RegraValida">E-mail</label>
                <input type="email" class="form-control form-control-sm" name="email" maxlength="80" max-size="80">
            </div>-->
            &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Continuar"  class="btn btn-info">
        <input type="hidden" name="pessoa" value="{{$pessoa}}"/>
        </form>
           

    </div>
   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>

</html>
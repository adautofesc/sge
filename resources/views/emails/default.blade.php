<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css" rel="stylesheet" media="all">
 body{
        background-color: #edf2f7;
        font-family:helvetica;
        color:#3d4852;
        font-size:10pt;

    }
    #content{
        background-color: white;
        width:50em;
        margin:10%;
        padding:1%;
        float:both;
    }
    h1{
        font-size:12pt;
    }
</style>
</head>
<body>
    <div id="container">
        <div id="content">
            <h1>SGE INFORMA:</h1>
            <br>
            <p>Olá pessoal,</p>
            <br>
            <p>Gostaria de avisar que o sistema de autenticação foi atualizado para garantir mais segurança ao nosso sistema e proporcinar novas funcionalidades.<br>
                Porém, todos usuários tiveram suas senhas alteradas e alguns usuários também tiveram o nome de usuário alterado.</p>
            <p>Abaixo seguem os seus novos dados para efetuar login no sistema SGE:</p>
            <h5>Usuário: <strong>{{$username}}</strong></h5>
            <h5>Senha: <strong>{{$password}}</strong></h5>
            <p>Lembramos que todos de manter uma senha segura, pois os dados de nossos alunos e colegas podem ser expostos através de senhas inseguras. </p>
            <p>Sua senha poderá ser alterada como anteriormente.</p>
            <p><small><a href="https://sistema.fesc.com.br">Acesse o sistema por aqui.</a></small></p>
            <p><small>Cordialmente, Adauto.</small></p>


        </div>
    </div>
</body>
</html>
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
            <h1>Solicitação de troca de senha.</h1>
            <br>
            <p>Atenção</p>
            <br>
            <p>Houve uma solicitação para alteração de senha em seu perfil. Caso não tenha sido você, desconsidere este e-mail.</p>
            <p>Para redefinir sua senha, clique no link abaixo.</p>

            <h5><strong><a href="https://sge.fesc.com.br/perfil/resetar-senha/{{urlencode($token)}}"> Clique aqui para redefinir sua senha.</a></strong></h5>
            
            <p>Lembramos todos que é importante manter uma senha com letras e numeros aleatórios para garantir a segurança de seus dados. </p>
            <p>Sua senha poderá ser alterada como anteriormente.</p>
            <br>
            <p><small>Cordialmente, SGE.</small></p>


        </div>
    </div>
</body>
</html>
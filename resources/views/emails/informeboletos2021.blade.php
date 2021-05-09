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
 
            <p>Olá {{$nome}},</p>
            <br>
            <p>Gostariamos de avisar que seus boletos já estão disponíveis no <a href="https://sge.fesc.com.br/perfil" target="_blank"> perfil do aluno</a></p>
            <p>Também informamos que seu endereço de acesso às aulas é <strong>{{$username}}</strong>. A senha foi enviada através da plataforma da Microsoft. Verifique sua caixa de SPAM caso não tenha encontrado.</p>                   
            <p>Recomendamos que acesse pelo menos uma vez o site <a href="https://outlook.com">Outlook.com</a> com antecedência, para verificar que todos os dados estão corretos.</p>
            
            <p>Nós lhe desejamos boas vindas e que tenha um ótimo curso.</p>
            <p>Cordialmente, <br> Equipe FESC</p>


        </div>
    </div>
</body>
</html>
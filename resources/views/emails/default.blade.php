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
            <h1>FESC INFORMA:</h1>
            <br>
            <p>Olá {{$pessoa->nome}},</p>
            <br>
            <p>Gostaria de avisar que os boletos dos seus cursos já estão disponíveis no <a href="https//sge.fesc.com.br/perfil" target="_blank"> perfil do aluno</a></p>
            <p>Também informamos que os dados de acesso foram enviados para todos alunos através da plataforma da Microsoft. Verifique sua caixa de SPAM caso não tenha encontrado.</p>
            <p>Por motivo de segurança não armazenamos as senhas dos alunos, mas seu login de acesso é:</p>
            <h5>E-mail: <strong>{{$username}}</strong></h5>        
            <p>Recomendamos que acesse pelo menos uma vez o site <a href="https://outlook.com">Outlook.com</a> com antecedência, para verificar que você tem acesso à plataforma</p>
            <br>
            <p>Nós lhe desejamos boas vindas e que tenha um ótimo curso.</p>
            <p><small>Cordialmente, equipe FESC</small></p>


        </div>
    </div>
</body>
</html>
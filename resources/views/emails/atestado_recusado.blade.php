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
            
            <p>Caro aluno(a),</p>
            <br>
            <p>O atestado de número {{$atestado->id}} que você enviou não foi aprovado pelo seguine motivo:</p>
            <blockquote>"{{$motivo}}"</blockquote>
            <p>Por favor cadastre novamente o atestado corrigindo a(s) pendência(s) acima citada(s)</p>
            
            <p><small>Cordialmente, equipe FESC</small></p>


        </div>
    </div>
</body>
</html>
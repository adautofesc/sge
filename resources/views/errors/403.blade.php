<!doctype html>
<html class="no-js" lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> Sistema de Gestão Educacional - SGE FESC </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="{{ asset('css/vendor-min.css')}}">
        <!-- Theme initialization -->
        <script>
            var themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {};
            var themeName = themeSettings.themeName || '';
            if (themeName)
            {
                document.write('<link rel="stylesheet" id="theme-style" href="{{asset('/')}}css/app-' + themeName + '.css">');
               
            }
            else
            {
                document.write('<link rel="stylesheet" id="theme-style" href="{{asset('css/app.css')}}">');
            }
    
        </script>
        <style>
            .btn{
                box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19);
            }
        </style>
    </head>

    <body>
        <div class="app blank sidebar-opened">
            <article class="content">
                <div class="error-card global">
                    <div class="error-title-block">
                        <h1 class="error-title"><i class="fa fa-ban"></i></h1>
                        <h2 class="error-sub-title"> Sem permissão de acesso </h2>
                    </div>
                    <div class="error-container">
                        <p>Para acessar esse recurso você precisa se uma autorização específica. Comunique o responsável para adquirí-la</p>
                        <p><small>Error 403</small></p>
                        <a class="btn btn-primary" href="javascript:history.back(-1)"> <i class="fa fa-angle-left"></i> Voltar para página anterior. </a>
                    </div>
                </div>
            </article>
        </div>
      ]
       
      <script src="{{ asset('js/vendor-min.js') }}" ></script>
      <script src="{{ asset('js/app.js') }} "></script>
    </body>

</html>
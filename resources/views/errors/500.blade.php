<!doctype html>
<html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>SGE FESC </title>
        <meta name="description" content="error 500">
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
        <div class="main-wrapper">
            
                <div class="app blank sidebar-opened" id="sidebar-overlay"></div>
                <article class="content ">
                    <section class="section">
                        <div class="error-card global">
                            <div class="error-title-block">
                                <h1 class="error-title"><i class="fa fa-bug"></i></h1>
                                
                                <h2 class="error-sub-title"> Desculpe </h2>
                            </div>
                            <div class="error-container">
                                <p>O recurso que você está tentando acessar não está funcionando no momento, comunique o responsável.</p>
                                <p><small>Error 500</small></p>
                                <a class="btn btn-primary rounded" href="javascript:history.back(-1)"> <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Voltar para página anterior. </a>
                            </div>
                        </div>
                    </section>
                </article>
        </div>
        <!-- Reference block for JS -->
       
        <script src="{{ asset('js/vendor-min.js') }}" ></script>
        <script src="{{ asset('js/app.js') }} "></script>
    </body>

</html>

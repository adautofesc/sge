<!doctype html>
<html class="no-js" lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> Sistema de Gestão Educacional - SGE FESC </title>
        <meta name="description" content="Página de login do SGE da FESC">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="{{asset('css/vendor.css')}}">
        <!-- Theme initialization -->
        <script>
            var themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {};
            var themeName = themeSettings.themeName || '';
            if (themeName)
            {
                document.write('<link rel="stylesheet" id="theme-style" href="css/app-' + themeName + '.css">');
            }
            else
            {
                document.write('<link rel="stylesheet" id="theme-style" href="css/app.css">');
            }
        </script>
    </head>

    <body>
        <div class="auth">
            <div class="auth-container">
                <div class="card">
                    <header class="auth-header">
                        <h1 class="auth-title">
                            <div class="logo"> <span class="l l1"></span> <span class="l l2"></span> <span class="l l3"></span> <span class="l l4"></span> <span class="l l5"></span> </div> SGE <i>FESC</i></h1>
                    </header>
                    <div class="auth-content">

                        @include('inc.errors')

                        <h5 class="text-xs-center">Segunda via de boleto Online</h5>
                        <br>
                        <form id="login-form" action="" method="POST" novalidate="">
                        {{csrf_field()}}
                            <div class="form-group"> <label for="cpf">CPF</label> <input type="number" class="form-control underlined" name="cpf" id="cpf" max-size="11" placeholder="CPF sem pontos ou traços com 11 dígitos" required> </div>
                            <div class="form-group"> <label for="nascimento">Nascimento</label> <input type="text" class="form-control underlined" name="nascimento" id="nascimento" title="Sua data de nascimento completa ex. 01/01/1950" placeholder="00/00/0000" required> </div>
                            
                            <div class="form-group"> <button type="submit" class="btn btn-block btn-primary">Acessar</button>
                            @if(isset($nome))
                            <br>
                            <p>Entrar com login salvo:</p>
                            <button type="button" onclick="location.replace('/loginSaved');"class="btn btn-block btn-secondary">{{$nome}}</button> 
                            @endif


                            </div>
                            <div class="form-group">
                                <p class="text-muted text-xs-center">Após vencimento voce pode retirar a segunda via no <a href="https://www63.bb.com.br/portalbb/boleto/boletos/hc21e.bbx" target="_blank">site do Banco do Brasil.</a></p>
                                <p><small>Atualizado em 12/04/2018</small></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
        <script>
            (function(i, s, o, g, r, a, m)
            {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function()
                {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-80463319-2', 'auto');
            ga('send', 'pageview');
        </script>
        <script src="{{asset('js/vendor.js')"></script>
        <script src="{{asset('js/app.js')"></script>
    </body>

</html>
<!doctype html>
<html class="no-js" lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> SGE FESC</title>
        <meta name="description" content="Sistema de Gestão Educacional da FESC">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="css/vendor.css">
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
                             Sistema de Gestão
                        </h1>
                    </header>
                    <div class="auth-content">
                        <p class="text-xs-center">Preencha dos dados para prosseguir.</p>
                        <form id="login-form" action="/index.html" method="GET" novalidate="">
                            <div class="form-group"> <label for="usernamex">Nome de Usuário</label> <input type="text" class="form-control underlined" name="usernamex" id="usernamex" placeholder="Digite aqui seu login" required> </div>
                            <div class="form-group"> <label for="password">Senha</label> <input type="password" class="form-control underlined" name="password" id="password" placeholder="digite aqui sua senha" required> </div>
                            <div class="form-group"> <label for="remember">
            <input class="checkbox" id="remember" type="checkbox">
            <span>Lembrar senha</span>
          </label> <a href="reset.html" class="forgot-btn pull-right">Esqueceu a senha?</a> </div>
                            <div class="form-group"> <button type="submit" class="btn btn-block btn-primary">Login</button> </div>
                            <div class="form-group">
                                <p class="text-muted text-xs-center">Não tem cadastro?? <a href="signup.html">Solicitar</a></p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-xs-center">
                    <a href="index.html" class="btn btn-secondary rounded btn-sm"> <i class="fa fa-arrow-left"></i> Back to dashboard </a>
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
        <script src="js/vendor.js"></script>
        <script src="js/app.js"></script>
    </body>

</html>

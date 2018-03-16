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

    <body  >
        <div class="auth" >
            <div class="auth-container" style="width:40em;">
                <div class="card">
                    <header class="auth-header">
                        <h1 class="auth-title">
                            <div class="logo" > 
                                <span class="l l1"></span> <span class="l l2"></span> <span class="l l3"></span> <span class="l l4"></span> <span class="l l5"></span> 
                            </div> SGE <i>FESC</i> </h1>
                            
                    </header>
                    <div class="auth-content">

                        @include('inc.errors')

                        <h5 class="text-xs-center">Segunda via de boleto Online</h5>
                        <br>
                        <h3 class="text-xs-center"><b>{{$nome}}</b></h3>
                        <br>
                        <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Numero</th>
                          <th scope="col">Vencimento</th>
                          <th scope="col">Valor</th>
                          <th scope="col">Estado</th>
                          <th scope="col">Imprimir</th>
                        </tr>
                      </thead>
                      <tbody>
                     @foreach($boletos as $boleto)

                        <tr>
                          <th scope="row">{{$boleto->id}}</th>
                          <td>{{\Carbon\Carbon::parse($boleto->vencimento)->format('d/m/Y')}}</td>
                          <td>R$ {{number_format($boleto->valor,2,',','.')}}</td>
                          <td>{{$boleto->status}}</td>
                          <td class="text-xs-center"><a href="{{asset('/boleto').'/'.$boleto->id}}" target="_blank"><i class="fa fa-print"></i></a></td>
                        </tr>
                    @endforeach
                      </tbody>
                    </table>
                    <p> Qualquer divergência de valores entre em contato conosco: 3372-1308.
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
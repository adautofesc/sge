
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

                    
                        <p class="text-xs-center alert-info">As credenciais de acesso foram atualizadas, verifique seu e-mail para obtê-las</p>
                        <form method="POST" action="{{ route('login') }}">
                        {{csrf_field()}}
                            <div class="form-group"> <label for="username">Login</label> 
                                <!--<input type="text" class="form-control underlined" name="login" id="username" placeholder="Digite aqui seu nome de usuário" required> -->
                                <input id="username" type="text" class="form-control underlined " name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                            </div>
                            <div class="form-group "> <label for="password">Senha</label> 
                                <!--<input type="password" class="form-control underlined" name="senha" id="password" placeholder="Sua senha" required> -->
                                <input id="password" type="password" class="form-control underlined @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            </div>
                            <div class="form-group"> 
                                <label for="remember">
                                    <input class="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> 
                                    <span>Lembrar</span>
                                </label> 
                               
                                @if (Route::has('password.request'))
                                    <a class="forgot-btn pull-right" href="{{ route('password.request') }}">
                                        {{ __('Esqueceu a senha?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="form-group"> 
                                <button type="submit" class="btn btn-block btn-primary">Entrar</button>
                            </div>
                            <div class="form-group">
                                <p class="text-muted text-xs-center">Não tem cadastro? Solicite na FESC 1</p>
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


    </body>

</html>
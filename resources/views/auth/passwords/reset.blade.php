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
                document.write('<link rel="stylesheet" id="theme-style" href="../../css/app-' + themeName + '.css">');
            }
            else
            {
                document.write('<link rel="stylesheet" id="theme-style" href="../../css/app.css">');
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

                        <p class="text-xs-center">Redefinição de senha por e-mail.</p>
                        <form method="POST" action="{{ route('password.update') }}">
                        {{csrf_field()}}
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group"> 
                                <label for="email">E-mail</label> 
     
                                <input id="email" type="text" class="form-control underlined @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Digite aqui seu e-mail institucional" autofocus>
                            </div>
                            <div class="form-group"> 
                                <label for="password">Senha</label> 
                                
                                <input id="password" type="password" class="form-control underlined @error('password') is-invalid @enderror" name="password"  required autocomplete="new-password" placeholder="Minimo 8 caracteres">
                            </div>
                            <div class="form-group"> 
                                <label for="email">Confime a senha</label> 
                              
                                <input id="password-confirm" type="password" class="form-control underlined" name="password_confirmation" required autocomplete="new-password">
                                
                            </div>
                            <div class="form-group"> <button type="submit" class="btn btn-block btn-primary">Redefinir senha</button> </div>
                            <div class="form-group">
                                <small>
                                <p class="text-muted text-xs-center"> Caso você não tenha cadastrado um endereço de E-mail, terá que comparecer na FESC 1, levando um documento com foto.</p></small>
                                <p class="text-muted text-xs-center">Lembrou da senha? <a href="javascript:history.back(-1)">voltar</a></p>
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

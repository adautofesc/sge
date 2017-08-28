<!doctype html>
<html class="no-js" lang="pt-br">
    @include('layout.header')
    <body>
        <div class="main-wrapper">
            <div class="app" id="app">
                @include('layout.top')
                @include('layout.menu')
                <div class="content items-list-page">

                @yield('pagina')  <!-- Aqui vem o código da página -->

                </div>
            </div>
        </div>
        @include('layout.bottom')
        @include('layout.footer')
        @yield('scripts')
    </body>
</html>

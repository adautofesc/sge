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
        <div class="main-wrapper">
            <div class="app" id="app">
                <div class="sidebar-overlay" id="sidebar-overlay"></div>
                <article class="content error-500-page">
                    <section class="section">
                        <div class="error-card">
                            <div class="error-title-block">
                                <h1 class="error-title">500</h1>
                                <h2 class="error-sub-title"> Erro interno. </h2>
                            </div>
                            <div class="error-container">
                                <p>Sistema em manutenção. Aguarde uns instantes.</p>
                                
                            </div>
                        </div>
                    </section>
                </article>
            </div>
        </div>
    </body>

             

</html>

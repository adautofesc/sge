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
                <? include "side_menu.php"; ?>
 <!-- Tipo da página******************************************************** -->                   
               <article class="content item-editor-page">
<!-- Tipo da página********************************************************  início conteúdo-->           	


                    <div class="title-block">
                        <h3 class="title"> Confirme os cursos<span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                    <div class="subtitle-block">
                        <h3 class="subtitle"><small>Matrícula de:</small> Adauto Junior</h3>
                    </div>
                    <div class="card card-block">
                                        <!-- Nav tabs -->
                                        <div class="card-title-block">
                                            <h3 class="title"> Esta é sua programação atual: </h3>
                                        </div>
                                        <!-- Tab panes -->
                                        <div class="row">
                                        	<div class="col">
                                        		<div class="title">Dom.</div>
                                        		
                                        	</div>
                                        	<div class="col" >
                                        		<div class="title">Seg.</div>
                                        		<div class="box-placeholder">9:00 ~ 9:50<br>Alongamento<br><small>Adilson</small></div>
                                        		<div class="box-placeholder">9:00 ~ 10:00<br>Alongamento<br><small>Adilson</small></div>
                                        	</div>
                                        	<div class="col">
                                        		<div class="title">Ter.</div>
                                        		<div class="box-placeholder">9:00<br>Alongamento<br><small>Adilson</small></div>
                                        	</div>
                                        	<div class="col">
                                        		<div class="title">Qua.</div>
                                        	</div>
                                        	<div class="col">
                                        		<div class="title">Qui.</div>
                                        	</div>
                                        	<div class="col">
                                        		<div class="title">Sex.</div>
                                        	</div>
                                        	<div class="col">
                                        		<div class="title">Sab.</div>
                                        	</div>
                                        </div>
                                    </div>
                    
                   
                    <div class="card-block">
                    	<a class="btn btn-primary" href="matriculas_finaliza.php">Finalizar Matrícula</a>
                    	
                    	<a class="btn btn-secondary" href="matriculas_descontos.php">Descontos</a>
                    </div>
					</section>
                  
                

<!-- ------------------------------------------------------------------------- fim conteúdo------- -->
                </article>
                <? include "footer.php";?>
<!-- *********************************************** Footer  abaixo os modals -->                
              
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog --> 
            </div><!-- .app -->
        </div><!-- .wrapper -->
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
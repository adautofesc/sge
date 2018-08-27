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
                        <h3 class="title"> Atendimento ao aluno<span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                    <form name="item">
                        <div class="card card-block">
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Nome e/ou CPF
								</label>
								<div class="col-sm-8"> 
									<input type="search" list="nomes" class="form-control boxed" placeholder=""> 
									<datalist id="nomes" style="display:hidden;">
										<option value="324000000000 Adauto Junior 10/11/1984 id:0000014">
										<option value="326500000000 Fulano 06/07/1924 id:0000015">
										<option value="3232320000xx Beltrano 20/02/1972 id:0000016">
										<option value="066521200010 Ciclano 03/08/1945 id:0000017">
										
									</datalist>
									<input type="hidden" name="id_pessoa">
								</div>
							</div>
							
							
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									
								</label>
								<div class="col-sm-8"> 
									<a href="pessoas_aluno_atendimento.php" class="btn btn-primary">Procurar</a> 
									<a href="pessoas_add.php" class="btn btn-secondary">Cadastrar Aluno</a> 
								
									<!-- 
									<button type="submit" class="btn btn-primary"> Cadastrar</button> 
									-->
								</div>
							</div>
							
                        </div>
                    </form>
                </article>

<!-- ------------------------------------------------------------------------- fim conteúdo------- -->
                </article>
                <? include "footer.php";?>
<!-- *********************************************** Footer  abaixo os modals -->                
                
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
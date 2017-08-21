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
                        <h3 class="title"> Efetivação de Matrícula <span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                    <div class="subtitle-block">
						 As vagas nas turmas já estão reservadas e o nome cadastrado nas listas de chamada. Porém a matrícula deve ser efetivada (assinatura do contrato, da matrícula e satisfação dos requisitos) o mais breve possível. 
								</div>
                    <form name="item">
                        <div class="card card-block">
                        	<div class="subtitle-block">
									<p>Adauto I O Junior</p>
									<p>Matricula 0123321 de 15/07/2017 por Fabio R.</p>
								</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Atestado:
								</label>
								
								   <a href="disciplinas_show.php?" class="btn btn-primary">Entregar atestado</a> ou 023323 - Entregue em 31/07/2017 para Debora R. 
								
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Imagem
								</label>
								<a href="matriculas_termo_imagem.php" target="_blank" class="btn btn-primary">Imprimir termo de cessão de imagem</a>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Contrato
								</label>
								<a href="matriculas_contrato.php" target="_blank" class="btn btn-primary">Imprimir Contrato</a>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Matrícula
								</label>
								<a href="matriculas_termo_matricula.php" target="_blank" class="btn btn-primary">Imprimir Matrícula</a>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Efetivar 
								</label>
								<a href="disciplinas_show.php?" class="btn btn-primary">Efetivar Matrícula</a>
							</div>
							
								
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
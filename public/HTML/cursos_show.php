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
                        <h3 class="title">
                        	 Curso: Qualidade de vida
                        	 <span class="sparkline bar" data-type="bar"></span> 
                        </h3>
                    </div>
                    <form name="item">
                        <div class="card card-block">
							
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Programa
								</label>
								<div class="col-sm-10"> 
									<span>Nome do Programa</span> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Descrição
								</label>
								<div class="col-sm-10"> 
									<span>Aqui vai a descrição do curso que eu não sei muito bem o que dizer, mas tenho que escrever até completar o tamanho do campo, pra eu saber como está a quebra de linha</span>
								</div>
							</div>
							
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Carga horária
								</label>
								<div class="col-sm-4"> 
									<span>00 horas</span> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Bolsas Oferecidas
								</label>
								<div class="col-sm-4"> 
									<span>05</span> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Valor
								</label>
								<div class="col-sm-4"> 
									<span>R$ 100,00</span>
								</div>
							</div>
							

                            <div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Disciplinas obrigatórias</label>
                                <div class="col-sm-10"> 
									<div>
							
										<span>Disciplina obrigatória 1 (00hs)</span>
									</div>
									<div>
									
										<span>Disciplina obrigatória 2 (00hs)</span>
									</div>
									<div>
									
										<span>Disciplina obrigatória 3 (00hs)</span>
									</div>
									<div>
									
										<span>Disciplina obrigatória 4 (00hs)</span>
									</div>
									<div>
									
										<span>Disciplina obrigatória 5 (00hs)</span>
									</div>
			                	</div>
                                    
                            </div>
                            <div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Disciplinas optativas</label>
                                <div class="col-sm-10"> 
									<div>
										
										<span>Disciplina optativa 1 (00hs)</span>
									</div>
									<div>
										
										<span>Disciplina optativa 2 (00hs)</span>
									</div>
									<div>
										
										<span>Disciplina optativa 3 (00hs)</span>
									</div>
									
			                	</div>
                                    
                            </div>
                            <div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Requisitos</label>
                                <div class="col-sm-10"> 
									<div>
										<i class="fa fa-flag"></i>
										<span> Atestado saúde</span>
									</div>
									<div>
										<i class="fa fa-flag-o"></i>
										<span>Ter feito módulo anterior</span>
									</div>
			                	</div>
                                    
                            </div>
                            <div class="form-group row">
								<div class="col-sm-10 col-sm-offset-2"> 
									<i class="fa fa-flag"></i>
									<span> Requisito Obrigatório</span>
									<i class="fa fa-flag-o"></i>
									<span>Requisito Recomendado</span>
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
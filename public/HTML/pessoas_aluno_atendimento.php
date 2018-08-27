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
                        <h3 class="title"> Adauto Junior (Adauto Junior)<span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                    <div class="subtitle-block">
                        <h3 class="subtitle"> Dados Gerais <a href="pessoas_show.php" class="btn btn-secondary btn-sm rounded-s">
							Ver Dados completos
							</a>
						</h3>
                    </div>
                    <form name="item">
                        <div class="card card-block">
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Gênero
								</label>
								<div class="col-sm-2"> 
									Masculino
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Nascimento
								</label>
								<div class="col-sm-2"> 
									30/05/1984
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Idade
								</label>
								<div class="col-sm-2"> 
									32 anos
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Telefone 1
								</label>
								<div class="col-sm-2"> 
									(16)3372-1308
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Telefone 2
								</label>
								<div class="col-sm-2"> 
									(16)3372-1308
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									CPF
								</label>
								<div class="col-sm-2"> 
									33721308
								</div>
							</div>
							
							
                        </div>
                        <div><br></div>
                        <div class="subtitle-block">
                        	<h3 class="subtitle"> Opções de atendimento	</h3>
                    	</div>
						<section class="section">
							<div class="row">
								<div class="col-xl-4 center-block">
									<div class="card card-primary">
										<div class="card-header">
											<div class="header-block">
												<p class="title" style="color:white">Matrículas</p>
											</div>
										</div>
										<div class="card-block">
											<div><a href="matricula_cursos_disponiveis.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-plus-circle "></i>  Nova Matrícula</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-check-square-o"></i> Efetivar Matrícula</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-times-circle"></i> Cancelar Matrícula</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-times"></i> Cancelar curso</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-print"></i> Impressão</a></div>
										</div>
										
									</div>
								</div>	
								<div class="col-xl-4 center-block">	
									<div class="card card-primary">
										<div class="card-header">
											<div class="header-block">
												<p class="title" style="color:white">Financeiro</p>
											</div>
										</div>
										<div class="card-block">
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-usd "></i>  Extrato</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-barcode"></i> 2a Via de Boleto</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-money"></i> Pagamento</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-fire-extinguisher"></i> Resolução de problemas</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-reply"></i> Estorno</a></div>
										</div>
										
									</div>
								</div>
								<div class="col-xl-4 center-block">	
									<div class="card card-primary">
										<div class="card-header">
											<div class="header-block">
												<p class="title" style="color:white">Acadêmico</p>
											</div>
										</div>
										<div class="card-block">
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-archive "></i>  Histórico</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-external-link"></i> Declarações</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-heart"></i> Entrega de atestado</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-certificate"></i> Certificados</a></div>
											<div><a href="pessoas_add.php" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-book"></i> Relação de Faltas</a></div>
										</div>
										
									</div>
								</div>
							</div>
						</section>
					
                    </form>
                

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
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
                        <h3 class="title"> Cadastrando novo CURSO<span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                    <form name="item">
                        <div class="card card-block">
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Nome
								</label>
								<div class="col-sm-10"> 
									<input type="text" class="form-control boxed" placeholder=""> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Programa
								</label>
								<div class="col-sm-10"> 
									<select class="c-select form-control boxed">
										<option selected>Selecione um programa</option>
										<option value="1">EMG</option>
										<option value="2">PID</option>
										<option value="3">UATI</option>
										<option value="4">UNIT</option>
									</select> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Descrição
								</label>
								<div class="col-sm-10"> 
									<textarea rows="4" class="form-control boxed"></textarea> 
								</div>
							</div>
							
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Carga horária
								</label>
								<div class="col-sm-4"> 
									<input type="text" class="form-control boxed" placeholder="Horas"> 
								</div>
									<label class="col-sm-2 form-control-label text-xs-right">
									Bolsas Oferecidas
								</label>
								<div class="col-sm-4"> 
									<input type="text" class="form-control boxed" placeholder="Opcional - qnde maxima de bolsas"> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Valor
								</label>
								<div class="col-sm-3"> 
									<div class="input-group">
										 <span class="input-group-addon">R$</span>
										 <input type="text" class="form-control" placeholder="" style="text-align: right"> 
										 <span class="input-group-addon">,00</span> 
									</div>
								</div>
							</div>
							

                            <div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Requisitos</label>
                                <div class="col-sm-10"> 
									<div>
										<label>
										<input class="checkbox" type="checkbox">
										<span>Atestado saúde</span>
										</label>
									</div>
									<div>
										<label>
										<input class="checkbox" type="checkbox">
										<span>Ter feito módulo anterior</span>
										</label>
									</div>
									<div>
										<label>
										<input class="checkbox" type="checkbox">
										<span>Smartphone Android 4 ou superior</span>
										</label>
									</div>
			                	</div>
                                    
                            </div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label text-xs-right"></label>
								<div class="col-sm-10 col-sm-offset-2"> 
									<a href="cursos_show.php" class="btn btn-primary">Cadastrar</a>
									<a href="cursos_add.php" class="btn btn-secondary">Cadastrar e adicionar mais um</a>
									<a href="cursos_add_disciplinas.php" class="btn btn-secondary">Cadastrar disciplinas do curso</a>
									<!--
									<button type="submit" class="btn btn-primary">Cadastrar e escolher disciplinas obrigatórias</button> 
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
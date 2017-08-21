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
                        <h3 class="title"> Descontos <span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                    <div class="subtitle-block">
									Todos os dados aqui serão analisados pelo setor competente.</br> O(a) tendente se responsabiliza pela veracidade das informações fornecidas.
								</div>
                    <form name="item">
                        <div class="card card-block">
                        	<div class="subtitle-block">
									<p>Adauto I O Junior</p>
									<p>Saldo atual: R$ 400,00 ou 4X R$400,00</p>
								</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Bolsa
								</label>
								<div class="col-sm-6"> 
								   Autorizada (100%) 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Promoção
								</label>
								<div class="col-sm-6"> 
									<select class="c-select form-control boxed">
										<option selected>Selecione para ativar</option>
										<option value="1">Convide um amigo e ganhe 10% na matrícula</option>
										<option value="2">Piscina com 10% para alunos de outros cursos</option>
										<option value="3">Rematrícula</option>
									</select> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Casos especiais
								</label>
								<div class="col-sm-6"> 
									<select class="c-select form-control boxed">
										<option selected>Selecione para ativar</option>
										<option value="1">Aluno da EMG (precisa estar no cadastro)</option>
										<option value="2">Parceria (precisa estar autorizado pela parceria)</option>
										<option value="3">Encaminhamento (será verificado pela administração)</option>
									</select> 
								</div>
							</div>
							
							
							<div class="form-group row"> 
								
								<label class="col-sm-2 form-control-label text-xs-right">
									Porcentagem
								</label>
								<div class="col-sm-2"> 
									<div class="input-group">
										<span class="input-group-addon">% </span> 
										<input type="number" class="form-control boxed" placeholder=""> 
									</div>
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Valor
								</label>
								<div class="col-sm-2"> 
									<div class="input-group">
										<span class="input-group-addon">R$</span> 
										<input type="number" class="form-control boxed" placeholder=""> 
									</div>
								</div>
								
							</div>
                                
							<div class="form-group row">
								<div class="col-sm-10 col-sm-offset-2">
									<a href="disciplinas_show.php?" class="btn btn-primary">Finalizar Matrícula</a> 
									<a href="pessoas_aluno_atendimento.php" class="btn btn-secondary">Cancelar</a> 
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
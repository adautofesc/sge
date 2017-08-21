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
				<form name="item">

                    <div class="title-block">
                        <h3 class="title"> Fulano de Tal<span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                   
                    <div class="subtitle-block">
                        <h3 class="subtitle"> Dados Gerais </h3>
                    </div>
                    
                        <div class="card card-block">
                        	
							
							<div class="form-group row">
								
								<label class="col-sm-2 form-control-label text-xs-right">Nascimento</label>
								<div class="col-sm-3">
									10/11/1984 (32 anos)
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">Telefone</label>
								<div class="col-sm-3"> 
									(16) 9 9822-5566
								</div>
							</div>
								
							
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Gênero</label>
                                <div class="col-sm-10"> 
                                	Masculino
		                		</div>
                            </div>
                            
                            <div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Nome Social</label>
								<div class="col-sm-10"> 
									
								</div>
							</div>    
                                
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">RG</label>
								<div class="col-sm-3"> 
									000.000.000 / 0 
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">CPF</label>
								<div class="col-sm-3"> 
									<a href="#">000.000.000-00</a> (Responsável)
								</div>
								
								
							</div>                                
                        </div>
                        <div class="subtitle-block">
	                        <h3 class="subtitle"> Dados de contato </h3>
                    	</div>
                    	<div class="card card-block">
                    		<div class="form-group row">
                    			<label class="col-sm-2 form-control-label text-xs-right">E-mail</label>
								<div class="col-sm-4"> 
									Fulano@provedor.com.br 
								</div>	
                    		</div>
                    		<div class="form-group row">
                    			<label class="col-sm-2 form-control-label text-xs-right">Telefone alternativo</label>
								<div class="col-sm-4"> 
									(16) 3373 - 4844 
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">Telefone de um contato</label>
								<div class="col-sm-4"> 
										(16) 3373 - 4844 
								</div>
                    		</div>
                    		<div class="form-group row">
                    			<label class="col-sm-2 form-control-label text-xs-right">Logradouro</label>
								<div class="col-sm-10"> 
									Rua São Sebastião
								</div>	
                    		</div>
                    		<div class="form-group row">
                    			<label class="col-sm-2 form-control-label text-xs-right">Número</label>
								<div class="col-sm-4"> 
									2828
								</div>	
								<label class="col-sm-2 form-control-label text-xs-right">Complemento</label>
								<div class="col-sm-4"> 
									
								</div>	
                    		</div>
                    		<div class="form-group row">
                    			<label class="col-sm-2 form-control-label text-xs-right">Bairro</label>
								<div class="col-sm-4"> 
									Vila Nery
								</div>	
								<label class="col-sm-2 form-control-label text-xs-right">CEP</label>
								<div class="col-sm-4"> 
									13560-000
								</div>	
                    		</div>
                    		<div class="form-group row">
                    			<label class="col-sm-2 form-control-label text-xs-right">Cidade</label>
								<div class="col-sm-4"> 
									São Carlos
								</div>	
								<label class="col-sm-2 form-control-label text-xs-right">Estado</label>
								<div class="col-sm-4"> 
									São Paulo
								</div>	
                    		</div>
                    	</div>
                    

						<div class="subtitle-block">
                        <h3 class="subtitle"> Dados Clínicos</h3>
                    	</div>
                        <div class="card card-block">
	                        <div class="form-group row"> 
									<label class="col-sm-4 form-control-label text-xs-right">Necesssidades especiais</label>
									<div class="col-sm-8"> 
										Não
									</div>
							</div>
							<div class="form-group row"> 
									<label class="col-sm-4 form-control-label text-xs-right">Medicamentos uso contínuo</label>
									<div class="col-sm-8"> 
										Não 
									</div>
							</div>
							<div class="form-group row"> 
									<label class="col-sm-4 form-control-label text-xs-right">Alergias</label>
									<div class="col-sm-8"> 
										Intolerância a lactose
									</div>
							</div>
							<div class="form-group row"> 
									<label class="col-sm-4 form-control-label text-xs-right">Doença crônica</label>
									<div class="col-sm-8"> 
										Nenhuma 
									</div>
							</div>
                        </div>
                        <div class="subtitle-block">
                    		<h3 class="subtitle">Finalizando cadastro</h3>
                    	</div>
                        <div class="card card-block">
                        	<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Observações
								</label>
								<div class="col-sm-10"> 
									Cadastrado em 03/01/2017 por Fulano
									Ultima atualização em 03/03/2017 por Ciclano
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
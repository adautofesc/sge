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
                        <h3 class="title"> Cadastrando uma nova pessoa<span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                    <form name="item">
                    <div class="subtitle-block">
                        <h3 class="subtitle"> Dados Gerais </h3>
                    </div>
                    
                        <div class="card card-block">
                        	
                        	
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Nome*</label>
								<div class="col-sm-10"> 
									<input type="text" class="form-control boxed" placeholder=""> 
								</div>
							</div>
							
							<div class="form-group row">
								
								<label class="col-sm-2 form-control-label text-xs-right">Nascimento*</label>
								<div class="col-sm-3">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
										<input type="text" class="form-control boxed" placeholder=""> 
									</div>
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">Telefone*</label>
								<div class="col-sm-3"> 
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-phone"></i></span> 
										<input type="text" class="form-control boxed" placeholder=""> 
									</div>
								</div>
							</div>
								
							
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Gênero*</label>
                                <div class="col-sm-10"> 
                                	<label>
                                		<input class="radio" name="inline-radios" type="radio">
		                    			<span>Masculino</span>
		                			</label>
		                			<label>
                                		<input class="radio" name="inline-radios" type="radio">
		                    			<span>Feminino</span>
		                			</label>
		                			<label>
                                		<input class="radio" name="inline-radios" type="radio">
		                    			<span>Trans Masculino</span>
		                			</label>
		                			<label>
                                		<input class="radio" name="inline-radios" type="radio">
		                    			<span>Trans Feminino</span>
		                			</label>
		                			<label>
                                		<input class="radio" name="inline-radios" type="radio">
		                    			<span>Outro</span>
		                			</label>
		                		</div>
                            </div>
                            
                            <div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Nome Social</label>
								<div class="col-sm-10"> 
									<input type="text" class="form-control boxed" placeholder=""> 
								</div>
							</div>    
                                
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">RG</label>
								<div class="col-sm-3"> 
									<input type="text" class="form-control boxed" placeholder=""> 
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">CPF*</label>
								<div class="col-sm-2"> 
									<input type="text" class="form-control boxed" placeholder="">
								</div>
								<div class="col-sm-2"> 
									<a href="pessoas_add.php" class="btn btn-primary btn-sm rounded-s" > Responsável</a>
								</div>
								
							</div>                                
                            <div class="form-group row">
								<label class="col-sm-2 form-control-label text-xs-right"></label>
								<div class="col-sm-10 col-sm-offset-2"> 
									<a href="#" class="btn btn-primary">Adicionar Mais informação</a>
									<!--
									<button type="submit" class="btn btn-primary">Cadastrar e escolher disciplinas obrigatórias</button> 
									-->
								</div>
		                   </div>    
							
						
                        </div>
                        <div class="subtitle-block">
                        <h3 class="subtitle"> Dados de contato </h3>
                    	</div>
                    
                        <div class="card card-block">
                        	<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">CEP</label>
								<div class="col-sm-3"> 
									<input type="text" class="form-control boxed" placeholder=""> 
								</div>
							</div>
                        	
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Endereço</label>
								<div class="col-sm-10"> 
									<input type="text" class="form-control boxed" placeholder=""> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Número</label>
								<div class="col-sm-2"> 
									<input type="text" class="form-control boxed" placeholder=""> 
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Estado
								</label>
								<div class="col-sm-2"> 
									<select class="c-select form-control boxed">
										<option selected>Selecione</option>
										<option value="1">SP</option>
										<option value="2">RJ</option>
										<option value="3">PR</option>
										<option value="4">MG</option>
									</select> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Cidade</label>
								<div class="col-sm-2"> 
									<input type="text" class="form-control boxed" placeholder=""> 
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">Bairro</label>
								<div class="col-sm-3"> 
									<select class="c-select form-control boxed">
										<option selected>Bairros de São Carlos</option>
										<option value="1">Vila Nery</option>
										<option value="2">Santa Paula</option>
										<option value="3">Vila Prado</option>
										<option value="4">Centro</option>
									</select> 
								</div>
								<div class="col-sm-2"> 
									<input type="text" class="form-control boxed" placeholder="Outro"> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">E-Mail</label>
								<div class="col-sm-10"> 
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span> 
										<input type="text" class="form-control boxed" placeholder=""> 
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label text-xs-right"></label>
								<div class="col-sm-10 col-sm-offset-2"> 
									<a href="#" class="btn btn-primary">Adicionar mais informação</a>
									<!--
									<button type="submit" class="btn btn-primary">Cadastrar e escolher disciplinas obrigatórias</button> 
									-->
								</div>
		                   </div>
						</div>
						<div class="subtitle-block">
                        <h3 class="subtitle"> Dados Clínicos</h3>
                    	</div>
                    
                        <div class="card card-block">
                        <div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Necesssidade Especial?</label>
								<div class="col-sm-3"> 
									<input type="text" class="form-control boxed" placeholder="Motora, visual, auditiva, etc"> 
								</div>
							</div>
			                	
			              	
                        </div>	
                        	
							
						</div>
						<div class="subtitle-block">
                        <h3 class="subtitle">Outros dados </h3>
                    	</div>
                    
                        <div class="card card-block">
                        	
                        </div>	
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Nome*</label>
								<div class="col-sm-10"> 
									<input type="text" class="form-control boxed" placeholder=""> 
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
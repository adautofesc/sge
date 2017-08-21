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
                 <article class="content items-list-page">
<!-- Tipo da página********************************************************  início conteúdo-->           	

                    <div class="title-search-block">
                        <div class="title-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="title"> Adicionando disciplinas obrigatórias ao curso:
	
                                    </h3>
                                    <p class="title-description"> Qualidade de vida </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card items">
                        <ul class="item-list striped">
                            <li class="item item-list-header hidden-sm-down">
                                <div class="item-row">
                                    <div class="item-col fixed item-col-check">
                                    	<label class="item-check" id="select-all-items">
											<input type="checkbox" class="checkbox">
											<span></span>
										</label> 
									</div>
                                    
                                    <div class="item-col item-col-header item-col-title">
                                        <div> <span>Nome</span> </div>
                                    </div>
                                    <div class="item-col item-col-header item-col-sales">
                                        <div> <span>Programa</span> </div>
                                    </div>
                                    <div class="item-col item-col-header item-col-sales">
                                        <div> <span>Carga</span> </div>
                                    </div>

                                    <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="item-row">
                                    <div class="item-col fixed item-col-check"> 
	                                    <label class="item-check" id="select-all-items">
											<input type="checkbox" class="checkbox">
											<span></span>
										</label> 
									</div>
                                    
                                    <div class="item-col fixed pull-left item-col-title">
                                        <div class="item-heading">Nome</div>
                                        <div>
                                            <a href="disciplinas-show.php" class="">
                                                <h4 class="item-title"> Qualidade de vida </h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="item-col item-col-sales">
                                        <div class="item-heading">Programa</div>
                                        <div> UATI </div>
                                    </div>
                                    <div class="item-col item-col-sales">
                                        <div class="item-heading">Carga</div>
                                        <div> 30h </div>
                                    </div>                                    

                                    <div class="item-col fixed item-col-actions-dropdown">
                                        
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="item-row">
                                    <div class="item-col fixed item-col-check"> 
	                                    <label class="item-check" id="select-all-items">
											<input type="checkbox" class="checkbox">
											<span></span>
										</label> 
									</div>
                                    
                                    <div class="item-col fixed pull-left item-col-title">
                                        <div class="item-heading">Nome</div>
                                        <div>
                                            <a href="disciplinas-show.php" class="">
                                                <h4 class="item-title"> Informática</h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="item-col item-col-sales">
                                        <div class="item-heading">Programa</div>
                                        <div> PID </div>
                                    </div>
                                    <div class="item-col item-col-sales">
                                        <div class="item-heading">Carga</div>
                                        <div> 30h </div>
                                    </div>                                    

                                    <div class="item-col fixed item-col-actions-dropdown">
                                        
                                    </div>
                                </div>
                            </li>

                        </ul>
                        <div class="form-group row"></div>
                        <div class="form-group row">
								<div class="col-sm-10 col-sm-offset-2" style="padding-left:2%"> 
									<a href="cursos_add_disciplinas_opt.php" class="btn btn-primary">Cadastrar e escolher disciplinas opcionais</a>
									<!--
									<button type="submit" class="btn btn-primary">Cadastrar e escolher disciplinas obrigatórias</button> 
									-->
								</div>
		                   </div>
                    </div>
                   
                </article>


<!-- ------------------------------------------------------------------------- fim conteúdo------- -->
                </article>
                <? include "footer.php";?>
<!-- *********************************************** Footer  abaixo os modals -->                
               <div class="modal fade" id="confirm-modal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
    				</button>
                                <h4 class="modal-title"><i class="fa fa-warning"></i> Atenção</h4>
                            </div>
                            <div class="modal-body">
                                <p>Você tem certeza que deseja fazer isso?</p>
                            </div>
                            <div class="modal-footer"> <button type="button" class="btn btn-primary" data-dismiss="modal">Sim</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button> </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div> 
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
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
                        <h3 class="title"> Criar nova turma <span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                    <form name="item">
                        <div class="card card-block">
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Programa
								</label>
								<div class="col-sm-6"> 
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
									Curso
								</label>
								<div class="col-sm-6"> 
									<select class="c-select form-control boxed">
										<option selected>Selecione um curso</option>
										<option value="1">Qualidade de vida</option>
										<option value="2">Caminhada Orientada</option>
										<option value="3">Consciência Corporal</option>
										<option value="4">Atividade física e Lazer</option>
									</select> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Professor
								</label>
								<div class="col-sm-6"> 
									<select class="c-select form-control boxed">
										<option selected>Selecione um professor</option>
										<option value="1">Adailton</option>
										<option value="2">Adauto</option>
										<option value="3">Adilson</option>
										<option value="4">Adriano</option>
									</select> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Unidade
								</label>
								<div class="col-sm-6"> 
									<select class="c-select form-control boxed">
										<option selected>Selecione um local</option>
										<option value="1">FESC 1 - Vila Nery</option>
										<option value="2">FESC 2 - Vila Prado</option>
										<option value="3">FESC 3 - Sta Paula</option>
										<option value="4">CC Abc - Bairro</option>
										<option value="4">CRAS Xyz - Bairro</option>
									</select> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Dia(s) semana.
								</label>
								<div class="col-sm-10"> 
									<label><input class="checkbox" disabled="disabled" type="checkbox"><span>Dom</span></label>
									<label><input class="checkbox" type="checkbox"><span>Seg</span></label>
									<label><input class="checkbox" type="checkbox"><span>Ter</span></label>
									<label><input class="checkbox" type="checkbox"><span>Qua</span></label>
									<label><input class="checkbox" type="checkbox"><span>Qui</span></label>
									<label><input class="checkbox" type="checkbox"><span>Sex</span></label>
									<label><input class="checkbox" type="checkbox"><span>Sab</span></label>
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Data de início
								</label>
								<div class="col-sm-3"> 
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
										<input type="date" class="form-control boxed" placeholder="dd/mm/aaaa"> 
									</div>
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Data do fim
								</label>
								<div class="col-sm-3"> 
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
										<input type="date" class="form-control boxed" placeholder="dd/mm/aaaa"> 
									</div>
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Horário de início
								</label>
								<div class="col-sm-2"> 
									<input type="time" class="form-control boxed" placeholder="00:00"> 
								</div>
								<label class="col-sm-2 form-control-label text-xs-right">
									Horário Termino
								</label>
								<div class="col-sm-2"> 
									<input type="time" class="form-control boxed" placeholder="00:00"> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Nº de vagas
								</label>
								<div class="col-sm-4"> 
									<input type="text" class="form-control boxed" placeholder="Recomendado: 30 vagas"> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Preço
								</label>
								<div class="col-sm-4"> 
									<div class="input-group">
										<span class="input-group-addon">R$ </span> 
										<input type="number" class="form-control boxed" placeholder=""> 
									</div>
								</div>
								
							</div>
							
							
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">Opções (ao selecionar alguma, zera o preço)</label>
                                <div class="col-sm-10"> 
									<div>
										<label>
										<input class="checkbox" type="checkbox">
										<span>Preço por carga semanal (número de atividades na semana)</span>
										</label>
									</div>
									<div>
										<label>
										<input class="checkbox" type="checkbox">
										<span>Turma de Parceria</span>
										</label>
									</div>
									<div>
										<label>
										<input class="checkbox" type="checkbox">
										<span>Turma EMG</span>
										</label>
									</div>
									<div>
										<label>
										<input class="checkbox" type="checkbox">
										<span>Turma Eventual</span>
										</label>
									</div>
			                	</div>
                                    
                            </div>
                                
							<div class="form-group row">
								<div class="col-sm-10 col-sm-offset-2">
									<a href="disciplinas_show.php?" class="btn btn-primary">Cadastrar</a> 
									<a href="disciplinas_show.php?" class="btn btn-secondary">Cadastrar a próxima</a> 
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
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
                        <h3 class="title"> Selecione os cursos<span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                    <div class="subtitle-block">
                        <h3 class="subtitle"><small>Matrícula de:</small> Adauto Junior</h3>
                    </div>
                    <form name="item" class="form-inline">
                    	<section class="section">
                        <div class="row sameheight-container">
                            <div class="col-xl-12">
                                <div class="card sameheight-item">
                                    <div class="card-block">
                                        <!-- Nav tabs -->
                                        <div class="row">
                                        	<div class="col-xs-6">
                                        		<div class="card-title-block">
                                            		<h3 class="title"> Cursos disponíveis </h3>
                                    			 </div>
                                        	</div>
                                        	<div class="col-xs-6 text-xs-right">
                                        		Valor atual (R$0,00)
                                        	</div>
                                        </div>
                                        
                                        <ul class="nav nav-tabs nav-tabs-bordered">
                                            <li class="nav-item"> <a href="" class="nav-link active" data-target="#todos" data-toggle="tab" aria-controls="todos" role="tab">Todos</a> </li>
                                            <li class="nav-item"> <a href="" class="nav-link" data-target="#ce" aria-controls="ec" data-toggle="tab" role="tab">CE</a> </li>
                                            <li class="nav-item"> <a href="" class="nav-link" data-target="#emg" aria-controls="emg" data-toggle="tab" role="tab">EMG</a> </li>
                                            <li class="nav-item"> <a href="" class="nav-link" data-target="#pid" aria-controls="pid" data-toggle="tab" role="tab">PID</a> </li>
                                            <li class="nav-item"> <a href="" class="nav-link" data-target="#uati" aria-controls="uati" data-toggle="tab" role="tab">UATI</a> </li>
                                            <li class="nav-item"> <a href="" class="nav-link" data-target="#unit" aria-controls="unit" data-toggle="tab" role="tab">UNIT</a> </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content tabs-bordered">
                            
                                            <div class="tab-pane fade in active" id="todos">
                                            	<h4>Todos os programas</h4>
                                                <section class="example">
                                            <div class="table-flip-scroll">
                                                <table class="table table-striped table-bordered table-hover flip-content">
                                                    <thead class="flip-header">
                                                        <tr> 
                                                        	<th>S</th>
                                                            <th>Curso</th>
                                                            <th>Professor</th>
                                                            <th>Dia(s)</th>
                                                            <th>Horário</th>
                                                            <th>Local</th>
                                                            <th>Vagas</th>
                                                            <th>Valor</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td><a href="#turma_show.php"  target="_blank" title="Clique para ver detalhes em outra guia">Yoga para o trabalho</a></td>
                                                            <td>Adilson</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Dança Chill</td>
                                                            <td>Rita</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Yoga para o trabalho</td>
                                                            <td>Adilson</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </section>
                                            </div>
                                            <div class="tab-pane fade" id="ce">
                                                <h4>Centro Esportivo</h4>
                                                <section class="example">
                                            <div class="table-flip-scroll">
                                                <table class="table table-striped table-bordered table-hover flip-content">
                                                    <thead class="flip-header">
                                                        <tr> 
                                                        	<th>S</th>
                                                            <th>Curso</th>
                                                            <th>Professor</th>
                                                            <th>Dia(s)</th>
                                                            <th>Horário</th>
                                                            <th>Local</th>
                                                            <th>Vagas</th>
                                                            <th>Valor</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Yoga para o trabalho</td>
                                                            <td>Adilson</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Dança Chill</td>
                                                            <td>Rita</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Yoga para o trabalho</td>
                                                            <td>Adilson</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </section>
                                            </div>
                                            <div class="tab-pane fade" id="emg">
                                                <h4>Escola Municipal de Governo</h4>
                                                <section class="example">
                                            <div class="table-flip-scroll">
                                                <table class="table table-striped table-bordered table-hover flip-content">
                                                    <thead class="flip-header">
                                                        <tr> 
                                                        	<th>S</th>
                                                            <th>Curso</th>
                                                            <th>Professor</th>
                                                            <th>Dia(s)</th>
                                                            <th>Horário</th>
                                                            <th>Local</th>
                                                            <th>Vagas</th>
                                                            <th>Valor</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Yoga para o trabalho</td>
                                                            <td>Adilson</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Dança Chill</td>
                                                            <td>Rita</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Yoga para o trabalho</td>
                                                            <td>Adilson</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </section>
                                            </div>
                                            <div class="tab-pane fade" id="pid">
                                                <h4>Programa de Inclusão Digital</h4>
                                                <section class="example">
                                            <div class="table-flip-scroll">
                                               <table class="table table-striped table-bordered table-hover flip-content">
                                                    <thead class="flip-header">
                                                        <tr> 
                                                        	<th>S</th>
                                                            <th>Curso</th>
                                                            <th>Professor</th>
                                                            <th>Dia(s)</th>
                                                            <th>Horário</th>
                                                            <th>Local</th>
                                                            <th>Vagas</th>
                                                            <th>Valor</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Yoga para o trabalho</td>
                                                            <td>Adilson</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Dança Chill</td>
                                                            <td>Rita</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Yoga para o trabalho</td>
                                                            <td>Adilson</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </section>
                                            </div>
                                            <div class="tab-pane fade" id="uati">
                                                <h4>Universidade Aberta da Terceira Idade</h4>
                                                <section class="example">
                                            <div class="table-flip-scroll">
                                                <table class="table table-striped table-bordered table-hover flip-content">
                                                    <thead class="flip-header">
                                                        <tr> 
                                                        	<th>S</th>
                                                            <th>Curso</th>
                                                            <th>Professor</th>
                                                            <th>Dia(s)</th>
                                                            <th>Horário</th>
                                                            <th>Local</th>
                                                            <th>Vagas</th>
                                                            <th>Valor</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Yoga para o trabalho</td>
                                                            <td>Adilson</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Dança Chill</td>
                                                            <td>Rita</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Yoga para o trabalho</td>
                                                            <td>Adilson</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </section>
                                            </div>
                                            <div class="tab-pane fade" id="unit">
                                                <h4>Universidade Aberta do Trabalhador</h4>
                                                <section class="example">
                                            <div class="table-flip-scroll">
                                                <table class="table table-striped table-bordered table-hover flip-content">
                                                    <thead class="flip-header">
                                                        <tr> 
                                                        	<th>S</th>
                                                            <th>Curso</th>
                                                            <th>Professor</th>
                                                            <th>Dia(s)</th>
                                                            <th>Horário</th>
                                                            <th>Local</th>
                                                            <th>Vagas</th>
                                                            <th>Valor</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Costura</td>
                                                            <td>Fabiana</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Espanhol</td>
                                                            <td>Carla</td>
                                                            <td>Seg. Qua. Sex.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                        <tr class="odd gradeX">
                                                            <td>
                                                            	<div class="item-col fixed item-col-check">
																	<label class="item-check" id="select-all-items">
																		<input type="checkbox" class="checkbox">
																		<span></span>
																	</label> 
																</div>
															</td>
                                                            <td>Auxiliar Administrativo</td>
                                                            <td>Claudia</td>
                                                            <td>Ter. Qui.</td>
                                                            <td>7:00-8:00</td>
                                                            <td>FESC 1</td>
                                                            <td>20</td>
                                                            <td>R$ 200,00</td>
                                                        </tr>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </section>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-block -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col-xl-6 -->
                            
                            <!-- /.col-xl-6 -->
                        </div>
                    </section>
                    
                    <div class="card-block">
                    	<a class="btn btn-primary" href="matricula_confirma_cursos.php">Avançar</a>
                    	
                    	<button class="btn btn-secondary">Limpar</button>
                    </div>
					
                    </form>
                

<!-- ------------------------------------------------------------------------- fim conteúdo------- -->
                </article>
                <? include "footer.php";?>
<!-- *********************************************** Footer  abaixo os modals -->                
              
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog --> 
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
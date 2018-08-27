


<!doctype html>
<html>
<head id="Head1"><meta charset="utf-8" /><title>
	FESC - Termo de Matrícula
</title>
    <style type="text/css">
        * {
            font-family: Tahoma, MS Sans Serif, Arial, Sans Serif;
            font-size: 11px;
            /*color:#000000;*/
            text-decoration: none;
            /*text-align:left;*/
        }
        @media screen,print {

        /* *** TIPOGRAFIA BASICA *** */
            .page-break { 
                page-break-before: always; 
            }
        }
        @media print { 
            #link{
                display:none;
            }
        }
        #link{
            padding: 4px 11px;
            border: 1px solid #ffcc00;
            -moz-border-radius: 8px;
            -webkit-border-radius: 8px;
            border-radius: 8px;
            background-color: #ffcc00 !important;
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffcc00), color-stop(100%,#ff6600)) !important;
            background: -webkit-linear-gradient(top, #ffcc00, #ff6600) !important;
            background: -moz-linear-gradient(top, #ffcc00, #ff6600) !important;
            background: -ms-linear-gradient(top, #ffcc00, #ff6600) !important;
            background: -o-linear-gradient(top, #ffcc00, #ff6600) !important;
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffcc00', endColorstr='#ff6600',GradientType=0 );
            background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZmY2MwMCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmZjY2MDAiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
            font-family:"Segoe UI";
            font-size:20px;
            font-weight: bold;
            color: #fff;
            text-shadow: 0 1px 0 #666;
            box-shadow: inset 0 1px 1px #fff, 0 2px 3px #666;
            cursor:pointer;
            position: relative;


        }

    </style>
<link href="../App_Themes/ob12/CardView/sprite.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/CardView/spriteAccessible.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/CardView/styles.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/Editors/sprite.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/Editors/spriteAccessible.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/Editors/styles.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/GridView/sprite.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/GridView/spriteAccessible.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/GridView/styles.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/PivotGrid/sprite.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/PivotGrid/spriteAccessible.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/PivotGrid/styles.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/VerticalGrid/sprite.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/VerticalGrid/spriteAccessible.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/VerticalGrid/styles.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/Web/sprite.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/Web/spriteAccessible.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/Web/styles.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/XtraReports/sprite.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/XtraReports/spriteAccessible.css" type="text/css" rel="stylesheet" /><link href="../App_Themes/ob12/XtraReports/styles.css" type="text/css" rel="stylesheet" /></head>
<body onload="javascript:self.print();">
     <a href="{{asset('/recadastramento')}}" id="link"> Finalizar Acesso</a>
@foreach($matriculas as $matricula)
   <div class="page-break">
        <table cellspacing="6" cellpadding="6" border="0" id="FormView1" style="width:100%;">
	<tr>
		<td colspan="2">
                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                    <tr>
                        <td>
                            <img id="FormView1_Image1" src="{{asset('img/logo.jpg')}}" style="border-width:0px;" />
                        </td>
                        <td width="100%" align="center">
                            <strong>TERMO DE MATRICULA Nº &nbsp;<span id="FormView1_CurDesTit">{{$matricula->id}}</span></strong></div>
                        </td>
                        <td>&nbsp;
                            
                        </td>
                    </tr>
                </table>
                <p><strong>FUNDAÇÃO EDUCACIONAL SÃO CARLOS-FESC</strong>, inscrita no CNPJ sob nº 45.361.904/0001-80, com sede na Rua São Sebastião, nº 2.828, Vila Nery, São Carlos/SP, neste ato representada por seu Diretor-Presidente</p>
                <p>
                    <strong>ALUNO:</strong>
                    <span id="FormView1_AluNom" style="font-weight:bold;">{{$pessoa->nome}}</span>&nbsp;
                    &nbsp;endereço:&nbsp;<span id="FormView1_Label9" style="font-weight:bold;">{{$pessoa->endereco->logradouro}}, {{$pessoa->endereco->numero}}, {{$pessoa->endereco->complemento}}</span>
                    &nbsp;, bairro:&nbsp;<span id="FormView1_Label10" style="font-weight:bold;">{{$pessoa->endereco->bairro_str}}</span>
                    &nbsp;, cidade:&nbsp;<span id="FormView1_Label11" style="font-weight:bold;">{{$pessoa->endereco->cidade}}</span>
                    &nbsp;<span id="FormView1_Label12" style="font-weight:bold;">{{$pessoa->endereco->estado}}</span>
                    &nbsp;, cep:&nbsp;<span id="FormView1_Label13" style="font-weight:bold;">{{$pessoa->endereco->cep}}</span>
                    &nbsp;, fone:&nbsp;<span id="FormView1_Label14" style="font-weight:bold;">{{$pessoa->telefone}}</span>
                    
                    &nbsp;,CPF
							nº
							<span id="FormView1_AluCpf" style="font-weight:bold;">{{$pessoa->cpf}}</span>,
                            RG
                            <span id="FormView1_Label1" style="font-weight:bold;">{{$pessoa->rg}}</span>
                    , doravante denominado ALUNO
                </p>

                <p>Têm justo e acordado o seguinte:</p>

                <p>
                    <strong>1. OBJETO</strong><br />
                    <strong>1.1</strong> O presente formaliza a inscrição do ALUNO nas seguinte atividades:
                    
                    @foreach($matricula->inscri as $insc)
                        <br>&nbsp;&nbsp;<span id="FormView1_CurDes" style="font-weight:bold;">
                        @if($insc->turma->disciplina==null)
                            {{ $insc->turma->curso->nome }} 
                        @else
                            {{ $insc->turma->curso->nome }}, disciplina: {{ $insc->turma->disciplina->nome }}
                        @endif    
                            - toda {{ucwords(implode(', ', $insc->turma->dias_semana )) }} 
                         feira(s), das {{$insc->turma->hora_inicio}} às {{$insc->turma->hora_termino}}</span>&nbsp;do programa
                                    <span id="FormView1_PRMDes" style="font-weight:bold;">{{$insc->turma->programa->nome}}</span></strong>
                                       
                        
                 
                    @endforeach

                    <br>, mediante adesão aos termos do presente instrumento e apresentação do RG, CPF, comprovante de endereço e atestado médico, este necessário para a prática de atividades físicas.
                </p>
                <p>
                    <strong>2. VALOR E CONDIÇÕES DE PAGAMENTO:</strong>
                    <br />
                    <strong>2.1</strong> O ALUNO pagará à FESC, pela prestação dos serviços ora ajustados, o valor total de
                    <span id="FormView1_MatVlrPag" style="font-weight:bold;" >R$ {{number_format($matricula->valor-$matricula->valor_desconto, 2, ',', '.')}}</span>, dividido em
                    <span id="FormView1_CPACod" style="font-weight:bold;">{{$matricula->parcelas}}</span>
                    parcelas de
                    <span id="FormView1_parcela" style="font-weight:bold;">R$ {{number_format(($matricula->valor-$matricula->valor_desconto)/$matricula->parcelas, 2, ',', '.')}}</span>
                    cada uma, vencíveis no dia
                    <span id="FormView1_MatDiaPag" style="font-weight:bold;">28</span>
                    de cada mês, após o início das aulas e através de boleto bancário;
                    <br />
                    <strong>2.2</strong> Se o vencimento do prazo cair em feriado, considera-se prorrogado o prazo até o primeiro dia útil seguinte;
                    <br />
                    <strong>2.3</strong> O não pagamento no prazo estipulado acarretará juros de mora de 1% ao mês (0,033% ao dia);
                    <br />
                    <strong>2.4</strong> As parcelas vencidas e não pagas serão inscritas na Dívida Ativa da Fazenda Pública, e cobradas mediante procedimento administrativo e, se necessário, judicial.
                </p>
                <p>
                    <strong>3. CERTIFICADO: </strong>
                    <br />
                    <strong>3.1</strong> No caso em que o curso/oficina é certificado, o aluno deverá ter no mínimo 75% de presença efetiva, isto é, comparecer em no mínimo 75% das aulas. Neste caso, o atestado médico não abona as faltas.
                    <br>
                    <strong>3.2</strong> Os casos omissos serão resolvidos pela Chefia de cada Programa Educacional.
                </p>
                <p>
                    <strong>4.	CANCELAMENTO: </strong>
                    <br />
                    <strong>4.1</strong> A rescisão do contrato ocorrerá somente através da formalização do cancelamento da matrícula mediante assinatura do requerimento de cancelamento pelo aluno ou seu representante legal na Secretaria Escolar;
                    <br />
                    <strong>4.2</strong> Caso o aluno realize o cancelamento antes da data de início do curso, ficará isento de qualquer pagamento.
                    <br />
                    <strong>4.3</strong> A falta de comparecimento ou frequência do aluno, enquanto não realizar o cancelamento da matrícula, não o exime do pagamento das parcelas acordadas na cláusula 2.1.
                    <br />
                    <strong>4.4</strong> Somente após a realização do cancelamento na Secretaria Escolar, o aluno estará isento do pagamento das parcelas futuras não vencidas.
                    <br />
                    <strong>4.5</strong> Será considerado sem aproveitamento o aluno que deixar de comparecer a mais de 25% do total de aulas ofertadas, caso em que perderá direito ao certificado de conclusão e também solicitação de bolsa de estudo para o próximo semestre, caso houver;
                </p>
                <p>
                    <strong>5.	OBRIGAÇÕES REGIMENTAIS:</strong>
                    <br />
                    <strong>5.1</strong> O ALUNO regularmente matriculado fica submetido aos deveres de boa convivência e colaboração previstos no Regimento Interno da FESC (Resolução 16/2008) e no Regimento do Programa Educacional correspondente ao curso, podendo sofrer sanções disciplinares em caso de seu descumprimento;
                    <br />
                    <strong>5.2</strong> É de inteira responsabilidade da FESC o atendimento aos direitos regimentais do aluno, bem como a citada prestação de serviços com garantia de adequadas condições para a qualidade do ensino.
                </p>
                <p>
                    <strong>6.	FORO:</strong> Fica eleito o Foro da Comarca de São Carlos para dirimir quaisquer controvérsias oriundas do presente ajuste.
                </p>

                
                <div align="right">
                    <p>
                        São Carlos,
                                <span id="FormView1_data_atual">{{date("d/m/Y")}}</span>
                    </p>
                </div>
                </br></br>
                                <table border="0" cellpadding="2" cellspacing="2" width="100%">
                                    <tr>
                                        <td align="center">__________________________________</br>

                                            <strong>Diretor(a) Presidente</strong>
                                            </br>
                                            <strong>Fundação Educacional São Carlos</strong>
                                        </br>
                                            </br>
                                        <td align="center">__________________________________</br>

                                            <span id="FormView1_AluNomAss">{{$pessoa->nome}}</span>
                                            </br>
                                            <strong>Nome do Aluno ou responsável</strong>
                                            </br><span id="FormView1_MatResNomLabel"></span>
                                            </br>
                                        </td>
                                    </tr>
                                </table>

                <br />
                </br>
                    <div>
			<table cellspacing="0" rules="all" border="1" id="FormView1_g1" style="border-color:Black;border-width:1px;border-style:Solid;width:100%;border-collapse:collapse;">
				<tr>
					<th align="left" scope="col">Local</th><th align="left" scope="col">Turma</th><th align="left" scope="col">Dt.Inicio</th><th align="left" scope="col">Dt.Final</th><th align="left" scope="col">Carga Hor&#225;ria</th>
				</tr>
                @foreach($matricula->inscri as $insc)
                        <tr>
                            <td>{{$insc->turma->local->nome}}</td>
                            <td>

                                @if($insc->turma->disciplina==null)
                                    {{ $insc->turma->curso->nome }} 
                                @else
                                    {{ $insc->turma->curso->nome }}, disciplina: {{ $insc->turma->disciplina->nome }}
                                @endif    
                                    - toda {{ucwords(implode(', ', $insc->turma->dias_semana )) }} 
                                 feira(s), das {{$insc->turma->hora_inicio}} às {{$insc->turma->hora_termino}}
                            </td>
                            <td>{{$insc->turma->data_inicio}}</td>
                            <td>{{$insc->turma->data_termino}}</td>
                            @if($insc->turma->disciplina==null)
                                <td>{{$insc->turma->curso->carga}}</td>
                            @else
                                <td>{{$insc->turma->disciplina->carga}}</td>  
                            @endif     
                        
                        </tr>
                    @endforeach


			</table>
		</div>
                <br />
                <div>

		</div>
                
            </td>
	</tr>
</table>
</div>
@endforeach       
</body>
</html>



<!doctype html>
<html>
<head id="Head1"><meta charset="utf-8" /><title>
	FESC - Termo de Matrícula
</title>
    <style type="text/css">
        p,.texto {
            font-family: Tahoma, MS Sans Serif, Arial, Sans Serif;
            font-size: 12pt;
            text-align: justify;
            /*color:#000000;*/
            text-decoration: none;
            /*text-align:left;*/
        }
        #FormView1_MatDiaPag{
            font-size: 14pt;
        }
        .header-tabela{
            font-family: Tahoma, MS Sans Serif, Arial, Sans Serif;
            font-size: 10pt;
            text-align: justify;
            /*color:#000000;*/
            text-decoration: none;

        }
        .corpo-tabela{
            font-family: Tahoma, MS Sans Serif, Arial, Sans Serif;
            font-size: 10pt;
            text-align: left;
            /*color:#000000;*/
            text-decoration: none;

        }
    </style>
</head>
<body onload="javascript:self.print();">

    <form name="form1" method="post" action="./ImpMatriculas.aspx?MatCod=68264" id="form1">
<div>
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="1QTT+qa6d04akHRCYfwmXQbkItvk6vxzYkXFLKNOMwtvVT9K0q9Ix8i4ZmUcAW6A69azNrW9UxG3ijzzx8iXY2OKV3Bu41VN4KSFm3aQUqv2rh4MNb9d6uMeBOR+cfpfdSRDS77tuDVqlc2w+FTXf1jsD+GXcWQu7bF1MnGQmFJ1yHeRsD5VDYS5BUKQP5niEy0UaeR1d+Jxa6h6wcAgoi0EOCndpEHdViSRG98bDIfZA4uHS3rZKLr+41QDBtPTpzmOrNzyNfo9R/dHaA+32WDMhFxgoHrV5gaDqd4gitVdH6osj/dHNUjLg7+d+iMoQ2h6FXybySv1LO3ZxlHJcHWM5KWkVW7b2D8kH/LFi/OkBDaEnIniJG+88fTNa64yOGDRpnw2q6HkNiPQfxQVBOrakEGwO/4M3oLX2v5Ps2GOCFQDz+PXk3cYsguv3EXg2ulmqRfW5w7W2x7k0TvhX4TYaAdGCvE7Dbm9N0cWPyn5452xr49n8lQx2XGXUsUOb4CZfwLmFMBhyeYcs4JO5C9v+92vK6E2dJzyHvHqN+EH6yj8MK25S5hi0dEkT5jdf2rWLGlLsM6CJHm+gcIjJ6+iwrWkoy9ob0pldJggwzyLY5ITviGMZEuR2+xmNdIJk8zHKW83UiVZCoBu5/wy458ebFff37vCNzyUoQVsfkFq0eEwmQUigI6NkF2/DUp2QXtZk3mAJjoChtv4JZZgMbjHH53xOlYoaEflBfq9FThTyd0mK3DNgJBsPAzR0VPG/KMdHcmhO1fTDQouYKXYxoO6xgIt+Y+DNKeXgH0yhhbNYU7coGtWYiYSjBxa+c75R3GUdepXZF7HEqdfLxI1VDTaMkSEuNTfh5VEDv73UAHcnSHA78ptaAdEwxSbKiFcky7G5krX0q+pq0V68gI37buXlFwNfLYaDN+LMa7YNn7jrC8Hc8fh5rI9F4q4thLT0B7oiyCfLLMXfFKPAJnebnwNaFtZrz6/iFWp7ZYflTo594NB9j3XKRoyAooTWiaNp/gNHP19B0lSTHSj/my/eHNZEhQZg4Fb/7HSpSDOw1RJKPIttuEEjHAJvLmxl33aHdbE8iB/ld7K1gxI7GPOy0T8UxXyL4udsvf1lhW3jCFRIAq+fbmXN3hqc/3/Vrh40CGL84NAkmez+XNn181ec+1ZyTrsPSnSVYgArZ3D5t8WhqKja9Mq5EMDNx+Zw8XhwHcIPWm2fFjDEwO7WYRGhtcsBdwyImGaiBFsA1w7M7KIYUO29BxVNK9MEL7nMS3VUMn0MoSjwE0RyOpKfmFJkJ8f1z+asbwl/uADlUTr5N1Xlo21X+dIDP1liPZHV0X4APC+DIvZwm2hPFiBjN8XSVK/5UawV8bKikayC5y/pS/iDcP4Rcv4oTXAzQi3y6TzECx2wACvkFrHdyzl4rHMdpVbS+5gE5bPpKtA5Y0Mmzpcr92ieMSfHm5nZaAFuSVdcXiS8QmAhrtyDMSpWKN5ypS9PgdJtDek4znEojSqedvXI+sh7u+J2ApMzG8DZdDya8za9Oe8xrF3TUH/QYFScucPM3UFQ2jawagHxiTFvDvnEe4x3mC3jBAUbF7bH34IODl/e2dMHgwDwbcROwcnUyduKz7My0UHhaJ5sXiFvR0=" />
</div>

        <table cellspacing="6" cellpadding="6" border="0" id="FormView1" style="width:100%;">
	<tr>
		<td colspan="2">
                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                    <tr>
                        <td>
                            <img id="FormView1_Image1" src="{{asset('img/logo.jpg')}}" style="border-width:0px;" />
                        </td>
                        <td width="100%" align="center" style="text-align: center" class="texto">
                            <strong>TERMO DE MATRICULA Nº &nbsp;<span id="FormView1_CurDesTit">{{$matricula->id}}</span></strong></div>
                        </td>
                        <td><img src="/img/code39.php?code=MT{{$matricula->id}}">
                            
                        </td>
                    </tr>
                </table>
                <p><strong>FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong>, pessoa jurídica de direito público inscrita no CNPJ sob nº 45.361.904/0001-80, com sede na Rua São Sebastião, nº 2828, Vila Nery, São Carlos/SP, neste ato representada por seu Diretor-Presidente, doravante denominhada FESC<br>
                
                
                    ALUNO:
                    <span id="FormView1_AluNom" style="font-weight:bold;">{{$pessoa->nome}}</span>&nbsp;
                    &nbsp;endereço:&nbsp;<span id="FormView1_Label9" >{{$pessoa->logradouro}}, {{$pessoa->end_numero}}</span>
                    &nbsp;, bairro:&nbsp;<span id="FormView1_Label10" >{{$pessoa->bairro}}</span>
                    &nbsp;, cidade:&nbsp;<span id="FormView1_Label11" >{{$pessoa->cidade}}</span>
                    &nbsp;<span id="FormView1_Label12" >{{$pessoa->estado}}</span>
                    &nbsp;, cep:&nbsp;<span id="FormView1_Label13" >{{$pessoa->cep}}</span>
                    &nbsp;, fone:&nbsp;<span id="FormView1_Label14" >{{$pessoa->telefone}}</span>
                    
                    &nbsp;,CPF
							nº
							<span id="FormView1_AluCpf">{{$pessoa->cpf}}</span>,
                            RG
                            <span id="FormView1_Label1">{{$pessoa->rg}}</span>
                    , doravante denominado ALUNO<br>
                    Têm justo  e acordado o seguinte:</br>
                </p>


                <p>
                    <strong>1. OBJETO</strong><br />
                    <strong>1.1</strong> O presente formaliza a inscrição do ALUNO nas seguinte atividades:</p>
                    
          <table cellspacing="0" rules="all" border="1" id="FormView1_g1" style="border-color:Black;border-width:1px;border-style:Solid;width:100%;border-collapse:collapse;">
                <tr class="header-tabela">
                    <th align="left" scope="col">&nbsp;CURSO </th>
                    <th align="center" scope="col" width="80px">&nbsp;DIAS </th>
                    <th align="center" scope="col" width="50px" >&nbsp;HORÁRIO </th>
                    <th align="center" scope="col" width="100px">&nbsp;DE/ATE </th>
        
                    <th align="center" scope="col">&nbsp; LOCAL/SALA</th>
                </tr>

                @foreach($inscricoes as $insc)

                        <tr class="corpo-tabela">
     
                            <td>

                                @if($insc->turma->disciplina==null)
                                    {{ $insc->turma->curso->nome }} 
                                @else
                                    {{ $insc->turma->curso->nome }}, {{ $insc->turma->disciplina->nome }}
                                @endif 
                            </td>
                            <td>{{ucwords(implode(', ', $insc->turmac->dias_semana )) }}</td>   
                                 
                            <td>{{$insc->turmac->hora_inicio}} às {{$insc->turmac->hora_termino}}</td>
                            <td align>{{$insc->turmac->data_inicio}} à {{$insc->turmac->data_termino}}</td>
                             
                            <td>{{$insc->turmac->local->nome}} <br>
                                @if(isset($insc->turmac->sala->nome))
                                sala {{$insc->turmac->sala->nome}}
                                @endif
                            </td>

                        </tr>
                    @endforeach


            </table>
                <p>
                    <strong> 2. VALOR E CONDIÇÕES DE PAGAMENTO</strong>
                        <br />
                        2.1 O ALUNO pagará à FESC, pela prestação dos serviços ora ajustados, o valor total de
                        <span id="FormView1_MatVlrPag">R$ {{number_format($matricula->valor->valor-$matricula->valor_desconto, 2, ',', '.')}}</span>, dividido em
                        <span id="FormView1_CPACod">{{$matricula->getParcelas()}}</span>
                        parcelas de R$ {{number_format(($matricula->valor->valor-$matricula->valor_desconto)/$matricula->getParcelas(),2,',','.')}}
                        <span id="FormView1_parcela"></span>
                        cada uma, vencíveis no dia
                        <strong><span id="FormView1_MatDiaPag">10
                        de cada mês</span></strong>, após o início das aulas e através de boleto bancário;
                        <br />
                        2.2 Se o vencimento do prazo cair em feriado, considera-se prorrogado o prazo até o primeiro dia útil seguinte;
                        <br />
                        <strong>2.3 O não pagamento no prazo estipulado acarretará multa de 2% (dois por cento) sobre o valor da parcela em atraso, juros de mora de 1% (um por cento) ao mês (0,33% ao dia), bem como a atualização monetária pelo índice IPCA/IBGE até a data do efetivo pagamento;
                        <br /></strong>
                        2.4 As parcelas vencidas e não pagas serão inscritas na Dívida Ativa da Fazenda Pública, e cobradas mediante procedimento administrativo e, se necessário, judicial.<br>
                    <strong> 3. VIGÊNCIA</strong>
                        <br />
                        3.1 O Contrato vigorará pelo prazo de duração do serviço educacional contratado, permanecendo, em caso de parcelamento, inalteradas as obrigações financeiras ajustadas.
                        <br>
                        3.2 Os serviços educacionais contratados terão duração, período de férias escolares, feriados e pontos facultativos estabelecidos em Resolução do Conselho Diretor da FESC e de acordo com as Portarias Municipais, que estabelecem os feriados nacionais, estadual e municipais e declara os dias de Ponto Facultativo do ano letivo para os órgãos e entidades da Administração Pública direta e indireta do Poder Executivo Municipal.
                        <br>
                    <strong>4. CERTIFICADO</strong> 
                        <br />
                        4.1 No caso em que o curso/oficina é certificado, o aluno deverá ter no mínimo 75% de presença efetiva, isto é, comparecer em no mínimo 75% das aulas. A apresentação de atestado médico não abona as faltas.
                        <br>
                        4.2 Para que seja admitida a presença, será tolerado o atrazo de no máximo 10 (dez) minutos;
                        <br>
                        4.3 Será considerado sem aproveitamento o aluno que deixar de comparecer a mais de 25% do total de aulas ofertadas, caso em perderá o direito ao certificado de conclusão, o que não o exime de pagamento das mensalidades em aberto, se houver.
                        <br>
                    <strong>5.	CANCELAMENTO</strong><br>                  
                        5.1 A não quitação de qualquer parcela no prazo estipulado implicará no CANCELAMENTO SUMÁRIO DA MATRÍCULA, ficando automaticamente rescindido o presente termo de prestação de serviços educacionais, independentemente de qualquer notificação;
                        <br>
                        5.2 A desistência da continuidade no serviço educacional pelo(a) Aluno(a) e/ou Representante Legal após o pagamento somente será aceita se o pedido for formalizado e protocolado na Secretaria Escolar ou enviado ao e-mail: secretaria{{'@'}}fesc.saocarlos.sp.gov.br.
                        <br>
                        5.3. Para as atividades da Universidade Aberta da Terceira Idade, haverá cancelamento da inscrição nas disciplinas em que o aluno deixar de frequentar por no máximo 30 (trinta) dias. A matrícula só será cancelada após pedido formalizado de cancelamento na Secretaria Escolar.
                        <br>
                    <strong>6.  DA PRIORIDADE DE MATRÍCULAS</strong><br>
                        6.1. Aos alunos dos cursos não certificados da Universidade Aberta da Terceira Idade que tiverem assiduidade superior a 75% e apresentarem rendimento atribuído pelos Educadores “com aproveitamento” terão prioridade de matrícula em período antecessor ao período de matrículas abertas a novos alunos e alunos evadidos ou classificados como rendimento “sem aproveitamento”.
                        <br>
                    <strong>7. OBRIGAÇÕES GERAIS</strong><br />
                        7.1 O ALUNO regularmente matriculado fica submetido aos Regimentos Internos, disponibilizados no site FESC.SAOCARLOS.SP.GOV.BR, submetendo-se às suas disposições, bem como às demais obrigações constantes da legislação aplicável à FESC.
                        <br>                      
                        7.2 A prestação de serviços educacionais pode contemplar o oferecimento de aulas, atividades culturais, reuniões, apresentações e outras previstas em calendário escolar, a critério da FESC.
                        <br>
                        7.3 O aluno fica ciente, ainda que a FESC não disponibiliza qualquer serviço de estacionamento, vigilância ou guarda de veículos de qualquer natureza.
                        <br>
                        7.4 A FESC reserva-se o direito de alterar a data prevista para início ou cancelar o serviço educacional, hipóteses em que restituirá os valores pagos, se houver, sem qualquer acréscimo. Dentre as hipóteses de cancelamento do serviço educacional, inclui-se o não atingimento da quantidade mínima de alunos para a abertura de turma(s) para qualquer curso.
                        <br>
                        7.5 O(A) Aluno(a) e/ou seu Representante Legal e o(s) Responsável(is) Financeiro(s) se obrigam a manter sempre atualizados os dados fornecidos no Contrato, especialmente o endereço, e-mail celular, assumindo integral responsabilidade pelos danos decorrentes de eventual desatualização.
                        <br>
                        7.6 O aluno declara neste termo, estar em plenas condições de saúde, apto a realizar atividades físicas e não portar nenhuma moléstia contagiosa que possa prejudicar os demais alunos da FESC. Não obstante a declaração de saúde, é dever do aluno apresentar atestado médico específico para a prática da(s) atividade(s) contratada(s), comprometendo-se a apresentar atestado médico no ato da matrícula e renová-lo anualmente, para os cursos da UATI, ou semestralmente, para os cursos da Piscina Aquecida.
                        <br>
                    <strong>8.	FORO</strong><br>
                        8.1 Fica eleito o Foro da Comarca de São Carlos para dirimir quaisquer controvérsias oriundas do presente ajuste.
                        <br>
                        <strong>9.	PROTEÇÃO DOS DADOS</strong><br>
                        9.1 O aluno declara ter ciência que os dados pessoais coletados pela pela Fundação Educacional São Carlos serão armazenados e processados em servidores terceiros, porém com acesso exclusivo à Fundação para o controle de suas atividades pedagógicas e contábeis em conformidade com a Lei nº 13.709/2018.
                </p>

                
                <div align="right">
                    <p>
                        São Carlos,
                                <span id="FormView1_data_atual">{{date("d/m/Y")}}</span>
                  </p>
          </div>
                
                                <table border="0" cellpadding="2" cellspacing="2" width="100%" style="height:100px;" class="texto">
                                    <tr>
                                    <td align="center" style="text-align:center;">
                                        <img src="{{asset('img/assinaturas/cotrim.png')}}" width="150px"  /></br>
                                        __________________________________</spam><br/>
                                        Eduardo Antonio Teixeira Cotrim
                                            </br>
                                            <strong>Diretor Presidente da FESC</strong>
                                       
                                      <td align="center" style="text-align:center;">
                                            <br><br><br><br><br>
                                            <span>
                                            __________________________________</spam><br/>


                                            <span id="FormView1_AluNomAss">{{$pessoa->nome}}</span>
                                            </br>
                                            <strong>Aluno(a) ou Responsável por procuração.</strong>
                                            </br><span id="FormView1_MatResNomLabel"></span>
                                            </br>
                                      </td>
                                    </tr>
                                </table>

                <br />
                </br>
                    <div>
			
		</div>
                <br />
                <div>

		</div>
                
      </td>
	</tr>
</table>


        
    </form>
</body>
</html>
<!DOCTYPE html>
<!--
 * OpenBoleto - Geração de boletos bancários em PHP
 *
 * LICENSE: The MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this
 * software and associated documentation files (the "Software"), to deal in the Software
 * without restriction, including without limitation the rights to use, copy, modify,
 * merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-->
<html lang="pt-BR">

   <head>
      <meta charset="UTF-8">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>
	  	Boletos em Lote v2024
      </title>
      <link rel="stylesheet" href="{{ asset('css/boletos.css')}}">
   </head>

   <body>

      <div style="width: 666px">
         
         <div class="noprint info">
            <h2>Instruções de Impressão</h2>
            <ul>
               <li>Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use modo
                  econômico).</li>
               <li>Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens mínimas à esquerda e à direita
                  do
                  formulário.</li>
               <li>Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o código de
                  barras.</li>
               <li>Caso não apareça o código de barras no final, pressione F5 para atualizar esta tela.</li>
               <li>Caso tenha problemas ao imprimir, copie a sequencia numérica abaixo e pague no caixa eletrônico
                  ou no
                  internet banking:</li>
            </ul>
            <span class="header">Linha Digitável:
			{{ $boleto->dados["linha_digitavel"]}}
            </span>
            <span class="header">Valor: R$
			{{ $boleto->dados["valor_boleto"]}}
            </span>
            
          
            <br>
            <div class="linha-pontilhada" style="margin-bottom: 20px;">Recibo do pagador</div>
         </div>
         

         <table class="table-boleto" cellpadding="0" cellspacing="0" border="0">
            <tbody>
               <tr>
                  <td valign="bottom" colspan="8" class="noborder nopadding">
                     <div class="logocontainer">
                        <div class="logobanco">
                           <img src="{{asset('img/logobb.gif')}}" alt="logotipo do BB">
                        </div>
                        <div class="codbanco">
						{{ $boleto->dados["codigo_banco_com_dv"]}}
                        </div>
                     </div>
                     <div class="linha-digitavel">
					 {{ $boleto->dados["linha_digitavel"]}}
                     </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="3" width="250" rowspan="2" valign="top">
                     <div class="titulo">Beneficiário</div>
                     <div class="conteudo">
					 {{ $boleto->dados["cedente"]}}<br />
					 Rua São Sebastião, 2828 Vila Nery<br />
					 13560-230 - São Carlos - SP
                     </div>
                  </td>
                  <td colspan="2">
                     <div class="titulo">CPF/CNPJ do Beneficiário</div>
                     <div class="conteudo">
					 {{ $boleto->dados["cpf_cnpj"]}}
                     </div>
                  </td>
               </tr>
               <tr>
                  <td width="120">
                     <div class="titulo">Agência/Código do Beneficiário</div>
                     <div class="conteudo rtl">
					 {{ $boleto->dados["agencia_codigo"]}}
                     </div>
                  </td>
                  <td width="110">
                     <div class="titulo">Vencimento</div>
                     <div class="conteudo rtl">
					 {{ $boleto->dados["data_vencimento"]}}
                     </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="3">
                     <div class="titulo">Pagador</div>
                     <div class="conteudo float_left">
					 {{ $boleto->dados["sacado"]}}
                     </div>
                     <div class="conteudo cpf_cnpj">
					 {{ $boleto->dados["cpf_sacado"]}}
                     </div>
                  </td>
                  <td>
                     <div class="titulo">Nº documento</div>
                     <div class="conteudo rtl">
					 {{ $boleto->dados["numero_documento"]}}
                     </div>
                  </td>
                  <td>
                     <div class="titulo">Nosso número</div>
                     <div class="conteudo rtl">
					 {{ $boleto->dados["nosso_numero"]}}
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div class="titulo">Espécie</div>
                     <div class="conteudo">
					 {{ $boleto->dados["especie"]}}
                     </div>
                  </td>
                  <td>
                     <div class="titulo">Quantidade</div>
                     <div class="conteudo rtl">
					 {{ $boleto->dados["quantidade"]}}
                     </div>
                  </td>
                  <td>
                     <div class="titulo">Valor</div>
                     <div class="conteudo rtl">
					 {{ $boleto->dados["valor_boleto"]}}
                     </div>
                  </td>
                  <td>
                     <div class="titulo">(-) Descontos / Abatimentos</div>
                     <div class="conteudo rtl">
                        
                     </div>
                  </td>
                  <td>
                     <div class="titulo">(=) Valor Documento</div>
                     <div class="conteudo rtl">
					 	{{$boleto->valor_cobrado}}
                     </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <div class="conteudo"></div>
                     <div class="titulo">Demonstrativo</div>
                  </td>
                  <td>
                     <div class="titulo">(-) Outras deduções</div>
                     <div class="conteudo">
                        
                     </div>
                  </td>
                  <td>
                     <div class="titulo">(+) Outros acréscimos</div>
                     <div class="conteudo rtl">
                    &nbsp;
                     </div>
                  </td>
                  <td>
                     <div class="titulo">(=) Valor cobrado</div>
                     <div class="conteudo rtl">
					 {{$boleto->valor_cobrado}}
                     </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="4">
                     <div style="margin-top: 10px" class="conteudo">
					 @foreach($lancamentos as $lancamento)
						{{ $lancamento->referencia}} - R$ {{ $lancamento->valor}}
						<BR>
						
					@endforeach
                     </div>
                  </td>
                  <td class="noleftborder">
                     <div class="titulo">Autenticação mecânica</div>
                  </td>
               </tr>
               <tr>
                  <td colspan="4" class="notopborder">
                     <table style="width: 100%;" cellpadding="0" cellspacing="0" border="0"
                        style="margin:0; padding:0;">
                        <tbody style="margin:0; padding:0;">
                           <tr style="margin:0; padding:0;">
                              <td style="margin:0; padding:0;" class="noborder">
                                 <div class="conteudo">
                                    &nbsp;
                                 </div>
                              </td>
                           </tr>
                           <tr style="margin:0; padding:0;">
                              <td style="margin:0; padding:0;" class="noborder">
                                 <div class="conteudo">
                                    &nbsp;
                                 </div>
                              </td>
                           </tr>
                           <tr style="margin:0; padding:0;">
                              <td style="margin:0; padding:0;" class="noborder">
                                 <div class="conteudo">
                                    &nbsp;
                                 </div>
                              </td>
                           </tr>
                           <tr style="margin:0; padding:0;">
                              <td style="margin:0; padding:0;" class="noborder">
                                 <div style="margin-bottom: 10px;" class="conteudo">
                                    &nbsp;
                                 </div>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
                  <td class="notopborder nobottomborder noleftborder" style="text-align:center">
                     
                     <img src="{{asset('img/qrcode.php').'?code='. $boleto->dados["pix"]}}" alt="QR Code" width="100px" />
                     
                  </td>
               </tr>
               <tr>
                  <td colspan="5" class="notopborder bottomborder"
                     style="padding: 0px 20px 10px 0px; text-align: right">
                     <div class="titulo">Recibo do pagador</div>
                  </td>
               </tr>
            </tbody>
         </table>
         <br>
         <div class="linha-pontilhada">Corte na linha pontilhada</div>
         <br>

         <!-- Ficha de compensação -->
         <table class="table-boleto" cellpadding="0" cellspacing="0" border="0">
            <tbody>
               <tr>
                  <td valign="bottom" colspan="8" class="noborder nopadding">
                     <div class="logocontainer">
                        <div class="logobanco">
                           <img src="{{asset('img/logobb.gif')}}" alt="logotipo do banco">
                        </div>
                        <div class="codbanco">
                        {{ $boleto->dados["codigo_banco_com_dv"]}}
                        </div>
                     </div>
                     <div class="linha-digitavel">
                     {{ $boleto->dados["linha_digitavel"]}}
                     </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="7">
                     <div class="titulo">Local de pagamento</div>
                     <div class="conteudo">
                        Qualquer banco ou Pix até o vencimento
                     </div>
                  </td>
                  <td width="180">
                     <div class="titulo">Vencimento</div>
                     <div class="conteudo rtl">
                     {{ $boleto->dados["data_vencimento"]}}
                     </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="7" rowspan="2" valign="top">
                     <div class="titulo">Beneficiário</div>
                     <div class="conteudo float_left">
                     {{ $boleto->dados["cedente"]}}<br />
                     Rua São Sebastião, 2828 Vila Nery<br />
                     13560-230 - São Carlos - SP
                     </div>
                     <div class="conteudo cpf_cnpj">
                     {{ $boleto->dados["cpf_cnpj"]}}
                     </div>


                  </td>
                  <td>
                     <div class="titulo">Agência/Código beneficiário</div>
                     <div class="conteudo rtl">
                     {{ $boleto->dados["agencia_codigo"]}}
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div class="titulo">Nosso número</div>
                     <div class="conteudo rtl">
                     {{ $boleto->dados["nosso_numero"]}}
                     </div>
                  </td>
               </tr>
               <tr>
                  <td width="110" colspan="2">
                     <div class="titulo">Data do documento</div>
                     <div class="conteudo">
                        {{ $boleto->dados["data_documento"]}}
                     </div>
                  </td>
                  <td width="120" colspan="2">
                     <div class="titulo">Nº documento</div>
                     <div class="conteudo">
                        {{ $boleto->dados["numero_documento"]}}
                     </div>
                  </td>
                  <td width="60">
                     <div class="titulo">Espécie doc.</div>
                     <div class="conteudo">
                     {{ $boleto->dados["especie"]}}
                     </div>
                  </td>
                  <td>
                     <div class="titulo">Aceite</div>
                     <div class="conteudo">
                     {{ $boleto->dados["aceite"]}}
                     </div>
                  </td>
                  <td width="110">
                     <div class="titulo">Data processamento</div>
                     <div class="conteudo">
                     {{ $boleto->dados["data_processamento"]}}
                     </div>
                  </td>
                  <td>
                     <div class="titulo">(=) Valor do Documento</div>
                     <div class="conteudo rtl">
                     {{ $boleto->dados["valor_boleto"]}}
                     </div>
                  </td>
               </tr>
               
               <tr>
                  <td colspan="7" valign="top">
                     <div class="titulo">Instruções (Texto de responsabilidade do beneficiário)</div>
                  </td>
                  <td>
                     <div class="titulo">(-) Outras deduções</div>
                     <div class="conteudo rtl">
                        &nbsp;
                     </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="7" class="notopborder" valign="top">
                     <div class="conteudo">
                     {{ $boleto->dados["instrucoes1"] }}
                     </div>
                     <div class="conteudo">
                     {{ $boleto->dados["instrucoes2"] }}
                     </div>
                  </td>
                  <td>
                     <div class="titulo">(+) Mora / Multa</div>
                     <div class="conteudo rtl">
                        &nbsp;
                     </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="7" class="notopborder">
                     <div class="conteudo">
                     {{ $boleto->dados["instrucoes3"] }}
                     </div>
                     <div class="conteudo">
                     {{ $boleto->dados["instrucoes4"] }}
                     </div>
                  </td>
                  <td>
                     <div class="titulo">(+) Outros acréscimos</div>
                     <div class="conteudo rtl">
                        &nbsp;
                     </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="7" class="notopborder">
                     <div class="conteudo">
                        &nbsp;
                     </div>
                     <div class="conteudo">
                       &nbsp;
                     </div>
                  </td>
                  <td>
                     <div class="titulo">(=) Valor cobrado</div>
                     <div class="conteudo rtl">
                     {{$boleto->valor_cobrado}}
                     </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="7" valign="top">
                     <div class="titulo">Pagador</div>
                     <div class="conteudo float_left">
                     {{ $boleto->dados["sacado"]}}<br />
                     {{ $boleto->dados["endereco1"]}}<br />
                     {{ $boleto->dados["endereco2"]}}
                     </div>
                     <div class="conteudo cpf_cnpj">
                     {{ $boleto->dados["cpf_sacado"]}}
                     </div>
                  </td>
                  <td class="noleftborder">
                     <div class="titulo" style="margin-top: 50px">Cód. Baixa</div>
                  </td>
               </tr>

               <tr>
                  <td colspan="6" class="noleftborder">
                     <div class="titulo">Pagador / Avalista <div class="conteudo pagador">
                           &nbsp;
                        </div>
                     </div>
                  </td>
                  <td colspan="2" class="norightborder noleftborder">
                     <div class="conteudo noborder rtl">Autenticação mecânica - Ficha de Compensação</div>
                  </td>
               </tr>

               <tr>
                  <td colspan="8" class="noborder">
                  <img src="{{asset('img/barcode.php').'?code='. $boleto->dados["codigo_barras"]}}"  with="600" height="50">
                  </td>
               </tr>

            </tbody>
         </table>
        
      </div>
   </body>

</html>
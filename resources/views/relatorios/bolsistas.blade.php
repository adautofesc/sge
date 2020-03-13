<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/')}}/css/vendor.css"/>
<title>SGE - Relatório de bolsistas - Fesc</title>
<style type="text/css">
	@media print {
            .hide-onprint { 
                display: none;
            }
             .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
        		float: left;
  				}
		   .col-sm-12 {
		        width: 100%;
		   }
		   .col-sm-11 {
		        width: 91.66666667%;
		   }
		   .col-sm-10 {
		        width: 83.33333333%;
		   }
		   .col-sm-9 {
		        width: 75%;
		   }
		   .col-sm-8 {
		        width: 66.66666667%;
		   }
		   .col-sm-7 {
		        width: 58.33333333%;
		   }
		   .col-sm-6 {
		        width: 50%;
		   }
		   .col-sm-5 {
		        width: 41.66666667%;
		   }
		   .col-sm-4 {
		        width: 33.33333333%;
		   }
		   .col-sm-3 {
		        width: 25%;
		   }
		   .col-sm-2 {
		        width: 16.66666667%;
		   }
		   .col-sm-1 {
		        width: 8.33333333%;
		   }
		   table{
				font-size: 11px;
			}
        }

</style>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-2 col-sm-2">
			<img src="{{asset('/')}}/img/logofesc.png" width="80"/>
			</div>
			<div class="col-xs-10 col-sm-10">
             <small>   
			<p>
			<strong>FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong><br/>
			Rua São Sebastião, 2828, Vila Nery <br/>
			São Carlos - SP. CEP 13560-230<br/>
			Tel.: (16) 3372-1308 e 3372-1325
			</p>
        </small>
			</div>
			
		</div>
		<br/>
		<div class="title-block">
			<center>
            <h3 class="title"> Relatório de bolsistas </h3>
            <h5 class="title"> Filtrado por mais de 3 faltas consecutivas.
            		 
            </h5></center>
        </div>
        <br>
        <br>
        Total de bolsistas: <strong>{{count($bolsas)}}</strong> .
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <table>
                    <thead >
                        <th width="5%">ID Pessoa</th>
                        <th width="50%">Nome</th>
						<th width="15%">Data da solicitação</th>
						<th width="30%">Tipo</th>
                        
                    </thead>
                    <tbody>
                    @foreach($bolsas as $bolsa)
                    <tr style="border-bottom: 1px solid gray;">
                        <td><a href="#">{{$bolsa->pessoa}}</a></td>
                        <td>
                            {{$bolsa->getNomePessoa()}}
                        </td>
                        <td>
                            {{$bolsa->created_at->format('d/m/Y')}}
						</td>
					<td>{{$bolsa->desconto->nome}}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
                </table>


       
                
         
             </div>
        </div>


        	
	<script src="{{asset('/')}}/js/vendor.js">
	</script>
</body>

</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/')}}/css/vendor.css"/>
<title>Cancelamento de matrícula - Fesc</title>
<style type="text/css">
	h5{
		font-size: 1.3em;
		margin: 0 0 0 0;
	}
	@media print {

            .hide-onprint { 
                display: none;
            }
        }
    .cut {
    	margin-top: 5%;
    	margin-bottom: 5%;

		border-bottom: 1px gray dashed;
	}

	.cut p {
		margin: 0 0 5px 0;
		padding: 0px;
		font-family: 'Arial Narrow';
		font-size: 9px;
	}
</style>
</head>

<body>
	<div class="container">
		<div class="row hide-onprint">
			<div class="col-xs-12" style="margin-top: 20px;margin-bottom: 50px;">
				<a href="#" class="btn btn-primary" onclick="print();">Imprimir</a>
				<a href="{{asset('/secretaria/atender')}}/{{$pessoa->id}}" class="btn btn-primary" >Voltar ao atendimento</a>
			</div>
		</div>
		<div class="row" style="margin-bottom: 0;">
			<div class="col-xs-2" tyle="margin-bottom: 0;">
				<img src="{{asset('/')}}/img/logofesc.png" width="80"/>
			</div>
			<div class="col-xs-6" tyle="margin-bottom: 0;">
				<p>
					<small><small>
						<strong>
						FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong><br/>
						Rua São Sebastião, 2828, Vila Nery <br/>
						São Carlos - SP. CEP 13560-230<br/>
						Tel.: (16) 3372-1308 e 3372-1325
					</small></small>
				</p>
			</div>
			<div class="col-4" tyle="margin-bottom: 0;" align="right">
				<img src="/img/code39.php?code=CM{{$matricula->id}}">
			
			</div>

			
		</div>
	
		<div class="title-block">
			<center>
            <h5> <strong>CANCELAMENTO DE MATRÍCULA {{$matricula->id}}</strong></h5></center>
        </div>


        <div class="row">
        	<div class="col-xs-12">

	        	<p style="margin-top: 5%">
	        		Eu, {{$pessoa->nome}}, alun{{\App\Pessoa::getArtigoGenero($pessoa->genero)}} regularmente matriculad{{\App\Pessoa::getArtigoGenero($pessoa->genero)}} nesta instituição no ano de {{date("Y")}}, venho pela presente, DECLARAR MINHA DESISTÊNCIA À VAGA, NAS TURMAS DOS CURSOS ABAIXO:
		       </p>
		       <ul>
		       	@foreach($inscricoes as $inscricao)
		       		@if(isset($inscricao->turma->disciplina->nome))
		       		<li> {{$inscricao->turma->curso->nome}},{{$inscricao->turma->disciplina->nome}} ({{implode(',',$inscricao->turma->dias_semana)}}  das  {{$inscricao->turma->hora_inicio}} às {{$inscricao->turma->hora_termino}})</li>
		       		@else
		       		<li> {{$inscricao->turma->curso->nome}} ({{implode(',',$inscricao->turma->dias_semana)}}. das  {{$inscricao->turma->hora_inicio}} às {{$inscricao->turma->hora_termino}})</li>
		       		@endif

		       	@endforeach
		       </ul>
		       <p style="margin-top: 8%" align="center">
		       	São Carlos, {{$matricula->updated_at->format('d')}} de {{(new \App\classes\Data($matricula->updated_at->format('d/m/Y')))->mes()}} de {{$matricula->updated_at->format('Y')}}.
		       </p>
		       <center>
		       <p style="border-top: solid 1px black; width: 30%; margin-top: 10%" align="center" >
		       	{{$pessoa->nome}}
		       </p></center>
        	</div>
        </div>

        @if(count($matricula->getInscricoes())>4)
        <div style="page-break-before: always;"> </div>   
        @else
        <div class="cut">
			<p>corte na linha pontilhada</p>
		</div>
		@endif
		<div class="row">
        	<div class="col-xs-2" tyle="margin-bottom: 0;">
				<img src="{{asset('/')}}/img/logofesc.png" width="60"/>
			</div>
			<div class="col-xs-4" tyle="margin-bottom: 0;">
				<p>
					<small><small>
						<strong>
						FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong><br/>
						Rua São Sebastião, 2828, Vila Nery <br/>
						São Carlos - SP. CEP 13560-230<br/>
						Tel.: (16) 3372-1308 e 3372-1325
					</small></small>
				</p>
			</div>
			<div class="col-xs-6" tyle="margin-bottom: 0;" align="right">
				<img src="/img/code39.php?code=CM{{$matricula->id}}">
			
			</div>
        </div>
			
			
       


        <div class="row">
        	<div class="col-xs-12">

	        	<p style="margin-top: 0%">
	        		<strong>PROTOCOLO DE CANCELAMENTO DE MATRÍCULA {{$matricula->id}}</strong><br>
	        		Eu, {{$pessoa->nome}}, alun{{\App\Pessoa::getArtigoGenero($pessoa->genero)}} regularmente matriculad{{\App\Pessoa::getArtigoGenero($pessoa->genero)}} nesta instituição no ano de {{date("Y")}}, venho pela presente, DECLARAR MINHA DESISTÊNCIA À VAGA, NAS TURMAS DOS CURSOS ABAIXO:
		       </p>
		       <ul>
		       	@foreach($inscricoes as $inscricao)
		       		@if(isset($inscricao->turma->disciplina->nome))
		       		<li> {{$inscricao->turma->curso->nome}},{{$inscricao->turma->disciplina->nome}} ({{implode(',',$inscricao->turma->dias_semana)}}  das  {{$inscricao->turma->hora_inicio}} às {{$inscricao->turma->hora_termino}})</li>
		       		@else
		       		<li> {{$inscricao->turma->curso->nome}} ({{implode(',',$inscricao->turma->dias_semana)}}. das  {{$inscricao->turma->hora_inicio}} às {{$inscricao->turma->hora_termino}})</li>
		       		@endif
		       	@endforeach
		       </ul>
		       <p  align="center">
		       		São Carlos, {{$matricula->updated_at->format('d')}} de {{(new \App\classes\Data($matricula->updated_at->format('d/m/Y')))->mes()}} de {{$matricula->updated_at->format('Y')}}.
		       </p>
		       <center>
		       <p style="border-top: solid 1px black; width: 30%; margin-top: 5%" align="center" >
		       	{{session("nome_usuario")}} - Servidor da FESC.
		       </p></center>
        	</div>
        </div>
 



	</div>
	     	
	<script src="{{asset('/')}}/js/vendor.js">
	</script>
</body>

</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<style type="text/css">
@media screen,print {

    /* *** TIPOGRAFIA BASICA *** */
    .page-break { 
    page-break-before: always; 
    }

    * {
        margin: 0;
        padding: 0;
    }
}

	</style>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
<title>Documento Oficial - Fesc</title>
</head>

<body>
	@foreach($turmas as $turma)
	<div class="container">
		<div class="row">
			<div class="col-xs-1" >
			<img src="{{asset('/img/logofesc.png')}}" width="65"/>
			</div>
			<div class="col-xs-4" style="margin-left: 1rem;">
			<p style="font-size: 0.6rem;">
			<strong>FUNDAÇÃO EDUCACIONAL SÃO CARLOS</strong><br/>
			Rua São Sebastião, 2828, Vila Nery <br/>
			São Carlos - SP. CEP 13560-230<br/>
			Tel.: (16) 3372-1308 e 3372-1325<br/>
			<i>Emitido em: {{date('d/m/Y H:i')}}</i>
			</p>
			</div>
            <div class="col-xs-2" style="margin-left: -1rem; text-align: center">
                <img src="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=https://sistema.fesc.com.br/docentes/frequencia/nova-aula/{{$turma->id}}&choe=UTF-8" width="100px" title="Link para a chamada dessa turma">
                 
            </div>
			<div class="col-xs-5">
					 <h3 class="title" style="font-size: 1rem;">Turma {{$turma->id}} - 
        @if(!empty($turma->disciplina->nome))
            {{$turma->disciplina->nome}} / 
        @endif
        {{$turma->curso->nome}}

    </h3>
    <p class="title-description" style="font-size: 0.7rem">
        
        @foreach($turma->dias_semana as $dia)
            {{ucwords($dia)}}, 
        @endforeach
        das {{$turma->hora_inicio}} às {{$turma->hora_termino}} - 
        Prof(a). {{$turma->professor->nome_simples}}
        <br>
        @if($turma->status == 'andamento' || $turma->status == 'iniciada' )
        <span  class="badge badge-pill badge-success" style="font-size: 0.8rem">
        @elseif($turma->status == 'espera' || $turma->status == 'lancada' || $turma->status == 'inscricao' )
         <span  class="badge badge-pill badge-info" style="font-size: 0.8rem">
        @elseif($turma->status == 'cancelada')
         <span  class="badge badge-pill badge-danger" style="font-size: 0.8rem">
        @else
         <span  class="badge badge-pill badge-secondary" style="font-size: 0.8rem">
        @endif

            <i class="fa fa-{{$turma->icone_status}} icon"></i> {{$turma->status}}
        </span>
        Início em {{$turma->data_inicio}} Término em {{$turma->data_termino}}
    </p>
			</div>
		</div>
	
        <div class="row">
        	<div class="col-xs-12">
	        	
		    
		        <table class="table table-striped table-condensed" style="font-size: 11px;">
                        <thead style="line-height: 0.6rem">
                            <th width="0px">&nbsp;</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th>Venc. Atestado</th>
                        </thead>
                        <tbody>
                        	@php($a = 0)
                            @foreach($turma->inscricoes as $inscricao)
                            @php($a++)
                            <tr style="line-height: 0.3rem">
                                <td>
                                    <!--
                                    <small>
                                        <a hrfe="#" class="btn btn-danger btn-sm" title="Remover esta pessoa da turma" onclick="remover('{{$inscricao->id}}')">
                                            <i class=" fa fa-times text-white"></i>
                                        </a>
                                    </small>-->
                                   {{$a}}
                                </td>
                                <td>
                                    
                                   
                                    <b>{{$inscricao->pessoa->nome}}</b>
                                    
                                   
                                </td>
                                <td>
                                   
                                    @foreach($inscricao->telefone as $telefone)
                                   
                                    {{\App\classes\Strings::formataTelefone($telefone->valor)}} . 
                                    @endforeach
                                    
                                </td>
                                <td>
                                    <e-mail>{{$inscricao->pessoa->getEmail()}}</e-mail>
                                </td>
                                <td>
                                    @if(isset($inscricao->atestado))
                                        @if($inscricao->atestado->validade<=date('Y-m-d'))
                                       <span>{{\Carbon\Carbon::parse($inscricao->atestado->validade)->format('d/m/y')}} <i class="fa fa-warning"></i> 
                                        @else
                                        <span> {{\Carbon\Carbon::parse($inscricao->atestado->validade)->format('d/m/y')}}
                                        @endif
                                    
                                </span>

                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
        	</div>
	        
        </div>
  
	</div>
	<div class="page-break"></div>
	@endforeach
        	
	<script src="{{asset('/js/vendor.js')}}">
	</script>
</body>

</html>

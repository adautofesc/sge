@extends('layout.app')
@section('titulo')Cancelamento de inscrição @endsection
@section('pagina')

<div class="title-search-block">
    <div class="title-block">
        <h3 class="title">Alun{{$pessoa->getArtigoGenero($pessoa->genero)}}: {{$pessoa->nome}} 
            @if(isset($pessoa->nome_resgistro))
                ({{$pessoa->nome_resgistro}})
            @endif
           
        </h3>
        <p class="title-description"> <b> Cod. {{$pessoa->id}}</b> - Tel. {{$pessoa->telefone}} </p>
    </div>
</div>
@include('inc.errors')
<form name="item" method="post" enctype="multipart/form-data">
{{csrf_field()}}
    <div class="card card-block">
    	<div class="subtitle-block">
            <h3 class="subtitle"><i class=" fa fa-minus-circle" style="color:red"></i> Cancelamento da INSCRIÇÃO {{ $inscricao->id}}</h3>
            <small><STRONG>APÓS O CANCELAMENTO, NÃO HAVERÁ GARANTIA DE VAGAS.</STRONG></small>
        </div>
		<div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">Motivo do cancelamento</label>
            <div class="col-sm-10"> 
                <div>
                  
                    <label>
                    <input class="checkbox" type="checkbox" name="cancelamento[0]" value="Problemas com horário" >
                    <span>Problemas com horário</span>
                    </label><br>
                    <label>
                    <input class="checkbox" type="checkbox"  name="cancelamento[1]" value="Problemas de saúde / alergias" >
                    <span>Problemas de saúde / alergias</span>
                    </label><br>
                    <label>
                     <input class="checkbox" type="checkbox"  name="cancelamento[2]" value="Problemas com transporte" >
                    <span>Problemas com transporte</span>
                    </label><br>
                    <label>
                     <input class="checkbox" type="checkbox"  name="cancelamento[3]" value="Problemas financeiros" >
                    <span>Problemas financeiros</span>
                    </label><br>
                    <label>
                     <input class="checkbox" type="checkbox"  name="cancelamento[4]" value="Problemas no atendimento (administrativo)" >
                    <span>Problemas no atendimento (administrativo)</span>
                    </label><br>
                    <label>
                    <input class="checkbox" type="checkbox"  name="cancelamento[5]" value="Problemas no atendimento (secretaria)" >
                    <span>Problemas no atendimento (secretaria)</span>
                    </label><br>
                    <label>
                    <input class="checkbox" type="checkbox"  name="cancelamento[6]" value="Problemas no atendimento (professores)" >
                    <span>Problemas no atendimento (professores)</span>
                    </label><br>
                    <label>
                    <input class="checkbox" type="checkbox" n name="cancelamento[7]" value="Insatisfação com a infra-estrutura (acessibilidade, segurança, estacionamento)" >
                    <span>Insatisfação com a infra-estrutura (acessibilidade, segurança, estacionamento) </span>
                    </label><br>
                    <label>
                   <input class="checkbox" type="checkbox"  name="cancelamento[8]" value="Insatisfação com a manutenção das instalações (limpeza, conservação de equipamentos)" >
                    <span>Insatisfação com a manutenção das instalações (limpeza, conservação de equipamentos)</span>
                    </label><br>
                    <label>
                   <input class="checkbox" type="checkbox"  name="cancelamento[9]" value="Insatisfação com as aulas" >
                    <span>Insatisfação com as aulas</span>
                    </label><br>
                    <label>
                   <input class="checkbox" type="checkbox"  name="cancelamento[10]" value="Transferência de turma" >
                    <span>Transferencia de turma</span>
                    </label><br>
                    <label>
                    <input class="checkbox" type="checkbox"  name="cancelamento[11]" value="Outros/prefiro não dizer." >
                    <span>Outro(s)/prefiro não dizer.</span>
                    </label><br>
                   
             
                </div>
            </div>        
        </div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right"></label>
			<div class="col-sm-10 col-sm-offset-2"> 
				<input type="hidden" name="pessoa" value="{{$pessoa->id}}">
                <input type="hidden" name="inscricao" value="{{$inscricao->id}}">
                <button type="submit" name="btn"  class="btn btn-danger">SALVAR</button>
                <button type="reset" name="btn"  class="btn btn-primary">Restaurar</button>
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
			</div>
       </div>
    </div>
</form>
 </div>
</section>
@endsection
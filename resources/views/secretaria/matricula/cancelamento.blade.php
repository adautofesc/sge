@extends('layout.app')
@section('titulo')Cancelamento de Matrícula @endsection
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
            <h3 class="subtitle"><i class=" fa fa-minus-circle" style="color:red"></i> Cancelamento da MATRICULA {{ $matricula->id}}</h3>
            <small><STRONG>TODAS TURMAS VINCULADAS A ESSA MATRÍCULA SERÃO CANCELADAS</STRONG></small>
        </div>
        <!--
		<div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Motivo
            </label>
            <div class="col-sm-6"> 
                <select name="desconto" class="c-select form-control boxed" ">
                    <option value="1">Problemas com o horário</option>
                    <option value="1">Problemas com o transporte</option>
                    <option value="1">Problemas de saúde</option>
                    <option value="2">Problemas com os Professores</option>
                    <option value="3">Problemas financeiros</option>
                    <option value="4">Problemas com o atendimento (secretaria) </option>
                    <option value="4">Problemas com o atendimento (adminstrativo) </option>
                    <option value="5">Problemas com a infra-estrutura do local</option>
                </select>
            </div>
        </div>
    -->
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
            <label class="col-sm-2 form-control-label text-xs-right">ATENÇÂO!</label>
            <div class="col-sm-10"> 
                <div>
                    <label>
                    <input class="checkbox" type="checkbox" name="cancelar_boletos" checked="checked" >
                    <span>Cancelar boletos</span>
                    </label>
                </div>
            </div>
        </div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right"></label>
			<div class="col-sm-10 col-sm-offset-2"> 
				<input type="hidden" name="pessoa" value="{{$pessoa->id}}">
                <input type="hidden" name="matricula" value="{{$matricula->id}}">
                <button type="submit" name="btn"  class="btn btn-danger">SALVAR</button>
                <button type="reset" name="btn"  class="btn btn-primary">Restaurar</button>
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
			</div>
       </div>
    </div>
</form>

@endsection
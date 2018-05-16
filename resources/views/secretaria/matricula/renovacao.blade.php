@extends('layout.app')
@section('titulo')Renovação de matrícula @endsection
@section('pagina')
<style>
.label {
    background-color: #777;
    display: inline;
    padding: .2em .6em .3em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25em;
  }
  .turma{
    max-width:600px;
    text-align: left;
    

  }
</style>
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
    	<div class="title-block">
            <h3 class="title"><i class=" fa fa-check-square-o "></i> Renovação de marículas. </h3>
        </div>

        

        <section class="example">
            <div class="table-flip-scroll">
                <ul class="item-list striped">
                    <li class="item item-list-header hidden-sm-down">
                        <div class="item-row">
                            <div class="item-col fixed item-col-check">
                                <label class="item-check" id="select-all-items">
                                    <input type="checkbox" class="checkbox">
                                <span></span>
                                </label> 
                            </div>
                            
                            <div class="item-col item-col-header turma">
                                <div> <span>Turma atual</span> </div>
                            </div>
                            <div class="item-col item-col-header" style="max-width: 30px;">
                                <div> <span><i class="fa fa-chevron-right"></i></span> </div>
                            </div>

                            <div class="item-col item-col-header">
                                <div> <span>Turma nova</span> </div>
                            </div>
                            

                            
                        </div>
                    </li>
                    @foreach($matriculas as $matricula)
                    @foreach($matricula->inscricoes as $inscricao)

                    <li class="item">
                        <div class="item-row ">
                            <div class="item-col fixed item-col-check "> 

                                <label class="item-check" id="select-all-items">
                                <input type="checkbox" class="checkbox" name="turmas[]" value="{{$inscricao->turma->id}}">
                                <span></span>
                                </label>
                            </div>
                            
                            <div class="item-col turma ">
                                <div class="item-heading">Curso Atual</div>
                                <div class="">
                                    
                                         <div href="#" style="margin-bottom:5px;" class="color-primary">Turma {{$inscricao->turma->id}} - <i class="fa fa-{{$inscricao->turma->icone_status}}" title=""></i><small> {{$inscricao->turma->texto_status. ' - Começa em  ' .$inscricao->turma->data_inicio}}</small></div> 
                                        <strong>

                                   
                                    @if(isset($inscricao->turma->disciplina))
                                    
                                        <h4 class="item-title"> {{$inscricao->turma->disciplina->nome}}</h4>       
                                        <small>{{$inscricao->turma->curso->nome}}</small>
                                    
                                   @else
                                    
                                        <h4 class="item-title"> {{$inscricao->turma->curso->nome}}</h4>           
                                    
                                    @endif
                                    </strong>


                                     
                                     <p>Prof. <strong>{{$inscricao->turma->professor->nome_simples}}</strong><br>
                                       
                                     
                                    Local: <span class="label">{{$inscricao->turma->local->sigla}}</span> Horário: {{implode(', ',$inscricao->turma->dias_semana)}} - {{$inscricao->turma->hora_inicio}} ás {{$inscricao->turma->hora_termino}}</p>
                                </div>
                            </div>
                            <div  class="item-col" style="max-width: 30px">
                                <div class="item-heading"></div>
                                <div> <i class="fa fa-chevron-right"></i></div>
                            </div>
                            <div class="item-col">
                                <div class="item-heading">Nova Turma</div>
                                <div class="">
                                    
                                         <div style="margin-bottom:5px;" class="color-primary">Turma {{$inscricao->proxima_turma->first()->id}} - <i class="fa fa-{{$inscricao->proxima_turma->first()->icone_status}}" ></i><small> {{$inscricao->proxima_turma->first()->texto_status. ' - Começa em  ' .$inscricao->proxima_turma->first()->data_inicio}}</small></div> 
                                        <strong>

                                   
                                    @if(isset($inscricao->proxima_turma->first()->disciplina))
                                    
                                        <h4 class="item-title"> {{$inscricao->proxima_turma->first()->disciplina->nome}}</h4>       
                                        <small>{{$inscricao->proxima_turma->first()->curso->nome}}</small>
                                    
                                   @else
                                    
                                        <h4 class="item-title"> {{$inscricao->proxima_turma->first()->curso->nome}}</h4>           
                                    
                                    @endif
                                    </strong>


                                     
                                     <p>Prof. <strong>{{$inscricao->proxima_turma->first()->professor->nome_simples}}</strong><br>
                                       
                                     
                                    Local: <span class="label">{{$inscricao->proxima_turma->first()->local->sigla}}</span> Horário: {{implode(', ',$inscricao->proxima_turma->first()->dias_semana)}} - {{$inscricao->proxima_turma->first()->hora_inicio}} ás {{$inscricao->proxima_turma->first()->hora_termino}}</p>
                                </div>
                            </div>
                        </div>
                    </li> 
                    @endforeach
                    @endforeach
                </ul>
            </div>
        </section>
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right"></label>
			<div class="col-sm-10 col-sm-offset-2"> 
				<input type="hidden" name="pessoa" value="{{$pessoa->id}}">
                <button type="submit" name="btn"  class="btn btn-primary">Salvar</button>
                <button type="reset" name="btn"  class="btn btn-primary">Restaurar</button>
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
			</div>
       </div>
    </div>
</form>
@endsection
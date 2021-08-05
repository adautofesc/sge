@extends('perfil.layout')
@section('titulo')
    Perfil FESC - Rematrículas
@endsection

@section('style')
    <style>
     h1 {margin-top:2rem;
            font-size:14pt;
            font-weight: bold;}
        .description{
            margin-top:2rem;
            font-size:9pt;
        }
        table tr th{
            font-size: 9pt;
            
        }
        table tr td{
            font-size: 10pt;
            
        }
        .form{
            margin-top:2rem;
        }
        .button{
            margin-top:.1rem;
        }
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
@endsection
@section('body')
<div class="card mb-3">
                      
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12">
          <h5 class="mb-0">Rematricula</h5>
          
          <p class="text-secondary"><small>Selecione as atividades que deseja se rematricular</small></p>
          
          @if($errors->any())
            @foreach($errors->all() as $erro)
                <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" >×</button>       
                        <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
                </div>
            @endforeach
          @endif
        </div> 
      </div>
      <form method="POST" enctype="multipart/form-data">
      {{csrf_field()}}
        <table class="table">
            <tr>
                <th>&nbsp;</th>
                <th>Turma</th>
                <th>Dia e Horário</th>
                <th>Professor(a)</th>
                <th>Local</th>
            </tr>
         @foreach($matriculas as $matricula)
                @foreach($matricula->inscricoes as $inscricao)
                    @if($inscricao->proxima_turma->count()==1)
                        <tr>
                            <td><input type="checkbox" name="turma[]" value="{{$inscricao->proxima_turma->first()->id}}"></td>
                            <td>
                            <strong title="Começa em {{$inscricao->proxima_turma->first()->data_inicio}}">{{$inscricao->proxima_turma->first()->id}} </strong> - 
                                @if(isset($inscricao->proxima_turma->first()->disciplina))
                                        
                                    {{$inscricao->proxima_turma->first()->disciplina->nome}}     
                                    <small>{{$inscricao->proxima_turma->first()->curso->nome}}</small>
                            
                                @else
                            
                                    {{$inscricao->proxima_turma->first()->curso->nome}}        
                            
                                @endif
                            </td>
                            <td> 
                                {{implode(', ',$inscricao->proxima_turma->first()->dias_semana)}} {{$inscricao->proxima_turma->first()->hora_inicio}} ás {{$inscricao->proxima_turma->first()->hora_termino}}
                            </td>
                            <td>
                                {{$inscricao->proxima_turma->first()->professor->nome_simples}}
                            </td>
                            <td>
                                {{$inscricao->proxima_turma->first()->local->sigla}}
                            </td>
                        </tr>
                    @elseif($inscricao->proxima_turma->count()>1)

                    @foreach($inscricao->proxima_turma as $next)

                    <tr style="background-color:#f5f5f5;" title="Escolha uma opção">
                            <td><input type="radio" name="turma[{{$inscricao->id}}]" value="{{$next->id}}"></td>
                            <td>
                            <strong title="Começa em {{$next->data_inicio}}">{{$next->id}} </strong> - 
                                @if(isset($next->disciplina))
                                        
                                    {{$next->disciplina->nome}}     
                                    <small>{{$next->curso->nome}}</small>
                            
                                @else
                            
                                    {{$next->curso->nome}}        
                            
                                @endif
                            </td>
                            <td> 
                                {{implode(', ',$next->dias_semana)}} {{$next->hora_inicio}} ás {{$next->hora_termino}}
                            </td>
                            <td>
                                {{$next->professor->nome_simples}}
                            </td>
                            <td>
                                {{$next->local->sigla}}
                            </td>
                        </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="5"><small>Turma {{$inscricao->turma->id}} de {{$inscricao->turma->getNomeCurso()}} sem continuação disponível</small></td>
                    </tr>
                    @endif
                @endforeach
            @endforeach
        </table>
        
        <div class="form-group row">                
            <div class="col-md-12 form-group form"> 
                <input type="hidden" name="pessoa" value="{{$pessoa->id}}">
                <button type="submit" name="btn"  class="btn btn-success">Avançar</button>
                <button type="reset" name="btn"  class="btn btn-outline-secondary">Limpar</button>
                <button type="cancel" name="btn" class="btn btn-outline-secondary" onclick="history.back(-2);return false;">Cancelar</button>
            </div>
        </div>

      </form>

      
      
    </div>

  </div>

@endsection

@section('scripts')
<script>
function cancelar(){
  if(confirm("Confirmar saída do programa de parceria?"))
    window.location.replace('/perfil/parceria/cancelar');
}
 </script>   
@endsection
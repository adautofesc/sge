@extends('perfil.layout')
@section('titulo')
    Perfil FESC - Me matricular
@endsection

@section('style')
    <style>
      .rodape{
        margin-bottom:0px;
        padding-top:1rem;
        border-bottom: 1px solid WhiteSmoke;
        padding-bottom: 1rem;
        
      }
      .rodape:hover{
        background-color: whitesmoke;
      }
      hr{
        margin-bottom: 0;
      }
    </style>
@endsection
@section('body')
@php
    $valor = 0;
@endphp
<form action="/perfil/matricula/inscricao" method="post">
<div class="card mb-3">
                      
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12">
          <h5 class="mb-0">Confirme as turmas escolhidas</h6>
          
          <p class="text-secondary"><small>Atente-se aos dias e horários das turmas e ao Termo de Matrícula incluso abaixo.</small></p>
          <hr>
          @if($errors->any())
            @foreach($errors->all() as $erro)
                <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" >×</button>       
                        <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
                </div>
            @endforeach
          @endif
          @foreach($turmas as $turma)
          @php
          $valor += $turma->valor; 
          @endphp
          <div class="form-group row rodape">
            <div class="col-sm-1">
              <input type="hidden"  name="turma[]" value="{{$turma->id}}" >  <small>{{$turma->id}}</small> 
            </div>
            <div class="col-sm-8">
              <strong>{{$turma->getNomeCurso()}}</strong> - <small>De {{$turma->data_inicio}} a {{$turma->data_termino}}</small>
              <br> <small> {{implode(', ',$turma->dias_semana)}} - {{$turma->hora_inicio}} ás {{$turma->hora_termino}} | {{$turma->professor->nome_simples}}</small>
              

            </div>
            <div class="col-sm-2">
              R$ {{number_format($turma->valor,2,',','.')}} <br>
              <small> {{$turma->getParcelas()}}X R$ {{number_format($turma->valor/$turma->getParcelas(),2,',','.')}}</small>
              
            </div>
          </div>
          

          @endforeach
          <div class="form-group row rodape">
            <div class="col-sm-12">
              Valor total: <strong>R$ {{number_format($valor,2,',','.')}}</strong><br>
            </div>
          </div>
          <div class="form-group row rodape">
            <div class="col-sm-12">
            <input type="checkbox" class="checkbox" name="aceite" value="{{$turma->id}}" required > Concordo com o <a href="/perfil/matricula/termo" target="_blank">Termo de Matrícula</a>
            </div>
          </div>
          
          
        

          
          
        <div class="form-group row">
          <div class="col-sm-9">
            <button class="btn btn-success" type="submit" name="btn" >Confirmar</button> 
            <button type="reset" name="btn"  class="btn btn-outline-secondary">Limpar</button>
            <button type="cancel" name="btn" class="btn btn-outline-secondary" onclick="history.back(-1);return false;">Cancelar</button>
            @if(isset($parceria))
            <a href="#" class="btn btn-outline-danger" onclick="cancelar();"> Cancelar parceria</a>
            @endif
            @csrf
          </div>
        </div>
      

      
      
    </div>

  </div>
</form>
@endsection

@section('scripts')
<script>

 </script>   
@endsection
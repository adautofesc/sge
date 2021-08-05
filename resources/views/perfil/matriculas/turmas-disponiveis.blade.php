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
<form action="./confirmacao" method="post">
<div class="card mb-3">
                      
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12">
          <h5 class="mb-0">Matricule-se agora mesmo</h6>
          
          <p class="text-secondary"><small>Escolha as turmas que deseja se matricular.</small></p>
          <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" >×</button>       
            <p class="modal-title"><i class="fa fa-warning"></i> Os cursos virtuais serão realizados de forma síncrona (nos dias e horários previstos) através da plataforma Microsoft Teams. Os alunos receberão os dados de acesso e instruções por e-mail antes do início das aulas. Em caso de dúvidas ligue: (16) 3372-1308</p>
          </div>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" >×</button>       
            <p class="modal-title"><i class="fa fa-danger"></i>Antes de se matricular verifique se sua conexão e seu equipamento de acesso suportam o aplicativo Microsoft Teams</p>
          </div>
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
          @if($turma->verificaRequisitos($pessoa->id))
            @if($turma->matriculados<=$turma->vagas)
            <label class="form-group row rodape">
              <div class="col-sm-1">
                <input type="checkbox" class="checkbox" name="turma[]" value="{{$turma->id}}" >  <small>{{$turma->id}}</small> 
              </div>
              <div class="col-sm-8">
                <strong>{{$turma->nomeCurso}}</strong> - <small>De {{$turma->data_inicio}} a {{$turma->data_termino}}</small>
                <br> <small> {{implode(', ',$turma->dias_semana)}} - {{$turma->hora_inicio}} ás {{$turma->hora_termino}} | {{$turma->professor->nome_simples}}</small>
                

              </div>
              <div class="col-sm-2">
                R$ {{number_format($turma->valor,2,',','.')}} <br>
              <small> {{$turma->getParcelas()}}X R$ {{number_format($turma->valor/$turma->getParcelas(),2,',','.')}}</small>
                
              </div>
            </label>
            @else
            <div class="form-group row rodape alert-danger">
              <div class="col-sm-1">
                <input type="checkbox" class="checkbox"  readonly name="turma[]" value="{{$turma->id}}" title="Não há mais vagas neste curso" >  <small>{{$turma->id}}</small> 
              </div>
              <div class="col-sm-8">
                <strong>* SEM VAGAS</strong> | {{$turma->nomeCurso}} - <small>De {{$turma->data_inicio}} a {{$turma->data_termino}}</small>
                <br> <small> {{implode(', ',$turma->dias_semana)}} - {{$turma->hora_inicio}} ás {{$turma->hora_termino}} | {{$turma->professor->nome_simples}}</small>
                

              </div>
              <div class="col-sm-2">
                R$ {{number_format($turma->valor,2,',','.')}}
                
              </div>
            </div>
            @endif
          
          @endif

          @endforeach

          
          
        <div class="form-group row">
          <div class="col-sm-9">
            <button class="btn btn-success" type="submit" name="btn" >Cadastrar</button> 
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
@extends('perfil.layout')
@section('titulo')
    Minhas matrículas - Perfil FESC
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

<div class="card mb-3">
                      
    <div class="card-body">
      <div class="row">
        <div class="col-sm-8">
          <h5 class="mb-0">Matriculas ativas</h5>
          
          <p class="text-secondary"><small>Abaixo você encontrará a lista de matrículas ativas.</small></p>
          
          
          
        </div>
        <div class="col-sm-4">
          <a class="btn btn-success" href="/perfil/matricula/inscricao" title="Abre página para escolher os cursos que deseja se matricular.">Adicionar Matricula</a>
        </div>
        
      </div>
      <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" >×</button>       
        <p class="modal-title"><i class="fa fa-warning"></i> Os cursos virtuais serão realizados de forma síncrona (nos dias e horários previstos) através da plataforma Microsoft Teams. Os alunos receberão os dados de acesso e instruções por e-mail antes do início das aulas. Em caso de dúvidas ligue: (16) 3372-1308</p>
      </div>
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" >×</button>       
        <p class="modal-title"><i class="fa fa-danger"></i>Antes de se matricular verifique se sua conxão e seu equipamento de acesso suportam o aplicativo Microsoft Teams</p>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-12">
          @if($errors->any())
            @foreach($errors->all() as $erro)
                <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" >×</button>       
                        <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
                </div>
            @endforeach
          @endif
          @foreach($matriculas as $matricula)
                @foreach($matricula->inscricoes as $inscricao)
                <div class="form-group row rodape" title="Inscrição {{$inscricao->status}}">
                  
                  <div class="col-sm-9">
                    <strong>{{$inscricao->turma->getNomeCurso()}}</strong><br>  <small>De {{$inscricao->turma->data_inicio}} a {{$inscricao->turma->data_termino}}</small>
                    <small> toda {{implode(', ',$inscricao->turma->dias_semana)}} - {{$inscricao->turma->hora_inicio}} ás {{$inscricao->turma->hora_termino}} | Prof. {{$inscricao->turma->professor->nome_simples}}</small>
                    
      
                  </div>
                  <div class="col-sm-2">
                    <a href="/perfil/matricula/termo/{{$matricula->id}}?type=ead" target="_blank" class="btn btn-outline-info btn-sm" title="Termo de matrícula">
                      Termo</a>
                    
                  </div>
                </div>



                @endforeach
          @endforeach
         

          
        
      

      
      
    </div>

  </div>


@endsection

@section('scripts')
<script>
  function cancelar(id,nome){
    if(confirm('Deseja mesmo cancelar a matrícula do curso "'+nome+ '" ?'))
      window.location.href = './cancelar/'+id;
  }



 </script>   
@endsection
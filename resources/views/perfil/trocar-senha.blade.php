@extends('perfil.layout')
@section('titulo')
    Perfil FESC - Alterar Senha
@endsection

@section('style')
    <style>

    </style>
@endsection
@section('body')
<div class="card mb-3">
                      
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12">
          <h5 class="mb-0">Alteração de senha</h6>
          
          <p class="text-secondary"><small>Preencha os campos abaixo para alterar sua senha.</small></p>
          <hr>
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
      <form method="POST" >
        <div class="form-group row">
          <label class="col-sm-2 form-control-label text-xs-right text-secondary">Senha atual </label>
          <div class="col-sm-3"> 
              <input type="password" class="form-control boxed" name="senha" maxlength="50" required> 
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 form-control-label text-xs-right text-secondary">Nova senha </label>
          <div class="col-sm-3"> 
              <input type="password" class="form-control boxed" name="nova-senha" maxlength="50" required> 
          </div>
          <label class="col-sm-2 form-control-label text-xs-right text-secondary">Redigite </label>
          <div class="col-sm-3"> 
              <input type="password" class="form-control boxed" name="redigite-senha" maxlength="50" required> 
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-12 offset-sm-2">
            <button class="btn btn-info" type="submit" name="btn" >Trocar</button> 
            <button type="reset" name="btn"  class="btn btn-secondary">Limpar</button>
            <button type="cancel" name="btn" class="btn btn-secondary" onclick="history.back(-1);return false;">Cancelar</button>
            @csrf
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
@extends('perfil.layout')
@section('titulo')
    Perfil FESC - Programa de Parceria
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
          <h5 class="mb-0">Programa de parceria</h5>
          
          <p class="text-secondary"><small>Cadastre ou atualize seu currículo para eventuais parcerias.</small></p>
          <hr>
          @if($errors->any())
            @foreach($errors->all() as $erro)
                <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" >×</button>       
                        <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
                </div>
            @endforeach
          @endif
          @if(isset($parceria))
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" >×</button>       
            <p class="modal-title"><i class="fa fa-success"></i> Você já está cadastrado como: {{$parceria}} <a href="/perfil/parceria/curriculo">Baixar Currículo</a> </p>
            <small> Para atualizar seus dados preencha o formulário abaixo.</small> 
          </div>
          @endif
        </div> 
      </div>
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group row">
          <label class="col-sm-3 form-control-label text-xs-right text-secondary">Área de atuação </label>
          <div class="col-sm-9"> 
              <input type="text" class="form-control boxed" name="area" maxlength="150" @if(isset($parceria)) value="{{$parceria}}" @endif required> 
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-3 form-control-label text-xs-right text-secondary">Currículo <br><small> Em PDF máximo 2MB</small></label>
          <div class="col-sm-9"> 
              <input type="file" class="form-control boxed" name="curriculo" accept="application/pdf" required > 
          </div>
        
        </div>
        <div class="form-group row">
          <div class="col-sm-9 offset-sm-3">
            <button class="btn btn-info" type="submit" name="btn" >Cadastrar</button> 
            <button type="reset" name="btn"  class="btn btn-secondary">Limpar</button>
            <button type="cancel" name="btn" class="btn btn-secondary" onclick="history.back(-1);return false;">Cancelar</button>
            @if(isset($parceria))
            <a href="#" class="btn btn-outline-danger" onclick="cancelar();"> Cancelar parceria</a>
            @endif
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
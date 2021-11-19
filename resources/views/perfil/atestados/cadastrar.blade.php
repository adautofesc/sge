@extends('perfil.layout')
@section('titulo')
    Perfil FESC - Cadastro de atestado
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
          <h5 class="mb-0">Cadastro de atestados</h5>
          
          <p class="text-secondary"><small>Cadastre seu atestado de saúde, atestado médico ou comprovante de vacinação.</small></p>
          <hr>
          
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" >×</button>       
            <p class="modal-title"><i class="fa fa-danger"></i><small><strong>Atenção! Falsificar atestados é crime!  Decreto Lei nº 2.848 de 07 de Dezembro de 1940</strong><br>
              Art. 298 - Falsificar, no todo ou em parte, documento particular ou alterar documento particular verdadeiro<br>
              Pena - reclusão, de um a cinco anos, e multa.</small></p>
          </div>
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
        <div class="form-group row"> 
          <label class="col-sm-3 form-control-label text-xs-right">
            Tipo de atestado
          </label>
          <div class="col-sm-9"> 
                    
            <select  class="form-control boxed" name="tipo" > 
                        <option value="saude">Saúde para atividades físicas</option>
                        <option value="medico">Médico para justificativa de ausências</option>
                        <option value="vacinacao">Vacinação contra COVID-19</option>
                    </select>
          </div>
        </div>
    
        <div class="form-group row"> 
          <label class="col-sm-3 form-control-label text-xs-right">
            Emissão
          </label>
          <div class="col-sm-9"> 
            <input type="date" class="form-control boxed" name="emissao" placeholder="" > 
          </div>
        </div>
        <div class="form-group row"> 
                <label class="col-sm-3 form-control-label text-xs-right">Atestado digitalizado<br><small> Em PDF máximo 2MB</small></label>
                <div class="col-sm-9">  
                    <input type="file" accept=".pdf" name="atestado" class="form-control boxed"  placeholder="" maxlength="150"> 
                </div>
            </div>
    
        <div class="form-group row">
          <div class="col-sm-9 offset-sm-3">
            <button class="btn btn-info" type="submit" name="btn" >Cadastrar</button> 
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
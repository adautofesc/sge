@extends('perfil.layout')
@section('titulo')
    Perfil FESC - Agendamento de atendimento presencial
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
        <div class="col-sm-12">
          <h5 class="mb-0">Agendamento de atendimento presencial</h5>
          
          <p class="text-secondary"><small>Escolha um dia e horário para ser atendido.</small></p>
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
      <br>
      
      <form method="POST" enctype="multipart/form-data">
        
        <div class="form-group row">
          <label class="col-sm-3 form-control-label text-xs-right text-secondary">Escolha uma data </label>
          <div class="col-sm-4"> 
              <input type="date" class="form-control boxed" name="dia" id="dia" min="{{date('Y-m-d')}}" max="{{$final}}" required> 
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-3 form-control-label text-xs-right text-secondary">Horário </label>
          <div class="col-sm-4"> 
              <select name="horario" id="horarios" class="form-control">
                <option>Selecione uma data</option>

              </select>
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
      <div class="row">
        <div class="col-sm-12">
          <small>Seus agendamentos:</small>
          
          @foreach ($agendamentos as $horario)
          <div class="form-group row rodape">
            <div class="col-sm-9">{{ \Carbon\Carbon::parse($horario->data)->format('d/m/Y')}} às {{substr($horario->horario,0,5)}}</div>
            <div class="col-sm-3"><a href="#" onclick="cancelar({{$horario->id}});" class="btn btn-sm btn-info">Cancelar</a></div>
          </div>
              
          @endforeach
          <hr><br>
        
  
         
        </div> 
      </div>

      
      
    </div>

  </div>

@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function() 
      {
        $("#dia").change(function() {
          $.get("{{asset('agenda-atendimento/')}}"+"/"+$("#dia").val())
            .done(function(data) 
            {
              $("#horarios").html("");
              if(!Array.isArray(data))
                $("#horarios").html("<option>"+data+"</option>");
              else
                if(data.length == 0)
                  $("#horarios").html("<option>Nenhum horário disponível</option>");
                else{
                  $.each(data, function(key, val){
                    var option = document.createElement("option");
                    option.text = val;
                    option.value = val;
                    $("#horarios").append(option);
                  });


                }

              
            });
        });


   });

function cancelar(id){
  if(confirm("Confirmar o cancelamento do horário?")){
    $.get("{{asset('perfil/atendimento/cancelar')}}"+"/"+id)
            .done(function(data) 
            {
              window.location.replace('/perfil/atendimento/');
            });

 

  }
    
}
 </script>   
@endsection
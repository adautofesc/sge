@extends('perfil.layout')
@section('titulo')
    Meus atestados - Perfil FESC
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
          <h5 class="mb-0">Atestados Médicos</h5>
          
          <p class="text-secondary"><small>Abaixo você encontrará a lista de atestados e a situação dos mesmos.</small></p>
          
          
          
        </div>
        <div class="col-sm-4">
          <a class="btn btn-success" href="/perfil/atestado/cadastrar" title="Abre página para cadastrar seu atestado.">Cadastrar Atestado</a>
          
        </div>
        
      </div>
      
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
          @foreach($atestados as $atestado)
            
            <div class="form-group row rodape">
              
              <div class="col-sm-9">
                <strong>Atestado de {{$atestado->tipo.' '.$atestado->id}}</strong> 
                  @switch($atestado->status)
                      @case('analisando')
                        <span class="badge badge-warning">Em análise</span>
                          @break
                      @case('aprovado')
                        <span class="badge badge-success">Aprovado</span>
                          @break
                      @case('reprovado')
                        <span class="badge badge-danger" title="Verifique seu e-mail para mais informações.">Reprovado</span>
                          @break
                      @case('vencido')
                      <span class="badge badge-secondary">Vencido</span>
                        @break
                      @default
                          
                  @endswitch  <br>  
                <small>Data de emissão: {{\Carbon\Carbon::parse($atestado->emissao)->format('d/m/Y')}}</small>
                @if($atestado->validade)
                <small>Data de validade: {{\Carbon\Carbon::parse($atestado->validade)->format('d/m/Y')}} </small>
                                 
                @endif
                
                
  
              </div>
        
            </div>



                
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

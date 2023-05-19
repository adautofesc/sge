@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Bem vindo !!!</h3>
            <p class="title-description">{{ $dados['data']}}</p>
        </div>
    </div>
</div>


<section class="section">
    <div class="row">
        
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Mural</p>
                    </div>
                </div>
                <div class="card-block">

                    <div class="text-xs-left">
                    @if($aniversariante)
                        <img src="{{asset('/img/aniversario.png')}}" alt="Cartaz da tela inicial" width="100%">    
                    @else
                        <img src="{{asset('/img/home.'.$img_ext)}}" alt="Cartaz da tela inicial" width="100%">
                        
                    @endif</div>
 
                </div>
            </div> 


        </div>
    



    @if(in_array('18', Auth::user()->recursos))

        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Agenda de Eventos</p>
                    </div>
                </div>
                <div class="card-block">
                    <ul>
                        <li>
                            <strong>15:00</strong> - Nome do evento - FESC 1 - sala 24
                        </li>
                        <li>
                            <strong>15:00</strong> - Nome do evento - FESC 1 - sala 24
                        </li>
                        
                    </ul>
                    
                    

                    
                </div>
            </div> 
        </div>
   
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Links externos</p>
                    </div>
                </div>
                <div class="card-block">
                    
                        <div class="list-group">
                            <a class="list-group-item" style="text-decoration:none;" href="https://outlook.office.com/mail/"><i class="fa fa-external-link"></i> Outlook (e-mail)</a>
                            <a class="list-group-item" style="text-decoration:none;" href="https://registro.topponto.com.br/registro/login"><i class="fa fa-external-link"></i> Top Ponto</a>
                            <a class="list-group-item" style="text-decoration:none;" href="http://fesc.com.br/portarias"><i class="fa fa-external-link"></i> Portarias (link atualizado)</a>
                            <a class="list-group-item" style="text-decoration:none;" href="http://fesc.com.br/resolucoes-fesc"><i class="fa fa-external-link"></i> Resoluções (link atualizado)</a>

                        </div>
                   
                    
                </div>
            </div> 


        </div>
    
    @endif
    </div>
</section>

@endsection
@section('scripts')
<script>
  

function apagaErro(id){

    if(confirm("Deseja excluir o aviso?")){
        $(location).attr('href','{{asset("/pessoa/apagar-atributo")}}/'+id);
    }

}
</script>
@endsection
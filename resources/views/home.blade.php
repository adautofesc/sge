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
                    <img src="{{asset('/img/cartazes_motivacionais/00'.str_pad(rand(1,10),2,"0",STR_PAD_LEFT).'.jpg')}}" alt="Cartaz motivacional" width="100%">
                    </div>
 
                </div>
            </div> 


        </div>
    



    @if(unserialize(Session('recursos_usuario'))->contains('recurso','18'))

        <div class="col-md-6 center-block">
            <div class="card card-warning">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Pendências de alunos</p>
                    </div>
                </div>
                <div class="card-block">
                    <small>
                    <table class="table">
                        <thead>
                            <th>Pessoa</th>
                            <th>Pendência</th>
                            <th>Apagar</th>
                        </thead>

                        @foreach($pendencias as $pendencia)
                        <tr>
                            <td><a href="/secretaria/atender/{{$pendencia->pessoa}}">{{$pendencia->pessoa}}</a></td>
                            <td>{{$pendencia->valor}}</td>
                            <td> <a href="#" class="close" onclick="apagaErro({{$pendencia->id}});" >&times;</a> </td>
                        </tr>
                        @endforeach
                        

                    </table>
                    </small>
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
                            <a class="list-group-item" style="text-decoration:none;" href="http://fescprotocolo.navka.com/sistema/Login.aspx"><i class="fa fa-bookmark"></i> Sistema de Protocolo</a>
                            <a class="list-group-item" style="text-decoration:none;" href="http://fesc.com.br/portarias/portarias-ano-2019"><i class="fa fa-file-text-o"></i> Portarias</a>
                            <a class="list-group-item" style="text-decoration:none;" href="http://fesc.com.br/resolucoes-fesc/resolucoes-ano-2019"><i class="fa fa-file-text-o"></i> Resoluções</a>
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
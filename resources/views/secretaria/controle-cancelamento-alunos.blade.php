@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('titulo')Controle de alunos - SGE FESC @endsection

<style type="text/css">
	@media print {
            .hide-onprint { 
                display: none;
            }
           
        }
.dropdown-menu li label{
	text-decoration: none;
	color:black;
	margin-left: 1rem;
	line-height: 1.1rem;
}
.dropdown-menu li label:hover{
    cursor: pointer;
	background-color:lightgray;

}
table{
    background-color: white;
    width: 100%;
}
table td{
    background-color: white;
}
</style>
@section('pagina')

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../">Início</a></li>
  <li class="breadcrumb-item"><a href="../">secretaria</a></li>
  <li  class="breadcrumb-item active">Controle de alunos</li>
</ol>

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Departamento de Secretaria da FESC</h3>
            <p class="title-description">Alunos com inscrição cancelada com emails e turma teams</p>
        </div>
        <div class="col-md-6 " ><span class="pull-right">{{$inscricoes->count()}}</span></div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12" style="margin-bottom: 50px;">
        <table class="table">
            <thead>
                <th><input type="checkbox" name="all" id="all"></th>
                <th>ID</th>
                <th>Turma</th>
                <th>Nome</th>
                <th>Celular</th>
                <th>E-mail</th>
                <th>Opções</th>
            </thead>
            <tbody>
                @foreach($inscricoes as $inscricao)
                @if(isset($inscricao->email_fesc) || isset($inscricao->insc_teams) )
                <tr>
                    <td><input type="checkbox" name="inscricao[{{$inscricao->id}}]" id=""></td>
                    <td><a href="/secretaria/atender/{{$inscricao->pessoa->id}}">{{$inscricao->pessoa->id}}</a></td>
                    <td><a href="/turmas/{{$inscricao->turma->id}}">{{$inscricao->turma->id}}</a></td>
                    <td>{{$inscricao->pessoa->nome}}</td>
                    <td>{{$inscricao->pessoa->getCelular()}}</td>
                    <td>{{$inscricao->email->valor}}</td>
                    <td>
                        @if(isset($inscricao->email_fesc))
                        <a href="#" onclick="removerEmail({{$inscricao->email_fesc->id}})"><img src="{{asset('/img/mail-green.png')}}" alt="{{$inscricao->email_fesc->valor}}" title="{{$inscricao->email_fesc->valor}}"></a>
                        @else
                        <a href="#" onclick="alterPessoa({{$inscricao->pessoa->id}})" data-toggle="modal" data-target="#confirm-modal"><img src="{{asset('/img/mail-yellow.png')}}" alt="email pendente" title="E-mai não registrado"></a>
                        @endif
                        &nbsp;
                        @if(isset($inscricao->insc_teams))
                        <a href="#" onclick="removerTeams({{$inscricao->insc_teams->id}})"><img src="{{asset('/img/teams-blue.png')}}" alt="Inscrito" title="Na equipe"></a>
                        @else
                        <a href="#" onclick="inscreverTeams({{$inscricao->pessoa->id}},{{$inscricao->turma->id}})" ><img src="{{asset('/img/teams-red.png')}}" alt="Inscrição pendente" title="Precisa ser inserido na equipe."></a>
                        @endif
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
       
           
        

@endsection
@section('modal')
    <div class="modal fade" id="confirm-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="fa fa-warning"></i> Insira o endereço cadastrado
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h4>
                </div>
                <div class="modal-body">
                    Endereço:<br>
                    <input type="email" class="form-control form-control-sm" name="email" id="campo_email" placeholder="cole aqui o endereço" maxlength="300" required><br>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="inserir();" class="btn btn-primary" data-dismiss="modal">Gravar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
          
@endsection
@section('scripts')
<script>
var pessoa = 0;
    $('#myDropdown').on('hide.bs.dropdown', function () {
    alert();
});
function alterPessoa(id){
    pessoa = id;
    setTimeout(function(){$('#campo_email').focus();},500);
    
}
function inserir(){
    endereco = $('#campo_email').val();
    if(endereco !== null){
        $.get("{{asset('pessoa/registrar-email-fesc')}}"+"/"+pessoa+"/"+encodeURI(endereco))
            .done(function(){
                location.reload();
            })
            .fail(function(){
                alert('Não foi possível gravar o email');
            })
        
    }
        
}

function removerEmail(id){
    if(confirm('Gostaria de apagar este registro?')){
        $.get("{{asset('pessoa/apagar-email-fesc')}}"+"/"+id)
            .done(function(){
                location.reload();
            })
            .fail(function(){
                alert('Não foi possível apagar o email');
            })
    }

}

function inscreverTeams(pessoa,turma){
    if(confirm('Confirmar o cadastro da pessoa na equipe da turma '+turma+' ?')){
        $.get("{{asset('pessoa/inscrever-equipe-teams')}}"+"/"+pessoa+"/"+turma)
            .done(function(){
                location.reload();
            })
            .fail(function(){
                alert('Não foi possível gravar a informação');
            })
    }

}
function removerTeams(id){
    if(confirm('A pessoa foi removida da equipe?')){
        $.get("{{asset('pessoa/remover-equipe-teams')}}"+"/"+id)
            .done(function(){
                location.reload();
            })
            .fail(function(){
                alert('Não foi possível gravar a informação');
            })
    }

}
  
</script>
@endsection
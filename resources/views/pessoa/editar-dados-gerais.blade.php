@extends('layout.app')
@section('pagina')

<form name="item" method="POST">

                    <div class="title-block">
                        <h3 class="title"> Edição de dados Gerais<span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                   @include('inc.errors')
                    <div class="subtitle-block">
                        <h3 class="subtitle"> 
                        @if(isset($dados['nome']))
                        	{{$dados['nome']}}
                        
                        </h3>
                    </div>
                    
                        <div class="card card-block">
                            
                            
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">Nome/social*</label>
                                <div class="col-sm-10"> 
                                    <input type="text" class="form-control boxed" placeholder="Preencha o nome completo, sem abreviações." name="nome"  value="{{$dados['nome']}}" required> 
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                
                                <label class="col-sm-2 form-control-label text-xs-right">Nascimento*</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                                        <input type="text" class="form-control boxed" placeholder="dd/mm/aaaa" name="nascimento" value="{{$dados['nascimento']}}" required> 
                                    </div>
                                </div>
                                
                            </div> 
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">Gênero*</label>
                                <div class="col-sm-10"> 
                                    <label>
                                        <input class="radio" name="genero" type="radio" {{ $dados['generom']}} value="M" >
                                        <span>Masculino</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" {{ $dados['generof']}} value="F" >
                                        <span>Feminino</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" {{ $dados['generox']}} value="X" >
                                        <span>Trans Masculino</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" {{ $dados['generoy']}} value="Y" >
                                        <span>Trans Feminino</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" {{ $dados['generoz']}} value="Z" >
                                        <span>Não Classificar</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">Nome Registro</label>
                                <div class="col-sm-10"> 
                                    <input type="text" class="form-control boxed" placeholder="nome social" name="nome_registro" value="{{$dados['nome_registro']}}"> 
                                </div>
                            </div>    
                                
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">RG </label>
                                <div class="col-sm-3"> 
                                    <input type="text" class="form-control boxed" placeholder="Somente numeros" name="rg" value="{{$dados['rg']}}"> 
                                </div>
                                <label class="col-sm-2 form-control-label text-xs-right">CPF* <small title="Caso não tiver CPF o responsável legal deverá ser cadastrado"><i class="fa fa-info-circle"></i></small></label>
                                <div class="col-sm-3"> 
                                    <input type="text" class="form-control boxed" placeholder="Somente numeros" name="cpf" value="{{$dados['cpf']}}">
                                </div>
                                
                                
                            </div>                                
                                               
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right"></label>
                                <div class="col-sm-10 col-sm-offset-2"> 
                                    <input type="hidden" name="pessoa" value="{{$dados['id']}}">
                                    <input type="hidden" name="action" id="input_action" value="edit">
                                    <button type="submit" name="btn_sub" value='1' class="btn btn-primary">Salvar</button>
                                    <a href="#" class="btn btn-warning" onclick="excluirPessoa({{$dados['id']}})" title="Mantem os dados da pessoa mas oculta ela do sistema"> <i class="fa fa-trash"></i> Deletar Pessoa</a>
                                    @if(\Auth::user()->pessoa == '19511')
                                    <a href="#" class="btn btn-danger" onclick="excluirPessoaDefinitivo({{$dados['id']}})" title="Apaga completamente do sistema"> <i class="fa fa-times"></i> Excluir Pessoa</a>
                                    @endif
                                   
                                    {{ csrf_field() }}
                                </div>
                                
                           </div>
                        </div>
                    </form>@endif

@endsection
@section('scripts')
<script>
    function excluirPessoa(pessoa){
        if(confirm('Deseja mesmo excluir esta pessoa do SGE?')){
            $('#input_action').val('delete');
            $('form').submit();
        }
    }
    function excluirPessoaDefinitivo(pessoa){
        if(confirm('DESEJA EXCLUIR COMPLETAMENTE ESSA PESSOA DO SISTEMA?')){
            $('#input_action').val('exclude');
            $('form').submit();
        }
    }
</script>
@endsection
<div class="tab-pane fade in active" id="geral">

                            
        <div class="row"> 
            <div class="col-xs-10">
                <a href="{{asset('/pessoa/adicionardependente').'/'.$pessoa['id']}}" class="btn btn-secondary btn-sm rounded-s"> Adicionar dependente </a>                                         
            </div>                                           
            <div class="col-xs-2 text-xs-right">                                        
                <a href="{{asset('/pessoa/editar/geral').'/'.$pessoa['id']}}" class="btn btn-primary btn-sm rounded-s"> Editar </a>
            </div>
        </div>  


        <section class="card card-block">
        <div class="form-group row">

            <label class="col-sm-2 form-control-label text-xs-right">Nascimento</label>
            <div class="col-sm-3">
                {{$pessoa['nascimento']}} ({{$pessoa['idade']}} anos)
            </div>
            @if(isset($pessoa['telefone']))
            <label class="col-sm-2 form-control-label text-xs-right">Telefone</label>
            <div class="col-sm-3"> 
                {{$pessoa['telefone']}}
            </div>
            @endif
        </div>                                   
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">Gênero</label>
            <div class="col-sm-10"> 
                {{$pessoa['genero']}}
            </div>
        </div>
        @if(isset($pessoa['nome_registro']))
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">Nome Registro</label>
            <div class="col-sm-10"> 
                {{$pessoa['nome_registro']}}
            </div>
        </div>    
        @endif    
        <div class="form-group row">
             @if(isset($pessoa['rg']))
            <label class="col-sm-2 form-control-label text-xs-right">RG</label>
            <div class="col-sm-3"> 
                {{$pessoa['rg']}}
            </div>
            @endif
            @if(isset($pessoa['cpf']))
            <label class="col-sm-2 form-control-label text-xs-right">CPF</label>
            <div class="col-sm-3"> 
                {{ $pessoa['cpf'] }}
            </div>
            @endif                                  
        </div> 
        <div class="form-group row">
             @if(isset($pessoa['username']))
            <label class="col-sm-2 form-control-label text-xs-right">Usuário</label>
            <div class="col-sm-3"> 
                {{$pessoa['username']}}
            </div>                                 
            
            <label class="col-sm-2 form-control-label text-xs-right">Senha</label>
            <div class="col-sm-3"> 
                <a href="{{asset('/pessoa/trocarsenha/'.$pessoa['id']) }}" class="btn btn-secondary btn-sm rounded-s"> Redefinir senha </a>

            </div>
            @else
            <label class="col-sm-2 form-control-label text-xs-right">Acesso ao sistema</label>
            <div class="col-sm-3"> 
                <a href="{{asset('/pessoa/cadastraracesso/').'/'.$pessoa['id']}}" class="btn btn-primary btn-sm rounded-s"> Cadastrar usuário </a>
            </div>
            @endif  
            @if(in_array('9', Auth::user()->recursos))
                @if(isset($perfil)) 
                <label class="col-sm-2 form-control-label text-xs-right">Acesso ao Perfil</label>
                <div class="col-sm-3"> 
                    <a href="{{asset('/pessoa/resetar-senha-perfil/').'/'.$pessoa['id']}}" class="btn btn-primary btn-sm rounded-s"> Resetar senha</a>
                </div>
                @endif
            @endif                           
        </div> 
        @if(count($pessoa['dependentes']))
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">Dependentes</label>
            <div class="col-sm-10"> 
                @foreach($pessoa['dependentes'] as $dependente)
                <a href="{{asset('/pessoa/mostrar/'.$dependente->valor)}}" target="_blank">{{$dependente->nome}}</a>
                <a href="#{{$dependente->id}}" onclick="remVinculo({{$dependente->id}});" class="btn btn-secondary btn-sm rounded-s"> Remover </a><br>
                @endforeach
            </div>
        </div>    
        @endif 
        @if(isset($pessoa['responsavel']))
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">Responsável:</label>
            <div class="col-sm-10"> 
                <a href="{{asset('/pessoa/mostrar/'.$pessoa->responsavel)}}" target="_blank">{{$pessoa['nomeresponsavel']}}</a>
                <a href="{{asset('/pessoa/remover-responsavel/'.$pessoa->responsavel) }}" class="btn btn-secondary btn-sm rounded-s"> Remover </a>

            </div>
        </div>    
        @endif 
        @if(isset($pessoa['responsavel_financeiro']))
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">Responsável Financeiro</label>
            <div class="col-sm-10"> 
                <a href="{{asset('/pessoa/mostrar/'.$pessoa->responsavel_financeiro)}}" target="_blank">{{$pessoa['nomeresponsavel_financeiro']}}</a>
                <a href="{{asset('/pessoa/remover-responsavel-financeiro/'.$pessoa->responsavel_financeiro) }}" class="btn btn-secondary btn-sm rounded-s"> Remover </a>
            </div>
        </div>    
        @endif 
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Histórico de atendimento:
            </label>
            <div class="col-sm-10">

               
                {{$pessoa['cadastro']}}
               
            </div>
        </div>     
    </section>
</div>
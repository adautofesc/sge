<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perfil Pessoal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        body, .smoke {
            background-color:WhiteSmoke;
        }
        h1 {margin-top:2rem;
            font-size:14pt;
            font-weight: bold;}
        .description{
            margin-top:2rem;
            font-size:12pt;
        }
        .form{
            margin-top:2rem;
        }
        .button{
            margin-top:.1rem;
        }
        .container-fluid{
            margin-top:5rem;
            background-color:white;
        
            
        }
        .col-md-5{
            background-color:white;
            -webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.38);
            -moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.38);
            box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.38);
            
        }
        
        
        
        
    </style>
   
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-md-center smoke" >
            <div class="col-md-5">
                <h1>
                <img src="{{asset('img/chave.svg')}}" width="24px" alt="icone de chave">
                    Cadastro Perfil FESC
                </h1>
                <noscript>
                    <!-- referência a arquivo externo -->
                    <div class="alert alert-danger"> Ative o javascript ou acesse o site de outro navegador.</div>
                </noscript>
                <p class="description">
                  
                    Cadastre-se para matrículas, rematrículas, parcerias e consultas diversas.

                </p>
                @if($errors->any())
                    @foreach($errors->all() as $erro)
                        <div class="alert alert-danger" onload="console.log('erro:{{$erro}}')">
                                <button type="button" class="close" data-dismiss="alert" >×</button>       
                                <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
                        </div>
                    @endforeach
                @endif

                <form method="POST" id="cadastro" action="/perfil/cadastrar-pessoa/{{$cpf}}" onsubmit="event.preventDefault(); return valida()">
                    
                    <div class="form-group row"> 
                        <label class="col-sm-2 form-control-label text-xs-right">Nome/social</label>
                        <div class="col-sm-10"> 
                            <input type="text" class="form-control boxed" placeholder="Preencha o nome completo, sem abreviações." name="nome" required> 
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        
                        <label class="col-sm-2 form-control-label text-xs-right">Nascimento</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                                <input type="date" class="form-control boxed" placeholder="dd/mm/aaaa" name="nascimento" required> 
                            </div>
                        </div>
                        <label class="col-sm-2 form-control-label text-xs-right">Celular</label>
                        <div class="col-sm-3"> 
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                                <input type="tel" class="form-control boxed" placeholder="Somente numeros" name="telefone" minlength="11" maxlength="11"> 
                            </div>
                        </div>
                    </div>
                        
                    
                    <div class="form-group row"> 
                        <label class="col-sm-2 form-control-label text-xs-right">Gênero</label>
                        <div class="col-sm-10"> 
                            <label>
                                <input class="radio" name="genero" type="radio" value="M" required>
                                <span>Masculino</span>
                            </label>
                            <label>
                                <input class="radio" name="genero" type="radio" value="F" >
                                <span>Feminino</span>
                            </label>
                        
                            <label>
                                <input class="radio" name="genero" type="radio" value="Z" >
                                <span>Não Binário</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label class="col-sm-2 form-control-label text-xs-right">RG </label>
                        <div class="col-sm-3"> 
                            <input type="number" class="form-control boxed" placeholder="Somente numeros" name="rg" required> 
                        </div>
                        <label class="col-sm-2 form-control-label text-xs-right">CPF* <small title="Caso não tiver CPF o responsável legal deverá ser cadastrado"><i class="fa fa-info-circle"></i></small></label>
                        <div class="col-sm-3"> 
                            <input type="number" class="form-control boxed" placeholder="Somente numeros" name="cpf" value="{{$cpf}}" readonly="true" required>
                        </div>
                        
                        
                    </div> 
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label text-xs-right">E-mail </label>
                        <div class="col-sm-4"> 
                            <input type="email" class="form-control boxed" name="email" required> 
                        </div>

                        <label class="col-sm-2 form-control-label text-xs-right" >CEP</label>
                        <div class="col-sm-4"> 
                            <input type="text" class="form-control boxed" placeholder="00000-000" name="cep"  onkeyup="mycep();" required minlength="8" maxlength="9"> 
                        </div> 
    
                    </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right">Logradouro</label>
                            <div class="col-sm-10"> 
                                <input type="text" class="form-control boxed" placeholder="Rua, avenida, etc" name="rua" required> 
                            </div>  
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right">Número</label>
                            <div class="col-sm-2"> 
                                <input type="text" class="form-control boxed" placeholder="" name="numero_endereco" required> 
                            </div>  
                            <label class="col-sm-2 form-control-label text-xs-right">Complemento</label>
                            <div class="col-sm-2"> 
                                <input type="text" class="form-control boxed" placeholder="" name="complemento_endereco"> 
                            </div> 
                            
        
                            <label class="col-sm-1 form-control-label text-xs-right">Bairro</label>
                            <div class="col-sm-3"> 
                                <input id="bairro" type="text" class="form-control boxed"  name="bairro_str" required> 
                                
                            </div> 
                             
                           
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right">Cidade</label>
                            <div class="col-sm-4"> 
                                <input type="text" class="form-control boxed" placeholder="" name="cidade" value="São Carlos"> 
                            </div>  
                            <label class="col-sm-2 form-control-label text-xs-right">Estado</label>
                            <div class="col-sm-4"> 
                                <select  class="form-control boxed"  name="estado" required> 
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espirito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP" selected="selected">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>  
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right">Senha </label>
                            <div class="col-sm-4"> 
                                <input type="password" class="form-control boxed" placeholder="Pelo menos 6 caracteres" name="senha" minlength="6" required> 
                            </div>
    
                            <label class="col-sm-2 form-control-label text-xs-right" >Redigite a senha</label>
                            <div class="col-sm-4"> 
                                <input type="password" class="form-control boxed"  name="contrasenha" minlength="6" required > 
                            </div> 
        
                        </div>
                    
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-info" type="submit" name="btn" value="1">Continuar</button> 
					<button type="reset" name="btn"  class="btn btn-secondary">Limpar</button>
                	<button type="cancel" name="btn" class="btn btn-secondary" onclick="history.back(-2);return false;">Cancelar</button>
                    @csrf
                </form>
                <p>
                &nbsp;
                </p>
            

            </div>
        </div>     
    </div>
        
   
    <script src="{{asset('/js/vendor.js')}}"></script>
    <script src="{{asset('/js/app.js')}} "></script>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script>
    function mycep(){
    var cep = $('[name=cep]').val();
    $('[name=rua]').val('Carregando dados a partir do CEP...');
    if(cep.length == 8 || cep.length==9){
        
        $.get("https://viacep.com.br/ws/"+cep+"/json/"+"/")
                .done(function(data) 
                {
                    if(!data.logradouro){
                        console.log(data);
                        $('[name=rua]').val('CEP não localizado');
                    }
                    else {
                        $('[name=rua]').val(data.logradouro);
                        $('[name=bairro_str]').val(data.bairro);
                        $('[name=bairro]').val(0);
                        $('[name=cep]').val(data.cep);
                        $('[name=cidade]').val(data.localidade);
                        $('[name=estado]').val(data.uf);
                    
                    }
                  

                })
                .fail(function() {
                    console.log('erro ao conectar com viacep');
                    $("#cepstatus").html('Erro ao conectar ao serviço de consulta de CEP');
                    $('[name=rua]').val('');

                });
    }

   
}
function valida(){
    
    if($('[name=senha]').val() == '123456'){
        alert('Senha não permitida, aumente a segurança inserindo letras.');
        $('[name=senha]').val('');
        $('[name=contrasenha]').val('');
        return false;

    }
        

    if($('[name=senha]').val() == $('[name=contrasenha]').val() ){
        
        $('#cadastro')[0].submit();
    }
    else{
        alert('Senha e contrasenha precisam ser iguais');
        $('[name=senha]').val('');
        $('[name=contrasenha]').val('');

        return false;

    }
        
}
</script>

</body>

</html>
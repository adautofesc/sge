@extends('perfil.layout')
@section('titulo')
    Perfil FESC - Programa de Parceria
@endsection

@section('style')
    <style>


        
        h1 {
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
@endsection
@section('body')
<div class="card mb-3">
                      
    <div class="card-body">
      <div class="row">
            <div class="col-md-12">
                <h5>
                
                    Alteração dos dados cadastrais
                </h5>
                <p class="text-secondary"><small>Atualize seus dados.</small></p>
                <hr>
                <noscript>
                    <!-- referência a arquivo externo -->
                    <div class="alert alert-danger"> Ative o javascript ou acesse o site de outro navegador.</div>
                </noscript>
                <p class="alert alert-info">Preencha apenas os campos que tiveram alterações</p>
                @if($errors->any())
                    @foreach($errors->all() as $erro)
                        <div class="alert alert-danger" onload="console.log('erro:{{$erro}}')">
                                <button type="button" class="close" data-dismiss="alert" >×</button>       
                                <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
                        </div>
                    @endforeach
                @endif

                <form method="POST" id="cadastro"  onsubmit="event.preventDefault(); return valida()">
                    
                    
                    
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label text-xs-right">Telefone</label>
                        <div class="col-sm-4"> 
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                                <input type="tel" class="form-control boxed" placeholder="Somente numeros" name="telefone" minlength="11" maxlength="11"> 
                            </div>
                        </div>
                        
                        
                        <label class="col-sm-2 form-control-label text-xs-right">Celular</label>
                        <div class="col-sm-4"> 
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                                <input type="tel" class="form-control boxed" placeholder="Somente numeros" name="celular" minlength="11" maxlength="11" > 
                            </div>
                        </div>
                    </div>
                        
                    
                  
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label text-xs-right">E-mail </label>
                        <div class="col-sm-4"> 
                            <input type="email" class="form-control boxed" name="email" > 
                        </div>

                        <label class="col-sm-2 form-control-label text-xs-right" >CEP</label>
                        <div class="col-sm-4"> 
                            <input type="text" class="form-control boxed" placeholder="00000-000" name="cep"  onkeyup="mycep();"  minlength="8" maxlength="9"> 
                        </div> 
    
                    </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right">Logradouro</label>
                            <div class="col-sm-10"> 
                                <input type="text" class="form-control boxed" placeholder="Rua, avenida, etc" name="rua" > 
                            </div>  
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right">Número</label>
                            <div class="col-sm-2"> 
                                <input type="text" class="form-control boxed" placeholder="" name="numero_endereco" > 
                            </div>  
                            <label class="col-sm-2 form-control-label text-xs-right"><small>Complemento</small></label>
                            <div class="col-sm-2"> 
                                <input type="text" class="form-control boxed" placeholder="" name="complemento_endereco"> 
                            </div> 
                            
        
                            <label class="col-sm-1 form-control-label text-xs-right">Bairro</label>
                            <div class="col-sm-3"> 
                                <input id="bairro" type="text" class="form-control boxed"  name="bairro_str" > 
                                
                            </div> 
                             
                           
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right">Cidade</label>
                            <div class="col-sm-4"> 
                                <input type="text" class="form-control boxed" placeholder="" name="cidade" value="São Carlos"> 
                            </div>  
                            <label class="col-sm-2 form-control-label text-xs-right">Estado</label>
                            <div class="col-sm-4"> 
                                <select  class="form-control boxed"  name="estado" > 
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

                    
                    
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-info" type="submit" name="btn" value="1">Continuar</button> 
					<button type="reset" name="btn"  class="btn btn-secondary">Limpar</button>
                	<button type="cancel" name="btn" class="btn btn-secondary" onclick="history.back(-1);return false;">Cancelar</button>
                    @csrf
                </form>
                <p>
                &nbsp;
                </p>
            

            </div>
      </div>
    </div>
</div>
@endsection
@section('scripts')
        
   
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
@endsection
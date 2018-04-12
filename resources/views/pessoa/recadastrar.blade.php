<!doctype html>
<html class="no-js" lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> Recadastramento - Sistema de Gestão Educacional - SGE FESC </title>
        <meta name="description" content="Página de login do SGE da FESC">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="{{asset('css/vendor.css')}}">
        <!-- Theme initialization -->
        <script>
            var themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {};
            var themeName = themeSettings.themeName || '';
            if (themeName)
            {
                document.write('<link rel="stylesheet" id="theme-style" href="css/app-' + themeName + '.css">');
            }
            else
            {
                document.write('<link rel="stylesheet" id="theme-style" href="css/app.css">');
            }
        </script>
    </head>

    <body>
<div class="main-wrapper" style="padding-top: 0;">
            <div class="app" id="app" style="padding-top: 0;">
                <div class="content items-list-page" style="padding-top: 0;">

<!-- ------------------------------------------------Conteúdo-------------------------------------------------------------- -->

<form name="item" method="POST" action="./recadastrado">
    {{csrf_field()}}

                    <div class="title-block">
                        <h3 class="title"> Recadastramento 2018<span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                   @include('inc.errors')
                    <div class="subtitle-block">
                        <h3 class="subtitle"> Dados Gerais </h3>
                    </div>
                    
                        <div class="card card-block">
                            
                            
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">Nome/social*</label>
                                <div class="col-sm-10"> 
                                    <input type="text" class="form-control boxed" placeholder="Preencha o nome completo, sem abreviações." name="nome" value="{{$pessoa->nome}}" required> 
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                
                                <label class="col-sm-2 form-control-label text-xs-right">Nascimento*</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                                        <input type="Text" class="form-control boxed" placeholder="dd/mm/aaaa" name="nascimento" value="{{$pessoa->nascimento}}" required> 
                                    </div>
                                </div>
                                <label class="col-sm-2 form-control-label text-xs-right">Telefone</label>
                                <div class="col-sm-3"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                                        <input type="tel" class="form-control boxed" placeholder="Somente numeros" name="telefone" value="{{$pessoa->telefone}}"> 
                                    </div>
                                </div>
                            </div>
                                
                            
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">Gênero*</label>
                                <div class="col-sm-10"> 
                                    <label>
                                        <input class="radio" name="genero" type="radio" value="M" {{$pessoa->genero =='M'? 'checked' :''}}>
                                        <span>Masculino</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" value="F" {{$pessoa->genero =='F'? 'checked' :''}}>
                                        <span>Feminino</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" value="X" {{$pessoa->genero =='X'? 'checked' :''}}>
                                        <span>Trans Masculino</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" value="Y" {{$pessoa->genero =='Y'? 'checked' :''}}>
                                        <span>Trans Feminino</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" value="Z" {{$pessoa->genero =='Z'? 'checked' :''}}>
                                        <span>Não Classificar</span>
                                    </label>
                                </div>
                            </div>
                            
   
                                
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">RG </label>
                                <div class="col-sm-3"> 
                                    <input type="text" class="form-control boxed" placeholder="Somente numeros" name="rg" value="{{$pessoa->rg}}"> 
                                </div>
                                <label class="col-sm-2 form-control-label text-xs-right">CPF* <small title="Caso não tiver CPF o responsável legal deverá ser cadastrado"><i class="fa fa-info-circle"></i></small></label>
                                <div class="col-sm-3"> 
                                    <input type="number" class="form-control boxed" placeholder="Somente numeros" name="cpf" value="{{$pessoa->cpf}}" onfocusout="validaCPF(this.value)">
                                </div>
                                
                                
                            </div>                                
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">E-mail</label>
                                <div class="col-sm-4"> 
                                    <input type="email" class="form-control boxed" placeholder="" name="email" value="{{$pessoa->email}}"> 
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Celular</label>
                                <div class="col-sm-4"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                                        <input type="text" class="form-control boxed" placeholder="Somente numeros" name="tel2" value="{{$pessoa->telefone_celular}}"> 
                                    </div> 
                                </div>
                                <label class="col-sm-2 form-control-label text-xs-right">Telefone de um contato</label>
                                <div class="col-sm-4"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                                        <input type="text" class="form-control boxed" placeholder="Somente numeros" name="tel3" value="{{$pessoa->telefone_contato}}"> 
                                    </div> 
                                </div>
                            </div>


                  
                            
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Logradouro</label>
                                <div class="col-sm-10"> 
                                    <input type="text" class="form-control boxed" placeholder="Rua, avenida, etc" name="rua" value="{{$pessoa->logradouro}}"> 
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Número</label>
                                <div class="col-sm-4"> 
                                    <input type="text" class="form-control boxed" placeholder="" name="numero_endereco" value="{{$pessoa->end_numero}}"> 
                                </div>  
                                <label class="col-sm-2 form-control-label text-xs-right">Complemento</label>
                                <div class="col-sm-4"> 
                                    <input type="text" class="form-control boxed" placeholder="" name="complemento_endereco" value="{{$pessoa->end_complemento}}"> 
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Bairro</label>
                                <div class="col-sm-4"> 
                                    <input id="bairro" type="text" class="form-control boxed"  name="bairro_str" value="{{$pessoa->bairro}}"> 
                                </div> 
                                <input type="hidden" name="bairro" value="{{$pessoa->id_bairro}}" required>
                                    <ul class="item-list" id="listabairros" style="display:none; width:700px; 
       height:500px;  
       position:absolute; 
       z-index:100; 
       top:50px; 
       padding:20px;
       margin-left:300px;
       background-color: white;
       overflow-y: hidden;
       border:1px solid #d0d0d0">

                                    </ul>
                                <label class="col-sm-2 form-control-label text-xs-right">CEP</label>
                                <div class="col-sm-4"> 
                                    <input type="text" class="form-control boxed" placeholder="00000-000" name="cep" value="{{$pessoa->cep}}"> 
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Cidade</label>
                                <div class="col-sm-4"> 
                                    <input type="text" class="form-control boxed" placeholder="" name="cidade" value="{{$pessoa->cidade}}"> 
                                </div>  
                                <label class="col-sm-2 form-control-label text-xs-right">Estado</label>
                                <div class="col-sm-4"> 
                                    <select  class="form-control boxed"  name="estado"> 
                                        <option value="AC" {{$pessoa->estado =='AC'? 'selected' :''}}>Acre</option>
                                        <option value="AL" {{$pessoa->estado =='AL'? 'selected' :''}}>Alagoas</option>
                                        <option value="AP" {{$pessoa->estado =='AP'? 'selected' :''}}>Amapá</option>
                                        <option value="AM" {{$pessoa->estado =='AM'? 'selected' :''}}>Amazonas</option>
                                        <option value="BA" {{$pessoa->estado =='BA'? 'selected' :''}}>Bahia</option>
                                        <option value="CE" {{$pessoa->estado =='CE'? 'selected' :''}}>Ceará</option>
                                        <option value="DF" {{$pessoa->estado =='DF'? 'selected' :''}}>Distrito Federal</option>
                                        <option value="ES" {{$pessoa->estado =='ES'? 'selected' :''}}>Espirito Santo</option>
                                        <option value="GO" {{$pessoa->estado =='GO'? 'selected' :''}}>Goiás</option>
                                        <option value="MA" {{$pessoa->estado =='MA'? 'selected' :''}}>Maranhão</option>
                                        <option value="MS" {{$pessoa->estado =='MS'? 'selected' :''}}>Mato Grosso do Sul</option>
                                        <option value="MT" {{$pessoa->estado =='MT'? 'selected' :''}}>Mato Grosso</option>
                                        <option value="MG" {{$pessoa->estado =='MG'? 'selected' :''}}>Minas Gerais</option>
                                        <option value="PA" {{$pessoa->estado =='PA'? 'selected' :''}}>Pará</option>
                                        <option value="PB" {{$pessoa->estado =='PB'? 'selected' :''}}>Paraíba</option>
                                        <option value="PR" {{$pessoa->estado =='PR'? 'selected' :''}}>Paraná</option>
                                        <option value="PE" {{$pessoa->estado =='PE'? 'selected' :''}}>Pernambuco</option>
                                        <option value="PI" {{$pessoa->estado =='PI'? 'selected' :''}}>Piauí</option>
                                        <option value="RJ" {{$pessoa->estado =='RJ'? 'selected' :''}}>Rio de Janeiro</option>
                                        <option value="RN" {{$pessoa->estado =='RN'? 'selected' :''}}>Rio Grande do Norte</option>
                                        <option value="RS" {{$pessoa->estado =='RS'? 'selected' :''}}>Rio Grande do Sul</option>
                                        <option value="RO" {{$pessoa->estado =='RO'? 'selected' :''}}>Rondônia</option>
                                        <option value="RR" {{$pessoa->estado =='RR'? 'selected' :''}}>Roraima</option>
                                        <option value="SC" {{$pessoa->estado =='SC'? 'selected' :''}}>Santa Catarina</option>
                                        <option value="SP" {{$pessoa->estado =='SP'? 'selected' :''}}>São Paulo</option>
                                        <option value="SE" {{$pessoa->estado =='SE'? 'selected' :''}}>Sergipe</option>
                                        <option value="TO" {{$pessoa->estado =='TO'? 'selected' :''}}>Tocantins</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right"></label>
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="hidden" name="pessoa" value="{{$pessoa->id}}">
                                    <button type="submit" name="btn"  class="btn btn-primary">Avançar</button>
                                    <button type="reset" name="btn"  class="btn btn-secondary">Restaurar</button>
                                    <button type="cancel" name="btn" class="btn btn-secondary" onclick="history.back(-2);return false;">Cancelar</button>
                                    

                                    
                                </div>
                           </div>
                        </div>
                    </form>





<!-- ------------------------------------------------/conteúdo---------------------------------------------------------------- -->

            </div>
        </div>
    </div>
<script src="{{ asset('js/vendor.js') }}" ></script>
<script src="{{ asset('js/app.js') }} "></script>


<script>
    $(document).ready(function() 
    {
  
 
   //On pressing a key on "Search box" in "search.php" file. This function will be called.
 
   $("#bairro").keyup(function() {
       
 
       //Assigning search box value to javascript variable named as "name".
 
       var name = $('#bairro').val();
       var namelist="";

 
       //Validating, if "name" is empty.
 
       if (name == "") {
            

 
           //Assigning empty value to "display" div in "search.php" file.
 
           $("#listabairros").html("");
            $("#listabairros").hide();
 
       }
 
       //If name is not empty.
 
       else {
            
 
           //AJAX is called.
            $.get("{{asset('pessoa/buscarbairro/')}}"+"/"+name)
                .done(function(data) 
                {
                    $.each(data, function(key, val){
                        namelist+='<li class="item item-list-header">'
                                    +'<a href="#" onclick="escolherBairro('+val.id+',\''+val.nome+'\')">'
                                        +val.nome
                                    +'</a>'
                                  +'</li>';
                    });
                    
                    $("#listabairros").html(namelist).show();

                });

        }
 
    });
 
});
//http://www.geradordecpf.org/funcao-javascript-validar-cpf.html
function validaCPF(cpf)
  {
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;
    if (cpf.length < 11){
        alert("CPF Inválido");
        return false;
    }
          
    for (i = 0; i < cpf.length - 1; i++)
          if (cpf.charAt(i) != cpf.charAt(i + 1))
                {
                digitos_iguais = 0;
                break;
                }
    if (!digitos_iguais)
          {
          numeros = cpf.substring(0,9);
          digitos = cpf.substring(9);
          soma = 0;
          for (i = 10; i > 1; i--)
                soma += numeros.charAt(10 - i) * i;
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(0)){
                alert("CPF Inválido");
                return false;
            }
          numeros = cpf.substring(0,10);
          soma = 0;
          for (i = 11; i > 1; i--)
                soma += numeros.charAt(11 - i) * i;
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(1)){
                alert("CPF Inválido");
                return false;
            }
          return true;
          }
    else{
        alert("CPF Inválido");
        return false;
    }
  }
/***
 * Vincula resgata os dados da pessoa clicada e preenche o formulário com eles
 * @param id - código da pessoa que tem o endereço
 * @param nome - Nome da pessoa que tem o endereço, para preencher o campo "Vincular a"*/
function escolherBairro(id,nome) {
   
    $('[name=bairro]').val(id);
    $("#bairro").val(nome);
    $("#listabairros").html(''); 
    $("#listabairros").hide(); 

                   
}
</script>
        
</body>
</html>
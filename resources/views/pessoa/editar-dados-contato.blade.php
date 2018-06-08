@extends('layout.app')
@section('pagina')

<form name="item" method="POST">

                    <div class="title-block">
                        <h3 class="title"> Edição de dados de Contato<span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                   @include('inc.errors')
                    <div class="subtitle-block">
                        <h3 class="subtitle"> 
                        @if(isset($dados['nome']))
                        	{{$dados['nome']}}
                        
                        </h3>
                    </div>
                    
                        <div class="card card-block">
                            
                            
                            <div class="card card-block">
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Telefone</label>
                                <div class="col-sm-4"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                                        <input type="text" class="form-control boxed" placeholder="Somente numeros" name="telefone" value="{{$dados->telefone}}"> 
                                    </div> 
                                </div>
                                <label class="col-sm-2 form-control-label text-xs-right">E-mail</label>
                                <div class="col-sm-4"> 
                                    <input type="email" class="form-control boxed" placeholder="" name="email" value="{{$dados->email}}"> 
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Celular</label>
                                <div class="col-sm-4"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                                        <input type="text" class="form-control boxed" placeholder="Somente numeros" name="tel2" value="{{$dados->telefone_celular}}"> 
                                    </div> 
                                </div>
                                <label class="col-sm-2 form-control-label text-xs-right">Telefone de um contato</label>
                                <div class="col-sm-4"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                                        <input type="text" class="form-control boxed" placeholder="Somente numeros" name="tel3" value="{{$dados->telefone_contato}}"> 
                                    </div> 
                                </div>
                            </div>       
                            
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label text-xs-right">Logradouro</label>
                        <div class="col-sm-10"> 
                            <input type="text" class="form-control boxed" placeholder="Rua, avenida, etc" name="rua" value="{{$dados->logradouro}}"> 
                        </div>  
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label text-xs-right">Número</label>
                        <div class="col-sm-4"> 
                            <input type="text" class="form-control boxed" placeholder="" name="numero_endereco" value="{{$dados->end_numero}}"> 
                        </div>  
                        <label class="col-sm-2 form-control-label text-xs-right">Complemento</label>
                        <div class="col-sm-4"> 
                            <input type="text" class="form-control boxed" placeholder="" name="complemento_endereco" value="{{$dados->end_complemento}}"> 
                        </div>  
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label text-xs-right">Bairro</label>
                        <div class="col-sm-4"> 
                            <input id="bairro" type="text" class="form-control boxed"  name="bairro_str"> 
                            <ul class="item-list" id="listabairros" style="display:none; width:300px;  height:auto; position:absolute; z-index:100; top:50px; padding:20px;margin-left:300px; background-color: white; overflow-y: hidden; border:1px solid #d0d0d0">
                                
                            </ul> 
                                   
                           <input type="hidden" name="bairro" required>
                        </div> 
                       
                            
                        

                         
                        <label class="col-sm-2 form-control-label text-xs-right">CEP</label>
                        <div class="col-sm-4"> 
                            <input type="text" class="form-control boxed" placeholder="00000000" name="cep" value="{{$dados->cep}}"> 
                        </div>  
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label text-xs-right">Cidade</label>
                        <div class="col-sm-4"> 
                            <input type="text" class="form-control boxed" placeholder="" name="cidade" value="{{$dados->cidade}}"> 
                        </div>  
                        <label class="col-sm-2 form-control-label text-xs-right">Estado</label>
                        <div class="col-sm-4"> 
                            <select  class="form-control boxed"  name="estado"> 
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
                        <label class="col-sm-2 form-control-label text-xs-right">Vincular a</label>
                        <div class="col-sm-10"> 
                            <input type="text" class="form-control boxed" placeholder="Digite o nome da pessoa já cadastrada para vincular, senão deixe em branco."  id="vincular"> 
                            <input type="hidden" name="vinculara" >
                            <ul class="item-list" id="listapessoas">

                            </ul>
                        </div>  
                    </div>
                    <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right"></label>
                                <div class="col-sm-10 col-sm-offset-2"> 
                                    <input type="hidden" name="pessoa" value="{{$dados['id']}}">
                                    <button type="submit" name="btn_sub" value='1' class="btn btn-primary">Salvar</button>
                                   
                                   
                                    {{ csrf_field() }}
                                </div>
                    </div>
                </div>


         
            </form>
@endif

@endsection
@section('scripts')
<script>
    $(document).ready(function() 
    {
   // $('[name=estado]').val({{$dados->estado}});
 
   //On pressing a key on "Search box" in "search.php" file. This function will be called.

 
   $("#vincular").keyup(function() {
       
 
       //Assigning search box value to javascript variable named as "name".
 
       var name = $('#vincular').val();
       var namelist="";

 
       //Validating, if "name" is empty.
 
       if (name == "") {
            

 
           //Assigning empty value to "display" div in "search.php" file.
 
           $("#listapessoas").html("");
 
       }
 
       //If name is not empty.
 
       else {
            
 
           //AJAX is called.
            $.get("{{asset('pessoa/buscarapida/')}}"+"/"+name)
                .done(function(data) 
                {
                    $.each(data, function(key, val){
                        namelist+='<li class="item item-list-header">'
                                    +'<a href="#" onclick="vincularEndereco('+val.id+',\''+val.nome+'\')">'
                                        +val.numero+' - '+val.nascimento+' - '+val.nome
                                    +'</a>'
                                  +'</li>';
                    });
                    
                    $("#listapessoas").html(namelist).show();

                });

        }
 
    });
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
            $.get("{{asset('buscarbairro/')}}"+"/"+name)
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

function escolherBairro(id,nome) {
   
    $('[name=bairro]').val(id);
    $("#bairro").val(nome);
    $("#listabairros").html(''); 
    $("#listabairros").hide(); 

                   
}
 

/***
 * Vincula resgata os dados da pessoa clicada e preenche o formulário com eles
 * @param id - código da pessoa que tem o endereço
 * @param nome - Nome da pessoa que tem o endereço, para preencher o campo "Vincular a"*/
 function vincularEndereco(id,nome) {
    $.get("{{asset('pessoa/buscarendereco/')}}"+"/"+id)
                .done(function(data) 
                {
                    if(!data.id){
                        alert('Essa pessoa não tem dados de endereço');
                        $("#listapessoas").html(''); 
                        $("#vincular").val('');
                    }
                    else {
                        $('[name=rua]').val(data.logradouro);
                        $('[name=numero_endereco]').val(data.numero);
                        $('[name=complemento_endereco]').val(data.complemento);
                        $('[name=bairro]').val(data.bairro);
                        $('[name=cep]').val(data.cep);
                        $('[name=cidade]').val(data.cidade);
                        $('[name=estado]').val(data.estado);
                        $('[name=vinculara]').val(id);
                        $("#listapessoas").html(''); 
                        $("#vincular").val(nome);
                    }
                });
}
</script>
@endsection
@extends('layout.app')
@section('pagina')

<form name="item" method="POST">

                    <div class="title-block">
                        <h3 class="title"> Cadastrando uma nova pessoa<span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                   @include('inc.errors')
                    <div class="subtitle-block">
                        <h3 class="subtitle"> Dados Gerais </h3>
                    </div>
                    
                        <div class="card card-block">
                            
                            
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">Nome/social*</label>
                                <div class="col-sm-10"> 
                                    <input type="text" class="form-control boxed" placeholder="Preencha o nome completo, sem abreviações." name="nome" required> 
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                
                                <label class="col-sm-2 form-control-label text-xs-right">Nascimento*</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                                        <input type="date" class="form-control boxed" placeholder="dd/mm/aaaa" name="nascimento" required> 
                                    </div>
                                </div>
                                <label class="col-sm-2 form-control-label text-xs-right">Telefone</label>
                                <div class="col-sm-3"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                                        <input type="tel" class="form-control boxed" placeholder="Somente numeros" name="telefone"> 
                                    </div>
                                </div>
                            </div>
                                
                            
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">Gênero*</label>
                                <div class="col-sm-10"> 
                                    <label>
                                        <input class="radio" name="genero" type="radio" value="h" >
                                        <span>Masculino</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" value="m" >
                                        <span>Feminino</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" value="x" >
                                        <span>Trans Masculino</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" value=y >
                                        <span>Trans Feminino</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" value="z" >
                                        <span>Não Classificar</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">Nome Registro</label>
                                <div class="col-sm-10"> 
                                    <input type="text" class="form-control boxed" placeholder="nome social" name="nome_social"> 
                                </div>
                            </div>    
                                
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">RG </label>
                                <div class="col-sm-3"> 
                                    <input type="text" class="form-control boxed" placeholder="Somente numeros" name="rg"> 
                                </div>
                                <label class="col-sm-2 form-control-label text-xs-right">CPF* <small title="Caso não tiver CPF o responsável legal deverá ser cadastrado"><i class="fa fa-info-circle"></i></small></label>
                                <div class="col-sm-3"> 
                                    <input type="text" class="form-control boxed" placeholder="Somente numeros" name="cpf">
                                </div>
                                
                                
                            </div>                                
                        </div>
                        <br>
                        <div class="subtitle-block">
                            <h3 class="subtitle"> Dados de contato </h3>
                        </div>
                        <div class="card card-block">
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">E-mail</label>
                                <div class="col-sm-4"> 
                                    <input type="email" class="form-control boxed" placeholder="" name="email"> 
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Telefone alternativo</label>
                                <div class="col-sm-4"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                                        <input type="text" class="form-control boxed" placeholder="Somente numeros" name="tel2"> 
                                    </div> 
                                </div>
                                <label class="col-sm-2 form-control-label text-xs-right">Telefone de um contato</label>
                                <div class="col-sm-4"> 
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                                        <input type="text" class="form-control boxed" placeholder="Somente numeros" name="tel3"> 
                                    </div> 
                                </div>
                            </div>


                    </div>
                    <br>
                    <div class="subtitle-block">
                            <h3 class="subtitle"> Dados de endereço </h3>
                        </div>



                    <div class="card card-block">
                            
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Logradouro</label>
                                <div class="col-sm-10"> 
                                    <input type="text" class="form-control boxed" placeholder="Rua, avenida, etc" name="rua"> 
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Número</label>
                                <div class="col-sm-4"> 
                                    <input type="text" class="form-control boxed" placeholder="" name="numero_endereco"> 
                                </div>  
                                <label class="col-sm-2 form-control-label text-xs-right">Complemento</label>
                                <div class="col-sm-4"> 
                                    <input type="text" class="form-control boxed" placeholder="" name="complemento_endereco"> 
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Bairro</label>
                                <div class="col-sm-4"> 
                                    <select class="c-select form-control boxed" name='bairro'>
                                            @if(count($dados['bairros']))
                                            @foreach ($dados['bairros'] as $bairro)
                                                <option value="{{ $bairro->id }}"> {{ $bairro->nome }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>  
                                <label class="col-sm-2 form-control-label text-xs-right">CEP</label>
                                <div class="col-sm-4"> 
                                    <input type="text" class="form-control boxed" placeholder="00000-000" name="cep"> 
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Cidade</label>
                                <div class="col-sm-4"> 
                                    <input type="text" class="form-control boxed" placeholder="" name="cidade" value="São Carlos"> 
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
                        </div>
                    
                        <br>
                        <div class="subtitle-block">
                        <h3 class="subtitle"> Dados Clínicos</h3>
                        </div>
                        <div class="card card-block">
                            <div class="form-group row"> 
                                    <label class="col-sm-4 form-control-label text-xs-right">Necesssidades especiais</label>
                                    <div class="col-sm-8"> 
                                        <input type="text" class="form-control boxed" placeholder="Motora, visual, auditiva, etc. Se não tiver, não preencha." name="necessidade_especial"> 
                                    </div>
                            </div>
                            <div class="form-group row"> 
                                    <label class="col-sm-4 form-control-label text-xs-right">Medicamentos uso contínuo</label>
                                    <div class="col-sm-8"> 
                                        <input type="text" class="form-control boxed" placeholder="Digite os medicamentos de uso contínuo da pessoa. Se não tiver, não preencha." name="medicamentos"> 
                                    </div>
                            </div>
                            <div class="form-group row"> 
                                    <label class="col-sm-4 form-control-label text-xs-right">Alergias</label>
                                    <div class="col-sm-8"> 
                                        <input type="text" class="form-control boxed" placeholder="Digite alergias ou reações medicamentosas. Se não tiver, não preencha." name="alergias"> 
                                    </div>
                            </div>
                            <div class="form-group row"> 
                                    <label class="col-sm-4 form-control-label text-xs-right">Doença crônica</label>
                                    <div class="col-sm-8"> 
                                        <input type="text" class="form-control boxed" placeholder="Se não tiver, não preencha." name="doenca_cronica"> 
                                    </div>
                            </div>
                        </div>
                        <br>
                        <div class="subtitle-block">
                            <h3 class="subtitle">Finalizando cadastro</h3>
                        </div>
                        <div class="card card-block">
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">
                                    Observações
                                </label>
                                <div class="col-sm-10"> 
                                    <textarea rows="4" class="form-control boxed" name="obs"></textarea> 
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right"></label>
                                <div class="col-sm-10 col-sm-offset-2"> 
                                    <button type="submit" name="btn_sub" value='1' class="btn btn-primary">Salvar</button>
                                    @if(isset($dados['responsavel_por']) && $dados['responsavel_por']!='')
                                        <input type="hidden" name="responsavel_por" value="{{ $dados['responsavel_por' ]}}"/>
                                    @else
                                        <button type="submit" name="btn_sub" value='2' class="btn btn-secondary">Salvar sem CPF e cadastrar Responsável</button>
                                    @endif
                                    
                                    <button type="submit" name="btn_sub" value='3'  class="btn btn-secondary">Salvar e inserir outra pessoa</button>
                                   
                                    {{ csrf_field() }}
                                </div>
                                
                           </div>
                        </div>
                    </form>

@endsection
@section('scripts')
<script>
    $(document).ready(function() 
    {
 
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
 
});
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

                    /*
                    $.each(data, function(key, val){
                        $('#rua').val(val.logradouro);
                        $("#listapessoas").html(''); 
                        $("#vincular").val()='';
                        console.log(val.logradouro);                       
                    });
                    */
                  

                });
}
</script>
@endsection
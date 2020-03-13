@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('pagina')

<form name="item" method="POST">

    <div class="title-block">
        <h3 class="title"> Edição de dados Clínicos<span class="sparkline bar" data-type="bar"></span> </h3>
    </div>
    @include('inc.errors')
    <div class="subtitle-block">
        <h3 class="subtitle"> 
     
        
        </h3>
    </div>
    <div class="card card-block">
        <div class="form-group row"> 
                <label class="col-sm-4 form-control-label text-xs-right">Necesssidades especiais</label>
                
                <div class="col-sm-6"> 
                    

                    <input type="text" class="form-control boxed" placeholder="Motora, visual, auditiva, etc. Se não tiver, não preencha." name="necessidade_especial" value=""  maxlength="150"> 
                    <br>
                    <ul>
                        @foreach($dados->where('dado','necessidade_especial') as $dado)
                        <li>{{$dado->valor}} 
                            <a href="#" onclick="desativarDado('{{$dado->id}}')" title="Apagar Necessidade" >
                                <i class="fa fa-times text-danger"></i>
                            </a> </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-2">
                    <button type="submit" name="btn_sub" value='1' class="btn btn-primary" onclick="cadastrar('necessidade_especial',{{$pessoa}})">Adicionar</button>
                </div>
        </div>
        <div class="form-group row"> 
                <label class="col-sm-4 form-control-label text-xs-right">Medicamentos uso contínuo</label>
                <div class="col-sm-6"> 
                    
                    <input type="text" class="form-control boxed" placeholder="Digite os medicamentos de uso contínuo da pessoa. Se não tiver, não preencha." maxlength="150" name="medicamento" value=""> 
                    <br>
                    <ul>
                        @foreach($dados->where('dado','medicamento') as $dado)
                        <li>{{$dado->valor}}  
                            <a href="#" onclick="desativarDado('{{$dado->id}}')" title="Apagar medicamento" >
                                <i class="fa fa-times text-danger"></i>
                            </a></li>
                        @endforeach
                        </ul>
                       
                </div>
                <div class="col-sm-2">
                    <button type="submit" name="btn_sub" value='1' class="btn btn-primary" onclick="cadastrar('medicamento',{{$pessoa}})">Adicionar</button>
                </div>
        </div>
        <div class="form-group row"> 
                <label class="col-sm-4 form-control-label text-xs-right">Alergias</label>
                <div class="col-sm-6"> 
                    
                    <input type="text" class="form-control boxed" placeholder="Digite alergias ou reações medicamentosas. Se não tiver, não preencha."  maxlength="150" name="alergia" value=""> 
                    <br>
                    <ul>
                        @foreach($dados->where('dado','alergia') as $dado)
                        <li>{{$dado->valor}} 
                            <a href="#" onclick="desativarDado('{{$dado->id}}')" title="Apagar alergia" >
                                <i class="fa fa-times text-danger"></i>
                            </a> </li>
                        @endforeach
                    </ul>                  
                </div>
                <div class="col-sm-2">
                    <button type="submit" name="btn_sub" value='1' class="btn btn-primary" onclick="cadastrar('alergia',{{$pessoa}})">Adicionar</button>
                </div>
        </div>


        <div class="form-group row"> 
                <label class="col-sm-4 form-control-label text-xs-right">Doença crônica</label>
                <div class="col-sm-6">                 
                    <input type="text" class="form-control boxed" placeholder="Se não tiver, não preencha." maxlength="150" name="doenca" value="">
                    <br>
                    <ul>
                        @foreach($dados->where('dado','doenca') as $dado)
                        <li>{{$dado->valor}} 
                            <a href="#" onclick="desativarDado('{{$dado->id}}')" title="Apagar doença" >
                                <i class="fa fa-times text-danger"></i>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                        
                </div>
                <div class="col-sm-2">
                    <button name="btn_sub" value='1' class="btn btn-primary" onclick="cadastrar('doenca',{{$pessoa}})">Adicionar</button>
                </div>
        </div>
    </div>
                    
                        
              
</form>
<script>
    function cadastrar(tipo ,pessoa){
        event.preventDefault();
        dado = $("input[name="+tipo+"]").val();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            method: "POST",
            url: "/pessoa/inserir-dado-clinico",
            data: { pessoa, tipo, valor: dado }

        })
        .done(function(msg){
            location.reload(true);
        })
        .fail(function(jqXHR, textStatus, msg){
            alert('Erro ao gravar os dados. '+msg);

        });
        
        return false;
    }
    function desativarDado(id){
        if(confirm('Deseja mesmo apagar esse dado?')){
            $.ajax({
                headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'/pessoa/apagar-dado-clinico/'+id,
                method:"DELETE",
                
            })
            .done(function(){
                location.reload(true);
            })
            .fail(function(msg){
                alert('Erro '+msg)
            });
        }
    }
</script>



@endsection
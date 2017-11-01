 @extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Matrículas gravadas com sucesso</h3>
</div>

@include('inc.errors')
<div class="subtitle-block">
    <h3 class="subtitle"><small>De: </small> {{$nome}}</h3>
</div>

<form name="item" method="POST" action="gravar">
<div class="card card-danger">

    <div class="card-header">
        <div class="header-block">
        <p class="title" style="color:white"> Atenção!</p>
        </div>
    </div>


    <div class="card-block">
        <p>A matrícula foi gravada, agora fudeu manolo.</p>
    </div>
</div>
@foreach($matriculas as $turma)
<br>


 <div class="card card-primary" id="{{$turma->id}}">
                <div class="card-header">
                    <div class="header-block">
                    <a href="#" title="Remover" onclick="rmItem('{{$turma->id}}');"><span class="fa fa-times" style="color: white"></span></a>
                    <p class="title" style="color:white"> {{$turma->curso->nome}}</p> 

                    </div>
                </div>


<div class="card card-block">
        <div class="title-block center">
            <h3 class="title"> Período do curso</h3>
        </div>
        <div class="form-group row">
            <div class="col-xs-3">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                    <input type="Text" class="form-control boxed" value="{{$turma->data_inicio}}"  readonly> 
                </div>
            </div>
            <div class="col">
                <i class="fa fa-angle-double-right"></i>
            </div>
            <div class="col-xs-3">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                    <input type="Text" class="form-control boxed" value="{{$turma->data_termino}}"  readonly> 
                </div>
            </div>


        </div>

        <div class="title-block center">
            <h3 class="title"> Requisitos da atividade</h3>
        </div>

        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right"></label>
            <div class="col-sm-10">    
            @foreach($turma->curso->requisitos as $requisito)          
                <div>
                    <label>
                    <input class="checkbox" name="atributo[]" value="P" type="checkbox" required>
                    <span>{{$requisito->requisito}}
                    @if($requisito->obrigatorio)
                     (Obrigatório)
                     @endif

                    </span>
                    </label>
                </div>
            @endforeach
            </div>
        </div>
        <div class="title-block center">
            <h3 class="title"> Plano financeiro & Descontos</h3>
        </div>
        
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Desconto
            </label>
            <div class="col-sm-6"> 
                <select class="c-select form-control boxed" onchange="desconto('{{$turma->id}}',this);">
                    <option value="0" selected>Selecione para ativar</option>
                    @foreach($descontos as $desconto)
                    <option value="{{$desconto->id}}">{{$desconto->nome}}</option>
                    @endforeach
                   

                </select>
            </div>
            <div class="col-sm-2">
                <div class="input-group">
                    <span class="input-group-addon">% </span> 
                    <input type="number" class="form-control boxed" placeholder="" name="porcentagem{{$turma->id}}" id="porcentagem{{$turma->id}}" readonly> 
                </div>
            </div>
            <div class="col-sm-2">
                <div class="inline-form input-group">
                    <span class="input-group-addon">R$</span> 
                    <input type="number" class="form-control boxed" placeholder="" name="valor{{$turma->id}}" id="valor{{$turma->id}}" readonly> 
                </div>
            </div>
        </div>
        

        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Dividir em
            </label>
            <div class="col-sm-2"> 
                <div class="input-group">
                    
                    <input type="number" class="form-control boxed" value='{{$turma->tempo_curso}}' name='nparcelas{{$turma->id}}' id="nparcelas{{$turma->id}}" required> 
                    <span class="input-group-addon">Vezes</span> 
                </div>
            </div>
            <label class="col-sm-2 form-control-label text-xs-right">
                Dia de vencimento
            </label>
            <div class="col-sm-2"> 
                <input type="number" class="form-control boxed" value='7' name='dvencimento{{$turma->id}}' required>  
            </div>

            <div class="col-sm-2">
                <buttom class="btn btn-primary" onclick="aplicarPlano({{$turma->id}},{{$turma->valor}});" >Aplicar</buttom>
            </div>

        </div>
        <div class="subtitle-block">
        </div>
        <div class="subtitle-block">
            <p>Saldo: <b id="parcelas{{$turma->id}}">{{$turma->tempo_curso}}</b> parcela(s) de <small>R$</small> <b><span id="saldo_final_parcelado{{$turma->id}}">{{str_replace(',', '.', $turma->valor)/$turma->tempo_curso}}</span></b> = <small>R$</small> <b><span id="saldo_final{{$turma->id}}">{{$turma->valor}}</span></b></p>
        </div>
</div>
</div>
<input type="hidden" id="turma{{$turma->id}}" name="turmas[]" value="{{$turma->id}}">
@endforeach
{{ csrf_field() }}


                    
                        <div class="card card-block">
                            
                            
                            
                                
                            <div class="form-group row">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button type="submit" onclick="valida();"class="btn btn-primary">Finalizar Matrícula</button> 
                                    <a href="{{asset('/secretaria/atender')}}" class="btn btn-secondary">Cancelar</a> 
                                    <!-- 
                                    <button type="submit" class="btn btn-primary"> Cadastrar</button> 
                                    -->
                                </div>

                           </div>
                        </div>
                    </form>
@endsection
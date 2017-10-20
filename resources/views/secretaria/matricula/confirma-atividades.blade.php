 @extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Confirmação de horários de matrícula</h3>
</div>

@include('inc.errors')
<div class="subtitle-block">
    <h3 class="subtitle"><small>De: </small> Adauto Junior</h3>
</div>
<div class="card card-block">
    <!-- Nav tabs -->
    <div class="card-title-block">
        <h3 class="title"> Esta será sua programação semanal </h3>
    </div>
    <!-- Tab panes -->
    <div class="row">
     
        <div class="col-md-3" >
            <div class="title">Seg.</div>
            @foreach($turmas as $turma)
            @if(in_array('seg',$turma->dias_semana))
            <div class="box-placeholder">{{$turma->hora_inicio}} ~ {{$turma->hora_termino}}<br>{{$turma->curso->nome}}<br><small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
        <div class="col-md-3">
            <div class="title">Ter.</div>
            @foreach($turmas as $turma)
            @if(in_array('ter',$turma->dias_semana))
            <div class="box-placeholder">{{$turma->hora_inicio}} ~ {{$turma->hora_termino}}<br>{{$turma->curso->nome}}<br><small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
            
        </div>
        <div class="col-md-3">
            <div class="title">Qua.</div>
            @foreach($turmas as $turma)
            @if(in_array('qua',$turma->dias_semana))
            <div class="box-placeholder">{{$turma->hora_inicio}} ~ {{$turma->hora_termino}}<br>{{$turma->curso->nome}}<br><small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
        <div class="col-md-3">
            <div class="title">Qui.</div>
            @foreach($turmas as $turma)
            @if(in_array('qui',$turma->dias_semana))
            <div class="box-placeholder">{{$turma->hora_inicio}} ~ {{$turma->hora_termino}}<br>{{$turma->curso->nome}}<br><small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
        <div class="col-md-3">
            <div class="title">Sex.</div>
            @foreach($turmas as $turma)
            @if(in_array('sex',$turma->dias_semana))
            <div class="box-placeholder">{{$turma->hora_inicio}} ~ {{$turma->hora_termino}}<br>{{$turma->curso->nome}}<br><small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
        <div class="col-md-3">
            <div class="title">Sab.</div>
            @foreach($turmas as $turma)
            @if(in_array('sab',$turma->dias_semana))
            <div class="box-placeholder">{{$turma->hora_inicio}} ~ {{$turma->hora_termino}}<br>{{$turma->curso->nome}}<br><small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
</div>
<br>
<div class="title-block center">
    <h3 class="title">
        Requisitos para realização das atividades selecionadas
    </h3>
</div>

<div class="card card-block">

        <p> Para sua segurança e para melhor aproveitamento e andamento das atividades propostas, precisamos que os seguintes requisitos sejam atendidos:</p>


        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">Requisitos</label>
            <div class="col-sm-10"> 
                @foreach($turmas as $turma)
                    <p>{{$turma->curso->nome}}</p>
                    @foreach($turma->curso->requisitos as $requisito)
                            
                            <div>
                                <label>
                                <input class="checkbox" name="atributo[]" value="P" type="checkbox">
                                <span>{{$requisito->requisito}}
                                @if($requisito->obrigatorio)
                                 (Obrigatório)
                                 @endif

                                </span>
                                </label>
                            </div>
                        
                       
                     
                    @endforeach
                @endforeach
                 
            </div>
        </div>
</div>
<br>
<div class="title-block center">
                        <h3 class="title"> Plano financeiro & Descontos <span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                    <div class="subtitle-block">
                                    Todos os dados aqui serão analisados pelo setor competente.</br> O(a) tendente se responsabiliza pela veracidade das informações fornecidas.
                                </div>
                    <form name="item">
                        <div class="card card-block">
                            
                            
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">
                                    Desconto
                                </label>
                                <div class="col-sm-6"> 
                                    <select class="c-select form-control boxed" onchange="desconto(this);">
                                        <option value="0" selected>Selecione para ativar</option>
                                        @foreach($descontos as $desconto)
                                        <option value="{{$desconto->id}}">{{$desconto->nome}}</option>
                                        @endforeach
                                       

                                    </select> 
                                </div>
                            </div>
                            
                            
                            <div class="form-group row"> 
                                
                                <label class="col-sm-2 form-control-label text-xs-right">
                                    Porcentagem
                                </label>
                                <div class="col-sm-2"> 
                                    <div class="input-group">
                                        <span class="input-group-addon">% </span> 
                                        <input type="number" class="form-control boxed" placeholder="" id="porcentagem" readonly> 
                                    </div>
                                </div>
                                <label class="col-sm-1 form-control-label text-xs-right">
                                    Valor
                                </label>
                                <div class="col-sm-2"> 
                                    <div class="input-group">
                                        <span class="input-group-addon">R$</span> 
                                        <input type="number" class="form-control boxed" placeholder="" id="valor" readonly> 
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">
                                    Dividir em
                                </label>
                                <div class="col-sm-2"> 
                                    <div class="input-group">
                                        
                                        <input type="number" class="form-control boxed" value='1' name='nparcelas' id="nparcelas"> 
                                        <span class="input-group-addon">Vezes</span> 
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                   
                                </div>
                                <div class="col-sm-2">
                                    <buttom class="btn btn-primary" onclick="aplicarPlano();" >Aplicar</buttom>
                                </div>
   
                            </div>
                            <div class="subtitle-block">
                            </div>
                            <div class="subtitle-block">
                                <p>Saldo total: <b id="parcelas">1</b> parcela(s) de <small>R$</small> <b><span id="saldo_final_parcelado">{{$valor}}</span></b> = <small>R$</small> <b><span id="saldo_final">{{$valor}}</span></b></p>
                            </div>
                                
                            <div class="form-group row">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <a href="disciplinas_show.php?" class="btn btn-primary">Finalizar Matrícula</a> 
                                    <a href="pessoas_aluno_atendimento.php" class="btn btn-secondary">Cancelar</a> 
                                    <!-- 
                                    <button type="submit" class="btn btn-primary"> Cadastrar</button> 
                                    -->
                                </div>

                           </div>
                        </div>
                    </form>
@endsection
@section('scripts')
<script>

function desconto(item){
    console.log(item.value);

    if(item.value==0){
       $('#porcentagem').val(0)
        $('#valor').val(0);
        valor_desc=0;

    }
    @foreach($descontos as $desconto)
    if(item.value=={{$desconto->id}}){
        tipo='{{$desconto->tipo}}';
        valor_desc={{$desconto->valor}};
    }
    @endforeach

    if(tipo=="p"){
        $('#porcentagem').val(valor_desc);
        $('#valor').val(0);}
    else{
        $('#porcentagem').val(0)
        $('#valor').val(valor_desc);
    }


}
function aplicarPlano(){
    if($('#nparcelas').val()<1){
        alert('Numero de parcelas inválido.');
        
    }
    else{
        saldo={{$valor}};
        saldo=saldo-(saldo*$('#porcentagem').val()/100);
        saldo=saldo-$('#valor').val();
        $('#saldo_final_parcelado').html(parseFloat(Math.round(saldo/$('#nparcelas').val() * 100) / 100).toFixed(2)); 
        $('#saldo_final').html(saldo+',00'); 
        $('#parcelas').html($('#nparcelas').val());
    }

    
    


}

</script>

@endsection
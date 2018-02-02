@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Confirmação de horários de matrícula</h3>
</div>

@include('inc.errors')
<div class="subtitle-block">
    <h3 class="subtitle"><small>De: </small> {{$nome}}</h3>
</div>
<div class="card card-block">
    <!-- Nav tabs -->
    <div class="card-title-block">
        <h3 class="title"> Esta será sua programação semanal </h3>
    </div>
    <!-- Tab panes -->
    <div class="row">
     
        <div class="col" >
            <div class="title">Seg.</div>
            @foreach($todas_turmas as $turma)
            @if(in_array('seg',$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}" href="#{{$turma->id}}">{{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{$turma->curso->nome}} - <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Ter.</div>
            @foreach($todas_turmas as $turma)
            @if(in_array('ter',$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}">{{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{$turma->curso->nome}} - <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
            
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Qua.</div>
            @foreach($todas_turmas as $turma)
            @if(in_array('qua',$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}">{{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{$turma->curso->nome}} - <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Qui.</div>
            @foreach($todas_turmas as $turma)
            @if(in_array('qui',$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}">{{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{$turma->curso->nome}} - <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Sex.</div>
            @foreach($todas_turmas as $turma)
            @if(in_array('sex',$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}">{{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{$turma->curso->nome}} - <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Sab.</div>
            @foreach($todas_turmas as $turma)
            @if(in_array('sab',$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}">{{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{$turma->curso->nome}} - <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
</div>
<br>
<form name="item" method="POST" action="gravar">
    <input type="hidden" name="pendente" value="false">

<div class="card card-danger">

    <div class="card-header">
        <div class="header-block">
        <p class="title" style="color:white"> Atenção!</p>
        </div>
    </div>


<div class="card-block">
    <p>Todos os dados aqui serão analisados pelo setor competente.</p>
    <p> O(a) tendente se responsabiliza pela veracidade das informações fornecidas.</p>
    <p> Para sua segurança e para melhor aproveitamento e andamento das atividades propostas, precisamos que os requisitos sejam atendidos</p> </div></div>


@foreach($cursos as $curso)
<br>


 <div class="card card-primary" id="{{$curso->id}}">
                <div class="card-header">
                    <div class="header-block"><!--
                    <a href="#" title="Remover" onclick="rmItem('{{$curso->id}}');"><span class="fa fa-times" style="color: white"></span></a>-->
                    <p class="title" style="color:white"> {{$curso->nome}}</p> 

                    </div>
                </div>


<div class="card card-block">
    @if(count($curso->turmas)>1)
        
        <div class="title-block center">

            <h3 class="title"> Turmas escolhidas</h3>
            @foreach($curso->turmas as $turma)
            <small> {{$turma->disciplina->nome}} - Prof. {{$turma->professor->nome_simples}} </small><br/>
            @endforeach

        </div>
    @endif   
<!--
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
        </div>-->
        <div class="title-block center">
            <h3 class="title"> Plano financeiro & Descontos</h3>
        </div>
        
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Desconto
            </label>
            <div class="col-sm-6"> 
                <select name="fdesconto{{$curso->id}}" class="c-select form-control boxed" onchange="desconto('{{$curso->id}}',this);">
                    <option value="0" selected>Selecione para ativar</option>
                    @foreach($descontos as $desconto)
                    <option value="{{$desconto->id}}">{{$desconto->nome}}</option>
                    @endforeach
                   

                </select>
            </div>
            <div class="col-sm-2">
                <div class="input-group">
                    <span class="input-group-addon">% </span> 
                    <input type="number" class="form-control boxed" placeholder="" name="porcentagem{{$curso->id}}" id="porcentagem{{$curso->id}}" readonly> 
                </div>
            </div>
            <div class="col-sm-2">
                <div class="inline-form input-group">
                    <span class="input-group-addon">R$</span> 
                    <input type="number" class="form-control boxed" placeholder="" name="valor{{$curso->id}}" id="valor{{$curso->id}}" readonly> 
                </div>
            </div>
        </div>
        

        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Dividir em
            </label>
            <div class="col-sm-2"> 
                <div class="input-group">
                    
                    <input type="number" class="form-control boxed" value='{{$turma->tempo_curso}}' name='nparcelas{{$curso->id}}' id="nparcelas{{$curso->id}}" required> 
                    <span class="input-group-addon">Vezes</span> 
                </div>
            </div>
            <label class="col-sm-2 form-control-label text-xs-right">
                Dia de vencimento
            </label>
            <div class="col-sm-2"> 
                <input type="number" class="form-control boxed" value='7' name='dvencimento{{$curso->id}}' required>  
            </div>

            <div class="col-sm-2">
                <buttom class="btn btn-primary" onclick="aplicarPlano('{{$curso->id}}',{{ str_replace(',', '.', $curso->valor) }});" >Aplicar</buttom>
            </div>

        </div>
        <div class="subtitle-block">
        </div>
        <div class="subtitle-block">
            <p>Saldo: <b id="parcelas{{$curso->id}}">{{$turma->tempo_curso}}</b> parcela(s) de <small>R$</small> <b><span id="saldo_final_parcelado{{$curso->id}}">{{str_replace(',', '.', $curso->valor/$turma->tempo_curso)}}</span></b> = <small>R$</small> <b><span id="saldo_final{{$curso->id}}">{{$curso->valor}}</span></b></p>
        </div>
        <input type="hidden" name="valorcursointegral{{$curso->id}}" value="{{$curso->valor}}" >
        <input type="hidden" name="valordesconto{{$curso->id}}" value="0" >

</div>
</div>

@endforeach
<input type="hidden" name="turmas" value="{{$turmas_str}}">
{{ csrf_field() }}



                    
                        <div class="card card-block">
                            
                            
                            
                                
                            <div class="form-group row">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button type="submit" onclick="valida();" class="btn btn-primary">Gravar Matrícula</button> 
                                    <a href="{{asset('/secretaria/atender')}}" class="btn btn-secondary">Cancelar</a> 
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

function desconto(id,item){
    console.log(item.value);

    if(item.value==0){
       $('#porcentagem'+id).val(0)
        $('#valor'+id).val(0);
        valor_desc=0;

    }
    @foreach($descontos as $desconto)
    if(item.value=={{$desconto->id}}){
        tipo='{{$desconto->tipo}}';
        valor_desc={{$desconto->valor}};
    }
    @endforeach

    if(tipo=="p"){
        $('#porcentagem'+id).val(valor_desc);
        $('#valor'+id).val(0);}
    else{
        $('#porcentagem'+id).val(0)
        $('#valor'+id).val(valor_desc);
    }


}
function aplicarPlano(id,valor){
    if($('#nparcelas'+id).val()<1){
        alert('Numero de parcelas inválido.');
        
    }
    else{
        saldo=valor;
        saldo=saldo-(saldo*$('#porcentagem'+id).val()/100);
        saldo=saldo-$('#valor'+id).val();
        $('#saldo_final_parcelado'+id).html(parseFloat(Math.round(saldo/$('#nparcelas'+id).val() * 100) / 100).toFixed(2)); 
        $('#saldo_final'+id).html(saldo+',00'); 
        if(valor>saldo)
            $("input[name=valordesconto"+id+"]").val(valor-saldo);
        $('#parcelas'+id).html($('#nparcelas'+id).val());
    }

    
    


}
function rmItem(id){
    //console.log("hello");
    $('#turma'+id).val('0');
    $('.turma'+id).hide();
    var node=$("#"+id);
    if (node.parentNode) {
        node.parentNode.removeChild(node);
    }
    else{
        console.log(node);
        node.remove();
    }


}
function valida(){
    
    //event.preventDefault();
    if($("input[type=checkbox]:checked").length!=$("input[type=checkbox]").length){
        if(confirm('Existem requisitos não marcados, o que fará com que a matrícula seja feita, porém fique como pendente. Após 1 dia útil se a matrícula não for regularizada, será automaticamente cancelada.')){
            $("input[name=pendente]").val(true);
            document.forms[0].submit();

        }
        else
            return false;
    }    
    document.forms[0].submit();
 
}

</script>

@endsection
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rematrícula FESC 2021 : Turmas disponíveis</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        h1 {margin-top:2rem;
            font-size:14pt;
            font-weight: bold;}
        .description{
            margin-top:2rem;
            font-size:12pt;
        }
        table tr th{
            font-size: 10pt;
            
        }
        .form{
            margin-top:2rem;
        }
        .button{
            margin-top:.1rem;
        }
        .label {
            background-color: #777;
            display: inline;
            padding: .2em .6em .3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
        }
        .turma{
            max-width:600px;
            text-align: left;
    

  }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="title-search-block">
            <div class="title-block">
                <h1 class="title">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-checklist" fill="gray" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                        <path fill-rule="evenodd" d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                      </svg>
                Turmas disponíveis
                
                </h1>
                <p class="title-description"> Alun{{$pessoa->getArtigoGenero($pessoa->genero)}}: <b>{{$pessoa->nome}} </b></p>
            </div>
        </div>
        @include('inc.errors')
        <form name="item" method="post" action="/rematricula/gravar" >
        {{csrf_field()}}
        
            
        <p>Selecione os cursos que deseja fazer a rematrícula. Apenas serão exibidas turmas de continuação.<br>
                    Alterações de horários ou adição de novas disciplinas serão feitas posteriormente na secretaria, em atendimento previamente agendado e em período de novas matrículas.</p>
                    <p>Os valores para 2021 da UATI são: <br>
                    R$294,00 em 10x R$29,40 para 1 disciplina. <br>
                    R$622,00  em 10x R$62,20 para 2 ou 3 disciplinas  <br>
                    R$961,00 em 10x R$96,10 para 4 ou mais disciplinas.<br>
                    R$769,00 em 10x R$76,90 Natação e hidroginástica <br>
                    Demais cursos consulte a tabela de preços na FESC</p>
            
            
    
        <table class="table">
            <tr>
                <th>&nbsp;</th>
                <th>Turma</th>
                <th>Dia e Horário</th>
                <th>Professor(a)</th>
                <th>Local</th>
            </tr>
            @foreach($matriculas as $matricula)
                @foreach($matricula->inscricoes as $inscricao)
                    @if(isset($inscricao->proxima_turma->first()->id))
                        <tr>
                            <td><input type="checkbox" name="turmas[]" value="{{$inscricao->proxima_turma->first()->id}}"></td>
                            <td>
                            <strong title="Começa em {{$inscricao->proxima_turma->first()->data_inicio}}">{{$inscricao->proxima_turma->first()->id}} </strong> - 
                                @if(isset($inscricao->proxima_turma->first()->disciplina))
                                        
                                    {{$inscricao->proxima_turma->first()->disciplina->nome}}     
                                    <small>{{$inscricao->proxima_turma->first()->curso->nome}}</small>
                            
                                @else
                            
                                    {{$inscricao->proxima_turma->first()->curso->nome}}        
                            
                                @endif
                            </td>
                            <td> 
                                {{implode(', ',$inscricao->proxima_turma->first()->dias_semana)}} {{$inscricao->proxima_turma->first()->hora_inicio}} ás {{$inscricao->proxima_turma->first()->hora_termino}}
                            </td>
                            <td>
                                {{$inscricao->proxima_turma->first()->professor->nome_simples}}
                            </td>
                            <td>
                                {{$inscricao->proxima_turma->first()->local->sigla}}
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </table>
            <div class="form-group row">
                <div class="col-md-12 form-group form">
                <input type="checkbox" name="agree" id="agree">
                <label for="agree">Aceito o <a href="/rematricula/termo" target="_blank">TERMO DE MATRÍCULA</a> previsto e confirmo minha matrícula.</label>
                </div>
            </div>
            <div class="form-group row">
                
                <div class="col-md-12 form-group form"> 
                    <input type="hidden" name="pessoa" value="{{$pessoa->id}}">
                    <button type="submit" name="btn"  class="btn btn-primary">Confirmar</button>
                    <button type="reset" name="btn"  class="btn btn-primary">Limpar</button>
                    <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
                </div>
        </div>
        
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>

</html>
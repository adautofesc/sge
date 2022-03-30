<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('/css/vendor.css')}}"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório interno de ocupação de vagas</title>
    <style type="text/css">
        @media print {
                .hide-onprint { 
                    display: none;
                }
                 .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                    float: left;
                      }
               .col-sm-12 {
                    width: 100%;
               }
               .col-sm-11 {
                    width: 91.66666667%;
               }
               .col-sm-10 {
                    width: 83.33333333%;
               }
               .col-sm-9 {
                    width: 75%;
               }
               .col-sm-8 {
                    width: 66.66666667%;
               }
               .col-sm-7 {
                    width: 58.33333333%;
               }
               .col-sm-6 {
                    width: 50%;
               }
               .col-sm-5 {
                    width: 41.66666667%;
               }
               .col-sm-4 {
                    width: 33.33333333%;
               }
               .col-sm-3 {
                    width: 25%;
               }
               .col-sm-2 {
                    width: 16.66666667%;
               }
               .col-sm-1 {
                    width: 8.33333333%;
               }
               table{
                    font-size: 11px;
                }
            }
            .dropdown-menu li a{
                text-decoration: none;
                color:black;
                margin-left: 1rem;
                line-height: 2rem;
            }
    
    </style>
</head>
<body>
    <div class="container">
		<div class="row hide-onprint">
			<div class="col-xs-12" style="margin-top: 20px;margin-bottom: 50px;">
				<form class="inline-form" method="GET">
                    <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                        <select name="local" class="c-select form-control boxed"  onchange="carregarSalas(this.value)">
                            <option value="0">Selecione um local</option>
                            <option value="84">FESC Campus 1</option>
                            <option value="85">FESC Campus 2</option>
                            <option value="86">FESC Campus 3</option>
                            @foreach($locais as $local)
                            <option value="{{$local->id}}">{{$local->nome}}</option>
                            @endforeach
                        </select>
                         
                        </ul>
                    </div>
                    <div class="action dropdown" style="float: left; margin-right: 10px;"> 
                        <button class="btn  rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Desconto
                        </button>
               
                        <ul class="dropdown-menu" style="width: 400px;" id="select-sala">
                            <li> <a href="#">Caso não haja seleção todos serão usados</a></li>
                        
                          
                        
                        </ul>
                    </div>
				
                 
               
               
               <button class="btn btn-success" type="submit">Gerar</button>
				<button class="btn btn-primary" type="button" id="select-all">Limpar</button>
				<a href="#" class="btn btn-primary" onclick="print();">Imprimir</a>
                </form>
			
			</div>
		</div>
    <table class="table table-condensed  table-sm">
        <thead>
            <th>Dia\Sala</th>
            @foreach($salas as $sala)
            <th>{{$sala->nome}}</th>
            @endforeach

        </thead>
        <tbody>
            <tr>
                <th>Segunda</th>
                @foreach($salas as $sala)
                    <td>
                    @foreach($atividades as $atividade)                        
                            @if($atividade->dia == 'seg' && $atividade->sala == $sala->id)
                                {{$atividade->inicio}}/{{$atividade->termino}} : {{$atividade->descricao}}<br>
                            @endif                        
                    @endforeach                   
                    </td>
                @endforeach
            </tr>
            <tr>
                <th>Terça</th>
                @foreach($salas as $sala)
                    <td>
                    @foreach($atividades as $atividade)                        
                            @if($atividade->dia == 'ter' && $atividade->sala == $sala->id)
                                {{$atividade->inicio}}/{{$atividade->termino}} : {{$atividade->descricao}}<br>
                            @endif                        
                    @endforeach                   
                    </td>
                @endforeach
            </tr>
            <tr>
                <th>Quarta</th>
                @foreach($salas as $sala)
                    <td>
                    @foreach($atividades as $atividade)                        
                            @if($atividade->dia == 'qua' && $atividade->sala == $sala->id)
                                {{$atividade->inicio}}/{{$atividade->termino}} : {{$atividade->descricao}}<br>
                            @endif                        
                    @endforeach                   
                    </td>
                @endforeach
            </tr>
            <tr>
                <th>Quinta</th>
                @foreach($salas as $sala)
                    <td>
                    @foreach($atividades as $atividade)                        
                            @if($atividade->dia == 'qui' && $atividade->sala == $sala->id)
                                {{$atividade->inicio}}/{{$atividade->termino}} : {{$atividade->descricao}}<br>
                            @endif                        
                    @endforeach                   
                    </td>
                @endforeach
            </tr>
            <tr>
                <th>Sexta</th>
                @foreach($salas as $sala)
                    <td>
                    @foreach($atividades as $atividade)                        
                            @if($atividade->dia == 'sex' && $atividade->sala == $sala->id)
                                {{$atividade->inicio}}/{{$atividade->termino}} : {{$atividade->descricao}}<br>
                            @endif                        
                    @endforeach                   
                    </td>
                @endforeach
            </tr>
            <tr>
                <th>Sab</th>
                @foreach($salas as $sala)
                    <td>
                    @foreach($atividades as $atividade)                        
                            @if($atividade->dia == 'sab' && $atividade->sala == $sala->id)
                                {{$atividade->inicio}}/{{$atividade->termino}} : {{$atividade->descricao}}<br>
                            @endif                        
                    @endforeach                   
                    </td>
                @endforeach
            </tr>

            
        </tbody>
    </table>
    </div> <!-- /container -->
    <script src="{{asset('js/vendor.js')}}"></script>
    <script type="text/javascript">
    var options = [];

    $( '.dropdown-menu a' ).on( 'click', function( event ) {

        var $target = $( event.currentTarget ),
            val = $target.attr( 'data-value' ),
            $inp = $target.find( 'input' ),
            idx;

        if ( ( idx = options.indexOf( val ) ) > -1 ) {
            options.splice( idx, 1 );
            setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
        } else {
            options.push( val );
            setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
        }

        $( event.target ).blur();
            
        console.log( options );
        return false;
    });

    function carregarSalas(local){
        var salas;
        $("#select-sala").html('<option>Sem salas cadastradas</option>');
        $.get("{{asset('services/salas-api/')}}"+"/"+local)
                .done(function(data) 
                {
                    if(data.length>0){
                        $("#select-sala").html('');
                        let li_item = document.createElement("li");
                            li_item.className = "salas";
                        let a_item = document.createElement("a");
                            a_item.setAttribute('href', '#');
                            a_item.setAttribute('data-value', '0');
                            a_item.setAttribute('tabIndex', '-1');
                        let li_check = document.createElement("input");
                            li_check.setAttribute('type', 'checkbox');
                            li_check.setAttribute('id', 'select-all');
                            li_check.setAttribute('value', '0');                                 
                        let li_text = document.createTextNode(' TODAS');

                        a_item.appendChild(li_check);
                        a_item.appendChild(li_text);
                        li_item.appendChild(a_item);

                        $("#select-sala").append(li_item);

                    }
                        
                    $.each(data, function(key, val){
                        let li_item = document.createElement("li");
                            li_item.className = "salas";
                        let a_item = document.createElement("a");
                            a_item.setAttribute('href', '#');
                            a_item.setAttribute('data-value', val.id);
                            a_item.setAttribute('tabIndex', '-1');
                        let li_check = document.createElement("input");
                            li_check.setAttribute('type', 'checkbox');
                            li_check.setAttribute('name', 'salas[]');
                            li_check.setAttribute('value', val.id);
                        let li_text = document.createTextNode(' '+val.nome);

                        a_item.appendChild(li_check);
                        a_item.appendChild(li_text);
                        li_item.appendChild(a_item);
                        //console.log(li_item);

                        $("#select-sala").append(li_item);

                        });
                });
                
    };//function carregar salas 


        $('#select-all').click(function(event) {   
            alert();
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;                       
                });
            }
        }); 

        

        
    </script>
</body>
</html>
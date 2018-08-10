<div class="tab-pane fade" id="academicos">

    <section class="card card-block">
    Sem dados para exibir neste momento.<br/>
    <ol>
    @foreach($atendimentos as $atendimento)
    <li>{{$atendimento->created_at}}{{$atendimento->descricao}}</li>
    @endforeach
    </ol>


    <small> Futuramente exibira atividades concluídas para impressão de segunda via de certificados.</small>
    </section>
</div>
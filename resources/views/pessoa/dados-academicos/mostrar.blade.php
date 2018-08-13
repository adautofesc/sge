<div class="tab-pane fade" id="academicos">

    <section class="card card-block">
	    <ol>
		    @foreach($atendimentos as $atendimento)
		    <li>{{$atendimento->created_at}} por {{$atendimento->atendente->nome_simples}} Ref.: {{$atendimento->descricao}}</li>
		    @endforeach
	    </ol>
    </section>
</div>
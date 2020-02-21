<div class="tab-pane fade" id="academicos">

    <section class="card card-block">
		Atendimentos
	    <ul>
			@foreach($atendimentos as $atendimento)
			@if($atendimento->descricao != '')
			<li>{{$atendimento->created_at->format('d/m/y H:i')}} - {{$atendimento->descricao}}</li>
			@endif
		    @endforeach
		</ul>
		Contatos
		<ul>
			@foreach($contatos as $contato)
			<li>{{date('d/m/y H:i', strtotime($contato->data))}} - contato por <strong>{{$contato->meio}}</strong> - {{$contato->mensagem}}</li>
			@endforeach
		</ul>
    </section>
</div>
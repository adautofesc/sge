<div class="tab-pane fade" id="academicos">

    <section class="card card-block">
		Atendimentos
	    <ul>
			@foreach($atendimentos as $atendimento)
			@if($atendimento->descricao != '')
			@if(in_array('26', Auth::user()->recursos))
			<li>{{$atendimento->created_at->format('d/m/y H:i')}} - {{$atendimento->descricao}} Por {{$atendimento->atendente->nome_simples}}</li>
			@else
			<li>{{$atendimento->created_at->format('d/m/y H:i')}} - {{$atendimento->descricao}} </li>
			@endif
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
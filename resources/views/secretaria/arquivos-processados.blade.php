@extends('layout.app')
@section('titulo')Upload de arquivo de retorno @endsection
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Processamento de arquivos</h3>
            <p class="title-description">Resultado do processamento de arquivos da pasta temporária.</p>
        </div>
    </div>
</div>
@include('inc.errors')
<section class="section">
    <div class="row">
        <div class="col-md-10 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Arquivos processados:</p>
                    </div>
                </div>
                <div class="card-block">
                    @foreach($logs as $arquivo=>$log)
                    <figure title="{{$log}}">
                            @if(substr($log,0,1)=="E")
                             <span class="svg-error" >
                               {!!file_get_contents(asset('svg/si-glyph-document-error.svg'))!!}
                             </span>
                             @else
                             <span class="svg-success">
                               {!!file_get_contents(asset('svg/si-glyph-document-checked.svg'))!!}
                             </span>
                             @endif
                           
                          <figcaption>{{$arquivo}}</figcaption>
                    </figure>                    
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<style type="text/css">
figure {
  float: left;
  width: 20%;
  text-align: center;
  font-style: italic;
  font-size: smaller;
  text-indent: 0;
  border: thin silver solid;
  margin: 0.5em;
  padding: 0.5em;
}

svg {
    width: 3.5em;
}


.svg-error svg g g{
    fill:#f2101c;
}
.svg-success svg g g{
    fill:#42f4a1;
}
</style>

@endsection

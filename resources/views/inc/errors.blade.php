@if(count($errors) !=0)
    @foreach($errors->all() as $erro)
        <p class="alert alert-warning .alert-dismissible">{{ $erro }}</p>
    @endforeach
@endif
@if(isset($erros_bd) !=0)
    @foreach($erros_bd as $erro)
        <p class="alert alert-danger text-center .alert-dismissible">{{ $erro }}</p>
    @endforeach
@endif
@extends('perfil.layout')
@section('titulo')
    Perfil FESC
@endsection

@section('style')
    <style>

    </style>
@endsection
@section('body')
<div class="card mb-3">
                      
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12">
          <h5 class="mb-0">Seja bem-vindo!</h6>
          <br>
          <p class="text-secondary">Estamos construindo um painel para que você possa ter mais informações sobre seu relacionamento conosco. Sinta-se à vontade para fazer sugestões.</p>
          <hr>
          
          <p class="alert alert-info">Matrículas abertas! Clique <a href="/perfil/matricula/inscricao">aqui</a>  para se inscrever!</p>
          
          <p class="alert alert-success">Envie seus atestados OnLine. Clique <a href="/perfil/atestado">aqui</a>  para se acessar.</p>
          <p class="alert alert-warning">Os boletos dos seus cursos podem ser encontrados no menu "Boletos"</p>
          @if(isset($login))
          <p class="alert alert-success">Seu login de acesso ao Teams é <b>{{$login}}</b> A senha foi enviada para seu e-mail pessoal. Caso não encontrar, verifique também em sua caixa de SPAM.</p>
          @endif
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" >×</button>       
            <p class="modal-title"><i class="fa fa-danger"></i>Para as atividades presenciais é necessário enviar o atestado ou comprovanete de vacinação completa contra Covid-19. <a href="/perfil/atestado/cadastrar">Clique aqui</a> para enviar seu atestado.</p>
            
          </div>
        </div>
      </div>
      <hr>
      @if($errors->any())
            @foreach($errors->all() as $erro)
                <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" >×</button>       
                        <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
                </div>
            @endforeach
          @endif
      <div class="row">
        <div class="col-sm-12">
          <img src="{{asset('/img/matriculas_2021_02.jpg')}}" width="400rem">
        </div>
      </div>
    </div>

  </div>
<!--<div class="card mb-3">
  
<div class="card-body">
  <div class="row">
    <div class="col-sm-3">
      <h6 class="mb-0">Full Name</h6>
    </div>
    <div class="col-sm-9 text-secondary">
      Kenneth Valdez
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-sm-3">
      <h6 class="mb-0">Email</h6>
    </div>
    <div class="col-sm-9 text-secondary">
      fip@jukmuh.al
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-sm-3">
      <h6 class="mb-0">Phone</h6>
    </div>
    <div class="col-sm-9 text-secondary">
      (239) 816-9029
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-sm-3">
      <h6 class="mb-0">Mobile</h6>
    </div>
    <div class="col-sm-9 text-secondary">
      (320) 380-4539
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-sm-3">
      <h6 class="mb-0">Address</h6>
    </div>
    <div class="col-sm-9 text-secondary">
      Bay Area, San Francisco, CA
    </div>
  </div>
</div>

</div>
<div class="row gutters-sm">
<div class="col-sm-6 mb-3">
  <div class="card h-100">
    <div class="card-body">
      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Cursos em andamento</i></h6>
      <small>Web Design</small>
      <div class="progress mb-3" style="height: 5px">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <small>Website Markup</small>
      <div class="progress mb-3" style="height: 5px">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <small>One Page</small>
      <div class="progress mb-3" style="height: 5px">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <small>Mobile Template</small>
      <div class="progress mb-3" style="height: 5px">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <small>Backend API</small>
      <div class="progress mb-3" style="height: 5px">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
    </div>
  </div>
</div>
<div class="col-sm-6 mb-3">
  <div class="card h-100">
    <div class="card-body">
      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Cursos Finalizados</i></h6>
      <small>Web Design</small>
      <div class="progress mb-3" style="height: 5px">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <small>Website Markup</small>
      <div class="progress mb-3" style="height: 5px">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <small>One Page</small>
      <div class="progress mb-3" style="height: 5px">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <small>Mobile Template</small>
      <div class="progress mb-3" style="height: 5px">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <small>Backend API</small>
      <div class="progress mb-3" style="height: 5px">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
    </div>
  </div>
</div>
</div>-->
    
@endsection

@section('scripts')
    
@endsection
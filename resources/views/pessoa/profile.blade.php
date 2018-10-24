@extends('layout.app')
@section('titulo')Atendimento Secretaria. @endsection
@section('pagina')
<style>
.rela-block {
  display: block;
  position: relative;
  margin: auto;
  top: ;
  left: ;
  right: ;
  bottom: ;
}
.profile-pic {
  display: false;
  position: absolute;
  margin: false;
  top: -60px;
  left: 15%;
  right: false;
  bottom: false;
  -webkit-transform: translateX(-50%);
          transform: translateX(-50%);
  height: 100%;
  width: 18%;
  border: 10px solid #fff;
  border-radius: 100%;
  background: url("https://pbs.twimg.com/media/CdbiubzVIAANj8J.jpg") center no-repeat;
  background-size: cover;
}
.user-name{
	left:25%;
	font-size: 1.5em;
}
.user-desc{
	left:25%;
}

</style>

<section class="section">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 center-block">
            <div class="card card-primary">
                <div class="rela-block  card-block">
                	<div class="profile-pic" id="profile_pic"></div>
					<div class="rela-block profile-name-container">
						<div class="rela-block user-name" id="user_name">Adauto Junior</div>
						<div class="rela-block user-desc" id="user_description">Educador</div>
					</div>
					<div class="rela-block profile-card-stats">
						<div class="floated profile-stat works" id="num_works">28<br></div>
						<div class="floated profile-stat followers" id="num_followers">112<br></div>
						<div class="floated profile-stat following" id="num_following">245<br></div>
					</div>
                    
                </div>
            </div> 
        </div>
    </div>
</section>

@endsection
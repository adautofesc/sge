 @extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Nova Matrícula</h3>
</div>

@include('inc.errors')
<div class="subtitle-block">
    <h3 class="subtitle"><small>De: </small> Adauto Junior</h3>
</div>
<div class="card card-block">
    <!-- Nav tabs -->
    <div class="card-title-block">
        <h3 class="title"> Esta é sua programação atual: </h3>
    </div>
    <!-- Tab panes -->
    <div class="row">
     
        <div class="col" >
            <div class="title">Seg.</div>
            <div class="box-placeholder">9:00 ~ 9:50<br>Alongamento<br><small>Adilson</small></div>
            <div class="box-placeholder">9:00 ~ 10:00<br>Alongamento<br><small>Adilson</small></div>
        </div>
        <div class="col">
            <div class="title">Ter.</div>
            <div class="box-placeholder">9:00<br>Alongamento<br><small>Adilson</small></div>
        </div>
        <div class="col">
            <div class="title">Qua.</div>
        </div>
        <div class="col">
            <div class="title">Qui.</div>
        </div>
        <div class="col">
            <div class="title">Sex.</div>
        </div>
        <div class="col">
            <div class="title">Sab.</div>
        </div>
    </div>
</div>
<div class="card card-block">
    <!-- Nav tabs -->
    <div class="card-title-block">
        <h3 class="title"> Itens escolhidos </h3>
    </div>
    <!-- Tab panes -->
    <div class="row">
        <div class="col-xl-12" id="itens_escolhidos" > 
           
        </div>
            
        
    </div>
</div>
                    
<form name="item" class="form-inline">
	<section class="section">
    <div class="row ">
        <div class="col-xl-12">
            <div class="card sameheight-item">
                <div class="card-block">
                    <!-- Nav tabs -->  
                    <ul class="nav nav-tabs nav-tabs-bordered ">
                         @foreach($programas as $programa)
                            <li class="nav-item">
                                <a href="" class="nav-link {{$programa->id==1?'active':''}}" data-target="#{{$programa->sigla}}" aria-controls="{{$programa->sigla}}" data-toggle="tab" role="tab">{{$programa->sigla}}</a> 
                            </li>
                         @endforeach
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabs-bordered" id="turmas">
                        <!-- Tab panes ******************************************************************************** -->
                        
                        

                    </div>
                </div>
                <!-- /.card-block -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-xl-6 -->
        
        <!-- /.col-xl-6 -->
    </div>
</section>

<div class="card-block">
	<a class="btn btn-primary" href="matricula_confirma_cursos.php">Avançar</a>
	
	<button class="btn btn-secondary">Limpar</button>
</div>

</form>
@endsection
@section('scripts')
<script>
var itens;
$(document).ready(function(){
    listar(itens=0);

});
function addItem(turma){
    itens=itens+','+turma;
    listar(itens);

}
function rmItem(turma){
    var itensAtuais=itens.split(',');
    for(var i=0; i<itensAtuais.length;i++){
        if(itensAtuais[i]==turma){
            itensAtuais.splice(i,1);
            break;
        }
    }
    itens=itensAtuais.join();
    listar(itens);

}
function listar(itens_atuais){

    $('#turmas').load('{{asset('/secretaria/turmas-disponiveis')}}/'+itens_atuais+'/0');
     $('#itens_escolhidos').load('{{asset('/secretaria/turmas-escolhidas')}}/'+itens_atuais+'');

    /*
    $.ajax({
    url:'{{asset('/secretaria/turmas-disponiveis')}}' +
        '/'+itens_atuais+'/0',
    type:'GET',
    success: function(data){
           $('#turmas').html(data);
           console.log(data);
        }
    });
    */
}
function hoho() {
    // body...
    console.log('Hoho');
}
</script>



@endsection
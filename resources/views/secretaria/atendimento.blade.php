@extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <h3 class="title">Sra. {{$pessoa->nome}} 
        	@if(isset($pessoa->nome_resgistro))
        		({{$pessoa->nome_resgistro}})
        	@endif
           
        </h3>
        <p class="title-description"> <b> Cod. {{$pessoa->id}}</b> Tel. 3300-0050 </p>
        <div class="items-search">
            <form class="form-inline" method="POST">
            {{csrf_field()}}
                <div class="input-group"> 
                    &nbsp;<a href="?mostrar=todos" class="btn btn-primary btn-sm rounded-s">Ver todos</a>
                </div>
            </form>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-xl-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Matrículas</p>
                    </div>
                </div>
                <div class="card-block">
                    <div><a href="{{asset('/secretaria/matricula/nova')}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class=" fa fa-plus-circle "></i>  Nova Matrícula</a></div>
                    <div><a href="#" class="btn btn-secondary-outline col-xs-12 text-xs-left"><i class="fa fa-check-square-o"></i> Entrega de Atestado </a></div>
                  

                </div>
                
            </div>
        </div>  
        <div class="col-xl-4 center-block"> 
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Financeiro</p>
                    </div>
                </div>
                <div class="card-block">
                    <div><a href="{{asset('/financeiro/lancamentos/listar-por-pessoa')}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><small><i class=" fa fa-usd "></i>  Gerar Parcelas</small></a></div>
                    <div><a href="{{asset('/financeiro/boletos/listar-por-pessoa')}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><small><i class="fa fa-barcode"></i> Gerar Boletos</small></a></div>
                  
                   
                </div>
                
            </div>
        </div>
        <div class="col-xl-4 center-block"> 
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Pessoal</p>
                    </div>
                </div>
                <div class="card-block">
                    <div><a href="{{asset('/pessoa/mostrar/'.$pessoa->id)}}"  class="btn btn-primary-outline col-xs-12 text-xs-left"><small><i class=" fa fa-archive "></i> Dados completos</small></a></div>
                    <div><a href="#" class="btn btn-secondary-outline col-xs-12 text-xs-left"><i class="fa fa-external-link"></i> Certificados</a></div>
                    
                </div>
                
            </div>
        </div>
    </div>
</section>
<section class="section">
	<div class="row">
		<div class="col-xl-12 center-block">
			<div class="card card-primary">
				<div class="card-header">
					<div class="header-block">
						<p class="title" style="color:white">Matrículas & Inscrições</p>
					</div>
				</div>
                <ul class="item-list striped">
                    <li class="item item-list-header">
                        <div class="row striped">
                                                         
                            <div class="col-xl-4 text-success " style="line-height:40px !important; padding-left: 30px;">
                                <div><i class=" fa fa-circle "></i> &nbsp;<small><b>M0000  - Hidroginástica</b></small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div><small>Prof. Natalia Tasse </small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div><small>Seg, sex 14:00-16:00</small></div>
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>FESC 1</small></div>
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>21/05/2018</small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div>
                                    <i class=" fa fa-times "></i>
                                    <i class=" fa fa-pencil-square-o "></i>
                                    <i class=" fa fa-print "></i>
                                    
                                </div>
                            </div>
                     
                        </div>
                    </li>
                    <li>

                        <div class="row">
                                                         
                            <div class="col-xl-4 text-warning " style="line-height:40px !important; padding-left: 30px;">
                                <div class="dropdown-toggle"><i class=" fa fa-circle "></i> &nbsp;<small><b>M0000  - Atividades UATI</b></small></div>
                            </div>
                            <div class="col-xl-5" style="line-height:40px !important;">
                     
                                <div><small>3 Disciplinas</small></div>
                            
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>21/05/2018</small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <i class=" fa fa-times "></i>
                                    <i class=" fa fa-pencil-square-o "></i>
                                    <i class=" fa fa-print "></i>
                                    <i class=" fa fa-plus-circle "></i>
                            </div>
                     
                        </div>
                        <div class="row">
                                                         
                            <div class="col-xl-4" style="line-height:40px !important; padding-left: 50px;">
                                 <div><i class=" fa fa-caret-right "></i>&nbsp;<small>&nbsp;I0000  - Alongamento</small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div><small>Prof. Natalia Tasse </small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div><small>Seg, sex 14:00-16:00</small></div>
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>FESC 1</small></div>
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>21/05/2018</small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div>
                                    <i class=" fa fa-times "></i>
                                    <i class=" fa fa-share-square-o "></i>
                               
                                </div>
                            </div>
                     
                        </div>
                        <div class="row">
                                                         
                            <div class="col-xl-4" style="line-height:40px !important; padding-left: 50px;">
                                 <div><i class=" fa fa-caret-right "></i>&nbsp;<small>&nbsp;I0000  - Alongamento</small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div><small>Prof. Natalia Tasse </small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div><small>Seg, sex 14:00-16:00</small></div>
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>FESC 1</small></div>
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>21/05/2018</small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div>
                                    <i class=" fa fa-times "></i>
                                    <i class=" fa fa-share-square-o "></i>
                                 
                                </div>
                            </div>
                     
                        </div>
                        <div class="row">
                                                         
                            <div class="col-xl-4" style="line-height:40px !important; padding-left: 50px;">
                                 <div><i class=" fa fa-caret-right "></i>&nbsp;<small>&nbsp;I0000  - Alongamento</small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div><small>Prof. Natalia Tasse </small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div><small>Seg, sex 14:00-16:00</small></div>
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>FESC 1</small></div>
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>21/05/2018</small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div>
                                    <i class=" fa fa-times "></i>
                                    <i class=" fa fa-share-square-o "></i>
                                 
                                </div>
                            </div>
                     
                        </div>
                    </li>
                    <li>
                        <div class="row">
                                                         
                            <div class="col-xl-4 text-primary " style="line-height:40px !important; padding-left: 30px;">
                                <div><i class=" fa fa-circle-o "></i> &nbsp;<small><b>I0000  - Tal Curso</b></small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div><small>Prof. Natalia Tasse </small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div><small>Seg, sex 14:00-16:00</small></div>
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>FESC 1</small></div>
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>21/05/2018</small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div>
                                    <i class=" fa fa-times "></i>
                                    <i class=" fa fa-pencil-square-o "></i>
                                    <i class=" fa fa-print "></i>
                                   
                                </div>
                            </div>
                     
                        </div>
                    </li>
                    <li class="alert-warning">
                        <div class="row">
                                                         
                            <div class="col-xl-4 text-primary " style="line-height:40px !important; padding-left: 30px;">
                                <div><i class=" fa fa-circle-o "></i> &nbsp;<small><b>I0000  - Tal Curso</b></small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div><small>Prof. Natalia Tasse </small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div><small>Seg, sex 14:00-16:00</small></div>
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>FESC 1</small></div>
                            </div>
                            <div class="col-xl-1" style="line-height:40px !important;">
                                <div><small>21/05/2018</small></div>
                            </div>
                            <div class="col-xl-2" style="line-height:40px !important;">
                                <div>
                                    <i class=" fa fa-times "></i>
                                    <i class=" fa fa-pencil-square-o "></i>
                                    <i class=" fa fa-print "></i>
                                   
                                </div>
                            </div>
                     
                        </div>
                    </li>
                </ul>
			</div>
		</div>
    </div>
    <div class="row">
        <div class="col-xl-12 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Boletos</p>
                    </div>

                </div>

                <div class="card-block">
                    <ul class="item-list striped">
                        <li class="item item-list-header ">
                            <div class="row ">
                                <div class="col-xl-4 " style="line-height:40px !important; padding-left: 30px;">
                                    <div><i class=" fa fa-barcode "></i> &nbsp;<small><b>Número</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small><b>Vencimento</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div title="Vencimento"><small><b>Valor</b></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small><b>Status</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <small><b>Opções</b></small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="alert-info">
                            <div class="row ">
                                <div class="col-xl-4 " style="line-height:40px !important; padding-left: 30px;">
                                    <div class="dropdown-toggle"><i class=" fa fa-barcode "></i> &nbsp;<small><b>1001111</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>28/04/2017</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div title="Vencimento"><small>R$ 00,00</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>PAGO</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <i class=" fa fa-times "></i>
                                        <i class=" fa fa-pencil-square-o "></i>
                                        <i class=" fa fa-print "></i>
                                       
                                    </div>
                                </div>
                            </div>

                            <!-- foreach lancamentos do boleto -->
                             <div class="row">
                                                         
                                <div class="col-xl-4" style="line-height:40px !important; padding-left: 50px;">
                                    <div></i> &nbsp;<small>Matricula 02356 (Hidro)</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>Parcela 1 </small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>R$ 00,00</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                    
                                       
                                    </div>
                                </div>
                         
                            </div>
                        </li>
                        <li>
                            <div class="row ">
                                <div class="col-xl-4 " style="line-height:40px !important; padding-left: 30px;">
                                    <div class="dropdown-toggle"><i class=" fa fa-barcode "></i> &nbsp;<small><b>1001111</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>28/04/2017</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div title="Vencimento"><small>R$ 00,00</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small>Emitido</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <i class=" fa fa-times "></i>
                                        <i class=" fa fa-pencil-square-o "></i>
                                        <i class=" fa fa-print "></i>
                                       
                                    </div>
                                </div>
                            </div>

                            <!-- foreach lancamentos do boleto -->
                             <div class="row">
                                                         
                                <div class="col-xl-4" style="line-height:40px !important; padding-left: 50px;">
                                    <div></i> &nbsp;<small>Matricula 02356 (Hidro)</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>Parcela 2 </small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>R$ 00,00</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                    
                                       
                                    </div>
                                </div>
                         
                            </div>
                        </li>
                        
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Parcelas em aberto</p>
                    </div>
                </div>
                <div class="card-block">
                    <ul class="item-list striped">
                        <li class="item item-list-header ">
                            <div class="row ">
                                <div class="col-xl-4 " style="line-height:40px !important; padding-left: 30px;">
                                    <div><i class=" fa fa-usd "></i> &nbsp;<small><b>Referência</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small><b>Parcela</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div title="Vencimento"><small><b>Valor</b></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small><b>Status</b></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <small><b>Opções</b></small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row ">
                                <div class="col-xl-4 " style="line-height:40px !important; padding-left: 30px;">
                                    <div><i class=" fa fa-caret-right "></i> &nbsp;<small>Matricula 2192 (Hidro)</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div><small>Parcela 1</small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div title="Vencimento"><small>R$ 00,00</small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-1" style="line-height:40px !important;">
                                    <div><small></small></div>
                                </div>
                                <div class="col-xl-2" style="line-height:40px !important;">
                                    <div>
                                        <i class=" fa fa-times "></i>
                                        <i class=" fa fa-pencil-square-o "></i>
                                        <i class=" fa fa-print "></i>
                                       
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <small>Nenhuma parcela em aberto.</small>
                </div>
                
            </div>
        </div>
    </div>		
</section>



@endsection
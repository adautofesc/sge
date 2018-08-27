@extends('layout.app')
@section('pagina')

<form name="item" method="POST">

                    <div class="title-block">
                        <h3 class="title"> Editar Observação </h3>
                    </div>
                   @include('inc.errors')
                    <div class="subtitle-block">
                        <h3 class="subtitle"> 
                        @if(isset($dados['nome']))
                        	{{$dados['nome']}}
                        
                        </h3>
                    </div>
                    
                        <div class="card card-block">
                            
                            
                            <div class="form-group row"> 
                                <label class="col-sm-2 form-control-label text-xs-right">
                                    Observações
                                </label>
                                <div class="col-sm-10"> 
                                    <textarea rows="4" class="form-control boxed" name="obs" maxlength="150">{{$dados['obs']}}</textarea> 
                                </div>
                            </div>                                
                                               
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right"></label>
                                <div class="col-sm-10 col-sm-offset-2"> 
                                    <input type="hidden" name="pessoa" value="{{$dados['id']}}">
                                    <button type="submit" name="btn_sub" value='1' class="btn btn-primary">Salvar</button>
                                   
                                   
                                    {{ csrf_field() }}
                                </div>
                                
                           </div>
                        </div>
                    </form>@endif

@endsection
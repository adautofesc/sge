<div class="modal fade in" id="modal-vinc-programa" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" title="Fechar caixa">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Vincular a programa</h4>
            </div>
            <div class="modal-body">
				<div class="form-group row"> 
					<label class="col-sm-4 form-control-label text-xs-right">
						Programa 
					</label>
					<div class="col-sm-6"> 
						<select class="c-select form-control boxed" name="programa" id="vinc_programa" required>
							<option >Selecione um programa</option>
							@if(isset($programas))
							@foreach($programas as $programa)
							<option value="{{$programa->id}}">{{$programa->sigla.' - '.$programa->nome}}</option>
							@endforeach
							@endif
						</select> 
					</div>
				</div>       
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="vincularPrograma('{{$pessoa->id}}')" data-dismiss="modal">Confirmar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			</div>
			
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
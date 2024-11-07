<div class="modal fade in" id="modal-carga" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" title="Fechar caixa">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Adicionar Carga Horária</h4>
            </div>
            <div class="modal-body">
				<div class="form-group row"> 
					<label class="col-sm-4 form-control-label text-xs-right">
						Carga
					</label>
					<div class="col-sm-6"> 
						<input type="number" class="form-control" name="carga" id="carga" required>
							
					</div>
				</div>       
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="definirCarga('{{$pessoa->id}}')" data-dismiss="modal">Confirmar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			</div>
			
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
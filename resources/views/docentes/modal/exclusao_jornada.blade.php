<div class="modal fade in" id="modal-exclusao-jornada" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
                @csrf
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" title="Fechar caixa">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Exlusão jornada de trabalho</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row"> 
                    <h5 class="col-sm-12 form-control-label text-warning text-xs-center" >
                        <i class="fa fa-warning"></i> Deseja mesmo excluir a jornada de trabalho?
                    </h5>
                </div>

                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="excluirJornada();" >Confirmar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
                
            </div>
            
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

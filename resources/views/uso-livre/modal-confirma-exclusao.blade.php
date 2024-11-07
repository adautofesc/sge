<div class="modal fade in" id="modal-excluir-atendimento" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
                @csrf
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" title="Fechar caixa">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Confirmação</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row"> 
                    <h5 class="col-sm-12 form-control-label text-secondary text-xs-center title-description" >
                        Confirma a exclusão de atendimento para os itens clicados/selecionados?
                    </h5>
                </div>

                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="modificarAtendimento('excluir');" >Confirmar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
                
            </div>
            
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

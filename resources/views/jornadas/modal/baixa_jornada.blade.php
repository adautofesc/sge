<div class="modal fade in" id="modal-encerrar-jornada" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" title="Fechar caixa">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Termino de jornada de trabalho</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row"> 
                    <label class="col-sm-12 form-control-label text-xs-center" >
                        Aponte a data em que a jornada deixou ou deixará de acontecer.
                    </label>
                </div>

               

                <div class="form-group row">                
                    <label class="col-sm-3 text-xs-right">
                        Termino da jornada
                    </label>
                    <div class="col-sm-4"> 
                        
                            <input type="date" id="data_encerramento" class="form-control boxed" name="dt_termino" placeholder="Termino"> 
                        
                    </div>
                    
                </div>

                

                
               
    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="encerrarJornada();" >Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
                
            </div>
            
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

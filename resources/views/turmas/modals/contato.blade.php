<div class="modal fade in" id="modal-contato" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" title="Fechar caixa">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-bullhorn"></i> Registrar contato</h4>
            </div>
            <div class="modal-body">
               
               <div class="row">
                <div class="col-xs-3">
                    <select class="form-control form-control-sm" name="meio">
                        <option>Meio</option>
                            <option value="telefone">Telefone</option>
                            <option value="sms">SMS</option>
                            <option value="carta">Carta</option>
                            <option value="pessoa">Pessoal</option>
                            <option value="email">E-mail</option>
                            <option value="whatsapp">WhatsApp</option>
                    </select>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="form-control form-control-sm" name="mensagem" placeholder="Escreva aqui o motivo" maxlength="300"><br>
                    <input type="hidden" name="pessoa" value="">
                
                </div>

                    
                </div>
                
                <div>
                    <button type="button" class="btn btn-primary" onclick="registrar_contato(null,null);" data-dismiss="modal">Confirmar</button>                
                    <button type="button" class="btn btn-warning" onclick="registrar_contato(null,'Tentiva de contato telefônico fracassada: caixa postal');" data-dismiss="modal">Caixa postal</button> 
                    <button type="button" class="btn btn-warning" onclick="registrar_contato(null,'Tentiva de contato telefônico fracassada: número consta como inexistente');" data-dismiss="modal">Inexistente</button> 

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> 
                </div>
            
            
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
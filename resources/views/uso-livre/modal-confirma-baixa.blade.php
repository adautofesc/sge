<div class="modal fade in" id="modal-concluir-atendimento" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="/uso-livre/concluir">
            
                @csrf
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" title="Fechar caixa">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Finalizar Acesso</h4>
            </div>
            <div class="modal-body">
                
                <div class="form-group row">
                    
                    <label class="col-sm-2 offset-sm-3 form-control-label text-xs-right text-secondary">Horário</label>
                          <div class="col-sm-4"> 
                            <input type="time" class="form-control boxed" name="termino" id="encerramento" title="Selecione a pessoa para o horário ser preenchido automaticamente" required> 
                          </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 offset-sm-3 form-control-label text-xs-right text-secondary">Atividade</label>
                    <div class="col-sm-4"> 
                        <select name="atividade_fim" class="form-control" placeholder="selecione">
                          
                        <option value="0" selected >Em caso de troca</option>
                          <option value="comunicação" title="Enviar e-mails, fazer chamadas ou conversar">Comunicação</option>
                          <option value="estudo" title="Ralizar trabalhos escolares">Estudo</option>
                          <option value="recreação" title="Jogar ou usar Redes sociais">Recreação</option>
                          <option value="serviço público" title="Acessar algum serviço público - agenda Poupatempo, Detran, Gov.br">Serviço público</option>
                          <option value="trabalho" title="Criar currículo, pesquisar vagas de emprego ou algo relacionado a trabalho">Trabalho</option>
                          
          
                        </select>
                    </div>
                  
                </div>
                <div class="form-group row">
                    
                    <label class="col-sm-2 offset-sm-3 form-control-label text-xs-right text-secondary">Obs</label>
                          <div class="col-sm-4"> 
                            <textarea class="form-control boxed" name="obs" rows="4" > </textarea>
                          </div>
                </div>

                
            </div>
            <div class="modal-footer">
                <input type="hidden" name="usuarios_conclusao" value="">
                <button type="submit" class="btn btn-primary" >Confirmar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
                
            </div>
            </form>
            
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

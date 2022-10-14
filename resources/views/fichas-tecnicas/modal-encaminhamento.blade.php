<div class="modal fade in" id="modal-encaminhar-ficha" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" title="Fechar caixa">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Encaminhar Ficha Técnica</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row"> 
                    <label class="col-sm-12 form-control-label text-xs-center" >
                        Siga a ordem correta (próxima etapa) para o fluxo normal.
                    </label>
                </div>

                <div class="form-group row">                
                    <label class="col-sm-3 text-xs-right">
                        Para {{$ri}}
                    </label>
                    <div class="col-sm-4"> 
                        <select class="c-select form-control boxed" name="depto" id="depto" required>
                            
                            <option value="docente">Docente</option>
                            <option value="coordenacao">Coordenação {{$ficha->status=='docente'?'(Próxima etapa)':''}}</option>

                            @if($ri == 'Coordenador de Programa' || $ri == 'Contador' || $ri == 'Presidente' || $ri == 'Diretor' || $ri == 'Auxiliar Administrativo' )
                                <option value="diretoria">Diretoria  {{$ficha->status=='coordenacao'?'(Próxima etapa)':''}}</option>
                                <option value="administracao">Administração  {{$ficha->status=='diretoria'?'(Próxima etapa)':''}}</option>
                                <option value="presidencia">Presidência  {{$ficha->status=='presidencia'?'(Próxima etapa)':''}}</option>
                                <option value="secretaria">Secretaria  {{$ficha->status=='secretaria'?'(Próxima etapa)':''}}</option>
                                <option value="negado">** Recusar Ficha ** </option>
                            @endif
                        </select>

                    </div>
                    
                </div>
                <div class="form-group row">                
                    <label class="col-sm-3 text-xs-right">
                        Observações <br>
                        <small>até 250 caracteres</small>
                    </label>
                    <div class="col-sm-9">
                        <textarea name="obs" id="obs" cols="30" rows="6" class="form-control boxed" maxlength="250" title="Observações: até 250 caracteres"></textarea>
                    </div>
                    
                </div>
    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="encaminhar({{$ficha->id}});" >Enviar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>         
            </div>
            
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

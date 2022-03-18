<div class="modal fade in" id="modal-add-jornada" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/jornada/cadastrar" method="POST">
                @csrf
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" title="Fechar caixa">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Adição de jornada de trabalho</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row"> 
                    <label class="col-sm-12 form-control-label text-warning text-xs-center" >
                        <i class="fa fa-warning"></i> Não há verificação de ocupação de sala neste cadastro.
                    </label>
                </div>

                <div class="form-group row"> 
                    <label class="col-sm-2 form-control-label text-xs-right">
                        Atividade
                    </label>
                    <div class="col-sm-6"> 
                        <select class="c-select form-control boxed" name="tipo" required>
                            <option>Selecione uma opção</option>
                            <option value="Aula" title="Utilizado para turmas posteriores ou mudanças de horários">Aula - turma futura</option>
                            <option value="Coordenação" >HTP</option>
                            <option value="HTP" >HTP</option>
                            <option value="Translado">Translado</option>
                            <option value="Projeto">Projeto</option>
                           
                
                        </select> 
                    </div>
                </div>

                <div class="form-group row"> 
                    <label class="col-sm-2 form-control-label text-xs-right">
                        Data de início
                    </label>
                    <div class="col-sm-2"> 
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                            <input type="date" class="form-control boxed" name="dt_inicio" placeholder="dd/mm/aaaa" required> 
                        </div>
                    </div>
                    
                </div>

                <div class="form-group row"> 
                    <label class="col-sm-2 form-control-label text-xs-right">
                        Local
                    </label>
                    <div class="col-sm-3"> 
                        <select class="c-select form-control boxed" name="unidade" onchange="carregarSalas(this.value)" required >
                            <option>Selecione ums unidade de atendimento</option>
                            <option value="84">FESC 1</option>
                            <option value="85">FESC 2</option>
                            <option value="86">FESC 3</option>
                            <option value="118">FESC VIRTUAL</option>
                            @if($locais)
                            @foreach($locais as $unidade)
                            <option value="{{$unidade->id}}">{{$unidade->nome}}</option>
                            @endforeach
                            @endif
                        </select> 
                    </div>
                    <label class="col-sm-2 form-control-label text-xs-right">
                        Sala
                    </label>
                    <div class="col-sm-2"> 
                        <select class="c-select form-control boxed" name="sala" id="select_sala" required >
                            <option>Selecione um local antes.</option>
                        
                        </select> 
                    </div>
                </div>

                <div class="form-group row"> 
                    <label class="col-sm-2 form-control-label text-xs-right">
                        Dia(s) semana.
                    </label>
                    <div class="col-sm-10"> 
                        
                        <label><input class="checkbox" name="dias[]" value="seg" type="checkbox"><span>Seg</span></label>
                        <label><input class="checkbox" name="dias[]" value="ter" type="checkbox"><span>Ter</span></label>
                        <label><input class="checkbox" name="dias[]" value="qua" type="checkbox"><span>Qua</span></label>
                        <label><input class="checkbox" name="dias[]" value="qui" type="checkbox"><span>Qui</span></label>
                        <label><input class="checkbox" name="dias[]" value="sex" type="checkbox"><span>Sex</span></label>
                        <label><input class="checkbox" name="dias[]" value="sab" type="checkbox"><span>Sab</span></label>
                    </div>
                </div>
                
        
                <div class="form-group row"> 
                    <label class="col-sm-2 form-control-label text-xs-right">
                        Horário de início
                    </label>
                    <div class="col-sm-3"> 
                        <input type="time" class="form-control boxed" name="hr_inicio" placeholder="00:00" required > 
                    </div>
                    <label class="col-sm-2 form-control-label text-xs-right">
                        Horário Termino
                    </label>
                    <div class="col-sm-3"> 
                        <input type="time" class="form-control boxed" name="hr_termino" placeholder="00:00" required> 
                    </div>
                </div>

                
               
    
            </div>
            <div class="modal-footer">
                <input type="hidden" name="pessoa" value="{{$docente->id}}">
                <button type="submit" class="btn btn-primary" >Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
                
            </div>
            </form>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade in" id="modal-historico" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" title="Fechar caixa">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"> Histórico de alterações</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-condensed" style="font-size: 11px;">
                    <thead>
                        <th>Data</th>
                        <th>Evento</th>
                        <th>Responsável</th>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>{{\Carbon\Carbon::parse($log->data)->format('d/m/Y H:i')}}</td>
                            <td>{{$log->evento}}</td>
                            <td>
                                @if(in_array('26', Auth::user()->recursos))
                                {{$log->getPessoa()}}
                                @else
                                Alguem.
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
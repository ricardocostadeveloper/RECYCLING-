<div style="margin-top:50px;" class="modal fade" id="modalEdit" role="dialog" aria-labelledby="editLabel"
    data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editLabel">Editar Linha</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descrição</label>
                            <input type="text" class="form-control form-control-alternative" placeholder="Descrição"
                                name="descricao_d" id="descricao_d" autofocus="" required="">
                            <input type="hidden" name="id_falha" id="id_falha" autofocus="" required="">
                        </div>
                    </div>

                </div>


                <div class="card-footer py-4">
                    <div style="text-align: right">
                        <button type="submit" class="btn btn-success editModal">
                            <i class="ni ni-folder-17"></i> Salvar
                        </button>
                        <button id="excluirFalha " type="submit" class="btn btn-danger excluirFalha">
                            <i class="ni ni-folder-17"></i> Deletar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="margin-top:10;" class="modal fade" id="modalEdit" role="dialog" aria-labelledby="editLabel"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="width:100%;">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card" style="">
                    <div class='card-header'>
                      <h5>Detalhes do Produto</h5>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cimcode</label>
                                    <input type="text" class="form-control form-control-alternative"
                                        placeholder="Descrição" name="cimcode_d" id="cimcode_d" autofocus=""
                                        required="" disabled>
                                    <input id="id_produto" type="hidden">

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Linha</label>
                                    <input type="text" class="form-control form-control-alternative"
                                        placeholder="Descrição" name="linha_d" id="linha_d" autofocus="" required="" disabled>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cliente</label>
                                    <input type="text" class="form-control form-control-alternative"
                                    placeholder="Descrição" name="cliente_d" id="cliente_d" autofocus="" required="" disabled>

                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="card-footer py-4">
                            <div style="text-align: right">
                                <button id="salvarProduto" type="submit" class="btn btn-primary editModal">
                                    <i class="ni ni-folder-17"></i> Salvar
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="card" style="">
                    <div class='card-header'>
                        <h5>Vincular PartNumber</h5>
                    </div>
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-10">
                                <div class="form-group">
                                  <label>PARTNUMBER</label>
                                  <select id="selectPartnumber" placeholder="Selecione um Partnumber"></select>
                                </div>
                            </div>
                            <div class='col-md-2' style="align-content: flex-end;">
                                <button type="button" id="saveDataPartnumber" class="btn btn-success">
                                  <i class="fa-solid fa-plus"></i> Inserir
                                </button>
                            </div>
                            <div>
                              <table id="listar-partnumber" class="display" style="width:100%">
                                <thead>
                                  <tr>
                                    <th scope="col" class="text-center" id="partnumber">PARTNUMBER</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="margin-top:50px;" class="modal fade" id="modalDelete" role="dialog" aria-labelledby="editLabel"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editLabel">Excluir Partnumber</h4>
            </div>
            <div class="modal-body">

            <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Partnumber</label>
                            <input type="text" class="form-control form-control-alternative" placeholder="Partnumber" 
                                name="partnumber_d" id="partnumber_d" autofocus="" required="">
                            <input type="hidden" name="id_partnumber" id="id_partnumber" autofocus="" required="">
                        </div>
                    </div>
                </div>

                <div class="card-footer py-4">
                    <div style="text-align: right">
                        <button id="excluirPartnumber " type="submit" class="btn btn-danger excluirPartnumber">
                            <i class="ni ni-folder-17"></i> Deletar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
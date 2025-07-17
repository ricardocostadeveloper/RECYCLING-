<?php

// $status_login = 0;
// if (isset($_SESSION['usuario']) == true) {
//   $logado = $_SESSION['nome'];
//   $id_usuario = $_SESSION['id'];
//   $prontuario = $_SESSION['prontuario'];
//   $status_login = 1;
// } else {
//   $logado = "Usuário"; //Nome do usuario padrão 
// }


// if($_SESSION['user']==""){
//     unset($_SESSION['login']);
//     header('Location:src/auth/login.php');
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto</title>

    <style>
        .card-header {
            font-size: 18px;
            /* Tamanho da fonte da cabeçalho */
            font-weight: bold;
        }

        .table th,
        .table td {
            font-size: 18px;
            /* Tamanho da fonte da tabela */
            font-weight: bold;
            align-content: center;
        }

        .table td {
            font-size: 18px;
            /* Tamanho da fonte do conteúdo da tabela */
            font-weight: bold;
        }

        body {
            background: linear-gradient(135deg, #969696, #ffffff);
            /* Gradiente de laranja */
            color: #333;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            /* Fundo das cartas com leve transparência */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            /* Azul padrão */
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Azul mais escuro no hover */
        }

        .table thead th {
            background-color: #007bff;
            /* Azul para o cabeçalho da tabela */
            color: white;
        }

        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
            /* Efeito de hover nas linhas da tabela */
        }

        /* Cores de status */
        .cancelada {
            background: linear-gradient(to bottom, white, #ff3838);
            /* Amarelo suave */
        }

        /* Cores de status */
        .table-status-2 {
            background: linear-gradient(to bottom, white, #f9e261);
            /* Amarelo suave */
        }

        .table-status-3 {
            background-color: #d4edda;
            /* Verde suave */
        }

        .table-status-3 {
            background-color: #d4edda;
        }
    </style>
</head>

<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>

<div class='dashboard-app'>
    <header class='dashboard-toolbar'><a class="menu-toggle"><i class="fas fa-bars"></i></a></header>
    <div class='dashboard-content'>
        <div class='container'>
            <div class='card'>
                <div class='card-header'>
                    <h5>Adicionar Produto</h5>
                </div>
                <div class='card-body'>
                    <div class="row">
                        <div class='col-md-4'>
                            <div class="form-group">
                                <label for="">Adicionar Cimcode</label>
                                <input type="text" id="cimcodeInput" class="form-control"
                                    placeholder="Insira o partCimcodenumber">
                            </div>

                        </div>

                        <div class='col-md-4'>
                            <div class="form-group">
                                <label for="">Adicionar Linha</label>
                                <select id="selectLinha" placeholder="Selecione uma Linha"></select>

                            </div>
                        </div>

                        <div class='col-md-4'>
                            <div class="form-group">
                                <label for="">Adicionar Cliente</label>
                                <select id="selectCliente" placeholder="Selecione um Cliente"></select>

                            </div>
                        </div>


                    </div>
                    <br>
                    <div class="row">
                        <div class='col-md-4'>
                            <button type="button" id="saveDataButton" class="btn btn-success">
                                <i class="fa-solid fa-plus"></i> Inserir
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <br>

            <!-- Tabela de Produtos Cadastrados -->
            <div class="row mt-1">
                <div class="col-xl-12 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header border-0 bg-gradient-visteon-barra">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">Produtos Cadastrados</h5>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="listar-produtos" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" id="cimcode">CIMCODE</th>
                                        <th scope="col" class="text-center" id="linha">LINHA</th>
                                        <<th scope="col" class="text-center" id="cliente">CLIENTE</th>
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



<?php include 'detalhe-produto.php'; ?>


<script>
    $(document).ready(function () {

        $('#salvarProduto').hide();
        // Inicializar o Selectize Cliente
        var selectCliente = $('#selectCliente').selectize({
            maxItems: 1,
            valueField: 'id',
            labelField: 'title',
            searchField: 'title',
            options: [],
            create: false,
            load: function (query, callback) {
                $.ajax({
                    url: 'consultas/cliente/selectCliente.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query
                    },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        selectCliente[0].selectize.clearOptions();
                        selectCliente[0].selectize.addOption(res.options || []);
                        selectCliente[0].selectize.refreshOptions(false);
                    }
                });
            }
        });


        // Carregar as opções quando a página é carregada
        $.ajax({
            url: 'consultas/cliente/selectCliente.php',
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                selectCliente[0].selectize.addOption(res.options || []);
                selectCliente[0].selectize.refreshOptions(false);
            }
        });

        $('#salvarProduto').hide();


        // // Inicializar o Selectize linha
        var selectLinha = $('#selectLinha').selectize({
            maxItems: 1,
            valueField: 'id',
            labelField: 'title',
            searchField: 'title',
            options: [],
            create: false,
            load: function (query, callback) {
                $.ajax({
                    url: 'consultas/linhas/selectLinha.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query
                    },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        selectLinha[0].selectize.clearOptions();
                        selectLinha[0].selectize.addOption(res.options || []);
                        selectLinha[0].selectize.refreshOptions(false);
                    }
                });
            }
        });


        // Carregar as opções quando a página é carregada
        $.ajax({
            url: 'consultas/linhas/selectLinha.php',
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                selectLinha[0].selectize.addOption(res.options || []);
                selectLinha[0].selectize.refreshOptions(false);
            }
        });

        // criando tabela de linha com Datatable
        var table = $('#listar-produtos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "consultas/produtos/table.php",
            language: {
                url: 'http://localhost:8080/recycling/assets/js/dataTables-pt-BR.json',
            },
        });

        // Função para inicializar o DataTable
        function initializeTablePartnumber() {
            var table = $('#listar-partnumber').DataTable({
                "processing": true,
                "serverSide": true,
                "destroy": true, // Permite recriar o DataTable se ele já estiver inicializado
                "ajax": {
                    "url": "consultas/produtos_partnumber/table.php",
                    "data": function (d) {
                        var produtoId = $('#id_produto').val();
                        d.produto_id = produtoId;
                    }
                },
                "columns": [
                    { "data": "partnumber" },
                    { "data": "id", "visible": false }, // Oculte a coluna id
                    {
                        "data": null,
                        "defaultContent": "<button class='btn btn-danger delete-btn'>Delete</button>"
                    }
                ],
                "language": {
                    url: 'http://localhost:8080/recycling/assets/js/dataTables-pt-BR.json',
                },
            });

            $('#listar-partnumber tbody').on('click', '.delete-btn', function () {
                var row = table.row($(this).parents('tr')); // Pega a linha da tabela
                var data = row.data(); // Pega os dados da linha

                if (!data || !data.id) {
                    // alertify.error('ID não encontrado');
                    return; // Impede o delete se o id não estiver presente
                }

                var partnumberId = data.id; // ID da partnumber para excluir
                
                // Confirmação de delete com AlertifyJS
                alertify.confirm('Deletar', 'Tem certeza que deseja deletar este item?', function() { 
                    // Faz a requisição AJAX para deletar
                    $.ajax({
                        url: 'consultas/produtos_partnumber/delete.php', // Endpoint para deletar
                        type: 'POST',
                        data: { id: partnumberId },
                        success: function(response) {
                            alertify.success('Item deletado com sucesso');
                            // Remove a linha da tabela após sucesso
                            row.remove().draw();
                        },
                        error: function() {
                            alertify.error('Erro ao deletar o item');
                        }
                    });

                }, function() {
                    alertify.error('Cancelado');
                });
            });

        }

        // Ação ao clicar em uma linha de #listar-produtos
        $('#listar-produtos tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            $("#modalEdit").modal("show");

            // BUSCA O USUARIO LOGADO NO SISTEMA
            $.ajax({
                url: 'consultas/produtos/consultaDetail.php',
                type: 'post',
                dataType: 'json',
                data: {
                    id: data[3]
                },
                success: function (dados) {
                    $("#id_produto").val(dados.id);
                    $("#cimcode_d").val(dados.cimcode);
                    $("#linha_d").val(dados.linha);
                    $("#cliente_d").val(dados.cliente);

                    // Inicializa ou recria o DataTable após definir o produto_id
                    if ($.fn.DataTable.isDataTable('#listar-partnumber')) {
                        $('#listar-partnumber').DataTable()
                    .destroy(); // Destrói o DataTable existente                
                    }
                    initializeTablePartnumber(); // Inicializa o DataTable com o novo produto_id
                },

                error: function () {
                    $("#id_produto").val('');
                    $("#id_produto").prop('disabled', false);
                    $("#cimcode_d").val('');
                    $("#cimcode_d").prop('disabled', false);
                }
            });


            // Inicializar o Selectize partnumber (executado apenas uma vez)
            if (!$('#selectPartnumber')[0].selectize) {
                $('#selectPartnumber').selectize({
                    maxItems: 1,
                    valueField: 'id',
                    labelField: 'title',
                    searchField: 'title',
                    options: [],
                    create: false,
                    load: function (query, callback) {
                        $.ajax({
                            url: 'consultas/partnumber/selectPartnumber.php',
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                q: query
                            },
                            error: function () {
                                callback();
                            },
                            success: function (res) {
                                var selectPartnumber = $('#selectPartnumber')[0].selectize;
                                selectPartnumber.clearOptions();
                                selectPartnumber.addOption(res.options || []);
                                selectPartnumber.refreshOptions(false);
                            }
                        });
                    }
                });
            }

            // Carregar as opções de selectPartnumber na inicialização
            $.ajax({
                url: 'consultas/partnumber/selectPartnumber.php',
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    var selectPartnumber = $('#selectPartnumber')[0].selectize;
                    selectPartnumber.addOption(res.options || []);
                    selectPartnumber.refreshOptions(false);
                }
            });
        });
    });


    function updateTables() {
        // Supondo que você esteja utilizando DataTables
        $('#listar-produtos').DataTable().ajax.reload(); // Recarrega os dados da tabela
    }

    document.getElementById('saveDataButton').addEventListener('click', function () {
        const cimcode = document.getElementById('cimcodeInput').value.trim();
        const linha = document.getElementById('selectLinha').value.trim();
        const cliente = document.getElementById('selectCliente').value.trim();

        if (cimcode === "" || linha === "" || cliente === "") {
            alertify.error('Por favor, preencha todos os campos antes de inserir!');
        } else {
            fetch('consultas/produtos/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'cimcode': cimcode,
                        'linha_id': linha,
                        'cliente_id': cliente,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alertify.success(data.message); // Mostra a mensagem de sucesso
                        // Limpa os campos de entrada
                        document.getElementById('cimcodeInput').value = '';
                        document.getElementById('selectLinha').value = '';
                        document.getElementById('selectCliente').value = '';
                        // Atualiza as tabelas
                        updateTables();
                    } else {
                        alertify.error(data.message); // Mostra a mensagem de erro
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alertify.error('Erro ao salvar os dados!');
                });
        }
    });

    function updatePartnumber() {
        // Supondo que você esteja utilizando DataTables
        $('#listar-partnumber').DataTable().ajax.reload(); // Recarrega os dados da tabela
    }

    document.getElementById('saveDataPartnumber').addEventListener('click', function () {
        const partnumber = document.getElementById('selectPartnumber').value;
        const produto = document.getElementById('id_produto').value.trim();

        if (partnumber === "") {
            alertify.error('Por favor, preencha o partnumber!');
        } else {
            fetch('consultas/produtos/insertProduto_partnumber.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'partnumber_id': partnumber,
                        'produto_id': produto

                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alertify.success(data.message); // Mostra a mensagem de sucesso
                        // Limpa os campos de entrada
                        document.getElementById('selectPartnumber').value = '';
                        updatePartnumber();
                    } else {
                        alertify.error(data.message); // Mostra a mensagem de erro
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alertify.error('Erro ao salvar os dados!');
                });
        }
    });
        
</script>
<?php include 'footer.php'; ?>
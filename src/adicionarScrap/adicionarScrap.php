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

        #listar-scrap td,
        #listar-scrap th {
            text-align: center;
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
                    <h5>Adicionar scrap</h5>
                </div>

                <div class='card-body'>
                    <div class="row">
                        <div class='col-md-2'>
                            <div class="form-group">
                                <label for="">Adicionar Cliente</label>
                                <select id="selectCliente" placeholder="Selecione o cliente"></select>
                            </div>
                        </div>

                        <div class='col-md-2'>
                            <div class="form-group">
                                <label for="">Adicionar Cimcode</label>
                                <select id="selectProduto" placeholder="Selecione o Cimcode"></select>
                            </div>
                        </div>

                        <div class='col-md-2'>
                            <div class="form-group">
                                <label for="">Selecionar Área</label>
                                <select id="selectArea" class="form-control" placeholder="Selecione o seu setor">
                                    <option value="">Selecione</option>
                                    <option value="1">SMD</option>
                                    <option value="2">FA</option>
                                </select>
                            </div>
                        </div>

                        <div class='col-md-2'>
                            <div class="form-group">
                                <label for="">Reincidente</label>
                                <select id="selectReincidencia" class="form-control" placeholder="Sim ou Não">
                                    <option value="">Selecione</option>
                                    <option value="1">Sim</option>
                                    <option value="2">Não</option>
                                </select>
                            </div>
                        </div>

                        <div class='col-md-2'>
                            <div class="form-group">
                                <label for="">Turno</label>
                                <select id="selectTurno" class="form-control" placeholder="Selecione o turno">
                                    <option value="">Selecione</option>
                                    <option value="1">COMERCIAL</option>
                                    <option value="2">ESPECIAL</option>
                                </select>
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
                            <table id="listar-scrap" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" id="cliente">SERIAL</th>
                                        <th scope="col" class="text-center" id="setor">SETOR</th>
                                        <th scope="col" class="text-center" id="reincidente">REINCIDENTE</th>
                                        <th scope="col" class="text-center" id="turno">TURNO</th>
                                        <th scope="col" class="text-center" id="produto">PRODUTO</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-4">
                    <a href="index.php?page=detalheScrap" class="btn btn-light" id="proxPag">
                        <i class="fa-solid fa-arrow-right"></i> Prosseguir
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

<?php include 'detalhe-adicionarScrap.php'; ?>


<script>
    $(document).ready(function () {
        // Inicializar o Selectize linha
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

        $('#selectCliente').on('change', function () {
            var selectProduto = $('#selectProduto').selectize({
                maxItems: 1,
                valueField: 'id',
                labelField: 'title',
                searchField: 'title',
                options: [],
                create: false,
                load: function (query, callback) {
                    var clienteId = $('#selectCliente')
                        .val(); // Pega o valor atual do selectCliente
                    if (!clienteId)
                        return callback(); // Se não tiver valor selecionado, não carrega nada

                    $.ajax({
                        url: 'consultas/produtos/selectCimcode.php',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            cliente_id: clienteId // Passa o ID do cliente selecionado
                        },
                        error: function () {
                            callback();
                        },
                        success: function (res) {
                            selectProduto[0].selectize
                        .clearOptions(); // Limpa opções antigas
                            selectProduto[0].selectize.addOption(res.options ||
                                []); // Adiciona as novas opções
                            selectProduto[0].selectize.refreshOptions(
                            false); // Atualiza o selectize
                        }
                    });
                }
            })[0].selectize;

            // Carrega as opções do selectProduto quando o cliente é selecionado
            selectProduto.clearOptions();
            selectProduto.load(function (callback) {
                $.ajax({
                    url: 'consultas/produtos/selectCimcode.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        cliente_id: $('#selectCliente').val()
                    },
                    success: function (res) {
                        callback(res.options || []);
                    },
                    error: function () {
                        callback();
                    }
                });
            });
        });

        // criando tabela de linha com Datatable
        var table = $('#listar-scrap').DataTable({
            "processing": true,
            "serverSide": true,
            "destroy": true, // Permite recriar o DataTable se ele já estiver inicializado
            "ajax": {
                "url": "consultas/scrap/table.php"
            },
            "columns": [{
                    "data": "serial"
                },
                {
                    "data": "area"
                },
                {
                    "data": "reincidente"
                },
                {
                    "data": "turno"
                },
                {
                    "data": "produto_id"
                },
                {
                    "data": "id",
                    "visible": false
                }, // Oculte a coluna id
                {
                    "data": null,
                    "defaultContent": "<button class='btn btn-primary proxPag'>Detalhes</button>"
                }
            ],
            "language": {
                url: 'http://localhost:8080/recycling/assets/js/dataTables-pt-BR.json',
            },

        });
        $('#listar-scrap tbody').on('click', '.proxPag', function () {
                var row = table.row($(this).parents('tr')); // Pega a linha da tabela
                var data = row.data(); // Pega os dados da linha

                if (!data || !data.id) {
                    // alertify.error('ID não encontrado');
                    return; // Impede o redirecionamento se o ID não estiver presente
                }

                var scrapID = data.id; // ID do item para redirecionar
                // Redireciona para a nova página com o ID como parâmetro
                window.location.href = 'index.php?page=detalheScrap&id=' + scrapID;
        });
    });

    function updateTables() {
        // Supondo que você esteja utilizando DataTables
        $('#listar-scrap').DataTable().ajax.reload(); // Recarrega os dados da tabela
    }


    document.getElementById('saveDataButton').addEventListener('click', function () {
        const produto = document.getElementById('selectProduto').value.trim();
        const reincidente = document.getElementById('selectReincidencia').value.trim();
        const turno = document.getElementById('selectTurno').value.trim();
        const area = document.getElementById('selectArea').value.trim();

        if (produto === "" || reincidente === "" || turno === "" || area === "") {
            alertify.error('Por favor, preencha todos os campos antes de inserir!');
        } else {
            fetch('consultas/scrap/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'produto_id': produto,
                        'reincidente': reincidente,
                        'turno': turno,
                        'area': area
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alertify.success(data.message); // Mostra a mensagem de sucesso
                        // Limpa os campos de entrada
                        document.getElementById('selectProduto').value = '';
                        document.getElementById('selectReincidencia').value = '';
                        document.getElementById('selectTurno').value = '';
                        document.getElementById('selectArea').value = '';
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
</script>
<?php include 'footer.php'; ?>
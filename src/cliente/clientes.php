<?php
session_start();


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
    <title>Clientes</title>

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
                    <h5>Adicionar Clientes</h4>
                </div>
                <div class='card-body'>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <input type="text" id="clienteInput" class="form-control"
                                    placeholder="Insira o nome do cliente">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="button" id="saveDataButton" class="btn btn-success"><i
                                        class="fa-solid fa-plus"></i>
                                    Inserir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <br>
        <div class='container'>
            <div class="row mt-1">
                <div class="col-xl-12 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header border-0 bg-gradient-visteon-barra">
                            <div class="row align-items-center ">
                                <div class="col">
                                    <h5 class="mb-0">Clientes Cadastrados</h5>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table id="listar-cliente" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" id="descricao">Descrição</th>
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
<div style="margin-top:50px;" class="modal fade" id="modalEdit" role="dialog" aria-labelledby="editLabel"
    data-backdrop="static" data-keyboard="false">
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
                            <input type="hidden" name="id_cliente" id="id_cliente" autofocus="" required="">
                        </div>
                    </div>

                </div>


                <div class="card-footer py-4">
                    <div style="text-align: right">
                        <button type="submit" class="btn btn-success editModal">
                            <i class="ni ni-folder-17"></i> Salvar
                        </button>
                        <button id="excluirCliente " type="submit" class="btn btn-danger excluirCliente">
                            <i class="ni ni-folder-17"></i> Deletar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const selectElement = document.querySelector("#clienteInput");


    function updateTables() {
    // Supondo que você esteja utilizando DataTables
        $('#listar-cliente').DataTable().ajax.reload(); // Recarrega os dados da tabela
    }

    document.getElementById('saveDataButton').addEventListener('click', function () {
        const cliente = document.getElementById('clienteInput').value;

        if (cliente == "") {
            alertify.error('Insira o cliente!');
        } else {
            fetch('consultas/cliente/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'cliente': cliente,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alertify.success(data.message); // Mostra a mensagem de sucesso
                        // Limpa os campos de entrada
                        document.getElementById('clienteInput').value = '';
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

    $(document).ready(function () {
        // criando tabela de linha com Datatable
        var table = $('#listar-cliente').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "consultas/cliente/table.php",
            language: {
                url: 'http://localhost:8080/recycling/assets/js/dataTables-pt-BR.json',
            },
        });
        $('#listar-cliente tbody').on('click', 'tr', function () {
            var data = table.row(this).data();

            $("#modalEdit").modal("show");

            // BUSCA O USUARIO LOGADO NO SISTEMA
            $.ajax({
                url: 'consultas/cliente/consultaDetail.php',
                type: 'post',
                dataType: 'json',
                data: {
                    id: data[1]
                },
                success: function (dados) {
                    // $("#cs_cad").val('1');
                    $("#id_cliente").val(dados.id);
                    $("#descricao_d").val(dados.descricao);
                    // $("#requisitante").prop('disabled', true);
                },

                error: function () {
                    $("#id_cliente").val('');
                    $("#id_cliente").prop('disabled', false);

                    $("#descricao_d").val('');
                    $("#descricao_d").prop('disabled', false);

                }
            });
            // alert('You clicked on ' + data[5] + "'s row");
        });

        $(this).on('click', '.editModal', function (e) {
            e.preventDefault();
            if ($("#descricao_d").val()) {
                alertify.confirm("Inserir", "Deseja inserir?",
                    function () {
                        $.getJSON('consultas/cliente/edit.php?search=', {
                            id: $("#id_cliente").val(),
                            descricao_d: $("#descricao_d").val(),
                            ajax: 'true'
                        }, function (j) {});
                        alertify.success('Editado!');
                        updateTables();
                    },
                    function () {
                        alertify.error('Cancelado!');
                    });
            } else {
                alertify.error('Todos os campos são obrigatórios');
            };

        });

        $(this).on('click', '.excluirCliente', function (e) {
            e.preventDefault();
            //alert($('#inputRate').val());
            var id = $("#id_cliente").val();
            alertify.confirm("Excluir", "Deseja excluir Cliente?",
                function () {
                    $.getJSON('consultas/cliente/delete.php?search=', {
                        id: id,
                        ajax: 'true'
                    }, function (j) {

                    });
                    alertify.success('Excluído!');
                    updateTables();
                },
                function () {
                    alertify.error('Cancelado!');
                });
        });
    });
</script>
<?php include 'detalhe-clientes.php'; ?>
<?php include 'footer.php'; ?>
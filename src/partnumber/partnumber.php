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
    <title>Partnumber</title>

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
                    <h5>Adicionar Valor Unitário</h5>
                </div>
                <div class='card-body'>
                    <div class="row">
                        <div class='col-md-4'>
                            <div class="form-group">
                                <label for="">Adicionar Partnumber</label>
                                <input type="text" id="partnumberInput" class="form-control"
                                    placeholder="Insira o partnumber">
                            </div>

                        </div>
                        <div class='col-md-4'>
                            <div class="form-group">
                                <label for="">Adicionar Valor Unitário</label>
                                <input type="text" id="valorUnitarioInput" class="form-control"
                                    placeholder="Insira o valor unitário">
                            </div>
                            
                        </div>
                        <div class='col-md-4'>
                            <div class="form-group">
                                <label for="">Adicionar Descrição</label>
                                <input type="text" id="faseInput" class="form-control" placeholder="Insira a fase">
    
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

            <!-- Tabela de Partnumbers Cadastrados -->
            <div class="row mt-1">
                <div class="col-xl-12 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header border-0 bg-gradient-visteon-barra">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">Partnumber Cadastrados</h5>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="listar-partnumber" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" id="partnumber">PARTNUMBER</th>
                                        <th scope="col" class="text-center" id="valor_unit">VALOR UNITÁRIO</th>     
                                        <<th scope="col" class="text-center" id="fase">FASE</th>
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
<div style="margin-top:50px;" class="modal fade" id="modalEdit" role="dialog" aria-labelledby="editLabel"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editLabel">Editar Partnumber</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Partnumber</label>
                            <input type="text" class="form-control form-control-alternative" placeholder="Descrição"
                                name="partnumber_d" id="partnumber_d" autofocus="" required="">
                                <input id="id_partnumber" type="hidden">

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Valor Unitário</label>
                            <input type="text" class="form-control form-control-alternative" placeholder="Descrição"
                                name="valor_d" id="valor_d" autofocus="" required="">
 
                        </div>
                    </div>                    
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>Fase</label>
                            <input type="text" class="form-control form-control-alternative" placeholder="Descrição"
                                name="fase_d" id="fase_d" autofocus="" required="">

                        </div>
                    </div>
                </div>


                <div class="card-footer py-4">
                    <div style="text-align: right">
                        <button type="submit" class="btn btn-success editModal">
                            <i class="ni ni-folder-17"></i> Salvar
                        </button>
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

<script>
    const selectElement = document.querySelector("#partnumberInput");
    const valor_unit = document.getElementById('valorUnitarioInput').value.trim();
    const fase = document.getElementById('faseInput').value.trim();


    function updateTables() {
        // Supondo que você esteja utilizando DataTables
        $('#listar-partnumber').DataTable().ajax.reload(); // Recarrega os dados da tabela
    }

    document.getElementById('saveDataButton').addEventListener('click', function () {
        const partnumber = document.getElementById('partnumberInput').value.trim();
        const valor_unit = document.getElementById('valorUnitarioInput').value
            .trim(); // Atualize para valorUnitarioInput
        const fase = document.getElementById('faseInput').value.trim();

        if (partnumber === "" || valor_unit === "" || fase === "") {
            alertify.error('Por favor, preencha todos os campos antes de inserir!');
        } else {
            fetch('consultas/partnumber/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'partnumber': partnumber,
                        'valor_unit': valor_unit,
                        'fase': fase,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alertify.success(data.message); // Mostra a mensagem de sucesso
                        // Limpa os campos de entrada
                        document.getElementById('partnumberInput').value = '';
                        document.getElementById('valorUnitarioInput').value = '';
                        document.getElementById('faseInput').value = '';
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
        var table = $('#listar-partnumber').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "consultas/partnumber/table.php",
            language: {
                url: 'http://localhost:8080/recycling/assets/js/dataTables-pt-BR.json',
            },
        });
        $('#listar-partnumber tbody').on('click', 'tr', function () {
            var data = table.row(this).data();

            $("#modalEdit").modal("show");

            // BUSCA O USUARIO LOGADO NO SISTEMA
            $.ajax({
                url: 'consultas/partnumber/consultaDetail.php',
                type: 'post',
                dataType: 'json',
                data: {
                    id: data[3]
                },
                success: function (dados) {
                    $("#id_partnumber").val(dados.id);
                    $("#partnumber_d").val(dados.partnumber);
                    $("#valor_d").val(dados.valor_unit);
                    $("#fase_d").val(dados.fase);
                    // $("#requisitante").prop('disabled', true);
                },

                error: function () {
                    $("#id_partnumber").val('');
                    $("#id_partnumber").prop('disabled', false);

                    $("#partnumber_d").val('');
                    $("#partnumber_d").prop('disabled', false);

                }
            });
            // alert('You clicked on ' + data[5] + "'s row");
        });

        $(this).on('click', '.editModal', function (e) {
            e.preventDefault();
            if ($("#partnumber_d").val()) {
                alertify.confirm("Inserir", "Deseja editar?",
                    function () {
                        $.getJSON('consultas/partnumber/edit.php?search=', {
                            id: $("#id_partnumber").val(),
                            partnumber_d: $("#partnumber_d").val(),
                            valor_d: $("#valor_d").val(),
                            fase_d: $("#fase_d").val(),
                            ajax: 'true'
                        }, function (j) {});
                        alertify.success('Editado!');
                        $("#modalEdit").modal("hide"); // Fechar o modal
                        updateTables();
                       
                    },
                    function () {
                        alertify.error('Cancelado!');
                    });
            } else {
                alertify.error('Todos os campos são obrigatórios');
            };

        });


        $(this).on('click', '.excluirPartnumber', function (e) {
            e.preventDefault();
            //alert($('#inputRate').val());
            var id = $("#id_partnumber").val();
            alertify.confirm("Excluir", "Deseja excluir Partnumber ?",
                function () {
                    $.getJSON('consultas/partnumber/delete.php?search=', {
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
<?php include 'detalhe-partnumber.php'; ?>
<?php include 'footer.php'; ?>
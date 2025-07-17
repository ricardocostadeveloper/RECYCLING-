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
            <!-- Tabela de Produtos Cadastrados -->
            <div class="row mt-1">
                <div class="col-xl-12 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header border-0 bg-gradient-visteon-barra">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0"> Ánalise de Aprovação</h5>
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
                                        <th scope="col" class="text-center" id="produto">ENGENHEIRO/TÉCNICO</th>
                                        <th scope="col" class="text-center" id="produto">COORDENADOR</th>
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
        // criando tabela de linha com Datatable
        var table = $('#listar-scrap').DataTable({
            "processing": true,
            "serverSide": true,
            "destroy": true, // Permite recriar o DataTable se ele já estiver inicializado
            "ajax": {
                "url": "consultas/aprovacao/table.php"
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
                    "data": "Engenheiro/técnico"
                },
                {
                    "data": "Coordenador"
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
                window.location.href = 'index.php?page=detalheAprovacao&id=' + scrapID;
        });
    });

    function updateTables() {
        // Supondo que você esteja utilizando DataTables
        $('#listar-scrap').DataTable().ajax.reload(); // Recarrega os dados da tabela
    }


    
</script>
<?php include 'footer.php'; ?>
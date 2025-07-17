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
    <title>Linhas</title>

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
                    <h5>Dashboard</h4>
                </div>
            </div>
            <div class="card" style="background-color: lightgray;">
                <div class='card-body'>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <input type="text" id="linhaInput" class="form-control"
                                    placeholder="Insira o valor do Revenue">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="button" id="saveDataButton" class="btn btn-success"><i
                                        class="fa-solid fa-chart-pie"></i>
                                    Gerar Gráficos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                        <div class="card-body" style="width: 15rem;">
                            <h5 class="card-title">Objetivo</h5>
                            <a href="#" class="btn btn-primary">0,09%</a>
                        </div>
                   
                        <div class="card-body" style="width: 15rem;">
                            <h5 class="card-title">Scrap Dia</h5>
                            <a href="#" class="btn btn-primary">$ 479,26</a>
                        </div>
                   
                        <div class="card-body" style="width: 15rem;">
                            <h5 class="card-title">Diário</h5>
                            <a href="#" class="btn btn-primary">0,09%</a>
                        </div>
                        <div class="card-body" style="width: 15rem;">
                            <h5 class="card-title">Mensal</h5>
                            <a href="#" class="btn btn-primary">0,09%</a>
                        </div>
                   
                        <div class="card-body" style="width: 15rem;">
                            <h5 class="card-title">Acumulado do mês</h5>
                            <a href="#" class="btn btn-primary">$ 5.233,714</a>
                        </div>
                   
                    
                </div>
                
            </div>
            <div class="card" style="background-color:#e8e8e8;">
                <div class="row">
                        <div class="card-body" style="width: 15rem;">
                            <canvas id="Top3"></canvas>

                        </div>
                   
                        <div class="card-body" style="width: 15rem;">
                            <canvas id="ScrapAnual"></canvas>

                        </div>
                   
                        <div class="card-body" style="width: 15rem;">
                            <canvas id="ScrapArea"></canvas>
                        </div>
                </div>
            </div>
            <div class="card" style="background-color:#e8e8e8;">
                <div class="row">
                        <div class="card-body" style="width: 15rem;">
                            <canvas id="ScrapTurno"></canvas>
                        </div>
                   
                        <div class="card-body" style="width: 15rem;">
                            <canvas id="ScrapTotal"></canvas>
                        </div>
                   
                        <div class="card-body" style="width: 15rem;">
                            <canvas id="Top5"></canvas>
                        </div>
                </div>
            </div>

        </div>
        <br>

    </div>
</div>


<script>
 const Top3 = document.getElementById('Top3');
 const ScrapAnual = document.getElementById('ScrapAnual');
 const ScrapArea = document.getElementById('ScrapArea');
 const ScrapTurno = document.getElementById('ScrapTurno');
 const ScrapTotal = document.getElementById('ScrapTotal');
 const Top5 = document.getElementById('Top5');

new Chart(Top3, {
  type: 'bar',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1
    }]
  },
  options: {
    plugins: {
      title: {
        display: true,
        text: (ctx) => 'Top 3 Scrap ($)',
      }
    },
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});


new Chart(ScrapAnual, {
    type: 'line',
  data: {
    labels: ['Day 1', 'Day 2', 'Day 3','Day 4','Day 5','Day 6','Day 7', 'Day 8','Day 9','Day 10'],
    datasets: [
        {
            label: 'target',
            data: [9,9,9,9,9,9,9,9,9,9]
        },
        {
            label: 'Dataset 2',
            data: [9,2,8,11,6,7,8,17,3,6]
        }
    ]
  },
  options: {
    responsive: true,
    plugins: {
      title: {
        display: true,
        text: (ctx) => 'Anual Scrap (YTD)',
      }
    }
  }
});
new Chart(ScrapArea, {
  type: 'bar',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1
    }]
  },
  options: {
    plugins: {
      title: {
        display: true,
        text: (ctx) => 'Valor scrap área ($)',
      }
    },
    indexAxis: 'y',
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
new Chart(ScrapTurno, {
  type: 'pie',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1
    }]
  },
  options: {
    plugins: {
      title: {
        display: true,
        text: (ctx) => 'Scrap Turno ($)',
      }
    },
    indexAxis: 'y',
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

new Chart(ScrapTotal, {
  type: 'bar',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1
    }]
  },
  options: {
    plugins: {
      title: {
        display: true,
        text: (ctx) => 'Total Recuperado ($)',
      }
    },
    indexAxis: 'y',
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

new Chart(Top5, {
    type: 'bar',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1
    }]
  },
  options: {
    plugins: {
      title: {
        display: true,
        text: (ctx) => 'Top 3 Scrap ($)',
      }
    },
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

</script>

<!-- <?php include 'detalhe-linhas.php'; ?> -->
<?php include 'footer.php'; ?>
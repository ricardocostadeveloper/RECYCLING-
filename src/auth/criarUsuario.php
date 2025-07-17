<?php

session_start();

include 'conexao/db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prontuario = $_POST['prontuario'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];

    $tipo_usuario = 2; //1- admin 2 - comun

    // Prepare a consulta SQL para evitar SQL injection
    $sql = "INSERT INTO usuario (prontuario, senha, nome, tipo_usuario, created_at, updated_at) VALUES (?, ?, ?, ?, now(), now())";
    $stmt = $conn->prepare($sql);
    
    // Verifica se a preparação foi bem-sucedida
    if ($stmt) {
        // Use 'ssss' se todos os campos forem strings
        $stmt->bind_param('sssi', $prontuario, $nome, $senha, $tipo_usuario );
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            // Usuário criado com sucesso
            $_SESSION['usuario'] = $stmt->insert_id;
            header('Location: index.php?page=home'); // Redireciona para a página do dashboard
            exit();
        } else {
            $error_message = "Erro ao criar o usuário!";
        }
    } else {
        // Exibe o erro de SQL para depuração
        $error_message = "Erro no SQL: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Design by foolishdeveloper.com -->
    <title>Glassmorphism login Form Tutorial in html css</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #080710;
        }

        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }

        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }

        .shape:first-child {
            background: linear-gradient(#1845ad,
                    #23a2f6);
            left: -80px;
            top: -80px;
        }

        .shape:last-child {
            background: linear-gradient(to right,
                    #ff512f,
                    #f09819);
            right: -30px;
            bottom: -80px;
        }

        form {
            height: 520px;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
        }

        input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }

        ::placeholder {
            color: #e5e5e5;
        }

        button {
            margin-top: 50px;
            width: 100%;
            background-color: #ffffff;
            color: #080710;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        .social {
            margin-top: 30px;
            display: flex;
        }

        .social div {
            background: red;
            width: 100%;
            border-radius: 3px;
            padding: 5px 10px 10px 5px;
            background-color: rgba(255, 255, 255, 0.27);
            color: #eaf0fb;
            text-align: center;
        }

        .social div:hover {
            background-color: rgba(255, 255, 255, 0.47);
        }

        .social .fb {
            margin-left: 25px;
        }

        .social i {
            margin-right: 4px;
        }
    </style>
</head>

<body>
    <div class="background">
        <!--div class="shape"></div -->
        <div class="shape"></div>
    </div>
    <form method="POST">
        <h3>Criar Usuário</h3>
        <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
        <?php endif; ?>
        <label for="nome">Nome</label>
        <input type="text" placeholder="Informe seu nome" name="nome" required>

        <label for="username">Prontuário</label>
        <input type="text" placeholder="Informe seu prontuário" name="prontuario" required>

        <label for="senha">Senha</label>
        <input type="password" placeholder="Informe sua senha" name="senha" required>


        <button>Salvar</button>
        <div class="social">
            <!-- <div class="go"><a href="criarUsusario.php"><i class="fa-solid fa-user"></i> Criar Usuário</a></div> -->
        </div>
    </form>
</body>

</html>

</body>

</html>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start();
include 'conexao/db.php';

// Lógica de login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_type']) && $_POST['form_type'] == 'login') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM usuario WHERE email = ? AND senha = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $_SESSION['user'] = $result->fetch_assoc();
            header('Location: home.php');
            exit();
        } else {
            $error_message = "Login inválido!";
        }
    } else {
        $error_message = "Por favor, preencha todos os campos!";
    }
}

// Lógica de criar usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_type']) && $_POST['form_type'] == 'criar_usuario') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $tipo_usuario = isset($_POST['tipo_usuario']) ? intval($_POST['tipo_usuario']) : 2; // <-- CORRIGIDO
    $sql = "INSERT INTO usuario (email, senha, nome, tipo_usuario, created_at, updated_at) VALUES (?, ?, ?, ?, now(), now())";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('sssi', $email, $senha, $nome, $tipo_usuario);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $user_id = $stmt->insert_id;
            $sql_user = "SELECT * FROM usuario WHERE id = ?";
            $stmt_user = $conn->prepare($sql_user);
            $stmt_user->bind_param('i', $user_id);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();
            if ($result_user->num_rows > 0) {
                $_SESSION['user'] = $result_user->fetch_assoc();
            }
            header('Location: home.php');
            exit();
        } else {
            $criar_error_message = "Erro ao criar o usuário!";
        }
    } else {
        $criar_error_message = "Erro no SQL: " . $conn->error;
    }
    $criar_error_message = "Erro no SQL: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Recycling SA - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            min-height: 100vh;
            background: #f7faf7;
            background-image: url('src/auth/bg-recycling.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255,255,255,0.7); /* ajuste o 0.7 para mais ou menos opacidade */
            z-index: 0;
            pointer-events: none;
        }
        .header,
        .main-content,
        .modal-bg {
            position: relative;
            z-index: 1;
        }
        .header {
            background: #185c2b;
            color: #fff;
            padding: 18px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-left: 40px;
            padding-right: 40px;
        }

        .header .logo {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 1px;
        }

        .header .logo i {
            margin-right: 10px;
            font-size: 1.7rem;
        }

        .header .menu {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .header .menu a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            padding: 7px 18px;
            border-radius: 20px;
            transition: background 0.2s;
        }

        .header .menu a.login-btn {
            background: #fff;
            color: #185c2b;
            border: 2px solid #185c2b;
        }

        .header .menu a.criar-btn {
            background: #185c2b;
            border: 2px solid #fff;
            color: #fff;
            box-shadow: 0 2px 8px #0001;
        }

        .header .menu a:hover {
            background: #e6f7e6;
            color: #185c2b;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 90px;
        }

        .main-content h1 {
            font-size: 2.3rem;
            font-weight: 700;
            color: #185c2b;
            margin-bottom: 10px;
            text-align: center;
        }

        .main-content p {
            color: #444;
            font-size: 1.1rem;
            margin-bottom: 30px;
            text-align: center;
            max-width: 600px;
        }

        .main-content .actions {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .main-content .actions button {
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 20px;
            padding: 12px 30px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        .main-content .actions .btn-primary {
            background: #185c2b;
            color: #fff;
        }

        .main-content .actions .btn-secondary {
            background: #e6f7e6;
            color: #185c2b;
            border: 2px solid #185c2b;
        }

        .main-content .actions .btn-primary:hover,
        .main-content .actions .btn-secondary:hover {
            background: #fff;
            color: #185c2b;
        }

        /* Modal */
        .modal-bg {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.25);
            align-items: center;
            justify-content: center;
        }

        .modal-bg.active {
            display: flex;
        }

        .modal {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 6px 32px #0002;
            padding: 40px 30px 30px 30px;
            min-width: 320px;
            max-width: 95vw;
            position: relative;
        }

        .modal h3 {
            color: #185c2b;
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.5rem;
        }

        .modal label {
            color: #185c2b;
            font-weight: 600;
            margin-top: 18px;
            display: block;
        }

        .modal input {
            width: 90%;
            padding: 10px 14px;
            margin-top: 7px;
            border: 1px solid #b5e0b5;
            border-radius: 8px;
            font-size: 1rem;
            background: #f7faf7;
        }

        .modal button[type="submit"] {
            margin-top: 28px;
            width: 100%;
            background: #185c2b;
            color: #fff;
            padding: 12px 0;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .modal button[type="submit"]:hover {
            background: #138c3c;
        }

        .modal .close-modal {
            position: absolute;
            top: 12px;
            right: 18px;
            background: none;
            border: none;
            font-size: 1.3rem;
            color: #185c2b;
            cursor: pointer;
        }

        .alert {
            background: #ffdede;
            color: #b30000;
            border-radius: 7px;
            padding: 8px 12px;
            margin-bottom: 10px;
            text-align: center;
            font-size: 1rem;
        }

        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                padding: 12px 8px;
            }

            .main-content {
                margin-top: 40px;
            }

            .modal {
                padding: 18px 8px 18px 8px;
            }
        }

        .custom-modal {
            border: 2px solid #185c2b;
            border-radius: 28px;
            padding: 32px 28px 18px 28px;
            min-width: 320px;
            max-width: 370px;
            background: #fff;
            position: relative;
        }

        .custom-modal h2 {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: #222;
        }

        .custom-modal .subtitle {
            text-align: center;
            color: #444;
            font-size: 1rem;
            margin-bottom: 18px;
        }

        .custom-modal label {
            font-weight: 600;
            color: #222;
            margin-top: 12px;
            margin-bottom: 2px;
            display: block;
            font-size: 1rem;
        }

        .custom-modal input[type="text"],
        .custom-modal input[type="password"] {
            width: 90%;
            padding: 12px 16px;
            margin-bottom: 10px;
            border: none;
            border-radius: 18px;
            background: #f7ece8;
            font-size: 1rem;
            outline: none;
        }

        .custom-modal .btn-main {
            width: 100%;
            background: #185c2b;
            color: #fff;
            padding: 13px 0;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 20px;
            border: none;
            margin-top: 10px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .custom-modal .btn-main:hover {
            background: #138c3c;
        }

        .custom-modal .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 12px 0 10px 0;
        }

        .custom-modal .divider span {
            color: #888;
            font-size: 0.95rem;
            margin: 0 8px;
        }

        .custom-modal .divider:before,
        .custom-modal .divider:after {
            content: "";
            flex: 1;
            border-bottom: 1.5px solid #ccc;
        }

        .custom-modal .btn-google {
            width: 100%;
            background: #f7ece8;
            color: #222;
            padding: 11px 0;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 18px;
            border: none;
            margin-bottom: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .custom-modal .btn-google:hover {
            background: #f3e0d7;
        }

        .custom-modal .footer-link {
            text-align: center;
            font-size: 0.97rem;
            color: #444;
            margin-top: 2px;
        }

        .custom-modal .footer-link a {
            color: #185c2b;
            font-weight: 600;
            text-decoration: underline;
            cursor: pointer;
        }

        .custom-modal .alert {
            background: #ffdede;
            color: #b30000;
            border-radius: 7px;
            padding: 8px 12px;
            margin-bottom: 10px;
            text-align: center;
            font-size: 1rem;
        }

        .custom-modal .radio-group {
            margin: 8px 0 10px 0;
        }

        .custom-modal .radio-group label {
            font-weight: 500;
            display: flex;
            align-items: center;
            margin-bottom: 4px;
            font-size: 0.98rem;
        }

        .custom-modal .radio-group input[type="radio"] {
            margin-right: 7px;
            accent-color: #185c2b;
        }

        .custom-modal .radio-group .desc {
            color: #666;
            font-weight: 400;
            font-size: 0.93rem;
            margin-left: 4px;
        }

        .senha-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: -2px;
        }

        .senha-label .esqueci {
            font-size: 0.95rem;
            color: #138c3c;
            text-decoration: underline;
            font-weight: 600;
            cursor: pointer;
        }

        @media (max-width: 500px) {
            .custom-modal {
                max-width: 98vw;
                padding: 18px 4vw 10px 4vw;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <i class="fa-solid fa-recycle"></i> RECYCLING SA
        </div>
        <div class="menu">
            <a href="#" onclick="openModal('login')" class="login-btn">Entrar</a>
            <a href="#" onclick="openModal('criar')" class="criar-btn">Criar Conta</a>
        </div>
    </div>
    <div class="main-content">
        <h1>Conectamos quem tem resíduos a<br>quem precisa deles</h1>
        <p>
            RecyclingSA é a ponte entre indústrias e coletores, transformando resíduos em recursos e promovendo a
            economia circular.
        </p>
        <div class="actions">
            <button class="btn-primary" onclick="openModal('criar')">Comece agora</button>
            <button class="btn-secondary" onclick="openModal('login')">Já tenho uma conta</button>
        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal-bg" id="modal-login">
        <div class="modal custom-modal">
            <button class="close-modal" onclick="closeModal('login')">&times;</button>
            <form method="POST" autocomplete="off">
                <input type="hidden" name="form_type" value="login">
                <h2>Bem-vindo de volta</h2>
                <p class="subtitle">Entre com sua conta para conectar indústrias<br>e gerenciadores</p>
                <?php if (isset($error_message)): ?>
                <div class="alert"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <label for="email">Email</label>
                <input type="text" name="email" placeholder="Seu@email.com" required>
                <div class="senha-label">
                    <label for="password">Senha</label>
                    <a href="#" class="esqueci">Esqueceu a senha?</a>
                </div>
                <input type="password" name="password" placeholder="******" required>
                <button type="submit" class="btn-main">Entrar</button>
                <div class="divider"><span>ou continue com</span></div>
                <button type="button" class="btn-google"><img
                        src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" width="18"
                        style="vertical-align:middle;margin-right:8px;">Google</button>
                <div class="footer-link">
                    Não tem uma conta? <a href="#"
                        onclick="closeModal('login');openModal('criar');return false;">Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Criar Usuário -->
    <div class="modal-bg" id="modal-criar">
        <div class="modal custom-modal">
            <button class="close-modal" onclick="closeModal('criar')">&times;</button>
            <form method="POST" autocomplete="off">
                <input type="hidden" name="form_type" value="criar_usuario">
                <h2>Criar uma conta</h2>
                <p class="subtitle">Conecte-se à rede de gerenciamento de resíduos</p>
                <?php if (isset($criar_error_message)): ?>
                <div class="alert"><?php echo $criar_error_message; ?></div>
                <?php endif; ?>
                <label for="nome">Nome Completo</label>
                <input type="text" name="nome" placeholder="Nome" required>
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Seu@email.com" required>
                <label for="password">Senha</label>
                <input type="password" name="senha" placeholder="******" required>
                <label for="senha2">Confirmar senha</label>
                <input type="password" name="senha2" placeholder="******" required>
                <label style="margin-top:18px;">Tipo de conta</label>
                <div class="radio-group">
                    <label><input type="radio" name="tipo_usuario" value="1" checked> Indústria <span
                            class="desc">(quero vender ou repassar resíduos)</span></label>
                    <label><input type="radio" name="tipo_usuario" value="2"> Gerenciador <span class="desc">(quero
                            comprar ou coletar resíduos)</span></label>
                </div>
                <button type="submit" class="btn-main">Cadastrar</button>
                <div class="divider"><span>ou continue com</span></div>
                <button type="button" class="btn-google"><img
                        src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" width="18"
                        style="vertical-align:middle;margin-right:8px;">Google</button>
                <div class="footer-link">
                    Já tem uma conta? <a href="#" onclick="closeModal('criar');openModal('login');return false;">Faça
                        Login</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Abrir modal
        function openModal(type) {
            document.getElementById('modal-' + type).classList.add('active');
        }
        // Fechar modal
        function closeModal(type) {
            document.getElementById('modal-' + type).classList.remove('active');
        }
        // Fechar modal ao clicar fora
        document.querySelectorAll('.modal-bg').forEach(bg => {
            bg.addEventListener('click', function (e) {
                if (e.target === bg) bg.classList.remove('active');
            });
        });
        // Exibir modal de erro automaticamente se houver erro
        <?php if (isset($error_message)): ?>
            openModal('login');
        <?php elseif (isset($criar_error_message)): ?>
            openModal('criar');
        <?php endif; ?>
    </script>
</body>

</html>
<?php 
    // Verifica se a sessão não está ativa antes de iniciar
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verifica se o usuário está logado
    if (isset($_SESSION['user'])) {
        // Associa os dados da sessão às variáveis
        $logado = $_SESSION['user']['nome'] ?? 'Usuário';  // Nome do usuário padrão se não houver nome na sessão
        $id = $_SESSION['user']['id'] ?? '';
        $tipo_usuario = $_SESSION['user']['tipo_usuario'] ?? '';
        $prontuario = $_SESSION['user']['prontuario'] ?? '';
    } else {
        $logado = "Usuário"; // Nome do usuário padrão se a sessão não estiver definida
    }
?>
<body>
<div class='dashboard'>
    <div class="dashboard-nav">
        <header>
            <a class="menu-toggle"><i class="fas fa-bars"></i></a>
            <a class="brand-logo"><i class="fa-solid fa-recycling" style="color:white; margin: 10%;"></i> Recycling SA</a>
        </header>
        <nav class="dashboard-nav-list">
            <a href="home.php" class="dashboard-nav-item"><i class="fas fa-home" style="color:white; margin: 10%;"></i> Home </a>
            <a href="index.php?page=dashboard" class="dashboard-nav-item"><i class="fas fa-tachometer-alt" style="color:white; margin: 10%;"></i> Dashboard</a>
            <a href="#" class="dashboard-nav-item"><i class="fas fa-file-upload" style="color:white; margin: 10%;"></i> Upload </a>
            
            <div class='dashboard-nav-dropdown'>
                <a  class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fa-solid fa-trash" style="color:white; margin: 10%;"></i> Scrap </a>
                <div class='dashboard-nav-dropdown-menu'>
                    <a href="index.php?page=adicionarScrap"  class="dashboard-nav-dropdown-item">1 - Criar Scrap</a>
                    <a href="index.php?page=aprovacao"  class="dashboard-nav-dropdown-item">2 - Aprovar Scrap</a>
                    <a href="index.php?page=calcularScrap"  class="dashboard-nav-dropdown-item">3 - Separar para análise</a>
                    <a  class="dashboard-nav-dropdown-item">4 - Analisar Scrap</a>
                </div>
            </div>
            <div class='dashboard-nav-dropdown'>
                <a  class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fa-solid fa-circle-plus" style="color:white; margin: 10%;"></i> Cadastro </a>
                <div class='dashboard-nav-dropdown-menu'>
                    <a href="index.php?page=clientes" class="dashboard-nav-dropdown-item">Clientes</a>
                    <a href="index.php?page=falhas" class="dashboard-nav-dropdown-item">Falhas</a>
                    <a href="index.php?page=linhas" class="dashboard-nav-dropdown-item">Linhas</a>
                    <a href="index.php?page=partnumber" class="dashboard-nav-dropdown-item">Partnumber</a>
                    <a href="index.php?page=produtos" class="dashboard-nav-dropdown-item">Produtos</a>
                </div>
            </div>
            <a  class="dashboard-nav-item"><i class="fas fa-user" style="color:white; margin: 10%;"></i> <?php echo htmlspecialchars($logado); ?> </a>
            <div class="nav-item-divider"></div>
            <?php 
                // Verifica se o usuário está logado
                if (isset($_SESSION['user'])) {
                    echo '<a href="index.php?page=logout" class="dashboard-nav-item"><i class="fas fa-sign-out-alt"></i> Logout </a>';
                    
                } else {
                    echo '<a href="index.php?page=logout" class="dashboard-nav-item"><i class="fas fa-sign-out-alt"></i> Login </a>';
                }
            ?>
        </nav>
    </div>
</body>
</html>

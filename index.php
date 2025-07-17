<?php
session_start();
// Obter a página solicitada da URL. Se não for especificada, carregar 'home'.
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
include 'conexao/db.php';

// Páginas que não exigem login
$publicPages = ['login', 'criarUsuario'];

// Se não estiver logado e não for página pública, redireciona para login
if (!isset($_SESSION['user']) && !in_array($page, $publicPages)) {
    header('Location: index.php?page=login');
    exit();
}

// Verifica qual página foi solicitada e inclui o arquivo correspondente
switch ($page) {
    case 'login':
        include 'src/auth/login.php';
        break;
    case 'criarUsuario':
        include 'src/auth/criarUsuario.php';
        break;
    case 'aprovacao':
        include 'src/aprovacao/aprovacao.php';
        break;
    case 'detalheAprovacao':
        include 'src/aprovacao/detalheAprovacao.php';
        break;
    case 'dashboard':
        include 'src/dashboard/dashboard.php';
        break;
    case 'clientes':
        include 'src/cliente/clientes.php';
        break;
    case 'linhas':
        include 'src/linhas/linhas.php';
        break;
    case 'falhas':
        include 'src/falha/falhas.php';
        break;   
    case 'produtos':
        include 'src/produto/produtos.php';
        break;
    case 'partnumber':
        include 'src/partnumber/partnumber.php';
        break;
    case 'adicionarScrap':
        include 'src/adicionarScrap/adicionarScrap.php';
        break;
    case 'detalheScrap':
        include 'src/adicionarScrap/detalheScrap.php';
        break;
    case 'calcularScrap':
        include 'src/adicionarScrap/calcularScrap.php';
        break;           
    case '#':
    default:
        include 'home.php';
        break;
    case 'logout':
        include 'src/auth/logout.php';
        break;  
}
?>
<?php

session_start(); // Inicia a sessão

// Destrói todas as variáveis da sessão
$_SESSION = array();

// Se você deseja destruir a sessão completamente, também deve destruir o cookie de sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Por fim, destrói a sessão
session_destroy();

// Evitar cache para garantir que as informações antigas não sejam exibidas
header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Redireciona para a página de login
header('Location:index.php?page=login');
exit();

?>

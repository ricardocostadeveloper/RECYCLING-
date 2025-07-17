<?php
$host = 'localhost';
$base = 'recycling';
$usuario = 'root';
$senha = '';
try {
    //Conexão com a porta
    //$conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);

    //Conexão sem a porta
    $conn = new PDO("mysql:host=$host;dbname=" . $base, $usuario, $senha);
    //echo "Conexão com banco de dados realizado com sucesso.";
} catch (PDOException $err) {
    //echo "Erro: Conexão com banco de dados não realizado com sucesso. Erro gerado " . $err->getMessage();
}
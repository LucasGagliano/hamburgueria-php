<?php
// Conexão com o banco de dados.
// Copie este arquivo para conexao.php e troque pelos dados do seu banco.

$host  = "seu_host";
$user  = "seu_usuario";
$pass  = "sua_senha";
$db    = "nome_do_banco";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>

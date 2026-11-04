<?php
require_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conn->real_escape_string($_POST['nome']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $preco = floatval($_POST['preco']);
    $categoria = $_POST['categoria'] === 'bebida' ? 'bebida' : 'hamburguer';

    $sql = "INSERT INTO produtos (nome, descricao, preco, categoria)
            VALUES ('$nome', '$descricao', $preco, '$categoria')";

    $conn->query($sql);
}

header("Location: admin.php");
exit;
?>

<?php
// ============================================
// SALVAR PEDIDO NO BANCO
// Recebe JSON via POST: { endereco, total, itens: [{produto_id, quantidade, preco}] }
// ============================================

require_once "conexao.php";

header('Content-Type: application/json');

$dados = json_decode(file_get_contents("php://input"), true);

if (!$dados || empty($dados['itens']) || empty($dados['endereco'])) {
    echo json_encode(["sucesso" => false, "erro" => "Dados inválidos"]);
    exit;
}

$endereco = $conn->real_escape_string($dados['endereco']);
$total    = floatval($dados['total']);

// Insere o pedido
$sqlPedido = "INSERT INTO pedidos (endereco_entrega, total) VALUES ('$endereco', $total)";

if (!$conn->query($sqlPedido)) {
    echo json_encode(["sucesso" => false, "erro" => $conn->error]);
    exit;
}

$pedidoId = $conn->insert_id;

// Insere os itens do pedido
foreach ($dados['itens'] as $item) {
    $produtoId = intval($item['produto_id']);
    $quantidade = intval($item['quantidade']);
    $preco = floatval($item['preco']);

    $sqlItem = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario)
                 VALUES ($pedidoId, $produtoId, $quantidade, $preco)";

    $conn->query($sqlItem);
}

echo json_encode(["sucesso" => true, "pedido_id" => $pedidoId]);

$conn->close();
?>

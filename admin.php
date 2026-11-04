<?php
require_once "conexao.php";

// Excluir produto
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $conn->query("DELETE FROM produtos WHERE id = $id");
    header("Location: admin.php");
    exit;
}

$produtos = $conn->query("SELECT * FROM produtos ORDER BY categoria, nome");
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/output.css" />
    <title>Admin - Dev Burguer</title>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Painel Admin - Dev Burguer</h1>
            <a href="index.php" class="text-blue-600 hover:underline">← Voltar ao site</a>
        </div>

        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <h2 class="text-xl font-bold mb-4">Adicionar novo produto</h2>
            <form action="produto_salvar.php" method="POST" class="grid gap-3">
                <input type="text" name="nome" placeholder="Nome do produto" required
                    class="border p-2 rounded w-full" />

                <textarea name="descricao" placeholder="Descrição (opcional)"
                    class="border p-2 rounded w-full"></textarea>

                <input type="number" step="0.01" name="preco" placeholder="Preço (ex: 18.90)" required
                    class="border p-2 rounded w-full" />

                <select name="categoria" required class="border p-2 rounded w-full">
                    <option value="hamburguer">Hamburguer</option>
                    <option value="bebida">Bebida</option>
                </select>

                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded font-bold hover:bg-green-700">
                    Adicionar produto
                </button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-xl font-bold mb-4">Produtos cadastrados</h2>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Nome</th>
                        <th class="py-2">Categoria</th>
                        <th class="py-2">Preço</th>
                        <th class="py-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($p = $produtos->fetch_assoc()) { ?>
                    <tr class="border-b">
                        <td class="py-2"><?php echo htmlspecialchars($p['nome']); ?></td>
                        <td class="py-2"><?php echo htmlspecialchars($p['categoria']); ?></td>
                        <td class="py-2">R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></td>
                        <td class="py-2 flex gap-3">
                            <a href="produto_editar.php?id=<?php echo $p['id']; ?>"
                                class="text-blue-600 hover:underline">Editar</a>
                            <a href="admin.php?excluir=<?php echo $p['id']; ?>"
                                onclick="return confirm('Tem certeza que deseja excluir este produto?')"
                                class="text-red-600 hover:underline">Excluir</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-lg shadow p-4 mt-6">
            <h2 class="text-xl font-bold mb-4">Últimos pedidos</h2>
            <?php
            $pedidos = $conn->query("SELECT * FROM pedidos ORDER BY data_pedido DESC LIMIT 10");
            ?>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">#</th>
                        <th class="py-2">Endereço</th>
                        <th class="py-2">Total</th>
                        <th class="py-2">Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($ped = $pedidos->fetch_assoc()) { ?>
                    <tr class="border-b">
                        <td class="py-2">#<?php echo $ped['id']; ?></td>
                        <td class="py-2"><?php echo htmlspecialchars($ped['endereco_entrega']); ?></td>
                        <td class="py-2">R$ <?php echo number_format($ped['total'], 2, ',', '.'); ?></td>
                        <td class="py-2"><?php echo date('d/m/Y H:i', strtotime($ped['data_pedido'])); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

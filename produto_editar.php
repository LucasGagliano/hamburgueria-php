<?php
require_once "conexao.php";

$id = intval($_GET['id'] ?? 0);

// Atualizar produto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conn->real_escape_string($_POST['nome']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $preco = floatval($_POST['preco']);
    $categoria = $_POST['categoria'] === 'bebida' ? 'bebida' : 'hamburguer';

    $sql = "UPDATE produtos SET
                nome = '$nome',
                descricao = '$descricao',
                preco = $preco,
                categoria = '$categoria'
            WHERE id = $id";

    $conn->query($sql);

    header("Location: admin.php");
    exit;
}

// Buscar dados atuais do produto
$result = $conn->query("SELECT * FROM produtos WHERE id = $id");
$produto = $result->fetch_assoc();

if (!$produto) {
    header("Location: admin.php");
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/output.css" />
    <title>Editar Produto - Dev Burguer</title>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Editar Produto</h1>
            <a href="admin.php" class="text-blue-600 hover:underline">← Voltar</a>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <form method="POST" class="grid gap-3">
                <label class="font-medium">Nome</label>
                <input type="text" name="nome" required
                    value="<?php echo htmlspecialchars($produto['nome']); ?>"
                    class="border p-2 rounded w-full" />

                <label class="font-medium">Descrição</label>
                <textarea name="descricao"
                    class="border p-2 rounded w-full"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>

                <label class="font-medium">Preço</label>
                <input type="number" step="0.01" name="preco" required
                    value="<?php echo $produto['preco']; ?>"
                    class="border p-2 rounded w-full" />

                <label class="font-medium">Categoria</label>
                <select name="categoria" required class="border p-2 rounded w-full">
                    <option value="hamburguer" <?php echo $produto['categoria'] === 'hamburguer' ? 'selected' : ''; ?>>Hamburguer</option>
                    <option value="bebida" <?php echo $produto['categoria'] === 'bebida' ? 'selected' : ''; ?>>Bebida</option>
                </select>

                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded font-bold hover:bg-blue-700">
                    Salvar alterações
                </button>
            </form>
        </div>
    </div>

</body>
</html>

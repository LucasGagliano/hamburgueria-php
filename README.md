# Hamburgueria (PHP + MySQL)

Site de uma hamburgueria em que o cardápio vem de um banco de dados e os pedidos ficam salvos nele.

Esse projeto parte de uma hamburgueria que fizemos em grupo. O HTML, o CSS e a estrutura base vêm do repositório do pedro-kalili-07 (https://github.com/pedro-kalili-07/Hamburgueria), com contribuição do RicMTH. Nessa versão eu fiz toda a integração com o banco de dados.

## O que eu fiz

- Cardápio dinâmico: o index.php busca os produtos no MySQL
- Pedido salvo no banco (salvar_pedido.php) e também enviado pro WhatsApp
- Painel admin pra cadastrar, editar e excluir produtos e ver os últimos pedidos

## Tecnologias

PHP, MySQL, JavaScript, HTML e Tailwind CSS (esses dois últimos vêm do projeto original).

## Como rodar

Precisa de PHP e MySQL. Copie o conexao.example.php para conexao.php e coloque os dados do seu banco. O código usa as tabelas produtos (nome, descricao, preco, categoria), pedidos (endereco_entrega, total, data_pedido) e itens_pedido.

As pastas assets e styles (imagens e CSS) ficam no repositório original. Aqui está só a parte em PHP e JavaScript.

## O que ainda falta

- Login no painel admin. Hoje qualquer pessoa com o link consegue mexer nos produtos.

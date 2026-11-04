<?php
require_once "conexao.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <link rel="stylesheet" href="./styles/output.css" />

    <title>Dev burguer</title>
  </head>
  <body>
    <!--INICIO HEADER-->
    <header class="w-full h-[420px] bg-home bg-cover bg-center">
      <div class="w-full h-full flex flex-col justify-center items-center">
        <img
          src="./assets/hamb-1.png"
          alt="Logo DevBurguer"
          class="w-32 h-32 rounded-full shadow-lg hover:scale-110 duration-200"
        />

        <h1 class="text-4xl mt-4 mb-2 font-bold text-white">Dev Burguer</h1>
        <span class="text-white font-medium"> Rua dev 10, Recreio - RJ </span>

        <div class="bg-green-600 px-4 py-1 rounded-lg mt-5" id="date-span">
          <span class="text-white font-medium">
            Seg á Dom - 18:00 as 22:00
          </span>
        </div>
      </div>
    </header>
    <!--FIM HEADER-->

    <h2 class="text-2xl md:text-3xl font-bold text-center mt-9 mb-6">
      Conheça nosso menu
    </h2>

    <!--INICIO MENU-->
    <div id="menu">
      <!--INICIO GRID HAMBURGUER (DINÂMICO)-->
      <main
        class="grid grid-cols-1 md:grid-cols-2 gap-7 md:gap-10 mx-auto max-w-7xl px-2 mb-16"
      >
        <?php
        $sqlHamb = "SELECT * FROM produtos WHERE categoria = 'hamburguer'";
        $resultHamb = $conn->query($sqlHamb);

        while ($produto = $resultHamb->fetch_assoc()) {
            $id = $produto['id'];
            $nome = htmlspecialchars($produto['nome']);
            $descricao = htmlspecialchars($produto['descricao']);
            $preco = number_format($produto['preco'], 2, ',', '.');
            $precoData = $produto['preco'];
            $imagem = "./assets/hamb-" . (($id % 4) + 1) . ".png";
        ?>
        <!--PRODUTO ITEM -->
        <div class="flex gap-2">
          <img
            src="<?php echo $imagem; ?>"
            alt="<?php echo $nome; ?>"
            class="w-28 h-28 rounded-md hover:scale-110 hover:-rotate-2 duration-300"
          />
          <div>
            <p class="font-bold"><?php echo $nome; ?></p>
            <p class="text-sm">
              <?php echo $descricao; ?>
            </p>

            <div class="flex items-center gap-2 justify-between mt-3">
              <p class="font-bold text-lg">R$ <?php echo $preco; ?></p>

              <button
                class="bg-gray-900 px-5 rounded add-to-cart-btn"
                data-id="<?php echo $id; ?>"
                data-name="<?php echo $nome; ?>"
                data-price="<?php echo $precoData; ?>"
              >
                <i class="fa fa-cart-plus text-lg text-white"></i>
              </button>
            </div>
          </div>
        </div>
        <!--FIM PRODUTO ITEM-->
        <?php } ?>
      </main>
      <!--FIM GRID HAMBURGUER-->

      <div class="mx-auto max-w-7xl px-2 my-2">
        <h2 class="font-bold text-3xl">Bebidas</h2>
      </div>

      <!--INICIO GRID BEBIDAS (DINÂMICO)-->
      <div
        class="grid grid-cols-1 md:grid-cols-2 gap-7 md:gap-10 mx-auto max-w-7xl px-2 mb-16"
      >
        <?php
        $sqlBeb = "SELECT * FROM produtos WHERE categoria = 'bebida'";
        $resultBeb = $conn->query($sqlBeb);

        while ($produto = $resultBeb->fetch_assoc()) {
            $id = $produto['id'];
            $nome = htmlspecialchars($produto['nome']);
            $preco = number_format($produto['preco'], 2, ',', '.');
            $precoData = $produto['preco'];
            $imagem = "./assets/refri-" . (($id % 2) + 1) . ".png";
        ?>
        <!--BEBIDA ITEM-->
        <div class="flex gap-2 w-full">
          <img
            src="<?php echo $imagem; ?>"
            alt="<?php echo $nome; ?>"
            class="w-28 h-28 rounded-md hover:scale-110 hover:-rotate-2 duration-300"
          />
          <div class="w-full">
            <p class="font-bold"><?php echo $nome; ?></p>

            <div class="flex items-center gap-2 justify-between mt-3">
              <p class="font-bold text-lg">R$ <?php echo $preco; ?></p>

              <button
                class="bg-gray-900 px-5 rounded add-to-cart-btn"
                data-id="<?php echo $id; ?>"
                data-name="<?php echo $nome; ?>"
                data-price="<?php echo $precoData; ?>"
              >
                <i class="fa fa-cart-plus text-lg text-white"></i>
              </button>
            </div>
          </div>
        </div>
        <!--FIM BEBIDA ITEM-->
        <?php } ?>
      </div>
      <!--FIM GRID BEBIDAS-->

    </div>
    <!--FIM MENU-->

    <!--MODAL CART-->
    <div id="cart-modal"
      class="bg-black/60 w-full h-full fixed top-0 left-0 z-[99] flex items-center justify-center hidden"
    >
      <div class="bg-white p-5 rounded-md min-w-[90%] md:min-w-[600px]">
        <h2 class="text-center font bold text-2xl mb-2">Seu carrinho</h2>

        <div id="cart-items" class="flex justify-between mb-2 flex-col"></div>

        <p class="font-bold">Total: <span id="cart-total">0.00</span></p>
        
        <p class="font-bold">Endereço de entrega</p>

        <input
          type="text"
          placeholder="Digite seu endereço de entrega"
          id="address"
          class="w-full border-2 p-1 rouded my-1"
        />
        <p class="text-red-500 hidden" id="address-warn">
          Digite seu endereço completo!
        </p>

        <div class="flex items center justify-between mt-5 w-full">
          <button id="close-modal-btn">Fechar</button>
          <button
            id="checkout-btn"
            class="bg-green-500 text-white px-4 py-1 roudend"
          >
            Finalizar pedido
          </button>
        </div>
      </div>
    </div>
    <!--FIM MODAL CART-->

    <!--BUTTON CART FOOTER-->
    <footer
      class="w-full bg-red-500 py-3 fixed bottom-0 z-40 flex items-center justify-center"
    >
      <button
        class="flex items-center gap-2 text-white font-bold"
        id="cart-btn"
      >
        (<span id="cart-count">0</span>)
        veja meu carrinho

        <i class="fa fa-cart-plus text-lg text-white"></i>
      </button>
    </footer>
    <!--FIM BUTTON CART FOOTER-->

    <script src="script.js" defer></script>
  </body>
</html>

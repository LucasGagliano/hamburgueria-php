const menu = document.getElementById("menu")
const cartBtn = document.getElementById("cart-btn")
const cartModal = document.getElementById("cart-modal")
const cartItensContainer = document.getElementById("cart-items")
const cartTotal = document.getElementById("cart-total")
const checkoutBtn = document.getElementById("checkout-btn")
const closeModalBtn = document.getElementById("close-modal-btn")
const cartCounter = document.getElementById("cart-count")
const addressInput = document.getElementById("address")
const addressWarn = document.getElementById("address-warn")

let cart = [];

// Abrir o modal do carrinho
cartBtn.addEventListener("click",function(){
    cartModal.style.display = "flex"
})

// fechar o modal quando clicar fora 
cartModal.addEventListener("click", function(event){
    if(event.target === cartModal){
        cartModal.style.display = "none"
    }
}) 

//fechar o modal quando clicar fechar
closeModalBtn.addEventListener("click", function(){
    cartModal.style.display = "none"
}) 

menu.addEventListener("click", function(event){
    //console.log(event.target)

    let parentButton = event.target.closest(".add-to-cart-btn")

    if(parentButton){
        const id = parentButton.getAttribute("data-id")
        const name = parentButton.getAttribute("data-name")
        const price = parseFloat(parentButton.getAttribute("data-price"))

        addToCart(id, name, price)

    }


}) 


// funçao para adicionar no carrinho
function addToCart(id, name, price){
    const existingItem = cart.find(item => item.id === id)

    if(existingItem){
        //Se o item já existe, aumenta apenas a quantidade + 1
        existingItem.quantity += 1;
    }

    else{
        cart.push({
        id,
        name,
        price,
        quantity: 1,
    })
    }

    updateCartModal()
 
}

// Atualiza o carrinho
function updateCartModal(){
    cartItensContainer.innerHTML = "";
    let total = 0;

    cart.forEach( item =>  { 
        const cartItemElement = document.createElement("div");
        cartItemElement.classList.add("flex", "justify-between", "mb-4", "flex-col")

        cartItemElement.innerHTML = `
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium"> ${item.name}</p>
                    <p>Qtd: ${item.quantity}</p>
                    <p class="font-medium mt-2">R$ ${item.price.toFixed(2)}</p>
                </div>

                <button class="remove-from-cart-btn" data-id="${item.id}">
                    Remover
                </button>
                
            </div>
        `
        total += item.price * item.quantity;

        cartItensContainer.appendChild(cartItemElement);

    })

    cartTotal.textContent = total.toLocaleString("pt-BR",{
        style: "currency",
        currency: "BRL",
    });

    cartCounter.innerHTML = cart.length; 
}

// Funçao para remover item do carrinho 
cartItensContainer.addEventListener("click", function(event){
    if(event.target.classList.contains("remove-from-cart-btn")){
        const id = event.target.getAttribute("data-id")

        removeItemCart(id);
    }
})

function removeItemCart(id){
    const index = cart.findIndex(item => item.id === id);

    if(index !== -1){
        const item = cart[index];

        if(item.quantity > 1){
            item.quantity -= 1;
            updateCartModal();
            return;
        }

        cart.splice(index, 1);
        updateCartModal();

    }
}

addressInput.addEventListener("input", function(event){
    let inputValue = event.target.value;

    if(inputValue !== ""){
        addressInput.classList.remove("border-red-500")
        addressWarn.classList.add("hidden")
    }
})

// finalizar pedido
checkoutBtn.addEventListener("click", function(){

//   const isOpen = checkoutRestaurantOpen();
//   if(!isOpen){
//       alert("RESTAURANTE FECHADO NO MOMENTO!")
//       return;
//   }

    if(cart.length === 0 ) return;

    if(addressInput.value.trim() === ""){
        addressWarn.classList.remove("hidden")
        addressInput.classList.add("border-red-500")
        return;
    }

    let total = 0;

    const cartItems = cart.map((item) => {
        total += item.price * item.quantity;

        return(
            `${item.name} - Qtd: (${item.quantity}) - R$ ${item.price.toFixed(2)}`
        )
    }).join("\n")

    // Monta os dados para enviar ao backend PHP
    const pedidoData = {
        endereco: addressInput.value,
        total: total,
        itens: cart.map(item => ({
            produto_id: item.id,
            quantidade: item.quantity,
            preco: item.price
        }))
    };

    // Envia o pedido para salvar no banco de dados
    fetch("salvar_pedido.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(pedidoData)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Pedido salvo:", data);
    })
    .catch(error => {
        console.error("Erro ao salvar pedido:", error);
    });

    // Envia para o WhatsApp normalmente
    const message = encodeURIComponent(
        `Pedido:\n\n${cartItems}\n\nTotal: R$ ${total.toFixed(2)}\nEndereço: ${addressInput.value}`
    );

    const phone = "5500000000000"; // coloque aqui o número do WhatsApp da loja

    window.open(`https://wa.me/${phone}?text=${message}`, "_blank");

    cart = [];
    updateCartModal();
});

    
// verificar a hora e manipular o card horario 
function checkoutRestaurantOpen(){
    const data = new Date();
    const hora = data.getHours();
    return hora >= 18 && hora < 22;
    //ture = restaurante aberto
}

const spanItem = document.getElementById("date-span")
const isOpen = checkoutRestaurantOpen();

if(isOpen){
    spanItem.classList.remove("bg-red-500");
    spanItem.classList.add("bg-green-600");
}
else{
    spanItem.classList.remove("bg-green-600")
    spanItem.classList.add("bg-red-500")
}

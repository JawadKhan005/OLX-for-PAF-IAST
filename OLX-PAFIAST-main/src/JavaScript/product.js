// Sample product data
const products = [
    { id: 1, name: "Set", price: 99, image: "/olx-pafiast/image/mouse-ph-pod.jpg" },
    { id: 2, name: "Mouse", price: 4.5, image: "/olx-pafiast/image/mouse.jpg" },
    { id: 3, name: "Keyboard", price: 24, image: "/olx-pafiast/image/wireless-keyboard.jpg" },
    { id: 4, name: "Earpod", price: 19, image: "/olx-pafiast/image/earpod.jpg" },
];

let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Function to render products
function renderProducts() {
    const productList = document.getElementById("product-list");
    productList.innerHTML = ""; // Clear previous content
    products.forEach((product) => {
        const productHTML = `
            <div class="box">
                <div class="product" style="background-image: url('${product.image}');"></div>
                <div class="detail">
                    <p class="name">${product.name}</p>
                    <p class="price">$${product.price}</p>
                    <div class="addToBasket" onclick="addToCart(${product.id})">
                        <div class="AddToCart-btn">Add to Cart</div>
                    </div>
                </div>
            </div>
        `;
        productList.innerHTML += productHTML;
    });
}

// Function to show notification popup
function showNotification(message) {
    const popup = document.getElementById("popup-notification");
    popup.innerText = message;
    popup.classList.add("show");

    setTimeout(() => {
        popup.classList.remove("show");
    }, 1500);
}

// Function to update cart count
function updateCartCount() {
    const cartCount = document.getElementById("cart-count");
    cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
}

// Function to add product to cart
function addToCart(productId) {
    const product = products.find((item) => item.id === productId);
    const existingItem = cart.find((item) => item.id === productId);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ ...product, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    showNotification("Product added to cart!");
    updateCartCount();
}

// Function to navigate to cart page
function goToCart() {
    window.location.href = "cart.html";
}

// Function to render cart items on cart.html
function renderCart() {
    const cartItems = document.getElementById("cart-items");
    const subtotalElement = document.getElementById("subtotal");
    const totalElement = document.getElementById("total");
    let subtotal = 0;

    cartItems.innerHTML = ""; // Clear cart container
    cart.forEach((item) => {
    subtotal += item.price * item.quantity;

    const cartItemHTML = `
    <div class="separator"></div>
        <div class="product"">
            <div class="details name price">
                <p>${item.name}</p>
                <p>$${item.price}</p>
                <p class="quantity i input">
                    <i class="fa-solid fa-minus" onclick="decreaseQuantity(${item.id})"></i>
                    <span class="quantity-value">${item.quantity}</span>
                    <i class="fa-solid fa-plus" onclick="increaseQuantity(${item.id})"></i>
                </p>
            </div>
            <div class="remove fa-solid fa-xmark" onclick="removeFromCart(${item.id})"></div>
        </div>
    </div>
    `;
    cartItems.innerHTML += cartItemHTML;
    
    function increaseQuantity(id) {
        const item = cart.find(product => product.id === id);
        if (item) {
            item.quantity++;
            updateCart();
        }
    }
    
    function decreaseQuantity(id) {
        const item = cart.find(product => product.id === id);
        if (item && item.quantity > 1) {
            item.quantity--;
            updateCart();
        }
    }
});


function updateCart() {
    cartItems.innerHTML = "";
    subtotal = 0;
    cart.forEach((item) => {
        subtotal += item.price * item.quantity;

        const cartItemHTML = `
            <div class="product1" style="margin-bottom: 20px;">
                <div class="details">
                    <p class="name">${item.name}</p>
                    <p class="price">$${item.price}</p>
                    <p class="quantity">
                        <i class="fa-solid fa-minus" onclick="decreaseQuantity(${item.id})"></i>
                        <span class="quantity-value">${item.quantity}</span>
                        <i class="fa-solid fa-plus" onclick="increaseQuantity(${item.id})"></i>
                    </p>
                </div>
                <div class="remove fa-solid fa-xmark" onclick="removeFromCart(${item.id})"></div>
            </div>
        `;
        cartItems.innerHTML += cartItemHTML;
    });
}

    subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
    totalElement.textContent = `$${subtotal.toFixed(2)}`;
}

function removeFromCart(productId) {
    cart = cart.filter((item) => item.id !== productId);
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCart();
    updateCartCount();
}

// Initialize on page load
if (document.getElementById("product-list")) {
    renderProducts();
    updateCartCount();
}
if (document.getElementById("cart-items")) renderCart();

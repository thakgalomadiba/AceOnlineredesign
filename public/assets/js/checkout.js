document.addEventListener("DOMContentLoaded", () => {
  renderCheckout();
});

function renderCheckout() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const container = document.getElementById("checkout-container");
  const totalItemsEl = document.getElementById("checkout-total-items");
  const totalPriceEl = document.getElementById("checkout-total-price");
  const cartInput = document.getElementById("cart_data");

  if (!container || !totalItemsEl || !totalPriceEl) return;

  fetch("data/products.json")
    .then(res => res.json())
    .then(products => {
      container.innerHTML = "";
      let total = 0;
      let totalItems = 0;

      if (cart.length === 0) {
        container.innerHTML = "<p>Your cart is empty.</p>";
        totalItemsEl.textContent = "0";
        totalPriceEl.textContent = "0.00";
        return;
      }

      cart.forEach(item => {
        const product = products.find(p => p.id === item.id);
        if (!product) return;

        const itemTotal = parseFloat(product.price) * item.quantity;
        total += itemTotal;
        totalItems += item.quantity;

        const div = document.createElement("div");
        div.classList.add("checkout-item");
        div.style.display = "flex";
        div.style.alignItems = "center";
        div.style.marginBottom = "15px";
        div.style.borderBottom = "1px solid #eee";
        div.style.paddingBottom = "10px";

        div.innerHTML = `
          <img src="public/${product.image}" alt="${product.name}" style="width:60px;height:60px;object-fit:cover;margin-right:15px;border-radius:5px;">
          <div style="flex:1;">
            <strong>${product.name}</strong><br>
            <div style="margin:5px 0;">
              <button class="decrease-btn" data-id="${product.id}">➖</button>
              <span style="margin:0 8px;">${item.quantity}</span>
              <button class="increase-btn" data-id="${product.id}">➕</button>
              <button class="remove-btn" data-id="${product.id}" style="margin-left:10px;">Remove</button>
            </div>
            R${itemTotal.toFixed(2)}
          </div>
        `;

        container.appendChild(div);
      });

      totalItemsEl.textContent = totalItems;
      totalPriceEl.textContent = total.toFixed(2);
      if(cartInput) cartInput.value = JSON.stringify(cart);
    });
}

// -------------------------------
// Handle cart controls
// -------------------------------
document.addEventListener("click", e => {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  if (e.target.classList.contains("increase-btn")) {
    const id = parseInt(e.target.dataset.id);
    const item = cart.find(i => i.id === id);
    if (item) item.quantity += 1;
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCheckout();
    updateHeaderCart();
  }

  if (e.target.classList.contains("decrease-btn")) {
    const id = parseInt(e.target.dataset.id);
    const index = cart.findIndex(i => i.id === id);
    if (index !== -1) {
      cart[index].quantity -= 1;
      if (cart[index].quantity <= 0) cart.splice(index, 1);
    }
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCheckout();
    updateHeaderCart();
  }

  if (e.target.classList.contains("remove-btn")) {
    const id = parseInt(e.target.dataset.id);
    const index = cart.findIndex(i => i.id === id);
    if (index !== -1) cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCheckout();
    updateHeaderCart();
  }
});

// -------------------------------
// Update cart icon in header
// -------------------------------
function updateHeaderCart() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const cartCount = document.getElementById("cart-count");
  if(!cartCount) return;
  const totalItems = cart.reduce((acc, i) => acc + i.quantity, 0);
  cartCount.textContent = totalItems;
}

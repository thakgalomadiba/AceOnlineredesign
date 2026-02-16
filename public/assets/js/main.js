// ================================
// LOAD CART ON PAGE LOAD
// ================================
document.addEventListener("DOMContentLoaded", function () {
  updateCartUI();
});

// ================================
// GLOBAL CLICK HANDLER
// ================================
document.addEventListener("click", function (e) {

  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const dropdown = document.getElementById("cart-dropdown");

  // -------------------------------
  // ADD TO CART
  // -------------------------------
  if (e.target.classList.contains("add-to-cart")) {

    const productId = parseInt(e.target.dataset.id);
    const existingProduct = cart.find(item => item.id === productId);

    if (existingProduct) {
      existingProduct.quantity += 1;
    } else {
      cart.push({ id: productId, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartUI();

    // Auto open cart dropdown
    if (dropdown) dropdown.classList.add("active");
  }

  // -------------------------------
  // INCREASE QUANTITY
  // -------------------------------
  if (e.target.classList.contains("increase-btn")) {
    const productId = parseInt(e.target.dataset.id);
    const item = cart.find(item => item.id === productId);
    if (item) item.quantity += 1;

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartUI();
  }

  // -------------------------------
  // DECREASE QUANTITY
  // -------------------------------
  if (e.target.classList.contains("decrease-btn")) {
    const productId = parseInt(e.target.dataset.id);
    const itemIndex = cart.findIndex(item => item.id === productId);

    if (itemIndex !== -1) {
      cart[itemIndex].quantity -= 1;
      if (cart[itemIndex].quantity <= 0) cart.splice(itemIndex, 1);
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartUI();
  }

  // -------------------------------
  // TOGGLE CART DROPDOWN
  // -------------------------------
  if (e.target.classList.contains("cart-btn")) {
    if (cart.length === 0) {
      // Go to checkout if cart empty
      window.location.href = "/checkout.php";
    } else if (dropdown) {
      dropdown.classList.toggle("active");
    }
  }

  // -------------------------------
  // CLOSE DROPDOWN WHEN CLICKING OUTSIDE
  // -------------------------------
  if (!e.target.closest(".cart-container")) {
    if (dropdown) dropdown.classList.remove("active");
  }
});

// ================================
// UPDATE CART UI
// ================================
function updateCartUI() {

  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  const cartCount = document.getElementById("cart-count");
  const cartItems = document.getElementById("cart-items");
  const cartTotal = document.getElementById("cart-total");

  if (!cartCount || !cartItems || !cartTotal) return;

  fetch("products.json")
    .then(res => res.json())
    .then(products => {

      cartItems.innerHTML = "";
      let total = 0;
      let totalItems = 0;

      cart.forEach(item => {
        const product = products.find(p => p.id === item.id);
        if (!product) return;

        const itemTotal = parseFloat(product.price) * item.quantity;
        total += itemTotal;
        totalItems += item.quantity;

        const li = document.createElement("li");
        li.style.display = "flex";
        li.style.alignItems = "center";
        li.style.marginBottom = "10px";
        li.style.borderBottom = "1px solid #eee";
        li.style.paddingBottom = "10px";

        li.innerHTML = `
          <img src="public/${product.image}" alt="${product.name}" style="width:40px; height:40px; object-fit:cover; margin-right:10px; border-radius:4px;">
          <div style="flex:1;">
            <strong>${product.name}</strong><br>
            <div style="margin:5px 0;">
              <button class="decrease-btn" data-id="${product.id}">➖</button>
              <span style="margin:0 8px;">${item.quantity}</span>
              <button class="increase-btn" data-id="${product.id}">➕</button>
            </div>
            R${itemTotal.toFixed(2)}
          </div>
        `;

        cartItems.appendChild(li);
      });

      cartCount.textContent = totalItems;
      cartTotal.textContent = total.toFixed(2);

      if (cart.length === 0) {
        cartItems.innerHTML = "<p>Your cart is empty</p>";
      }
    })
    .catch(err => console.error("Error loading products:", err));
}

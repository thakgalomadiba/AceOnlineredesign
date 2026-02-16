// Load cart and render checkout page
document.addEventListener("DOMContentLoaded", function () {
  renderCheckout();
});

function renderCheckout() {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const checkoutItems = document.getElementById("checkout-items");
  const subtotalEl = document.getElementById("checkout-subtotal");
  const totalEl = document.getElementById("checkout-total");

  if (!checkoutItems || !subtotalEl || !totalEl) return;

  fetch("products.json")
    .then(res => res.json())
    .then(products => {

      checkoutItems.innerHTML = "";
      let subtotal = 0;

      cart.forEach(item => {
        const product = products.find(p => p.id === item.id);
        if (!product) return;

        const itemTotal = product.price * item.quantity;
        subtotal += itemTotal;

        const div = document.createElement("div");
        div.classList.add("checkout-item");
        div.style.display = "flex";
        div.style.alignItems = "center";
        div.style.marginBottom = "15px";
        div.innerHTML = `
          <img src="public/${product.image}" alt="${product.name}" style="width:60px; height:60px; object-fit:cover; margin-right:10px; border-radius:4px;">
          <div style="flex:1;">
            <strong>${product.name}</strong><br>
            Qty: ${item.quantity}<br>
            R${itemTotal.toFixed(2)}
          </div>
          <button class="remove-btn" data-id="${product.id}">Remove</button>
        `;
        checkoutItems.appendChild(div);
      });

      subtotalEl.textContent = subtotal.toFixed(2);
      totalEl.textContent = subtotal.toFixed(2); // you can add tax/shipping later
    });
}

// ==========================
// REMOVE ITEM BUTTON
// ==========================
document.addEventListener("click", function(e) {
  if (e.target.classList.contains("remove-btn")) {
    const productId = parseInt(e.target.dataset.id);
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart = cart.filter(item => item.id !== productId);
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCheckout(); // re-render page
    updateCartUI(); // also update header cart
  }
});

// Optional: Place Order button
document.getElementById("place-order-btn")?.addEventListener("click", function() {
  alert("Order placed! (Demo)"); 
  localStorage.removeItem("cart"); 
  renderCheckout(); 
  updateCartUI();
});

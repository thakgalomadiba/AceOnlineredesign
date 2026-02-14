const productList = document.getElementById('product-list');

let products = [];

fetch('products.json')
  .then(res => res.json())
  .then(data => {
    products = data;
    renderProducts(products);
  });

function renderProducts(items) {
  productList.innerHTML = '';

  items.forEach(p => {
    const card = document.createElement('div');
    card.classList.add('product-card');

    card.innerHTML = `
      <img src="${p.image}" alt="${p.name}">
      <h4>${p.name}</h4>
      <p>R ${p.price.toLocaleString()}</p>
      <button class="primary-btn">Add to Cart</button>
    `;
    productList.appendChild(card);
  });
}

// Optional: search functionality
const searchInput = document.getElementById('product-search');
searchInput.addEventListener('input', e => {
  const filtered = products.filter(p =>
    p.name.toLowerCase().includes(e.target.value.toLowerCase())
  );
  renderProducts(filtered);
});

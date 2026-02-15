document.addEventListener("DOMContentLoaded", () => {

  console.log("RENDER JS LOADED");

  async function loadCategories() {
    try {
      const response = await fetch('/public/assets/js/categories.json');

      if (!response.ok) {
        throw new Error("HTTP error " + response.status);
      }

      const categories = await response.json();

      console.log("Categories loaded:", categories);

      const container = document.getElementById("category-list");

      categories.forEach(category => {
        const card = document.createElement("div");
        card.classList.add("category-card");

        card.innerHTML = `
          <img src="${category.image}" alt="${category.name}">
          <h4>${category.name}</h4>
        `;

        container.appendChild(card);
      });

    } catch (error) {
      console.error("Error loading categories:", error);
    }
  }

  loadCategories();
});

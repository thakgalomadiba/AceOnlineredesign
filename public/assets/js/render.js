// Render categories dynamically
function renderCategories(categories) {
  const ul = document.getElementById('category-list');

  categories.forEach(category => {
    const li = document.createElement('li');
    li.textContent = category.name;

    // Check if category has subcategories
    if (category.subcategories.length > 0) {
      li.classList.add('has-sub');

      const subUl = document.createElement('ul');
      subUl.classList.add('submenu');

      category.subcategories.forEach(sub => {
        const subLi = document.createElement('li');
        subLi.textContent = sub;
        subUl.appendChild(subLi);
      });

      li.appendChild(subUl);

      // Mobile: click to toggle submenu
      li.addEventListener('click', function(e) {
        e.stopPropagation();
        subUl.style.display = subUl.style.display === 'block' ? 'none' : 'block';
        li.classList.toggle('open');
      });
    }

    ul.appendChild(li);
  });
}

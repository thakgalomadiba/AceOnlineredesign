const categoryList = document.getElementById('category-list');

function renderCategories(){
  categoryList.innerHTML = '';

  backendCategories.forEach(cat => {

    const li = document.createElement('li');
    li.classList.add("category-item");
    li.textContent = cat.name;

    if(cat.subcategories && cat.subcategories.length > 0){

      const subUl = document.createElement('ul');
      subUl.classList.add('subcategories');

      cat.subcategories.forEach(sub => {
        const subLi = document.createElement('li');
        subLi.textContent = sub.name || sub;
        subUl.appendChild(subLi);
      });

      li.appendChild(subUl);
    }

    categoryList.appendChild(li);

  });
}

renderCategories();
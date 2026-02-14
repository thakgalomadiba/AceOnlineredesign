const categoryList = document.getElementById('category-list');

const backendCategories = [
  { "name":"Consumer Electronics","subcategories":["TV & Audio","Cameras","Musical Instruments","Gaming"] },
  { "name":"Office & Business","subcategories":["Stationery","Office & Furniture","Industrial, Business & Science"] },
  { "name":"Family","subcategories":[] },
  { "name":"Consumables","subcategories":[] },
  { "name":"Personal & Lifestyle","subcategories":[] }
];

function renderCategories(){
  categoryList.innerHTML = '';
  backendCategories.forEach(cat=>{
    const li = document.createElement('li');
    li.textContent = cat.name;

    if(cat.subcategories.length>0){
      const subUl = document.createElement('ul');
      subUl.classList.add('subcategories');
      cat.subcategories.forEach(sub=>{
        const subLi = document.createElement('li');
        subLi.textContent = sub;
        subUl.appendChild(subLi);
      });
      li.appendChild(subUl);

      li.addEventListener('click', e=>{
        e.stopPropagation();
        li.classList.toggle('active');
      });
    }

    categoryList.appendChild(li);
  });
}

renderCategories();

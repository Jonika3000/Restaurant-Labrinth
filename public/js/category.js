function categoryChange(categoryId, locale) {
    let container = document.getElementById('dishesContainer');
    let containerSubCategories = document.getElementById('subCategories');
    let loadingCircle = document.getElementById('loadingCircle');

    container.innerHTML = '';
    containerSubCategories.innerHTML = '';

    loadingCircle.classList.remove('hidden');

    fetch('/' + locale + '/category/show/' + categoryId)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (Array.isArray(data.items)) {
                loadingCircle.classList.add('hidden');
                data.items.forEach(item => {
                    const dishDiv = createDivItem(item);
                    container.appendChild(dishDiv);
                });
            }

            if(Array.isArray(data.subCategories)){
                loadingCircle.classList.add('hidden');
                data.subCategories.forEach(category => {
                    const textCategory = createTextCategory(category);
                    containerSubCategories.appendChild(textCategory);
                });
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            container.innerHTML = '<p>Failed to load dishes. Please try again later.</p>';
        });
}

function createDivItem (item) {
    const dishDiv = document.createElement('div');
    dishDiv.classList.add('bg-background', 'h-full', 'rounded-xl', 'max-w-md', 'flex', 'flex-col', 'gap-3', 'p-4');

    const img = document.createElement('img');
    img.classList.add('object-cover', 'rounded-2xl', 'w-full', 'max-h-52');
    img.src =  '/uploads/images/' + item.photo;
    dishDiv.appendChild(img);

    const name = document.createElement('h3');
    name.classList.add('text-white', 'text-2xl', 'font-normal', 'w-full', 'break-words');
    name.innerText = item.name;
    dishDiv.appendChild(name);

    const description = document.createElement('h6');
    description.classList.add('text-white', 'text-lg', 'font-light', 'w-full', 'break-words');
    description.innerHTML = item.description;
    dishDiv.appendChild(description);

    const price = document.createElement('h3');
    price.classList.add('text-white', 'text-xl', 'font-normal', 'w-full', 'break-words');
    price.innerText = item.price + ' $';
    dishDiv.appendChild(price);

    const cartButtonDiv = document.createElement('div');
    cartButtonDiv.classList.add('w-full', 'justify-center', 'items-end', 'flex', 'h-full');
    const cartButton = document.createElement('button');
    cartButton.classList.add('w-4');
    const cartIcon = document.createElement('i');
    cartIcon.classList.add('fa-solid', 'fa-cart-shopping', 'text-white', 'text-xl');
    cartButton.appendChild(cartIcon);
    cartButtonDiv.appendChild(cartButton);
    dishDiv.appendChild(cartButtonDiv);

    return dishDiv;
}

function createTextCategory (category) {
    const textCategory = document.createElement('h3');
    textCategory.classList.add('text-white', 'font-bold', 'text-xl', 'hover:underline', 'cursor-pointer');
    textCategory.addEventListener('click', function() {
        categoryChange(category.id, locale);
    });
    textCategory.innerHTML = category.name;

    return textCategory;
}
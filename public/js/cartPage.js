var itemsLocalStorage = localStorage.getItem('cart');
var cartItems = itemsLocalStorage ? JSON.parse(itemsLocalStorage) : [];
var body = JSON.stringify({ cart: cartItems });

fetch('/cart/getItems', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: body
})
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        const itemsContainer = document.getElementById('items');
        itemsContainer.innerHTML = '';

        data.forEach(item => {
            const newItemDiv = document.createElement('div');
            newItemDiv.classList.add('bg-background', 'h-full', 'rounded-xl', 'flex', 'md:flex-row', 'gap-3', 'p-4', 'flex-wrap');

            const imgElement = document.createElement('img');
            imgElement.classList.add('object-cover', 'rounded-2xl', 'w-full', 'max-h-52', 'max-w-36');
            imgElement.src = '/uploads/images/' + item.photo;

            const textElement = document.createElement('h3');
            textElement.classList.add('text-white', 'text-2xl', 'font-normal', 'w-full', 'break-words');
            textElement.textContent = item.name;

            const quantityInput = document.createElement('input');
            quantityInput.type = 'number';
            quantityInput.value = item.quantity;
            quantityInput.classList.add('border', 'rounded-lg', 'w-7', 'p-1', 'h-7');
            quantityInput.min = 1;

            quantityInput.addEventListener('change', function() {
                const newQuantity = parseInt(quantityInput.value, 10);
                item.quantity = newQuantity;
                const index = cartItems.findIndex(cartItem => cartItem.id === item.id);
                if (index !== -1) {
                    cartItems[index].quantity = newQuantity;
                    localStorage.setItem('cart', JSON.stringify(cartItems));
                }
            });

            newItemDiv.appendChild(imgElement);
            newItemDiv.appendChild(textElement);
            newItemDiv.appendChild(quantityInput);

            itemsContainer.appendChild(newItemDiv);
        });
        delete itemsLocalStorage;
        delete cartItems;
        delete body;
    })
    .catch(error => {
        console.error('There has been a problem with your fetch operation:', error);
    });

var form = document.querySelector('form');
form.addEventListener('submit', function(event) {

    const cartInput = document.getElementById('cart-input');
    cartInput.value = JSON.stringify(cartItems);
    delete form;
    localStorage.removeItem('cart');
});

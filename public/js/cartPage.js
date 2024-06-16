document.addEventListener("DOMContentLoaded", function() {
    const itemsLocalStorage = localStorage.getItem('cart');
    const cartItems = itemsLocalStorage ? JSON.parse(itemsLocalStorage) : [];

    const body = JSON.stringify({ cart: cartItems });

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
            console.log('Items from server:', data);
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
});
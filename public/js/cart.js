function addToCart(itemId) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let itemIndex = cart.findIndex(item => item.id === itemId);

    if (itemIndex !== -1) {
        cart[itemIndex].quantity += 1;
    } else {
        cart.push({id: itemId, quantity: 1});
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    const alert = document.getElementById('alert');
    alert.classList.remove('hidden');
    setTimeout(() => {
        alert.classList.add('hidden')
    }, 1000);
}
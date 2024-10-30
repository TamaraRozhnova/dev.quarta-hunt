document.addEventListener('DOMContentLoaded', function() {
    let basketItems = document.querySelectorAll('.basket-item');
    if (basketItems) {
        basketItems.forEach(item => {
            let openRemoveItem = item.querySelector('.basket-item-actions-remove');
            let removeModal = item.querySelector('.remove-item-block');
            let closeModal = item.querySelector('.close-remove-item');

            if (openRemoveItem && removeModal && closeModal) {
                openRemoveItem.addEventListener('click', () => {
                    item.classList.add('remove');
                });

                closeModal.addEventListener('click', () => {
                    item.classList.remove('remove');
                });
            }
        });
    }
});
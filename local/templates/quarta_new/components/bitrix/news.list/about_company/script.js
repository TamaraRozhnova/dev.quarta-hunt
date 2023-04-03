window.addEventListener('DOMContentLoaded', () => {
    const rows = document.querySelectorAll('.row__item');

    rows.forEach(item => item.addEventListener('click', () => {
        const textNode = item.querySelector('.about-advantages__abs');
        textNode.classList.toggle('about-advantages__abs--open');
    }))
})

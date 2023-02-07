window.addEventListener('DOMContentLoaded', () => {
    const footerCollapses = document.querySelectorAll('.footer-collapse');
    footerCollapses.forEach(collapse => {
        const toggle = collapse.querySelector('.footer-collapse__toggle--mobile');
        toggle.addEventListener('click', () => {
            collapse.classList.toggle('footer-collapse--expanded');
        })
    })
})
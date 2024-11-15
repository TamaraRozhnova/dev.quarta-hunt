window.addEventListener('DOMContentLoaded', () => {
    const footerCollapses = document.querySelectorAll('.footer-collapse');
    footerCollapses.forEach(collapse => {
        const toggle = collapse.querySelector('.footer-collapse__toggle--mobile');
        toggle.addEventListener('click', () => {
            collapse.classList.toggle('footer-collapse--expanded');
        })
    })

    compareApi = new CompareApi();
    
    const cleanButton = document.querySelector(".compare-popup__clear");
    if (cleanButton) {
        cleanButton.addEventListener("click", () => {
            compareApi.clearCompare().then((response) => {
                if (response) {
                    window.location.reload();
                }
            });
        });
    }
})
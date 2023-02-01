(function () {
    const rows = document.querySelectorAll(".row__item");

    rows.forEach(item => item.addEventListener("click", () => {
        const textNode = item.querySelector(".advantages__abs");
        textNode.classList.toggle("advantages__abs--open");
    }))
})()
window.onload = function() {
    var src = document.getElementById("REGEMAIL"),
        dst = document.getElementById("REGLOGIN");
    src.addEventListener('input', function() {
        dst.value = src.value;
    });
};
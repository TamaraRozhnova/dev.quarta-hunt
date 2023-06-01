document.addEventListener("DOMContentLoaded", () => {

    function copyToClipboard(text) {
        let dummy = document.createElement("textarea");
      
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
      }

    document.querySelector('a[href=COPY_LINK]').addEventListener('click', function(event) {
        event.preventDefault();

        copyToClipboard(this.getAttribute('data-copy-attr'))
    })

    document.querySelectorAll('img.svg').forEach(img => {
        var imgId = img.id;
        var imgClass = img.className;
        var imgURL = img.src;
        var imgFill = img.getAttribute('data-fill');
        
        fetch(imgURL).then(r => r.text()).then(text => {
            var parser = new DOMParser();
            var xmlDoc = parser.parseFromString(text, "text/xml");
            var svg = xmlDoc.getElementsByTagName('svg')[0];
            
            if (typeof imgId !== 'undefined') {
                svg.setAttribute('id', imgId);
            }
            
            if (typeof imgClass !== 'undefined') {
                svg.setAttribute('class', imgClass);
            }        
            
            if (typeof imgFill !== 'undefined') {
                svg.setAttribute('fill', imgFill);
            }
            
            img.parentNode.replaceChild(svg, img);
            
        }).catch(console.error);
        
    });

});
/*  header.js — Carga automática del header universal R&C Consulting
    USO: 
    1. Agrega <div id="rc-header"></div> donde quieras el header
    2. Incluye <script src="./header/header.js"></script> DESPUÉS de Bootstrap JS
*/
(function(){
    var target = document.getElementById('rc-header');
    if(!target) return;

    // Detectar ruta base del script para encontrar header.html
    var scripts = document.getElementsByTagName('script');
    var basePath = './';
    for(var i = 0; i < scripts.length; i++){
        var src = scripts[i].src || '';
        if(src.indexOf('header.js') !== -1){
            basePath = src.substring(0, src.lastIndexOf('/') + 1);
            break;
        }
    }

    fetch(basePath + 'header.html')
        .then(function(r){ return r.text(); })
        .then(function(html){
            target.innerHTML = html;
            // Reinicializar Bootstrap dropdowns y collapse del header
            if(typeof bootstrap !== 'undefined'){
                target.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(el){
                    new bootstrap.Dropdown(el);
                });
            }
        })
        .catch(function(err){
            console.error('Error cargando header:', err);
        });
})();
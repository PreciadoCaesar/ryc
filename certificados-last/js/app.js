function verificarDatos() {



    //Verificar

    var inputDni = document.getElementById('inputDni');

    if (inputDni.value && inputDni.value.length > 7 && inputDni.value.length < 9) {

        //verifico que el texto del captcha este ok

        if (validateCaptcha() == 1) {

            //verifico que se acepte las politicas

            if (isCheckboxChecked() == true) {

                verRegistros();

                //SI LLEGO AQUI TODO ES CORRECTO

                ////console.log(inputDni.value);

                getCertificadoFiltro()

            }

            else {

                alert("Por favor, Acepte las políticas de datos");

            }

        }

        else {

        }

    }

    else {

        alert("Por favor, Verifique el DNI");

    }



}

function limpiarDatos() {

    limpiarTabla();

    limpiarCampos();



}



function limpiarTabla() {

    todocertificado = "";

    document.getElementById("todatabla").innerHTML = "";

}

function limpiarCampos() {

    document.getElementById("inputDni").value = "";

    limpiarCode();

    createCaptcha();

}

function limpiarCode() {

    document.getElementById("cpatchaTextBox").value = "";

}







function verRegistros() {



    verright.setAttribute("class", "right onn");



    //Efecto de aparición mediante un id





    //console.log("Registros verificados")

}









var todocertificado;

function getCertificadoFiltro() {

    var idcertificado;

    var dni;

    var nombre;

    var curso;

    var fecha;

    var modalidad;

    var horas;

    var pdf;



    //obtener filtros para realizar la consulta al servidor #subcategoria

    var dniconsulta = document.getElementById('inputDni');

    //console.log("El dni consulta es: "+dniconsulta.value);





    var xhttpproductofiltro = new XMLHttpRequest();



    xhttpproductofiltro.onreadystatechange = function () {



        if (this.readyState == 4 && this.status == 200) {

            //document.getElementById("get").innerHTML = this.responseText;

            todoproducto = JSON.parse(this.responseText);

            if (todoproducto == null) {

                //console.log('Todo esta vacio');

            }

            else {

                if (todoproducto.length == 0) {

                    //Corroborar que este vacio la lista

                    var todocuerpo2 = '<table>' +

                        '<tr>' +

                        '<div style="color: red;font-size: 22px;font-weight: 900;">' +

                        '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chat-square-dots-fill" viewBox="0 0 16 16"><path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.5a1 1 0 0 0-.8.4l-1.9 2.533a1 1 0 0 1-1.6 0L5.3 12.4a1 1 0 0 0-.8-.4H2a2 2 0 0 1-2-2zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/></svg>' +

                        ' Certificado no encontrado.' +

                        '</div>' +

                        '' +

                        '</tr>' +

                        '<tr>' +

                        'Si ya aprobó un curso, consulte con su asesor.' +

                        '</tr>' +

                        '</table>';



                    document.getElementById("todatabla").innerHTML = todocuerpo2;

                }

                else {

                    limpiarTabla();

                    var toptabla = '<table>' +

                        '<tr>' +

                        '<th>Acreditado</th>' +

                        '<th>Especialización</th>' +

                        '<th>Institución</th>' +

                        '</tr>';

                    var bottomtabla = '</table>' +

                        '<table id="gdxverpdf">' +

                        '</table>';







                    // DENTRO DEL BUCLE FOR DE app.js
for (let i = 0; i < todoproducto.length; i++) {
    // Extraer datos
    nombre = todoproducto[i].nombre;
    dni = todoproducto[i].dni;
    curso = todoproducto[i].curso;
    fecha = todoproducto[i].fecha;
    modalidad = todoproducto[i].modalidad;
    horas = todoproducto[i].horas;
    pdf = todoproducto[i].pdf;

    // GENERAR EL BLOQUE CELESTE (No usar <table>)
    var bloqueNuevo = `
        <div class="result-item-box animate__animated animate__fadeIn">
            <div class="row g-2 justify-content-center align-items-center">
                <div class="col-md-4 border-end-custom">
                    <strong class="label-mini">Acreditado</strong>
                    <p class="nombre-acreditado">${nombre}</p>
                    <span class="dni-badge">DNI: ${dni}</span>
                </div>
                <div class="col-md-5 border-end-custom">
                    <strong class="label-mini">Especialización</strong>
                    <p class="curso-titulo">${curso}</p>
                    <div class="detalles-curso">
                        <span><strong>Fecha:</strong> ${fecha}</span><br>
                        <span><strong>Modalidad:</strong> ${modalidad}</span>
                    </div>
                </div>
                <div class="col-md-3 d-flex flex-column justify-content-between">
                    <div>
                        <strong class="label-mini">Institución</strong>
                        <p class="inst-name">R&C CONSULTING</p>
                        <span class="horas-badge">Horas: ${horas}</span>
                    </div>
                    <a onclick="verEnModal('${pdf}')" class="gdxhoras pointer mt-2">
                         Ver Certificado
                    </a>
                </div>
            </div>
        </div>
    `;

    // Acumular los bloques
    todocertificado = bloqueNuevo + todocertificado; 
}

// Inyectar en el contenedor
document.getElementById("todatabla").innerHTML = todocertificado;

                }

            }

        }

    };

    //console.log(abc);

    /*Esto es para localhost - Descomentar para desarrollo local*/

    /*xhttpproductofiltro.open("GET", "http://localhost/app-certificados/php/api-123123.php?d="+dniconsulta.value+"&t="+encodeURIComponent(abc), true);*/

    /*Esto es para el servidor de producción*/

    xhttpproductofiltro.open("GET", "https://rc-consulting.org/app-certificados/php/api-123123.php?d=" + dniconsulta.value + "&t=" + encodeURIComponent(abc), true);

    xhttpproductofiltro.send();

    createCaptcha();

}









function mostrarPdf(pdf) {

    document.getElementById("gdxverpdf").innerHTML =

        ' <iframe  src = ' + '"' + pdf + '"' + ' width="100%" height="700" allowfullscreen webkitallowfullscreen></iframe>';

}







function pintarCeldaPorDNI(dni) {

    // Seleccionamos todas las filas dentro del tbody

    let filas = document.querySelectorAll("#tablaResultados tbody tr");



    filas.forEach(fila => {

        let celdas = fila.getElementsByTagName("td");



        if (celdas.length > 1 && celdas[1].textContent.trim() === dni) {

            celdas[1].style.backgroundColor = "#94ff8a"; // Pinta solo la celda del DNI

        } else {

            //celdas[1].style.backgroundColor = ""; // Limpia otras celdas

        }

    });

}

// NUEVO SCIPT
/*
function verEnModal(urlPdf) {

    document.getElementById("bodyModalPDF").innerHTML = 
        '<iframe src="' + urlPdf + '" width="100%" height="600px" style="border:none; border-radius: 0 0 15px 15px;"></iframe>';
    

    var miModal = new bootstrap.Modal(document.getElementById('modalCertificado'));
    miModal.show();
}*/

function verEnModal(pdfUrl) {
    var container = document.getElementById("bodyModalPDF");
    // Limpiamos e inyectamos el iframe con el link real de tu base de datos
    container.innerHTML = '<iframe src="' + pdfUrl + '" width="100%" height="100%" style="border:none; border-radius: 0 0 15px 15px;"></iframe>';
    
    // Abrimos el modal de Bootstrap manualmente
    var miModal = new bootstrap.Modal(document.getElementById('modalCertificado'));
    miModal.show();
}
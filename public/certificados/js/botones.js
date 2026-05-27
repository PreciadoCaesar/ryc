    //Funcionamiento de botones superiores

    //Secciones de modulos
    var btnapppress= document.getElementById('div-app');
    var btnadmpress= document.getElementById('div-admin');
    var btnguiapress= document.getElementById('div-guia');

    var btnizqpress= document.getElementsByClassName('btn-izq');
    var btnderpress= document.getElementsByClassName('btn-der');
    var btncenterpress= document.getElementsByClassName('btn-center');

    function btnAplicativo(){

        //Activar seccion 1
        btnapppress.style.display="flex";
        btnadmpress.style.display="none";
        btnguiapress.style.display="none";

        //console.log('btnAplicativo');
        btnizqpress[0].style.background="var(--azul)";
        btnizqpress[0].style.color="#e9fafd";

        btnderpress[0].style.background="#e9fafd";
        btnderpress[0].style.color="var(--azul)";

        btncenterpress[0].style.background="#e9fafd";
        btncenterpress[0].style.color="var(--azul)";
    }
    function btnGuia(){

        btnapppress.style.display="none";
        btnadmpress.style.display="none";
        btnguiapress.style.display="flex";

        //console.log('btnGuia');
        btnderpress[0].style.background="var(--azul)";
        btnderpress[0].style.color="#e9fafd";

        btnizqpress[0].style.background="#e9fafd";
        btnizqpress[0].style.color="var(--azul)";

        btncenterpress[0].style.background="#e9fafd";
        btncenterpress[0].style.color="var(--azul)";
    }
    function btnAdmin(){

        //Activar seccion 1
        btnapppress.style.display="none";
        btnadmpress.style.display="flex";
        btnguiapress.style.display="none";


        //console.log('btnGuia');
        btnderpress[0].style.background="#e9fafd";
        btnderpress[0].style.color="var(--azul)";

        btnizqpress[0].style.background="#e9fafd";
        btnizqpress[0].style.color="var(--azul)";

        btncenterpress[0].style.background="var(--azul)";
        btncenterpress[0].style.color="#e9fafd";
    }
    abc = '2050ABCD';
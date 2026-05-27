var code;

function createCaptcha() {



document.getElementById('captcha').innerHTML = "";



var charsArray =

"ABCDEFGHIJKLMNOPQRSTUVWXYZ";

var lengthOtp = 5;

var captcha = [];

for (var i = 0; i < lengthOtp; i++) {


    var index = Math.floor(Math.random() * charsArray.length + 1); 



    if (captcha.indexOf(charsArray[index]) == -1)

    captcha.push(charsArray[index]);

    else i--;

}

var canv = document.createElement("canvas");

canv.id = "captcha";

canv.width = 100;

canv.height = 50;

var ctx = canv.getContext("2d");

ctx.font = "600 20px Poppins, sans-serif";

ctx.fillStyle = "#ffffff";
ctx.fillText(captcha.join(""), 5, 35);





code = captcha.join("");

document.getElementById("captcha").appendChild(canv); 

limpiarCode();

}



//Validacion de captcha

function validateCaptcha() {

    var cpatchaTextBox = document.getElementById("cpatchaTextBox");

    event.preventDefault();



    if (document.getElementById("cpatchaTextBox").value == code) {

        return 1;

    }else{

        alert("Invalid Captcha. try Again");

        cpatchaTextBox.value = "";

        createCaptcha();

        

    }

}

var abc = '305*e2#@';


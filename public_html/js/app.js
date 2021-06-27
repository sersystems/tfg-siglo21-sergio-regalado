function fechaActual() {
  let anio = new Date().getFullYear(); 
  let mes = '0' + (new Date().getMonth()+1);
  let dia = '0' + new Date().getDate(); 
  return anio + '-' + mes.slice(-2) + '-' + dia.slice(-2);
}

function horaActual() {
  let minuto = '0' + new Date().getMinutes(); 
  let hora = '0' + new Date().getHours(); 
  return hora.slice(-2) + ':' + minuto.slice(-2);
}

async function dibujarCaptcha(captcha){
  const canvas = document.getElementById("canvas");
  const ctx = canvas.getContext("2d");
  ctx.textAlign = "center";
  ctx.textBaseline = "middle";
  ctx.fillStyle = "rgba(255,255,255,.95)";
  ctx.drawImage(laImagen, 0, 0);
  ctx.font = '22px Arial';
  ctx.fillText(captcha, 55, 13);
}

function generarCaptcha(){
  let caracterLista = new Array(
    'A','B','C','E','H','J','K','L','M','N','R','T','U','V','W','X','Y','Z',
    'a','b','c','d','e','h','k','m','n','r','u','v','w','x','z', 
    '2','3','4','6','7','8','9');
  let caracter1 = caracterLista[Math.floor(Math.random() * caracterLista.length)] + ' ';
  let caracter2 = caracterLista[Math.floor(Math.random() * caracterLista.length)] + ' ';
  let caracter3 = caracterLista[Math.floor(Math.random() * caracterLista.length)] + ' ';
  let caracter4 = caracterLista[Math.floor(Math.random() * caracterLista.length)] + ' ';
  let caracter5 = caracterLista[Math.floor(Math.random() * caracterLista.length)];
  return caracter1 + caracter2 + caracter3 + caracter4 + caracter5;
}

function validarCaptcha(captchaGenerada, captchaIngresada){
  if (captchaGenerada.replaceAll(' ', '') == captchaIngresada){ return true;
  }else{ 
    alert('El código captcha es incorrecto. Verifique e intente nuevamente.');
    return false; 
  }
}


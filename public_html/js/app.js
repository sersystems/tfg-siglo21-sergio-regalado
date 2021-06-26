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
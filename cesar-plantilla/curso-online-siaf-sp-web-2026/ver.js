function doGet(e) {
  return doPost(e);
}

function doPost(e) {
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
  
  var origen = e.parameter.origen || '';
  var nombres = e.parameter.nombres || '';
  var correo = e.parameter.correo || '';
  var telefono = e.parameter.telefono || '';
  var institucion = e.parameter.institucion || '';
  var cantidadAlumnos = e.parameter.cantidadAlumnos || '';
  var nivelCurso = e.parameter.nivelCurso || '';
  var requerimiento = cantidadAlumnos + ' - ' + nivelCurso;
  var curso = e.parameter.curso || '';
  var urlWha = e.parameter.urlWha || '';
  var fecha = new Date();

  sheet.appendRow([origen, nombres, correo, telefono, institucion, cantidadAlumnos, nivelCurso, requerimiento, curso, urlWha, fecha]);

  return ContentService.createTextOutput(JSON.stringify({
    resultado: "OK"
  })).setMimeType(ContentService.MimeType.JSON);
}

//id de implementacion AKfycbw1yJHtY22cXwnW4XDZo9w2eNckcBMIen9MdcaAEyAHA-0WsOGRJQ_4ClkE_SPoWQgMKg
//url httpsscript.google.commacrossAKfycbw1yJHtY22cXwnW4XDZo9w2eNckcBMIen9MdcaAEyAHA-0WsOGRJQ_4ClkE_SPoWQgMKgexec
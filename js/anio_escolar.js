$(document).ready(function(){

	$("#incluir").click(function(){
		var fecha_inicio = $("#fecha_inicio").val();
		var fecha_fin = $("#fecha_fin").val();
		var ano_escolar = $("#ano_escolar").val();

		if( fecha_inicio.length != 0 && fecha_fin.length != 0 && ano_escolar.length != 0 ){
			incluirAnioEscolar();
		}
		else if( fecha_inicio.length == 0 && fecha_fin.length == 0  ){
			alertify.error("Empty Field");
		}
		else if( fecha_inicio.length == 0 ){
			alertify.error("Select the start date of the academic period");
		}
		else if( fecha_fin.length == 0 ){
			alertify.error("Select the end date of the academic period");
		}
	});

	$("#modificar").click(function(){
		if( fecha_inicio.length != 0 && fecha_fin.length != 0 && ano_escolar.length != 0 ){
			alertify.confirm("Do you want to modify the academic period?", function(c){
				if(c){
					modificarAnioEscolar();
				}
			});
		}
		else if( fecha_inicio.length == 0 && fecha_fin.length == 0  ){
			alertify.error("Empty Fields");
		}
		else if( fecha_inicio.length == 0 ){
			alertify.error("Select the start date of the academic period");
		}
		else if( fecha_fin.length == 0 ){
			alertify.error("Select the end date of the academic period");
		}
		
	});

	$("#eliminar").click(function(){
		alertify.confirm("¿Do you want to delete the academic period?", function(c){
			if(c){
				eliminarAnioEscolar();
			}
		});
	});
	

	$("#fecha_fin").change(function() {
  
		var fecha_inicio = $("#fecha_inicio").val();
		var fecha_fin = $("#fecha_fin").val();
		
		//alert(fecha_fin);
		
		var fecha1 = fecha_inicio.split("-");
		var fecha2 = fecha_fin.split("-");

		var ano1 = fecha1[0];
		var ano2 = fecha2[0];		
		var mes1 = obtenerMes(fecha1[1]);
		var mes2 = obtenerMes(fecha2[1]);
		var dia1 = fecha1[2];
		var dia2 = fecha2[2];
		
		var ano_escolar;
		
		if(ano1 == ano2 && mes1 == mes2){
			
			ano_escolar = mes1 + " " + ano1;
					
		}else if(ano1 == ano2 && mes1 != mes2){
						
			ano_escolar = mes1 + " - " + mes2 + " " + ano2;
						
		}else{
						
			ano_escolar = ano1 + " - " + ano2;
		}
		
		$("#ano_escolar").val(ano_escolar);
		$("#ano_escolar").focus();
		
		//document.getElementById("ano_escolar").value = ano_escolar;
		
	});
	
	//Cada vez que se deje pulsado .seleccion por 750ms
	$(document).on("mouseover", ".seleccion", function(){
		var id_ano_escolar = $(this).find("td").eq(0).text();

		seleccionAnoEscolar(id_ano_escolar);
	});

});

function obtenerMes(mes){
	
	var mes_obt;
	
	switch (mes) { 
		case '01': 
			mes_obt = 'JAN';
			break;
		case '02': 
			ano_obt = 'FEB';
			break;
		case '03': 
			mes_obt = 'MAR';
			break;		
		case '04': 
			mes_obt = 'APR';
			break;
		case '05': 
			mes_obt = 'MAY';
			break;
		case '06': 
			ano_obt = 'JUN';
			break;
		case '07': 
			mes_obt = 'JUL';
			break;		
		case '08': 
			mes_obt = 'AGT';
			break;
		case '09': 
			mes_obt = 'SEP';
			break;
		case '10': 
		 	mes_obt = 'OCT';
			break;
		case '11': 
			mes_obt = 'NOV';
			break;		
		case '12': 
			mes_obt = 'DEC';
			break;
		default:
			mes_obt = 'NOT DEFINE';
	}
	
	return mes_obt;
	
}

//Capturamos la el id de la fila seleccionada y consultamos los datos 
function seleccionAnioEscolar(id_ano_escolar){
	var id = id_ano_escolar;

	consultarAnioEscolar(id);

	redireccionar('#form-maestro');
}

function consultarAnioEscolar(id){
	$.ajax({
		url: "../controlador/gestionar_anio_escolar.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultar="+id,
		success: verificarConsulta,
		error: function(){ alertify.error("Error"); }
	});
}

function incluirAnioEscolar(){

	var fecha_inicio, fecha_fin, anio_escolar;
	
	fecha_inicio = $("#fecha_inicio").val();

	fecha_fin    = $('#fecha_fin').val();

	anio_escolar = $('#ano_escolar').val();

	id_codigo_tele = $("#id_codigo_tele").val();
	numero = $("#numero").val();
	id_discapacidad = $("#id_discapacidad").val();
	id_sector = $("#id_sector").val();

	var anio_escolar = {
		fecha_inicioAE : fecha_inicio,
		fecha_finAE : fecha_fin,
		anio_escolarAE : anio_escolar
	}

	$.ajax({
		url: "../controlador/gestionar_anio_escolar.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "incluir="+JSON.stringify(anio_escolar),
		success: emitirResultado,
		error: function(){ alertify.error("Error saving academic period"); }
        	
	});
}

function modificarAnioEscolar(){

	var id_anio_escolar, fecha_inicio, fecha_fin, anio_escolar;

	id_anio_escolar = $("#id_anio_escolar").val();
	
	fecha_inicio = $("#fecha_inicio").val();

	fecha_fin    = $('#fecha_fin').val();

	anio_escolar = $('#ano_escolar').val();

	var anio_escolar = {
		id_anio_escolarAE : id_anio_escolar,
		fecha_inicioAE : fecha_inicio,
		fecha_finAE : fecha_fin,
		anio_escolarAE : anio_escolar
	}

	$.ajax({
		url: "../controlador/gestionar_anio_escolar.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "modificar="+JSON.stringify(anio_escolar),
		success: emitirResultado,
		error: function(){ alertify.error("Error modifing academic period"); }
        	
	});
}

function eliminarAnioEscolar(){

	var id_anio_escolar;

	id_anio_escolar = $("#id_anio_escolar").val();

	$.ajax({
		url: "../controlador/gestionar_anio_escolar.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "eliminar="+id_anio_escolar,
		success: emitirResultado,
		error: function(){ alertify.error("Error deleting academic period"); }
        	
	});
}

function verificarConsulta(dato){
	if(typeof dato.id_ano_escolar != 'undefined'){
		mostrarConsulta(dato);

		document.getElementById("consultar").hidden   = "hidden";
		document.getElementById("incluir").hidden   = "hidden";
		document.getElementById("modificar").hidden = "";
		document.getElementById("eliminar").hidden  = "";
	}
}

function mostrarConsulta(dato){

	$("#id_ano_escolar").val(dato.id_ano_escolar);

	if(dato.estatus == 'A'){

		$("#fecha_inicio").attr('disabled', false);
		$("#fecha_fin").attr('disabled', false);
		document.getElementById("incluir").hidden = "hidden";
		document.getElementById("modificar").hidden = "";

	}else if(dato.estatus == 'I'){

		$("#fecha_inicio").attr('disabled', true);
		$("#fecha_fin").attr('disabled', true);

	}

	$("#fecha_inicio").datepicker( "setDate", dato.fecha_inicio );
	$("#fecha_fin").datepicker( "setDate", dato.fecha_fin );
	
	$("#ano_escolar").val(dato.denominacion);
}

function emitirResultado(dato){

		alertify.alert(dato.msj);

		limpiarCamposAnioEscolar(id = ['id_ano_escolar', 'fecha_inicio', 'fecha_fin', 'ano_escolar']);

		busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_anio_escolar.php', 'consultaAvanzada');
}

//Limpia los campos
function limpiarCamposAnioEscolar(input){

	for(i=0; i<input.length; i++){
		document.getElementById(input[i]).value = "";
	}

	$("#fecha_inicio").attr('disabled', false);
	$("#fecha_fin").attr('disabled', false);
	document.getElementById("incluir").hidden = "";
	document.getElementById("modificar").hidden = "hidden";

}

function activarCamposEstudiante(){

	$("#fecha_inico").attr('disabled', false);
	$("#fecha_fin").attr('disabled', false);
	
}

function validarCampoVacio(input){

	var campo_vacio_valido = true;

	for(i=0; i<input.length; i++){

		var campo = document.getElementById(input[i]).value;

		if(campo.length < 1){
			document.getElementById(input[i]).focus();
			campo_vacio_valido = false;
			return campo_vacio_valido;
		}
		
	}
}



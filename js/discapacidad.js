$(document).ready(function(){
	busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_discapacidad.php', 'consultaAvanzada');

	$("#incluir").click(function(){

		var discapacidad = $("#nombre_discapacidad").val();

		if(discapacidad.length > 1){
			var mensaje = $("#msj-consulta").is(":visible");
			
			if( !mensaje ){
				incluirDiscapacidad();
			}
			else{
				alertify.error("This discapacity is already registered");
			}
		}
		else if(discapacidad.length == 1){
			alertify.error("This field must contain more than 1 character");
			$("#nombre_discapacidad").focus();
		}
		else{
			alertify.error("Campo Vacio");
			$("#nombre_discapacidad").focus();
		}

	});

	$("#modificar").click(function(){
		
		var discapacidad = $("#nombre_discapacidad").val();

		if(discapacidad.length > 1){
			var mensaje = $("#msj-consulta").is(":visible");
			
			if( !mensaje ){
				alertify.confirm( "Do you want to modify the discapacity?", function(c){
					if( c ){
						modificarDiscapacidad();
					}
				});
			}
			else{
				alertify.error("This discapacity is already registered");
			}
		}
		else if(discapacidad.length == 1){
			alertify.error("This field must contain more than 1 character");
			$("#nombre_discapacidad").focus();
		}
		else{
			alertify.error("Campo Vacio");
			$("#nombre_discapacidad").focus();
		}
	});

	$("#eliminar").click(function(){
		alertify.confirm( "Do you want to delete this discapacity?", function(c){
			if( c ){
				eliminarDiscapacidad();
			}
		});
	});

	$("#nombre_discapacidad").keyup(function () {

		var nombre_discapacidad = $("#nombre_discapacidad").val();

		consultarDiscapacidad(nombre_discapacidad);
	});

	//Cada vez que se deje pulsado .seleccion por 750ms
	$(document).on("taphold", ".seleccion", function(){
		var id     = $(this).attr("id");
		var nombre = $(this).text();

		$("#id_discapacidad").val(id);
		$("#nombre_discapacidad").val(nombre);

		desactivarIncluir();
	});

	//Desactivo el sombreado y seleccion de .seleccion
	$("#cuerpo-tabla-maestro").disableSelection();
	
});

function consultarDiscapacidad(nombre_discapacidad){

	var id_discapacidad;

	id_discapacidad = $("#id_discapacidad").val();

	var discapacidad = {
		id_discapacidadD : id_discapacidad,
		nombre_discapacidadD : nombre_discapacidad
	}

	$.ajax({
		url: "../controlador/gestionar_discapacidad.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultar="+JSON.stringify(discapacidad),
		success: verificarConsulta,
		error: function(){ alertify.error("Error"); }
	});
}

function incluirDiscapacidad(){

	var nombre_discapacidad;
	
	nombre_discapacidad = $("#nombre_discapacidad").val();

	$.ajax({
		url: "../controlador/gestionar_discapacidad.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "incluir="+nombre_discapacidad,
		success: emitirResultado,
		error: function(){ alertify.error("Error saving discapacity"); }
        	
	});
}

function modificarDiscapacidad(){

	var id_discapacidad, nombre_discapacidad;

	id_discapacidad = $("#id_discapacidad").val();
	
	nombre_discapacidad = $("#nombre_discapacidad").val();

	var discapacidad = {
		id_discapacidadD : id_discapacidad,
		nombre_discapacidadD : nombre_discapacidad
	}

	$.ajax({
		url: "../controlador/gestionar_discapacidad.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "modificar="+JSON.stringify(discapacidad),
		success: emitirResultado,
		error: function(){ alertify.error("Error modifing discapacity"); }
        	
	});
}

function eliminarDiscapacidad(){

	var id_discapacidad;

	id_discapacidad = $("#id_discapacidad").val();

	$.ajax({
		url: "../controlador/gestionar_discapacidad.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "eliminar="+id_discapacidad,
		success: emitirResultado,
		error: function(){ alertify.error("Error deleting discapacity"); }
        	
	});
}

function verificarConsulta(dato){
	if(dato.resultado == 'ALREADY EXIST'){
		$("#msj-consulta").show();
		document.getElementById('msj-p').innerHTML = dato.msj;
	}
	else if(dato.resultado == 'DON´T EXIST'){
		$("#msj-consulta").hide();
	}
}

function emitirResultado(dato){

		alertify.alert(dato.msj);

		limpiarCamposDiscapacidad(id = ['id_discapacidad', 'nombre_discapacidad']);

		busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_discapacidad.php', 'consultaAvanzada');

}

//Limpia los campos
function limpiarCamposDiscapacidad(input){

	for(i=0; i<input.length; i++){
		document.getElementById(input[i]).value = "";
	}

	$("#msj-consulta").hide();

	activarIncluir();

}

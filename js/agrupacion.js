$(document).ready(function(){

	$("#incluir").click(function(){
		var agrupacion = $("#nombre_agrupacion").val();

		if(agrupacion.length > 1){
			var mensaje = $("#msj-consulta").is(":visible");
			
			if( !mensaje ){
				incluirAgrupacion();
			}
			else{
				alertify.error("This grouping is already registered");
			}
		}
		else if(agrupacion.length == 1){
			alertify.error("The field must contain more than 1 character");
			$("#nombre_agrupacion").focus();
		}
		else{
			alertify.error("Campo Vacio");
			$("#nombre_agrupacion").focus();
		}
	});

	$("#modificar").click(function(){
		var agrupacion = $("#nombre_agrupacion").val();

		if(agrupacion.length > 1){
			var mensaje = $("#msj-consulta").is(":visible");
			
			if( !mensaje ){
				alertify.confirm("Do you want to modify the grouping?", function(c){
					if(c){
						modificarAgrupacion();
					}
				});
			}
			else{
				alertify.error("This grouping is already registered");
			}
		}
		else if(agrupacion.length == 1){
			alertify.error("The field must contain more than 1 character");
			$("#nombre_agrupacion").focus();
		}
		else{
			alertify.error("Empty Field");
			$("#nombre_agrupacion").focus();
		}
	});

	$("#eliminar").click(function(){
		alertify.confirm("Do you want to delete the grouping?", function(c){
			if(c){
				eliminarAgrupacion();
			}
		});
	});

	$("#nombre_agrupacion").keyup(function () {

		var nombre_agrupacion = $("#nombre_agrupacion").val();

		if(nombre_agrupacion.length > 2){
			consultarAgrupacion(nombre_agrupacion);
		}
		else{
			$("#msj-consulta").hide();
		}
	});

	//Cada vez que se deje pulsado .seleccion por 750ms
	$(document).on("taphold", ".seleccion", function(){
		var id     = $(this).attr("id");
		var nombre = $(this).text();

		$("#id_agrupacion").val(id);
		$("#nombre_agrupacion").val(nombre);

		desactivarIncluir();
	});

	//Desactivo el sombreado y seleccion de .seleccion
	$("#cuerpo-tabla-maestro").disableSelection();	
});

function consultarAgrupacion(nombre_agrupacion){

	var id_agrupacion;

	id_agrupacion = $("#id_agrupacion").val();

	var agrupacion = {
		id_agrupacionA : id_agrupacion,
		nombre_agrupacionA : nombre_agrupacion
	}

	$.ajax({
		url: "../controlador/gestionar_agrupacion.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultar="+JSON.stringify(agrupacion),
		success: verificarConsulta,
		error: function(){ alert("Error"); }
	});
}

function incluirAgrupacion(){

	var nombre_agrupacion;
	
	nombre_agrupacion = $("#nombre_agrupacion").val();

	$.ajax({
		url: "../controlador/gestionar_agrupacion.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "incluir="+nombre_agrupacion,
		success: emitirResultado,
		error: function(){ alertify.error("Error saving grouping"); }
        	
	});
}

function modificarAgrupacion(){

	var id_agrupacion, nombre_agrupacion;

	id_agrupacion = $("#id_agrupacion").val();
	
	nombre_agrupacion = $("#nombre_agrupacion").val();

	var agrupacion = {
		id_agrupacionA : id_agrupacion,
		nombre_agrupacionA : nombre_agrupacion
	}

	$.ajax({
		url: "../controlador/gestionar_agrupacion.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "modificar="+JSON.stringify(agrupacion),
		success: emitirResultado,
		error: function(){ alertify.error("Error modifing group"); }
        	
	});
}

function eliminarAgrupacion(){

	var id_agrupacion;

	id_agrupacion = $("#id_agrupacion").val();

	$.ajax({
		url: "../controlador/gestionar_agrupacion.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "eliminar="+id_agrupacion,
		success: emitirResultado,
		error: function(){ alertify.error("Error deleting grouping"); }
        	
	});
}

function verificarConsulta(dato){
	if(dato.resultado == 'YA EXISTE'){
		$("#msj-consulta").show();
		document.getElementById('msj-p').innerHTML = dato.msj;
	}else if(dato.resultado == 'DON´T EXIST'){
		$("#msj-consulta").hide();
	}
}

function emitirResultado(dato){

		alertify.alert(dato.msj);

		limpiarCamposAgrupacion(id = ['id_agrupacion', 'nombre_agrupacion']);

		busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_agrupacion.php', 'consultaAvanzada');

}

//Limpia los campos
function limpiarCamposAgrupacion(input){

	for(i=0; i<input.length; i++){
		document.getElementById(input[i]).value = "";
	}

	$("#msj-consulta").hide();

	activarIncluir();

}

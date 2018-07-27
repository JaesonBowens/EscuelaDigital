$(document).ready(function(){

	$("#incluir").click(function(){
		var contenido = $("#nombre_contenido").val();

		if(contenido.length > 1){
			var mensaje = $("#msj-consulta").is(":visible");
			
			if( !mensaje ){
				incluircontenido();
			}
			else{
				alertify.error("This content is already registered");
			}
		}
		else if(contenido.length == 1){
			alertify.error("The field must contain more than 1 character");
			$("#nombre_contenido").focus();
		}
		else{
			alertify.error("Empty Field");
			$("#nombre_contenido").focus();
		}
	});

	$("#modificar").click(function(){
		var contenido = $("#nombre_contenido").val();

		if(contenido.length > 1){
			var mensaje = $("#msj-consulta").is(":visible");
			
			if( !mensaje ){
				alertify.confirm("Do you want to modify the content?", function(c){
					if(c){
						modificarcontenido();
					}
				});
			}
			else{
				alertify.error("This content is already registered");
			}
		}
		else if(contenido.length == 1){
			alertify.error("This field must contain more than 1 character");
			$("#nombre_contenido").focus();
		}
		else{
			alertify.error("Campo Vacio");
			$("#nombre_contenido").focus();
		}
	});

	$("#eliminar").click(function(){
		alertify.confirm("Do you want to delete the content?", function(c){
			if(c){
				eliminarcontenido();
			}
		});
	});

	$("#nombre_contenido").keyup(function () {

		var nombre_contenido = $("#nombre_contenido").val();

		if(nombre_contenido.length > 2){
			consultarcontenido(nombre_contenido);
		}
		else{
			$("#msj-consulta").hide();
		}
	});

	//Cada vez que se deje pulsado .seleccion por 750ms
	$(document).on("taphold", ".seleccion", function(){
		var id     = $(this).attr("id");
		var nombre = $(this).text();

		$("#id_contenido").val(id);
		$("#nombre_contenido").val(nombre);

		desactivarIncluir();
	});

	//Desactivo el sombreado y seleccion de .seleccion
	$("#cuerpo-tabla-maestro").disableSelection();	
});

function consultarcontenido(nombre_contenido){

	var id_contenido;

	id_contenido = $("#id_contenido").val();

	var contenido = {
		id_contenidoC : id_contenido,
		nombre_contenidoC : nombre_contenido
	}

	$.ajax({
		url: "../controlador/gestionar_contenido.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultar="+JSON.stringify(contenido),
		success: verificarConsulta,
		error: function(){ alert("Error"); }
	});
}

function incluircontenido(){

	var nombre_contenido;
	
	nombre_contenido = $("#nombre_contenido").val();

	$.ajax({
		url: "../controlador/gestionar_contenido.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "incluir="+nombre_contenido,
		success: emitirResultado,
		error: function(){ alertify.error("Error saving content"); }
        	
	});
}

function modificarcontenido(){

	var id_contenido, nombre_contenido;

	id_contenido = $("#id_contenido").val();
	
	nombre_contenido = $("#nombre_contenido").val();

	var contenido = {
		id_contenidoC : id_contenido,
		nombre_contenidoC : nombre_contenido
	}

	$.ajax({
		url: "../controlador/gestionar_contenido.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "modificar="+JSON.stringify(contenido),
		success: emitirResultado,
		error: function(){ alertify.error("Error modifing content"); }
        	
	});
}

function eliminarcontenido(){

	var id_contenido;

	id_contenido = $("#id_contenido").val();

	$.ajax({
		url: "../controlador/gestionar_contenido.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "eliminar="+id_contenido,
		success: emitirResultado,
		error: function(){ alertify.error("Error deleting content"); }
        	
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

		limpiarCamposcontenido(id = ['id_contenido', 'nombre_contenido']);

		busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_contenido.php', 'consultaAvanzada');

}

//Limpia los campos
function limpiarCamposcontenido(input){

	for(i=0; i<input.length; i++){
		document.getElementById(input[i]).value = "";
	}

	$("#msj-consulta").hide();

	activarIncluir();

}

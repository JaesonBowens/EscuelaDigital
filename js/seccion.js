$(document).ready(function(){
	busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_seccion.php', 'consultaAvanzada');

	$("#incluir").click(function(){
		var id_grado = $("#id_grado").val();
		var grupo = $("#grupo").val();

		if( id_grado.length >= 1 && grupo.length == 1 ){
			var mensaje = $("#msj-consulta").is(":visible");
			if( !mensaje ){
				incluirSeccion();
			}
			else{
				alertify.error("This section is already registered");
			}
		}
		else if( id_grado.length == 0 ){
			alertify.error("You must select a grade");
			$("#id_grado").focus();
		}
		else if( grupo.length == 0 ){
			alertify.error( "You must enter the section" );
			$("#grupo").focus();
		}
	});

	$("#modificar").click(function(){
		var id_grado = $("#id_grado").val();
		var grupo = $("#grupo").val();

		if( id_grado.length >= 1 && grupo.length == 1 ){
			var mensaje = $("#msj-consulta").is(":visible");
			if( !mensaje ){
				alertify.confirm("Do you want to modify the section?", function(c){
					if(c){
						modificarSeccion();
					}
				});
			}
			else{
				alertify.error("This section is already registered");
			}
		}
		else if( id_grado.length == 0 ){
			alertify.error("You must select a grade");
			$("#id_grado").focus();
		}
		else if( grupo.length == 0 ){
			alertify.error( "You must enter the section" );
			$("#grupo").focus();
		}
	});

	$("#eliminar").click(function(){
		alertify.confirm("Do you want to delete the section?", function(c){
			if(c){
				eliminarSeccion();
			}
		});
	});

	$("#id_grado").change(function() {

        	var id_seccion = $("#id_seccion").val();

        	var id_grado = $("#id_grado").val();

	      	var grupo = $("#grupo").val();

	      	consultarSeccion(id_seccion, grupo, id_grado);

   	});

	$("#grupo").keyup(function() {

        	var id_seccion = $("#id_seccion").val();

        	var id_grado = $("#id_grado").val();

	      	var grupo = $("#grupo").val(); 

		if(id_grado != ''){

	      		consultarSeccion(id_seccion, grupo, id_grado);

		}

   	});

   	//Cada vez que se deje pulsado .seleccion por 750ms
	$(document).on("taphold", ".seleccion", function(){
		var id       = $(this).attr("id");
		var nombre   = $(this).find("td").eq(1).text();
		var id_grado = $(this).find("td").eq(0).find("input[name='id_grado']").val();

		$("#id_seccion").val(id);
		$("#grupo").val(nombre);
		$("#id_grado").val(id_grado);

		desactivarIncluir();
	});

	$(document).on("dblclick", ".seleccion", function(){
		var id       = $(this).attr("id");
		var nombre   = $(this).find("td").eq(1).text();
		var id_grado = $(this).find("td").eq(0).find("input[name='id_grado']").val();

		$("#id_seccion").val(id);
		$("#grupo").val(nombre);
		$("#id_grado").val(id_grado);

		desactivarIncluir();
	});

	//Desactivo el sombreado y seleccion de .seleccion
	$("#cuerpo-tabla-maestro").disableSelection();
	
});

function seleccionSeccion(tr, input1, input2, input3, grupo, id_grado){
	var id     = tr.id;

	document.getElementById(input1).value = id_grado;
	document.getElementById(input2).value = id;
	document.getElementById(input3).value = grupo;

	desactivarIncluir();

}

function consultarSeccion(id_seccion, grupo, id_grado){

	var seccion = {
		id_seccionS : id_seccion,
		grupoS : grupo,
		id_gradoS : id_grado
	}

	$.ajax({
		url: "../controlador/gestionar_seccion.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultar="+JSON.stringify(seccion),
		success: verificarConsulta,
		error: function(){ alertify.error("Error"); }
	});
}

function incluirSeccion(){

	var grupo, id_grado;
	
	grupo = $("#grupo").val();

	id_grado = $("#id_grado").val();

	var seccion = {
		grupoS : grupo,
		id_gradoS : id_grado
	}

	$.ajax({
		url: "../controlador/gestionar_seccion.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "incluir="+JSON.stringify(seccion),
		success: emitirResultado,
		error: function(){ alertify.error("Error saving section"); }
        	
	});
}

function modificarSeccion(){

	var id_seccion, grupo, id_grado;

	id_seccion = $("#id_seccion").val();
	
	grupo = $("#grupo").val();

	id_grado = $("#id_grado").val();

	var seccion = {
		id_seccionM : id_seccion,
		grupoM : grupo,
		id_gradoM : id_grado
	}

	$.ajax({
		url: "../controlador/gestionar_seccion.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "modificar="+JSON.stringify(seccion),
		success: emitirResultado,
		error: function(){ alertify.error("Error modifing section"); }
        	
	});
}

function eliminarSeccion(){

	var id_seccion;

	id_seccion = $("#id_seccion").val();

	$.ajax({
		url: "../controlador/gestionar_seccion.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "eliminar="+id_seccion,
		success: emitirResultado,
		error: function(){ alertify.error("Error deleting section"); }
        	
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

	limpiarCamposSeccion(id = ['id_grado', 'id_seccion', 'grupo']);

	busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_seccion.php', 'consultaAvanzada');

}

//Limpia los campos
function limpiarCamposSeccion(input){

	for(i=0; i<input.length; i++){
		document.getElementById(input[i]).value = "";
	}

	$("#msj-consulta").hide();

	activarIncluir();

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

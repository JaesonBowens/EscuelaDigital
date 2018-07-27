$(document).ready(function(){
	busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_grado.php', 'consultaAvanzada');

	$("#incluir").click(function(){
		var nivel = $("#nivel").val();
		var nivel_numero = $("#nivel_numero").val();

		if( nivel.length > 1 && ( nivel_numero.length >= 1 && nivel_numero.length <= 2 ) ){
			var mensaje = $("#msj-consulta").is(":visible");

			if( !mensaje ){
				incluirGrado();
			}
			else{
				alertify.error("This grade is already registered");
			}
		}
		else if( nivel.length == 1 ){
			alertify.error("The grade´s field must have more than 1 character");
		}
		else if( nivel.length < 1 ){
			alertify.error("The grade´s field can´t be empty");
		}
		else if( nivel_numero.length < 1 ){
			alertify.error("The number´s field can´t be empty");
		}		
	});

	$("#modificar").click(function(){
		var nivel = $("#nivel").val();
		var nivel_numero = $("#nivel_numero").val();

		if( nivel.length > 1 && ( nivel_numero.length >= 1 && nivel_numero.length <= 2 ) ){
			var mensaje = $("#msj-consulta").is(":visible");

			if( !mensaje ){
				alertify.confirm("Do you want to modify the grade?", function(c){
					if(c){
						modificarGrado();
					}
				});
			}
			else{
				alertify.error("This grade is already registered");
			}
		}
		else if( nivel.length == 1 ){
			alertify.error("The grade´s field must contain more than 1 character");
		}
		else if( nivel.length < 1 ){
			alertify.error("The grade´s field can´t be empty");
		}
		else if( nivel_numero.length < 1 ){
			alertify.error("The grade´s field can´t be empty");
		}
	});

	$("#eliminar").click(function(){
		alertify.confirm("Do you want to delete this grade?", function(c){
			if(c){
				eliminarGrado();
			}
		});
	});

	$("#nivel_numero").keyup(function() {

		var id_grado = $("#id_grado").val();

	      	var nivel = $("#nivel").val();

	      	var nivel_numero = $("#nivel_numero").val();

	      	consultarGrado(id_grado, nivel, nivel_numero);
	      
	});

	$("#nivel").keyup(function() {

		var id_grado = $("#id_grado").val();

	      	var nivel = $("#nivel").val();

	      	var nivel_numero = $("#nivel_numero").val();

	      	consultarGrado(id_grado, nivel, nivel_numero);
	      
	});

	//Cada vez que se deje pulsado .seleccion por 750ms
	$(document).on("taphold", ".seleccion", function(){
		var id           = $(this).attr("id");
		var nivel        = $(this).text();
		var nivel_numero = $(this).find("input[name='nivel_numero']").val();
		
		$("#id_grado").val(id);
		$("#nivel").val(nivel);
		$("#nivel_numero").val(nivel_numero);

		desactivarIncluir();
	});

	//Cada vez que de doble click sobre .seleccion
	$(document).on("dblclick", ".seleccion", function(){
		var id           = $(this).attr("id");
		var nivel        = $(this).text();
		var nivel_numero = $(this).find("input[name='nivel_numero']").val();
		
		$("#id_grado").val(id);
		$("#nivel").val(nivel);
		$("#nivel_numero").val(nivel_numero);

		desactivarIncluir();
	});

	//Desactivo el sombreado y seleccion de .seleccion
	$("#cuerpo-tabla-maestro").disableSelection();
	
});

function consultarGrado(id_grado, nivel, nivel_numero){

	var grado = {
		id_gradoG : id_grado,
		nivelG : nivel,
		nivel_numeroG : nivel_numero
	}

	$.ajax({
		url: "../controlador/gestionar_grado.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultar="+JSON.stringify(grado),
		success: verificarConsulta,
		error: function(){ alert("Error"); }
	});
}


function incluirGrado(){

	var nivel, nivel_numero;
	
	nivel = $("#nivel").val();

	nivel_numero = $("#nivel_numero").val();

	var grado = {
		nivelG : nivel,
		nivel_numeroG : nivel_numero
	}

	$.ajax({
		url: "../controlador/gestionar_grado.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "incluir="+JSON.stringify(grado),
		success: emitirResultado,
		error: function(){ alertify.error("Error saving grade"); }
        	
	});
}

function modificarGrado(){

	var id_grado, nivel, nivel_numero;

	id_grado = $("#id_grado").val();
	
	nivel = $("#nivel").val();

	nivel_numero = $("#nivel_numero").val();

	var grado = {
		id_gradoG: id_grado,
		nivelG : nivel,
		nivel_numeroG : nivel_numero
	}

	$.ajax({
		url: "../controlador/gestionar_grado.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "modificar="+JSON.stringify(grado),
		success: emitirResultado,
		error: function(){ alertify.error("Error modifing grade"); }
        	
	});
}

function eliminarGrado(){

	var id_grado;

	id_grado = $("#id_grado").val();

	$.ajax({
		url: "../controlador/gestionar_grado.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "eliminar="+id_grado,
		success: emitirResultado,
		error: function(){ alertify.error("Error deleting grade"); }
        	
	});
}

function verificarConsulta(dato){
	if(dato.resultado == 'ALREADY EXIST'){
		$("#msj-consulta").show();
		document.getElementById('msj-p').innerHTML = dato.msj;
	}else if(dato.resultado == 'DON´T EXIST'){
		$("#msj-consulta").hide();
	}
}

function emitirResultado(dato){

		alertify.alert(dato.msj);

		limpiarCamposGrado(id = ['id_grado', 'nivel', 'nivel_numero']);

		busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_grado.php', 'consultaAvanzada');

}

//Limpia los campos
function limpiarCamposGrado(input){

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

$(document).ready(function(){

	busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_codigo_telefonico.php', 'consultaAvanzada');

	$("#incluir").click(function(){

		var codigo = $("#opcion_codigo").val();

		if( codigo.length == 4 ){
			var mensaje = $("#msj-consulta").is(":visible");
			
			if( !mensaje ){	
				incluirCodigoTelefonico();
			}
			else{
				alertify.error("This telephone code is already registered");
			}
		}
		else if( codigo.length > 4 || ( codigo.length > 1 && codigo.length < 3) ){
			alertify.error("This field only accepts 4 numbers");
			$("#opcion_codigo").focus();
		}
		else{
			alertify.error("Campo Vacio");
			$("#opcion_codigo").focus();
		}

	});

	$("#modificar").click(function(){

		var codigo = $("#opcion_codigo").val();

		if( codigo.length == 4 ){
			var mensaje = $("#msj-consulta").is(":visible");
			
			if( !mensaje ){	
				alertify.confirm("Do you want to modify the telephone code?", function(c){
					if(c){
						modificarCodigoTelefonico();
					}
				});
			}
			else{
				alertify.error("This telephone code is already registered");
			}
		}
		else if( codigo.length > 4 || ( codigo.length > 1 && codigo.length < 3) ){
			alertify.error("This field only accepts 4 numbers");
			$("#opcion_codigo").focus();
		}
		else{
			alertify.error("Campo Vacio");
			$("#opcion_codigo").focus();
		}
	});

	$("#eliminar").click(function(){
		alertify.confirm("Do you want to delete this telephone code?", function(c){
			if(c){
				eliminarCodigoTelefonico();
			}
		});	
	});

	$("#opcion_codigo").keyup(function () {

		consultarCodigoTelefonico();

	});

	//Cada vez que se deje pulsado .seleccion por 750ms
	$(document).on("taphold", ".seleccion", function(){
		var id     = $(this).attr("id");
		var nombre = $(this).text();

		$("#id_codigo_tele").val(id);
		$("#opcion_codigo").val(nombre);

		desactivarIncluir();
	});

	//Desactivo el sombreado y seleccion
	$("#cuerpo-tabla-maestro").disableSelection();
});

function consultarCodigoTelefonico(){
	var id_codigo_tele, opcion_codigo;

	id_codigo_tele = $("#id_codigo_tele").val();
	opcion_codigo = $("#opcion_codigo").val();

	var codigo_telefonico = {
		id_codigo_teleCT : id_codigo_tele,
		opcion_codigoCT : opcion_codigo
	}

	$.ajax({
		url: "../controlador/gestionar_codigo_telefonico.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultar="+JSON.stringify(codigo_telefonico),
		success: verificarConsulta,
		error: function(){ alertify.error("Error"); }
	});
}

function incluirCodigoTelefonico(){

	var opcion_codigo;
	
	opcion_codigo = $("#opcion_codigo").val();

	$.ajax({
		url: "../controlador/gestionar_codigo_telefonico.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "incluir="+opcion_codigo,
		success: emitirResultado,
		error: function(){ alertify.error("Error saving telephone code"); }
        	
	});
}

function modificarCodigoTelefonico(){

	var id_codigo_tele, opcion_codigo;

	id_codigo_tele = $("#id_codigo_tele").val();
	
	opcion_codigo = $("#opcion_codigo").val();

	var codigo_telefonico = {
		id_codigo_teleCT : id_codigo_tele,
		opcion_codigoCT : opcion_codigo
	}

	$.ajax({
		url: "../controlador/gestionar_codigo_telefonico.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "modificar="+JSON.stringify(codigo_telefonico),
		success: emitirResultado,
		error: function(){ alertify.error("Error modifing telephone code"); }
        	
	});
}

function eliminarCodigoTelefonico(){

	var id_codigo_tele;

	id_codigo_tele = $("#id_codigo_tele").val();

	$.ajax({
		url: "../controlador/gestionar_codigo_telefonico.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "eliminar="+id_codigo_tele,
		success: emitirResultado,
		error: function(){ alertify.error("Error deleting telephone code"); }
        	
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

		limpiarCamposCodigoTelefonico(id = ['id_codigo_tele', 'opcion_codigo']);

		busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_codigo_telefonico.php', 'consultaAvanzada');
}

//Limpia los campos
function limpiarCamposCodigoTelefonico(input){

	for(i=0; i<input.length; i++){
		document.getElementById(input[i]).value = "";
	}

	$("#msj-consulta").hide();

	activarIncluir();

}

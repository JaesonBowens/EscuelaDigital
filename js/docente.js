$(document).ready(function(){	
	var ced;
	busquedaAvanzadaDocente();

	$("#consultar").click(function(){

		ced = $("#cedula").val();

		if( ced.length != 0 ){
			consultarDocente(ced);
		}
		else{
			alertify.error("Enter the I.D. Number of the teacher that you wish to consult");
		}
	});

	$("#incluir").click(function(){
		
		if(validarCampoVacio(id = ['cedula', 'nombre', 'apellido', 'nombre_usuario', 'clave_usuario', 'id_tipo_usuario', 'estatus', 'asignado']) != false){

			if( validarClaveUsuario() == false ){
				var msj = $("#msj-p-dos-A").text();

				alertify.error(msj);
			}else if( $("#msj-consulta-uno").is(":visible") ){
				var msj = $("#msj-consulta-uno").text();

				alertify.error(msj);
			}
			else{
				alertify.confirm("Do you want to save the teacher´s data?", function(c){
					if(c){

						$("#form_accion").val("incluir");
				
						realizarFormAccion();
					}
				});
			}
			
		}
	});

	$("#modificar").click(function(){
		if(validarCampoVacio(id = ['id_docente', 'cedula', 'nombre', 'apellido', 'id_usuario', 'nombre_usuario', 'clave_usuario', 'id_tipo_usuario', 'estatus', 'asignado']) != false){

			if( validarClaveUsuario() == false ){
				var msj = $("#msj-p-dos-A").text();

				alertify.error(msj);
			}else if( $("#msj-consulta-uno").is(':visible') ){
				var msj = $("#msj-consulta-uno").text();

				alertify.error(msj);
			}
			else{
				alertify.confirm("Do you want to update the teacher´s data?", function(c){
					if(c){

						$("#form_accion").val("modificar");
				
						realizarFormAccion();
					}
				});
			}
		}
	});

	$("#eliminar").click(function(){
		
		
			alertify.confirm("Do you want to delete the teacher´s data?", function(c){
				if(c){

					$("#form_accion").val("eliminar");
			
					realizarFormAccion();
				}
			});
	
	});

	$("#activar").click(function(){
		
		if(validarCampoVacio(id = ['id_docente', 'cedula', 'nombre', 'apellido', 'id_usuario', 'nombre_usuario', 'clave_usuario', 'id_tipo_usuario', 'estatus', 'asignado']) != false){

			if($("#id_codigo_tele").val() == "" && $("#numero").val() != ""){

				alertify.error("You must select the telephone code");

			}else if($("#id_codigo_tele").val() != "" && $("#numero").val() == ""){

				alertify.error("You must enter the teacher´s telephone number");

			}else if( validarClaveUsuario() == false ){
				var msj = $("#msj-p-dos-A").text();

				alertify.error(msj);
			}else if( $("#msj-consulta-uno").is(':visible') ){
				var msj = $("#msj-consulta-uno").text();

				alertify.error(msj);
			}
			else{

				$("#form_accion").val("activar");
	
				realizarFormAccion();
			}
		}
	});

	
	$("#clave_usuario").keyup(function(){

		if($("#clave_usuario").val() != " "){

			validarClaveUsuario();

		}

	});

	$("#nombre_usuario").keyup(function(){

		var nombre_usuario = $("#nombre_usuario").val();

		var id_usuario = $("#id_usuario").val();

		verificarNombreUsuario(id_usuario, nombre_usuario);

	});

	//Cada vez que se deje pulsado .seleccion por 750ms
	$(document).on("taphold", ".seleccion", function(){
		var cedula = $(this).find("td").eq(0).text();

		seleccionDocente(cedula);
	});

	$(document).on("dblclick", ".seleccion", function(){
		var cedula = $(this).find("td").eq(0).text();

		seleccionDocente(cedula);
	});
	
	$(".seleccion").dblclick(function(){
		var cedula = $(this).find("td").eq(0).text();

		seleccionDocente(cedula);
	});

	$("#cuerpo-tabla-maestro").disableSelection();

});


function realizarFormAccion(){

	var accion = $("#form_accion").val()

	if(accion == "incluir"){
		incluirDocente();
	}else if(accion == "modificar"){
		modificarDocente();
	}else if(accion == "eliminar"){
		eliminarDocente();
	}else if(accion == "activar"){
		activarDocente();
	}

}

function validarCampoVacio(input){

	var campo_vacio_valido = true;

	for(i=0; i<input.length; i++){

		var campo = document.getElementById(input[i]).value;

		if(campo.length < 1){
			if( input[i] == "nombre" ){
				alertify.error("You must enter the teacher´s name");
			}
			else if( input[i] == "apellido" ){
				alertify.error("You must enter the teacher´s surname");
			}
			else if( input[i] == "nombre_usuario" ){
				alertify.error("You must enter the teacher´s user name");
			}
			else if( input[i] == "clave_usuario" ){
				alertify.error("You must enter the user´s password");
			}
			else if( input[i] == "id_tipo_usuario" ){
				alertify.error("You must select the type of user");
			}

			document.getElementById(input[i]).focus();
			campo_vacio_valido = false;
			return campo_vacio_valido;
		}
		
	}

}

function verificarNombreUsuario(id_usuario, nombre_usuario){

	var usuario = {
		id_usuarioU : id_usuario,
		nombre_usuarioU : nombre_usuario
	}

	$.ajax({
		url: "../controlador/gestionar_usuario.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "verificarNombreUsuario="+JSON.stringify(usuario),
		success: verificarConsultaNombreUsuario,
		error: function(){ alertify.error("Error"); }
	});
}

function verificarConsultaNombreUsuario(dato){
	if(dato.resultado == 'ALREADY EXIST'){
		$("#msj-consulta-uno").show();
		document.getElementById('msj-p-uno').innerHTML = dato.msj;
		return false;
	}else if(dato.resultado == 'DON´T EXIST'){
		$("#msj-consulta-uno").hide();
	}
}

//Recivimos lo que se va a buscar, el id del div donde se colocara la informacion
//y la direccion del controlador donde se ejecutara la busqueda
function busquedaAvanzadaDocente(){

	var buscar_estatus, buscar_cedula, buscar_nombre, buscar_apellido;

	if($('#estatus1').is(':checked')) { 
		buscar_estatus = $('#estatus1').val(); 
	}else if($('#estatus2').is(':checked')){
		buscar_estatus = $('#estatus2').val(); 
	}else if($('#estatus3').is(':checked')){
		buscar_estatus = $('#estatus3').val(); 
	}

	buscar_cedula = $("#buscar_cedula").val(),
	buscar_nombre = $("#buscar_nombre").val(),
	buscar_apellido = $("#buscar_apellido").val()

	var buscar = {
		cedula : buscar_cedula,
		nombre : buscar_nombre,
		apellido : buscar_apellido,
		estatus : buscar_estatus
	}

	$.ajax({
		url: "../controlador/gestionar_docente.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultaAvanzada="+JSON.stringify(buscar),
		success: mostrarConsultaAvanzada,
		error: function(){ alertify.error("Error"); }
	});
}

function mostrarConsultaAvanzada(data){
	$("#cuerpo-tabla-maestro tr").remove();

	if( data.contador != 0 ){
		for( var i = 0; i < data.contador; i++ ){
			if( data.contador > 6 ){
				var fila = "<tr class='seleccion' title='Double Click on the teacher that you desire to modify' >";
				fila += "<td width='150px'>"+data.cedula[i]+"</td>";
				fila += "<td width='230px'>"+data.nombre[i]+"</td>";
				fila += "<td width='230px'>"+data.apellido[i]+"</td>";

				if(data.estatus[i] == 'A'){
					fila += "<td width='185px'>ACTIVE</td>";
				}else if(data.estatus[i] == 'I'){
					fila += "<td width='185px'>NO ACTIVE</td>";
				}
				fila += "</tr>";
			}
			else{
				var fila = "<tr class='seleccion' title='Double Click on the teacher that you desire to modify' >";
				fila += "<td width='150px'>"+data.cedula[i]+"</td>";
				fila += "<td width='230px'>"+data.nombre[i]+"</td>";
				fila += "<td width='230px'>"+data.apellido[i]+"</td>";

				if(data.estatus[i] == 'A'){
					fila += "<td width='200px'>ACTIVE</td>";
				}else if(data.estatus[i] == 'I'){
					fila += "<td width='200px'>NOT ACTIVE</td>";
				}
				fila += "</tr>";
			}

			$("#cuerpo-tabla-maestro").append(fila);
		}
	}

	if( data.contador > 1 ){
		$("#total").text("Total of "+data.contador+" teachers found");
	}
	else if( data.contador == 1 ){
		$("#total").text("Total of "+data.contador+" teachers found");
	}
	else{
		$("#total").text("Total of 0 teachers found");
	}
}

function seleccionDocente(cedula){

	limpiarCamposDocente(id = ['id_docente', 'cedula', 'nombre', 'apellido', 'id_codigo_tele', 'id_telefono', 'numero', 'id_usuario', 'nombre_usuario', 'clave_usuario', 'id_tipo_usuario', 'estatus', 'asignado', 'id_grado', 'id_seccion']);

	var ced = cedula;

	consultarDocente(ced);

	redireccionar('#form-maestro');
}

function consultarDocente(ced){
	$.ajax({
		url: "../controlador/gestionar_docente.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultar="+ced,
		success: verificarConsulta,
		error: function(){ alertify.error("Error"); }
	});
}

function incluirDocente(){
	var cedula, nombre, apellido, id_codigo_tele, numero;
	var id_sector, nombre_usuario, clave_usuario, id_tipo_usuario;
	
	cedula = $("#cedula").val();
	nombre = $("#nombre").val();
	apellido = $("#apellido").val();
	id_codigo_tele = $("#id_codigo_tele").val();
	numero = $("#numero").val();
	nombre_usuario = $("#nombre_usuario").val();
	clave_usuario = $("#clave_usuario").val();
	id_tipo_usuario = $("#id_tipo_usuario").val();

	var docente = {
		cedulaD : cedula,
		nombreD : nombre,
		apellidoD : apellido,
		id_codigo_teleD : id_codigo_tele,
		numeroD : numero,
		nombre_usuarioD : nombre_usuario,
		clave_usuarioD : clave_usuario,
		id_tipo_usuarioD : id_tipo_usuario
	}

	$.ajax({
		url: "../controlador/gestionar_docente.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "incluir="+JSON.stringify(docente),
		success: emitirResultado,
		error: function(){ alertify.error("Error saving teacher´s data, consult your technical support or data base provider"); }
        	
	});
}

function modificarDocente(){
	var id_docente, cedula, nombre, apellido, id_telefono, id_codigo_tele, numero;
	var id_usuario, nombre_usuario, clave_usuario, id_tipo_usuario;

	id_docente = $("#id_docente").val();
	cedula = $("#cedula").val();
	nombre = $("#nombre").val();
	apellido = $("#apellido").val();
	id_telefono = $("#id_telefono").val();
	id_codigo_tele = $("#id_codigo_tele").val();
	numero = $("#numero").val();
	id_usuario = $("#id_usuario").val();
	nombre_usuario = $("#nombre_usuario").val();
	clave_usuario = $("#clave_usuario").val();
	id_tipo_usuario = $("#id_tipo_usuario").val();
	
	var docente = {
		id_docenteD : id_docente,
		cedulaD : cedula,
		nombreD : nombre,
		apellidoD : apellido,
		id_telefonoD : id_telefono,
		id_codigo_teleD : id_codigo_tele,
		numeroD : numero,
		id_usuarioD : id_usuario,
		nombre_usuarioD : nombre_usuario,
		clave_usuarioD : clave_usuario,
		id_tipo_usuarioD : id_tipo_usuario
	}

	$.ajax({
		url: "../controlador/gestionar_docente.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "modificar="+JSON.stringify(docente),
		success: emitirResultado,
		error: function(){ alertify.error("Error modifing teacher´s data, consult your technical support or data base provider"); }
        	
	});
}

function eliminarDocente(){

	var id_docente = $("#id_docente").val();

	$.ajax({
		url: "../controlador/gestionar_docente.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "eliminar="+id_docente,
		success: emitirResultado,
		error: function(){ alertify.error("Error"); }
	});
}

function activarDocente(){

	var id_docente = $("#id_docente").val();

	$.ajax({
		url: "../controlador/gestionar_docente.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "activar="+id_docente,
		success: emitirResultado,
		error: function(){ alertify.error("Error"); }
	});
}

function verificarConsulta(dato){
	if(typeof dato.id_docente != 'undefined'){
		mostrarConsulta(dato);
		activarCamposDocente();
		
	}else{
		alertify.alert("I.D. Number not found!");
		activarCamposDocente();
		$("#estatus").val('ACTIVE');
		$("#asignado").val('NO');

		document.getElementById("incluir").hidden   = "";
		document.getElementById("consultar").hidden = "hidden";
		document.getElementById("activar").hidden   = "hidden";
		document.getElementById("modificar").hidden = "hidden";
		document.getElementById("eliminar").hidden  = "hidden";
	}
}

function mostrarConsulta(dato){

	$("#id_docente").val(dato.id_docente);
	$("#cedula").val(dato.cedula);

	$("#nombre").val(dato.nombre);

	$("#apellido").val(dato.apellido);

	if(dato.id_telefono != "NULL"){
		$("#id_telefono").val(dato.id_telefono);

		$("#id_codigo_tele").val(dato.id_codigo_tele);

		$("#numero").val(dato.numero);
	}

	$("#nombre_usuario").val(dato.nombre_usuario);//

	$("#estatus").val(dato.estatus);

	$("#asignado").val(dato.asignado);

	if(dato.asignado == 'YES'){

		$("#asignado-label-grado").show();

		$("#asignado-label-seccion").show();

		$("#id_grado").val(dato.id_grado);

		cargarSeccionSeleccion(dato.id_grado, dato.id_seccion);
	}

	$("#id_usuario").val(dato.id_usuario);

	$("#nombre_usuario").val(dato.nombre_usuario);

	$("#clave_usuario").val(dato.clave_usuario);

	$("#id_tipo_usuario").val(dato.id_tipo_usuario);
	
	document.getElementById("consultar").hidden = "hidden";
		document.getElementById("incluir").hidden   = "hidden";

		if(dato.estatus == 'ACTIVE'){
			document.getElementById("modificar").hidden = "";
			document.getElementById("activar").hidden   = "hidden";
			document.getElementById("eliminar").hidden  = "";
		}else if(dato.estatus == 'NOT ACTIVE'){
			document.getElementById("activar").hidden   = "";
			document.getElementById("modificar").hidden = "hidden";
			document.getElementById("eliminar").hidden  = "hidden";
		}
			
}

function emitirResultado(dato){

		alertify.alert(dato.msj);

		limpiarCamposDocente(id = ['id_docente', 'cedula', 'nombre', 'apellido', 'id_codigo_tele', 'id_telefono', 'numero', 'id_usuario', 'nombre_usuario', 'clave_usuario', 'id_tipo_usuario', 'estatus', 'asignado', 'id_grado', 'id_seccion']);


		busquedaAvanzadaDocente(' ', 'listado-catalogo', '../controlador/gestionar_docente.php', 'consultaAvanzada');
}

//Limpia los campos solo del estudiante
function limpiarCamposDocente(input){

	for(i=0; i<input.length; i++){
		document.getElementById(input[i]).value = "";
		
		if(input[i] == "cedula"){
			document.getElementById(input[i]).disabled = '';
		}
		else{
			document.getElementById(input[i]).disabled = 'disabled';	
		}
	}

	document.getElementById("consultar").hidden   = "";
	document.getElementById("incluir").hidden   = "hidden";
	document.getElementById("activar").hidden   = "hidden";
	document.getElementById("modificar").hidden = "hidden";
	document.getElementById("eliminar").hidden  = "hidden";

	if($("#asignado-label-grado").is(':visible')) {  
      		$("#asignado-label-grado").hide(); 
   	}; 

	if($("#asignado-label-seccion").is(':visible')) {  
      		$("#asignado-label-seccion").hide(); 
  };

	if($("#msj-consulta-dos-A").is(':visible')){
			$("#msj-consulta-dos-A").hide();
			document.getElementById('msj-p-dos-A').innerHTML = " ";
	}

}

function activarCamposDocente(){

	$("#cedula").attr('disabled', true);

	$("#nombre").attr('disabled', false);

	$("#apellido").attr('disabled', false);

	$("#id_codigo_tele").attr('disabled', false);

	$("#numero").attr('disabled', false);

	$("#nombre_usuario").attr('disabled', false);

	$("#clave_usuario").attr('disabled', false);

	$("#id_tipo_usuario").attr('disabled', false);

}

function validarClaveUsuario(){

    var clave_usuario_valido = true;

    if(document.getElementById("clave_usuario").value != ""){
				if(document.getElementById("clave_usuario").value.length < 6 || document.getElementById("clave_usuario").value.length > 15) {
						clave_usuario_valido = false;
						$("#msj-consulta-dos-A").show();
						document.getElementById('msj-p-dos-A').innerHTML = "&#x2718; The password must contain atleast 6 characters!";
        		return clave_usuario_valido;
      	}else{
						$("#msj-consulta-dos-A").hide();
						document.getElementById('msj-p-dos-A').innerHTML = " ";
				}

				if(document.getElementById("clave_usuario").value == document.getElementById("nombre_usuario").value) {
						clave_usuario_valido = false;
						$("#msj-consulta-dos-A").show();
						document.getElementById('msj-p-dos-A').innerHTML = "&#x2718; The password must be different to the user name!";
        		return clave_usuario_valido;
    		}else{
						$("#msj-consulta-dos-A").hide();
						document.getElementById('msj-p-dos-A').innerHTML = " ";
				}
    }else{

				clave_usuario_valido = false;

				return clave_usuario_valido

    }
}


$(document).ready(function(){	
	
	busquedaAvanzadaEstudiante();

	$("#incluir").click(function(){

		if(validarCampoVacio(id = ['nombre', 'apellido', 'fecha_nac', 'edad', 'id_discapacidad', 'estatus', 'asignado']) != false){

			$("#form_accion").val("incluir");
			realizarFormAccion();
			
		}else{
			
		}
	});

	$("#modificar").click(function(){
		
		if(validarCampoVacio(id = ['id_estudiante', 'nombre', 'apellido', 'fecha_nac', 'edad', 'id_discapacidad', 'estatus', 'asignado']) != false){

				alertify.confirm("Do you want to modify the student´s record?", function(c){
					if(c){

						$("#form_accion").val("modificar");
						realizarFormAccion();
			
					}
				});
	
		}
	});

	$("#eliminar").click(function(){
			alertify.confirm("Do you want to delete the student´s record?", function(c){
				if(c){

					$("#form_accion").val("eliminar");
					realizarFormAccion();
			
				}
			});
	});

	$("#activar").click(function(){
		
		if(validarCampoVacio(id = ['id_estudiante', 'nombre', 'apellido', 'fecha_nac', 'edad', 'id_codigo_tele', 'id_telefono', 'numero', 'id_discapacidad', 'estatus', 'asignado']) != false){


				$("#form_accion").val("activar");
				realizarFormAccion();
		
		}
	});

	$("#anadir-discapacidad").click(function(){
		anadirDiscapacidad();
	});

	//Cada vez que se deje pulsado .seleccion por 750ms
	$(document).on("taphold", ".seleccion", function(){

		var id_estudiante = $(this).find("td").eq(0).text();

		seleccionEstudiante(id_estudiante);
	});

	$(document).on("dblclick", ".seleccion", function(){
		var id_estudiante = $(this).find("td").eq(0).text();

		seleccionEstudiante(id_estudiante);
	});
	
	$(".seleccion").on("tap",function(){
		var id_estudiante = $(this).find("td").eq(0).text();

		seleccionEstudiante(id_estudiante);
	});

	$("#cuerpo-tabla-maestro").disableSelection();
});

function realizarFormAccion(){

	var accion = $("#form_accion").val()

	if(accion == "incluir"){
		incluirEstudiante();
	}else if(accion == "modificar"){
		modificarEstudiante();
	}else if(accion == "eliminar"){
		eliminarEstudiante();
	}else if(accion == "activar"){
		activarEstudiante();
	}

}

function anadirDiscapacidad(){
	alertify.prompt("Enter the name of the discapacity", function(c, discapacidad){
		if( c && discapacidad.length > 1 ){
			$.ajax({
				url: "../controlador/gestionar_discapacidad.php",
				type: "POST",
				async: true,
				dataType: "json",
				data: "incluirNuevaDiscapacidad="+discapacidad,
				success: function(dato){
					if( dato.resultado == "SUCCESSFUL" ){
						alertify.alert(dato.msj);

						var option = "<option value="+dato.id_discapacidad+">";
						option += dato.nombre_discapacidad;
						option += "</option>";

						$("#id_discapacidad").append(option);
						$("#id_discapacidad").val(dato.id_discapacidad);
					}
					else{
						alertify.error(dato.msj);	
					}
				},
				error: function(){ alertify.error("Error"); }
			});
		}
		else if( discapacidad.length == 0 ){
			alertify.error("Empty Field");
			anadirDiscapacidad();
		}
		else if( discapacidad.length == 1 ){
			alertify.error("The field must contain more than 1 character");
			anadirDiscapacidad();
		}
	});
}

function validarCampoVacio(input){

	var campo_vacio_valido = true;

	for(i=0; i<input.length; i++){

		var campo = document.getElementById(input[i]).value;

		if(campo.length < 1){
			if( input[i] == "nombre" ){
				alertify.error("You must enter the student´s name");
			}
			else if( input[i] == "apellido" ){
				alertify.error("You must enter the student´s surname");
			}
			else if( input[i] == "fecha_nac" ){
				alertify.error("You must enter the student´s date of birth");
			}
			else if( input[i] == "id_discapacidad" ){
				alertify.error("You must enter the student´s discapacity");
			}
			

			document.getElementById(input[i]).focus();
			console.log(document.getElementById(input[i]));
			campo_vacio_valido = false;
			return campo_vacio_valido;
		}
		
	}

	if($('#sexo1').is(':checked') || $('#sexo2').is(':checked')) { 
		campo_vacio_valido = true
	}else{
		alertify.error("You must select the student´s sex");
		campo_vacio_valido = false;
		return campo_vacio_valido;
	}
}

//Recivimos lo que se va a buscar, el id del div donde se colocara la informacion
//y la direccion del controlador donde se ejecutara la busqueda
function busquedaAvanzadaEstudiante(){

	var buscar_estatus, buscar_nombre, buscar_apellido;

	if($('#estatus1').is(':checked')) { 
		buscar_estatus = $('#estatus1').val(); 
	}else if($('#estatus2').is(':checked')){
		buscar_estatus = $('#estatus2').val(); 
	}else if($('#estatus3').is(':checked')){
		buscar_estatus = $('#estatus3').val(); 
	}

	buscar_nombre = $("#buscar_nombre").val(),
	buscar_apellido = $("#buscar_apellido").val()

	var buscar = {
		nombre : buscar_nombre,
		apellido : buscar_apellido,
		estatus : buscar_estatus
	}



	$.ajax({
		url: "../controlador/gestionar_estudiante.php",
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
				
				var fila = "<tr class='seleccion' title='Select the student that you want to modify' >";
			
				fila += "<td width='20px' hidden>"+data.id_estudiante[i]+"</td>";
				fila += "<td width='230px'>"+data.nombre[i]+"</td>";
				fila += "<td width='230px'>"+data.apellido[i]+"</td>";
				fila += "<td width='150px'>"+data.sexo[i]+"</td>";

				if(data.estatus[i] == 'A'){
					fila += "<td width='140px'>ACTIVE</td>";
				}else if(data.estatus[i] == 'I'){
					fila += "<td width='140px'>NOT ACTIVE</td>";
				}
				fila += "</tr>";
			}
			else{
				var fila = "<tr class='seleccion' title='Select the student that you want to modify' >";
				fila += "<td width='20px' hidden>"+data.id_estudiante[i]+"</td>";
				fila += "<td width='230px'>"+data.nombre[i]+"</td>";
				fila += "<td width='230px'>"+data.apellido[i]+"</td>";
				fila += "<td width='150px'>"+data.sexo[i]+"</td>";

				if(data.estatus[i] == 'A'){
					fila += "<td width='145px'>ACTIVE</td>";
				}else if(data.estatus[i] == 'I'){
					fila += "<td width='145px'>NOT ACTIVE</td>";
				}
				fila += "</tr>";
			}

			$("#cuerpo-tabla-maestro").append(fila);
		}
	}
 
	if( data.contador > 1 ){
		$("#total").text("Total of "+data.contador+" Students Found");
	}
	else if( data.contador == 1 ){
		$("#total").text("Total of "+data.contador+" Students Found");
	}
	else{
		$("#total").text("Total of 0 Students Found");
	}
}

function seleccionEstudiante(id_estudiante){
	
	limpiarCamposEstudiante(id = ['id_estudiante', 'nombre', 'apellido', 'fecha_nac', 'edad', 'id_codigo_tele', 'id_telefono', 'numero', 'id_discapacidad', 'estatus']);

	consultarIdEstudiante(id_estudiante);

	redireccionar('#form-maestro');
}

function consultarIdEstudiante(id_estudiante){
	$.ajax({
		url: "../controlador/gestionar_estudiante.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultarPorId="+id_estudiante,
		success: verificarConsulta,
		error: function(){ alertify.error("Error"); }
	});
}

function incluirEstudiante(){
	var nombre, apellido, fecha_nac, sexo;
	var id_codigo_tele, numero, id_discapacidad;
	

	nombre = $("#nombre").val();
	apellido = $("#apellido").val();
	fecha_nac = $("#fecha_nac").val();

	if($('#sexo1').is(':checked')) { 
		sexo = $('#sexo1').val(); 
	}else if($('#sexo2').is(':checked')){
		sexo = $('#sexo2').val(); 
	}

	id_codigo_tele = $("#id_codigo_tele").val();
	numero = $("#numero").val();
	id_discapacidad = $("#id_discapacidad").val();

	var estudiante = {
		nombreEst : nombre,
		apellidoEst : apellido,
		fecha_nacEst : fecha_nac,
		sexoEst : sexo,
		id_codigo_teleEst : id_codigo_tele,
		numeroEst : numero,
		id_discapacidadEst : id_discapacidad
	}

	$.ajax({
		url: "../controlador/gestionar_estudiante.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "incluir="+JSON.stringify(estudiante),
		success: emitirResultado,
		error: function(){ alertify.error("Error saving student´s data"); }
        	
	});
}

function modificarEstudiante(){
	var id_estudiante, nombre, apellido, fecha_nac, sexo;
	var id_telefono, id_codigo_tele, numero, id_discapacidad;

	id_estudiante = $("#id_estudiante").val();

	nombre = $("#nombre").val();
	apellido = $("#apellido").val();
	fecha_nac = $("#fecha_nac").val();

	if($('#sexo1').is(':checked')) { 
		sexo = $('#sexo1').val(); 
	}else if($('#sexo2').is(':checked')){
		sexo = $('#sexo2').val(); 
	}

	id_telefono = $("#id_telefono").val();
	id_codigo_tele = $("#id_codigo_tele").val();
	numero = $("#numero").val();
	id_discapacidad = $("#id_discapacidad").val();

	var estudiante = {
		id_estudianteEst: id_estudiante,
		nombreEst : nombre,
		apellidoEst : apellido,
		fecha_nacEst : fecha_nac,
		sexoEst : sexo,
		id_telefonoEst :id_telefono,
		id_codigo_teleEst : id_codigo_tele,
		numeroEst : numero,
		id_discapacidadEst : id_discapacidad
	}

	$.ajax({
		url: "../controlador/gestionar_estudiante.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "modificar="+JSON.stringify(estudiante),
		success: emitirResultado,
		error: function(){ alertify.error("Error modifing student´s data"); }
        	
	});
}

function eliminarEstudiante(){

	var id_estudiante = $("#id_estudiante").val();

	$.ajax({
		url: "../controlador/gestionar_estudiante.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "eliminar="+id_estudiante,
		success: emitirResultado,
		error: function(){ alertify.error("Error deleting student´s data"); }
	});
}

function activarEstudiante(){

	var id_estudiante = $("#id_estudiante").val();

	$.ajax({
		url: "../controlador/gestionar_estudiante.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "activar="+id_estudiante,
		success: emitirResultado,
		error: function(){ alertify.error("Error activating student´s record"); }
	});
}

function verificarConsulta(dato){
	//activarCamposEstudiante();

	if(typeof dato.id_estudiante != 'undefined'){
		mostrarConsulta(dato);

		document.getElementById("incluir").hidden   = "hidden";

		if(dato.estatus == 'ACTIVE'){

			document.getElementById("modificar").hidden = "";
			document.getElementById("activar").hidden   = "hidden";
			document.getElementById("eliminar").hidden  = "";
		}else if(dato.estatus == 'NOT ACTIVE'){
			document.getElementById("anadir-discapacidad").hidden = "hidden";

			document.getElementById("activar").hidden   = "";
			document.getElementById("modificar").hidden = "hidden";
			document.getElementById("eliminar").hidden  = "hidden";
		}
	}else{
		alertify.alert("¡Student not found!");

		$("#estatus").val('ACTIVE');
		$("#asignado").val('NO');

		document.getElementById("anadir-discapacidad").hidden = "";

		document.getElementById("incluir").hidden   = "";
		document.getElementById("activar").hidden   = "hidden";
		document.getElementById("modificar").hidden = "hidden";
		document.getElementById("eliminar").hidden  = "hidden";
	}
}

function mostrarConsulta(dato){
	//Mostramos los datos del estudiante
	$("#id_estudiante").val(dato.id_estudiante);

	$("#nombre").val(dato.nombre);

	$("#apellido").val(dato.apellido);

	$("#fecha_nac").val(dato.fecha_nac);

	$("#edad").val(dato.edad);

	if(dato.sexo == "F"){
		$("#sexo1").prop("checked", "checked");
	}else if(dato.sexo == "M"){
		$("#sexo2").prop("checked", "checked");
	}

	if(dato.id_telefono != ""){
		$("#id_telefono").val(dato.id_telefono);

		$("#id_codigo_tele").val(dato.id_codigo_tele);

		$("#numero").val(dato.numero);
	}

	$("#id_discapacidad").val(dato.id_discapacidad);

	$("#estatus").val(dato.estatus);

	$("#asignado").val(dato.asignado);

	if(dato.asignado == 'YES'){

		$('#asignado-label-grado').show();

		$('#asignado-label-seccion').show();

		$("#id_grado").val(dato.id_grado);

		cargarSeccionSeleccion(dato.id_grado, dato.id_seccion);
	}
			
}

function emitirResultado(dato){
		alertify.alert(dato.msj);

		limpiarCamposEstudiante(id = ['id_estudiante', 'nombre', 'apellido', 'fecha_nac', 'edad', 'id_codigo_tele', 'id_telefono', 'numero', 'id_discapacidad',  'estatus', 'asignado', 'id_grado', 'id_seccion']);

		busquedaAvanzadaEstudiante();
}


//Limpia los campos solo del estudiante
function limpiarCamposEstudiante(input){
	for(i=0; i<input.length; i++){
		
		document.getElementById(input[i]).value = "";
		
	}

	$("#sexo1").prop("checked", "");
	$("#sexo2").prop("checked", "");

	document.getElementById("incluir").hidden   = "";
	document.getElementById("activar").hidden   = "hidden";
	document.getElementById("modificar").hidden = "hidden";
	document.getElementById("eliminar").hidden  = "hidden";

	  
  	if ($("#asignado-label-grado").is(':visible')) {  
      		$("#asignado-label-grado").hide(); 
   	}; 

	if ($("#asignado-label-seccion").is(':visible')) {  
      		$("#asignado-label-seccion").hide(); 
   	};

}

/*function activarCamposEstudiante(){

	$("#nombre").attr('disabled', true);

	$("#apellido").attr('disabled', true);

	$("#fecha_nac").attr('disabled', false);

	$("#edad").attr('disabled', false);

	$("#sexo1").attr('disabled', false);
	$("#sexo2").attr('disabled', false);

	$("#id_codigo_tele").attr('disabled', false);

	$("#numero").attr('disabled', false);

	$("#id_discapacidad").attr('disabled', false);
		
}*/


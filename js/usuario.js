$(document).ready(function(){
	cargarUsuario();

	$("#nombre_usuario").keyup(function(){

		var nombre_usuario = $("#nombre_usuario").val();

		var id_usuario = $("#id_usuario").val();

		verificarNombreUsuario(id_usuario, nombre_usuario);

	});

	$("#clave_usuario").keyup(function(){

		if($("#clave_usuario").val() != " "){

			validarClaveUsuario();

		}

	});

	$("#clave_usuario_repetida").keyup(function() {

		var repetir = $("#clave_usuario_repetida").val();
		
		if(repetir.length >= 1){
        		validarClaveRepetida();
		}else{
			$("#msj-consulta-tres").hide(); 
			document.getElementById('msj-p-tres').innerHTML = " ";
		}
		
   	});

	$("#modificar").click(function() {
		var id_usuario = $("#id_usuario").val();
		var nombre_usuario = $("#nombre_usuario").val();
		var clave_usuario = $("#clave_usuario").val();
		var clave_usuario_repetida = $("#clave_usuario_repetida").val();

		if(validarCampoVacio(id = ['id_usuario', 'nombre_usuario', 'clave_usuario', 'clave_usuario_repetida']) != false){
			
        		if(validarClaveRepetida() == false && validarClaveUsuario() == false){
				
								alertify.error("Erroneous fields, please revise the form!");

						}else{
			
								/*var nombre_usuario = $("#nombre_usuario").val();

								var id_usuario = $("#id_usuario").val();*/

								//verificarNombreUsuario(id_usuario, nombre_usuario);
								alertify.confirm( "Do you want to modify the user´s data?", function(c){
									if(c){
										modificarUsuario();
									}
								});
						}	
		}
		else if( id_usuario.length == 0 ){
			alertify.error("Error to modify the user´s data, the ID can not be found");
		}
		else if( nombre_usuario.length == 0 && clave_usuario.length == 0 && clave_usuario_repetida.length == 0 ){
			alertify.error("You must fill in all of the fields");
			$("#nombre_usuario").focus();
		}
		else if( nombre_usuario.length == 0 ){
			alertify.error("You must enter user name");
			$("#nombre_usuario").focus();
		}
		else if( clave_usuario.length == 0 ){
			alertify.error("You must enter the user´s password");
			$("#clave_usuario").focus();
		}
		else if( clave_usuario_repetida.length == 0 ){
			alertify.error("You must repeat the user´s password");
			$("#clave_usuario_repetida").focus();
		}
   	});

	$("#cancelar").click(function() {

		$("#msj-consulta-uno").hide();

		$("#msj-consulta-dos-A").hide();

		$("#msj-consulta-tres").hide();

		cargarUsuario();	

   	});

});

function cargarUsuario(){
	var id_usuario = $("#id_usuario").val();

	$.ajax({
		url: "../controlador/gestionar_usuario.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultar="+id_usuario,
		success: mostrarUsuario,
		error: errorAjax
	});
}

function mostrarUsuario(dato){
	$("#nombre_usuario").val(dato.usuario[0]);
	$("#clave_usuario").val(dato.usuario[1]);
	$("#clave_usuario_repetida").val('');
}

function errorAjax(){
	alert("Error loading user´s data");
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
		success: verificarConsulta,
		error: function(){ alertify.error("Error"); }
	});
}

function modificarUsuario(){

	var id_usuario, nombre_usuario, clave_usuario;

	id_usuario = $("#id_usuario").val();
	
	nombre_usuario = $("#nombre_usuario").val();

	clave_usuario = $("#clave_usuario").val();

	var usuario = {
		id_usuarioU : id_usuario,
		nombre_usuarioU : nombre_usuario,
		clave_usuarioU : clave_usuario
	}

	$.ajax({
		url: "../controlador/gestionar_usuario.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "modificar="+JSON.stringify(usuario),
		success: emitirResultado,
		error: function(){ alertify.error("Error modifing user´s data"); }
        	
	});
}

function verificarConsulta(dato){
	if(dato.resultado == 'YA EXISTE'){
		$("#msj-consulta-uno").show();
		document.getElementById('msj-p-uno').innerHTML = dato.msj;
		return false;
	}else if(dato.resultado == 'DON´T EXIST'){
		$("#msj-consulta-uno").hide();
	}
}

function emitirResultado(dato){

		$("#msj-consulta-uno").hide();

		$("#msj-consulta-dos-A").hide();

		$("#msj-consulta-tres").hide();

		cargarUsuario();

		alertify.alert(dato.msj);

}

function validarClaveRepetida(){
	var clave_repetida_valido = true;
	var clave   = document.getElementById('clave_usuario');
	var repetir = document.getElementById('clave_usuario_repetida');

	if(repetir.value != ""){

		if(clave.value == repetir.value){

			clave_repetida_valido = false;

			$("#msj-consulta-tres").show();
			document.getElementById('msj-p-tres').innerHTML = "&#x2714; SAME";

			$( '#msj-p-tres' ).css({
   				color: 'green'
			});	

			return clave_repetida_valido;

		}else if(repetir.value != "" && clave.value != repetir.value){

			clave_repetida_valido = false;

			$("#msj-consulta-tres").show(); 
			document.getElementById('msj-p-tres').innerHTML = "&#x2718; THEY ARE THE SAME - The user´s password and the repeated password must be the same";

			$( '#msj-p-tres' ).css({
   				color: 'red'
			});
			
			return clave_repetida_valido;

		}else if(repetir.value == ""){
			
			clave_repetida_valido = false;

			$("#msj-consulta-tres").hide(); 
			document.getElementById('msj-p-tres').innerHTML = " ";

			return clave_repetida_valido;
		}
	}

}

function validarClaveUsuario(){

    var clave_usuario_valido = true;

    if(document.getElementById("clave_usuario").value != ""){
	if(document.getElementById("clave_usuario").value.length < 6 || document.getElementById("clave_usuario").value.length > 15) {
		clave_usuario_valido = false;
		$("#msj-consulta-dos-A").show();
		document.getElementById('msj-p-dos-A').innerHTML = "&#x2718; The password must contain atleast 6 characteres!";
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



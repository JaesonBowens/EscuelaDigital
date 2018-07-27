$(document).ready(function(){

	/*$("#nombre_usuario").keyup(function(){

		var username = '<%= Session["ses_id_estudiante"] %>';
        	alert(username );

	});*/

	$(document).on('keyup', function(e) {

		if (e.keyCode == 17){ //this is optional. Filtering the keycode only to what your combination has.
			
			$.ajax({
				url: "../controlador/estudiante_en_sesion.php",
				type: "POST",
				async: true,
				dataType: "json",
				data: "consultar=",
				success: mostrarNombreEstudiante,
				error: cargarError
			});
			
		}
		
	});

});

//Funcion para mosrar la actividad
function mostrarNombreEstudiante(data){

	//Recivimos las respuestas del Controlador
	
	nombre    = data.nombre;
	apellido  = data.apellido;

	alertify.log("SURNAME: "+apellido);
	alertify.log("NAME: "+nombre);
	alertify.log("- ASSIGNED STUDENT -");	
}

//Los que mostramos si la consulta Ajax no se ejecuto perfect
function cargarError(){
	alert("Error to request server´s information");
}


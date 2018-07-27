var nombre_actividad_validar = new Array;

var nombre_seccion_validar = new Array;

$(document).ready(function(){
	//Desactivo el sombreado y seleccion
	$("#cuerpo-tabla-maestro").disableSelection();
	$("#asig-actividad").disableSelection();
	$("#asig-contenido").disableSelection();
	$("#asig-agrupacion").disableSelection();
	$("#asig-sec-img").disableSelection();
	
	busquedaAvanzadaImagen('', 'listado-catalogo', '../controlador/gestionar_imagen.php', 'consultaAvanzada');

	var audioData = $('#id_tocar_audio').attr('src');

	if(audioData == ' '){
		$('#area_audio').show();
		$('#id_tocar_audio').hide();
		$('#quitar_audio').hide();
	}

	//Cada vez que seleccione una actividad
	$("#incluir").click(function(){
		var validada = validarAsignacion(nombre_actividad_validar);

		if(validada == true){
			nombre_actividad_validar = new Array;

			alertify.confirm("Do you want to save?", function(c){
				if(c){
					boton = document.getElementById("incluir");
					boton.type = "submit" ;
					boton.click();
				}
			});
		}
	});

	//Cada vez que seleccione una actividad
	$("#modificar").click(function(){
		var validada = validarAsignacion(nombre_actividad_validar);

		if(validada == true){
			nombre_actividad_validar = new Array;

			alertify.confirm("Do you want to modify?", function(c){
				if(c){
					boton = document.getElementById("modificar");
					boton.type = "submit" ;
					boton.click();
				}
			});
		}
	});

	$("#eliminar").click(function(){
		nombre_actividad_validar = new Array;

		alertify.confirm("Do you want to delete?", function(c){
			if(c){
				boton = document.getElementById("eliminar");
				boton.type = "submit" ;
				boton.click();
			}
		})
	});

	//Cada vez que seleccione una actividad
	$("#quitar_audio").click(function(){
			quitarAudio();
	});

		//Cada vez que seleccione una actividad
	$("#quitar_lng_sign").click(function(){
			quitarLenguajeSigno();
	});

	//Cada vez que seleccione una actividad
	$("#id_actividad").change(function(){
		//Optenemos el id y el nombre de la actividad o contenido
		var nombre = $("#id_actividad option:selected").text();
		var id     = $("#id_actividad option:selected").val();
		
		//Lo eliminamos del select
		$("#id_actividad option:selected").remove();

		asignarActividad(nombre, id, $("#id_area").val());

		nombre_actividad_validar.push(nombre);
	});

	//Cada vez que seleccione una actividad
	$("#id_seccion").change(function(){
		//Optenemos el id y el nombre de la actividad o contenido
		var nivel = $("#id_grado option:selected").text();
		var grupo = $("#id_seccion option:selected").text();
		var nombre = nivel+" "+grupo;
		var id     = $("#id_seccion option:selected").val();
		
		//Lo eliminamos del select
		$("#id_seccion option:selected").remove();

		asignarSeccion(nombre, id, $("#id_grado").val());

		nombre_seccion_validar.push(nombre);
	});

	//Cada vez que seleccione un contenido
	$("#id_contenido").change(function(){
		//Optenemos el id y el nombre de la actividad o contenido
		var nombre = $("#id_contenido option:selected").text();
		var id     = $("#id_contenido option:selected").val();
		
		//Lo eliminamos del select
		$("#id_contenido option:selected").remove();

		asignarContenido(nombre, id);
	});

	//Cada vez que seleccione una agrupacion
	$("#id_agrupacion").change(function(){
		//Optenemos el id y el nombre de la agrupacion
		var nombre = $("#id_agrupacion option:selected").text();
		var id     = $("#id_agrupacion option:selected").val();
		
		//Lo eliminamos del select
		$("#id_agrupacion option:selected").remove();

		asignarAgrupacion(nombre, id);
	});

	//Cada vez que seleccione una actividad a eliminar
	$(document).on("dblclick", ".actividadAsignado", function(){
		eliminarActividadAsignado($(this));
		var id = $(this).find("td").eq(0).find("input[name='id_actividad[]']").val();
		var nombre = $(this).find("td").eq(0).text();

		for(var i=0; i < nombre_actividad_validar.length; i++){
    			if (nombre_actividad_validar[i] == nombre){
      				nombre_actividad_validar.splice(i,1);
            			break;
           		}
		}

		alertify.log("The Activity \"" + nombre + "\" has been unassigned from the image");
	});

	$(document).on("taphold", ".actividadAsignado", function(){
		eliminarActividadAsignado($(this));
		var id = $(this).find("td").eq(0).find("input[name='id_actividad[]']").val();
		var nombre = $(this).find("td").eq(0).text();

		for(var i=0; i < nombre_actividad_validar.length; i++){
    			if (nombre_actividad_validar[i] == nombre){
      				nombre_actividad_validar.splice(i,1);
            			break;
           		}
		}

		alertify.log("The Activity \"" + nombre + "\" has been removed from the image");
	});


	//Cada vez que seleccione una actividad a eliminar
	$(document).on("dblclick", ".seccionAsignado", function(){
		eliminarSeccionAsignado($(this));
		var id = $(this).find("td").eq(0).find("input[name='id_seccion[]']").val();
		var nombre = $(this).find("td").eq(0).text();

		for(var i=0; i < nombre_seccion_validar.length; i++){
    			if (nombre_seccion_validar[i] == nombre){
      				nombre_seccion_validar.splice(i,1);
            			break;
           		}
		}

		alertify.log("The Section \"" + nombre + "\" has been removed from the image");
	});

	$(document).on("taphold", ".seccionAsignado", function(){
		eliminarSeccionAsignado($(this));
		var id = $(this).find("td").eq(0).find("input[name='id_seccion[]']").val();
		var nombre = $(this).find("td").eq(0).text();

		for(var i=0; i < nombre_seccion_validar.length; i++){
    			if (nombre_seccion_validar[i] == nombre){
      				nombre_seccion_validar.splice(i,1);
            			break;
           		}
		}

		alertify.log("The Section \"" + nombre + "\" has been removed from the image");
	});


	//Cada vez que seleccione un contenido a eliminar
	$(document).on("dblclick", ".contenidoAsignado", function(){
		eliminarContenidoAsignado($(this));
		
		var nombre = $(this).find("td").eq(0).text();

		alertify.log("The Content \"" + nombre + "\" has been removed from the image");
	});

	//Cada vez que deje pulsado un contenido a eliminar
	$(document).on("taphold", ".contenidoAsignado", function(){
		eliminarcontenidoAsignado($(this));
		
		var nombre = $(this).find("td").eq(0).text();

		alertify.log("The Content \"" + nombre + "\" has been removed from the image");
	});


	//Cada vez que seleccione un agrupacion a eliminar
	$(document).on("dblclick", ".agrupacionAsignado", function(){
		eliminarAgrupacionAsignado($(this));
		
		var nombre = $(this).find("td").eq(0).text();

		alertify.log("The Grouping \"" + nombre + "\" has been removed from the image");
	});

	//Cada vez que deje pulsado un contenido a eliminar
	$(document).on("taphold", ".agrupacionAsignado", function(){
		eliminarAgrupacionAsignado($(this));
		
		var nombre = $(this).find("td").eq(0).text();

		alertify.log("The Grouping \"" + nombre + "\" has been removed from the image");
	});

	$(document).on("dblclick", ".seleccionFila", function(){
		var id = $(this).find("td").eq(0).find("input[name='id_imagen']").val();

		cargarModificar(id);

		redireccionar("#form-maestro");
	});

	$(document).on("taphold", ".seleccionFila", function(){
		var id = $(this).find("td").eq(0).find("input[name='id_imagen']").val();

		cargarModificar(id);

		redireccionar("#form-maestro");
	});

	$("#id_area").change(function(){
		$.ajax({
			url: "../cabecera/campos_de_seleccion/actividad.php",
			type: "POST",
			async: true,
			dataType: "json",
			data: "consultarIdArea="+$(this).val(),
			success: cargarActividad
		});
	});

	$("#id_grado").change(function(){
		$.ajax({
			url: "../cabecera/campos_de_seleccion/seccion.php",
			type: "POST",
			async: true,
			dataType: "json",
			data: "consultarIdGrado="+$(this).val(),
			success: cargarSeccion
		});
	});

	$("#buscar_area").change(function(){
		$.ajax({
			url: "../cabecera/campos_de_seleccion/actividad.php",
			type: "POST",
			async: true,
			dataType: "json",
			data: "consultarIdArea="+$(this).val(),
			success: cargarActividadBuscar
		});
	});

	//Cuando se pulse cancelar limpiamos la pantalla
	$("#cancelar").click(function(){
		nombre_actividad_validar = new Array;

		$("#id_imagen").val("");
		$("#id_archivo").val("");
		$("#direccion_imagen").val("");
		$("#palabra").val("");
		$("#numero").val("");
		$("#hora").val("");
		$("#id_mostrar_imagen").attr("src", "../imagen/default-imagen.jpg");
		quitarAudio();
		
		$("#id_area").val("");
		$("#id_contenido").val("");
		$("#id_agrupacion").val("");
		$("#id_grado").val("");
		$("#id_seccion").val("");

		$("#asig-actividad tr").each(function(){
			eliminarActividadAsignado($(this));
		});

		$("#asig-contenido tr").each(function(){
			eliminarContenidoAsignado($(this));
		});

		$("#asig-agrupacion tr").each(function(){
			eliminarAgrupacionAsignado($(this));
		});

		$("#asig-sec-img tr").each(function(){
			eliminarSeccionAsignado($(this));
		});

		$("#incluir").attr("hidden", false);
		$("#modificar").attr("hidden", true);
		$("#eliminar").attr("hidden", true);
	});

	$("#anadir-contenido").click(function(){
		anadirContenido();
	});

	$("#anadir-agrupacion").click(function(){
		anadirAgrupacion();
	});
});

//Recivimos lo que se va a buscar, el id del div donde se colocara la informacion
//y la direccion del controlador donde se ejecutara la busqueda
function busquedaAvanzadaImagen(buscar, div, link, nombre){

	var buscar_actividad, buscar_contenido, buscar_agrupacion, buscar_seccion, buscar_palabra, buscar_numero, buscar_hora;

	buscar_actividad = $("#buscar_actividad").val();
	buscar_contenido = $("#buscar_contenido").val();
	buscar_agrupacion = $("#buscar_agrupacion").val();
	buscar_seccion = $("#buscar_seccion").val();
	buscar_palabra = $("#buscar_palabra").val();
	buscar_numero = $("#buscar_numero").val();
	buscar_hora = $("#buscar_hora").val();

	conexion = iniciarAjax();

	conexion.onreadystatechange = function(){
		if(conexion.readyState == 4 && conexion.status == 200){
			document.getElementById(div).innerHTML = conexion.responseText;
		}
	}

	conexion.open("GET", link+"?"+nombre+"="+buscar+"&&actividad="+buscar_actividad+"&&contenido="+buscar_contenido+"&&agrupacion="+buscar_agrupacion+"&&seccion="+buscar_seccion+"&&palabra="+buscar_palabra+"&&numero="+buscar_numero+"&&hora="+buscar_hora, true);
	conexion.send();
}

//Recivimos como parametro el nombre y el id del contenido
function asignarContenido(nombre, id){
	//Creamos la nueva fila con los datos
	var fila = "<tr title='Double Click if you want to delete' class='contenidoAsignado'>";
	fila    += "<td width='300px'>";
	fila    += "<input type='hidden' name='id_contenido[]' value='"+id+"'/>";
	fila    += nombre;
	fila    += "</td>";
	fila    += "</tr>";

	//Lo asignamos a la tabla  contenido
	$("#asig-contenido").append(fila);

	$("#contenidoCont").val( parseInt($("#contenidoCont").val()) + 1 );
}

//Recivimos como parametro el nombre y el id del contenido
function asignarActividad(nombre, id_actividad, id_area){
	//Creamos la nueva fila con los datos
	var fila = "<tr title='Double Click if you want to delete' class='actividadAsignado'>";
	fila    += "<td width='300px'>";
	fila    += "<input type='hidden' name='id_actividad[]' value='"+id_actividad+"'/>";
	fila    += "<input type='hidden' name='id_area' value='"+id_area+"'/>";
	fila    += nombre;
	fila    += "</td>";
	fila    += "</tr>";

	//Lo asignamos a la tabla actividad
	$("#asig-actividad").append(fila);

	$("#actividadCont").val( parseInt($("#actividadCont").val()) + 1 );
}

//Recivimos como parametro el nombre y el id del contenido
function asignarSeccion(nombre, id_seccion, id_grado){
	//Creamos la nueva fila con los datos
	var fila = "<tr title='Double Click if you want to delete' class='seccionAsignado'>";
	fila    += "<td width='700px'>";
	fila    += "<input type='hidden' name='id_seccion[]' value='"+id_seccion+"'/>";
	fila    += "<input type='hidden' name='id_grado' value='"+id_grado+"'/>";
	fila    += nombre;
	fila    += "</td>";
	fila    += "</tr>";

	//Lo asignamos a la tabla actividad
	$("#asig-sec-img").append(fila);

	$("#seccionCont").val( parseInt($("#seccionCont").val()) + 1 );
}

//Recivimos como parametro el nombre y el id del contenido
function asignarAgrupacion(nombre, id){
	//Creamos la nueva fila con los datos
	var fila = "<tr title='Double Click if you want to delete' class='agrupacionAsignado'>";
	fila    += "<td width='300px'>";
	fila    += "<input type='hidden' name='id_agrupacion[]' value='"+id+"'/>";
	fila    += nombre;
	fila    += "</td>";
	fila    += "</tr>";

	//Lo asignamos a la tabla  contenido
	$("#asig-agrupacion").append(fila);

	$("#agrupacionCont").val( parseInt($("#agrupacionCont").val()) + 1 );
}

function eliminarContenidoAsignado(fila){
	//Optenemos tanto el id como el nombre		
	var id     = fila.find("td").eq(0).find("input[name='id_contenido[]']").val();
	var nombre = fila.find("td").eq(0).text();
	
	//Eliminamos la fila
	fila.remove();

	//Creamos el option
	var option = "<option value='"+id+"'>";
	option    += nombre;
	option    += "</option>";
	
	//Lo agregamos al select
	$("#id_contenido").append(option);

	$("#contenidoCont").val( parseInt( $("#contenidoCont").val() ) - 1 );
}

function eliminarActividadAsignado(fila){
	//Optenemos tanto el id como el nombre		
	var id_area      = fila.find("td").eq(0).find("input[name='id_area']").val();
	var id_actividad = fila.find("td").eq(0).find("input[name='id_actividad[]']").val();
	var nombre       = fila.find("td").eq(0).text();

	var id_area_select = $("#id_area").val();
	
	//Eliminamos la fila
	fila.remove();

	if(id_area == id_area_select){
		//Creamos el option
		var option = "<option value='"+id_actividad+"'>";
		option    += nombre;
		option    += "</option>";
		
		//Lo agregamos al select
		$("#id_actividad").append(option);
	}

	$("#actividadCont").val( parseInt( $("#actividadCont").val() ) - 1 );
}

function eliminarSeccionAsignado(fila){
	//Optenemos tanto el id como el nombre		
	var id_grado     = fila.find("td").eq(0).find("input[name='id_grado']").val();
	var id_seccion = fila.find("td").eq(0).find("input[name='id_seccion[]']").val();
	var nombre       = fila.find("td").eq(0).text();

	var id_grado_select = $("#id_grado").val();
	
	//Eliminamos la fila
	fila.remove();

	if(id_grado == id_grado_select){
		//Creamos el option
		var option = "<option value='"+id_seccion+"'>";
		option    += nombre.substring(nombre.lastIndexOf('') + 1);
		option    += "</option>";
		
		//Lo agregamos al select
		$("#id_seccion").append(option);
	}

	$("#seccionCont").val( parseInt( $("#seccionCont").val() ) - 1 );
}

function eliminarAgrupacionAsignado(fila){
	//Optenemos tanto el id como el nombre		
	var id     = fila.find("td").eq(0).find("input[name='id_agrupacion[]']").val();
	var nombre = fila.find("td").eq(0).text();
	
	//Eliminamos la fila
	fila.remove();

	//Creamos el option
	var option = "<option value='"+id+"'>";
	option    += nombre;
	option    += "</option>";
	
	//Lo agregamos al select
	$("#id_agrupacion").append(option);

	$("#agrupacionCont").val( parseInt( $("#agrupacionCont").val() ) - 1 );
}

function cargarActividadBuscar(dato){

	$("#buscar_actividad option").remove();

	var option = "<option value=''>";
	option    += "SELECT";
	option    += "</option>";

	$("#buscar_actividad").append(option);

	for(var i = 0; i<dato.length; i++){
	
		//Creamos la opción
		var option = "<option value='"+dato[i].id_actividad+"'>";
		option    += dato[i].nombre_actividad;
		option    += "</option>";

		$("#buscar_actividad").append(option);
		
	}
}


function cargarActividad(dato){

	$("#id_actividad option").remove();

	var option = "<option value=''>";
	option    += "SELECT";
	option    += "</option>";

	$("#id_actividad").append(option);

	for(var i = 0; i<dato.length; i++){
		var comparo = false;

		$("#asig-actividad tr").each(function(){
			var id = $(this).find("td").eq(0).find("input[name='id_actividad[]']").val();

			if(id == dato[i].id_actividad){
				comparo = true;
			}
		});

		if(!comparo){
			//Creamos el option
			var option = "<option value='"+dato[i].id_actividad+"'>";
			option    += dato[i].nombre_actividad;
			option    += "</option>";

			$("#id_actividad").append(option);
		}
	}
}

function cargarSeccion(dato){

	$("#id_seccion option").remove();

	var option = "<option value=''>";
	option    += "SELECT";
	option    += "</option>";

	$("#id_seccion").append(option);

	for(var i = 0; i<dato.length; i++){
		var comparo = false;

		$("#asig-sec-img tr").each(function(){
			var id = $(this).find("td").eq(0).find("input[name='id_seccion[]']").val();

			if(id == dato[i].id_seccion){
				comparo = true;
			}
		});

		if(!comparo){
			//Creamos el option
			var option = "<option value='"+dato[i].id_seccion+"'>";
			option    += dato[i].grupo;
			option    += "</option>";

			$("#id_seccion").append(option);
		}
	}
}

function cargarModificar(id){
	$.ajax({
		url: "../controlador/gestionar_imagen.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "actualizarVista="+id,
		success: mostrarConsulta,
		error: function(){ alertify.error("Error"); }
	});
}

function mostrarConsulta(dato){
	//Mostramos los datos de la imagen
	$("#id_imagen").val(dato.imagen[0].id_imagen);
	$("#id_mostrar_imagen").attr("src", dato.imagen[0].direccion_imagen);
	$("#direccion_imagen").val(dato.imagen[0].direccion_imagen);

	var dir_lng_signo = dato.imagen[0].lenguaje_sena;

	var ext = dir_lng_signo.substring(dir_lng_signo.lastIndexOf('.') + 1).toLowerCase();

	if(ext == "ogg" || ext == "webm" || ext == "mp4"){
		$('#img_lenguaje_signo').hide();
		$('#video_lenguaje_signo').show();
		document.getElementById('video_lenguaje_signo').src = dir_lng_signo;
		$("#lenguaje_signo").attr("src", dir_lng_signo);
		$('#quitar_lng_sign').show();
	}else if(ext == "gif" || ext == "png" || ext == "bmp" || ext == "jpeg" || ext == "jpg"){
		$('#img_lenguaje_signo').show();
		$('#video_lenguaje_signo').hide();

		document.getElementById('video_lenguaje_signo').src = '';

		document.getElementById('img_lenguaje_signo').src = dir_lng_signo;

		$('#quitar_lng_sign').show();
	}else{
		$('#quitar_lng_sign').hide();
	}

	$("#id_tocar_audio").attr("src", dato.imagen[0].direccion_audio);

	$("#palabra").val(dato.imagen[0].palabra);
	$("#numero").val(dato.imagen[0].numero);
	$("#hora").val(dato.imagen[0].hora);

	//Limpiamos las tablas de la asignacion
	$("#asig-actividad tr").each(function(){
		eliminarActividadAsignado($(this));
	});

	$("#asig-contenido tr").each(function(){
		eliminarContenidoAsignado($(this));
	});

	$("#asig-agrupacion tr").each(function(){
		eliminarAgrupacionAsignado($(this));
	});

	//Limpiamos las tablas de la asignacion
	$("#asig-sec-img tr").each(function(){
		eliminarSeccionAsignado($(this));
	});


	//Insertamos los datos de la asignacion consultada
	for(var i = 0; i<dato.actividad.length; i++){
		var id_area      = dato.actividad[i].id_area;
		var id_actividad = dato.actividad[i].id_actividad;
		var nombre       = dato.actividad[i].nombre_actividad;

		nombre_actividad_validar.push(nombre);

		asignarActividad(nombre, id_actividad, id_area);
	}

	for(var i = 0; i<dato.contenido.length; i++){
		var id     = dato.contenido[i].id_contenido;
		var nombre = dato.contenido[i].nombre_contenido;

		asignarContenido(nombre, id);

		$("#id_contenido option").each(function(){
			if($(this).val() == id){
				$(this).remove();
			}
		});
	}

	if(dato.agrupacion != null){

		for(var i = 0; i<dato.agrupacion.length; i++){
			var id     = dato.agrupacion[i].id_agrupacion;
			var nombre = dato.agrupacion[i].nombre_agrupacion;

			asignarAgrupacion(nombre, id);

			$("#id_agrupacion option").each(function(){
				if($(this).val() == id){
					$(this).remove();
				}
			});
		}
	}

	//Insertamos los datos de la asignacion consultada
	for(var i = 0; i<dato.seccion.length; i++){
		var id_grado      = dato.seccion[i].id_grado;
		var id_seccion = dato.seccion[i].id_seccion;
		var nivel  = dato.seccion[i].nivel;
		var grupo = dato.seccion[i].grupo;
		var nombre = nivel+" "+grupo;;

		nombre_seccion_validar.push(nombre);

		asignarSeccion(nombre, id_seccion, id_grado);
	}

	var audio_Data = $('#id_tocar_audio').attr('src');

	if(audio_Data == ' '){
		$('#area_audio').show();
		$('#id_tocar_audio').hide();
		$('#quitar_audio').hide();
	}else{
		$('#area_audio').hide();
		$('#id_tocar_audio').show();
		$('#quitar_audio').show();

	}

	$("#incluir").attr("hidden", true);
	$("#modificar").attr("hidden", false);
	$("#eliminar").attr("hidden", false);

	redireccionar('#dos');			
}

function validarAsignacion(nombre_actividad){
	var input1  = $("#actividadCont").val();
	var input2  = $("#contenidoCont").val();
	var input3  = $("#agrupacionCont").val();
	var input4  = $("#seccionCont").val();
	var palabra = $("#palabra").val();
	var numero  = $("#numero").val();
	var hora    = $("#hora").val();

	if(validarImagenIncluida() == false){
		return false;
	}

	if(input1 != 0 && input2 != 0 && input4 != 0){
		for(var i = 0; i<nombre_actividad.length; i++){
			if(nombre_actividad[i] == "PLACE THE FIRST LETTER" || nombre_actividad[i] == "PLACE THE VOWELS" || nombre_actividad[i] == "WRITE THE FIRST LETTER OF THE OBJECT" || nombre_actividad[i] == "ENCUENTRA LA IMAGEN" || nombre_actividad[i] == "SELECT THE IMAGES WHOOSE FIRST LETTER IS EQUAL TO THE INDICATED" ){

				if(palabra == ""){
					alertify.error("Place the word to be associated with the image");
					return false;	
				}
			}else if(nombre_actividad[i] == "COUNT THE OBJECTS" || nombre_actividad[i] == "IDENTIFY THE NUMBER"){

				if(numero == ""){
					alertify.error("Place the number to be associated with the image");
					return false;	
				}
			}else if(nombre_actividad[i] == "SPELL THE NUMBER"){

				if(palabra == ""){
					alertify.error("Spell the number to be associated with the number in the image");
					return false;	
				}
			}else if(nombre_actividad[i] == "WHAT TIME IS IT?"){

				if(hora == ""){
					alertify.error("Place the time to be associated with the image");
					return false;	
				}
			}else if(nombre_actividad[i] == "SUBTRACT THE OBJECTS"){

				if(numero == ""){
					alertify.error("Place the quantity of objects in the number field");
					return false;	
				}

				if(input3 == 0){
					alertify.error("Associate the image to a grouping");
					return false;
				}
			}else if(nombre_actividad[i] == "SUM THE OBJECTS"){

				if(numero == ""){
					alertify.error("Place the quantity of objects in the number field");
					return false;	
				}

				if(input3 == 0){
					alertify.error("Associate the image to a grouping");
					return false;
				}
			}else if(nombre_actividad[i] == "FIND THE IMAGES WITH THE MOST OBJECTS"){

				if(numero == ""){
					alertify.error("Place the quantity of objects in the number field");
					return false;	
				}
			}
		}

		return true;
		
	}else{
		alertify.error("Assign Activities and Contents");
		return false;
	}
	
}

function validarImagenIncluida(){
	var fuData = $('#id_mostrar_imagen').attr('src');

	if (fuData == '../imagen/default-imagen.jpg') {
    		alertify.error("Please upload an image");
		return false;
	}else{
		return true;
	}
}

function quitarAudio(){
	$('#area_audio').show();
	$('#id_tocar_audio').hide();
	$('#quitar_audio').hide();
	document.getElementById('id_tocar_audio').src = '';
	document.getElementById('id_archivo_audio').value=null;
}

function quitarLenguajeSigno(){
	$('#img_lenguaje_signo').show();
	$('#video_lenguaje_signo').hide();
	document.getElementById('video_lenguaje_signo').src = '';
	document.getElementById('lenguaje_signo').value=null;
	document.getElementById('img_lenguaje_signo').src = "../imagen/icon/lenguaje-signo.png";
	$('#quitar_lng_sign').hide();
}

function anadirContenido(){
	alertify.prompt("Enter the name of the content", function(c, contenido){
		if( c && contenido.length > 1 ){
			$.ajax({
				url: "../controlador/gestionar_contenido.php",
				type: "POST",
				async: true,
				dataType: "json",
				data: "incluirNuevoContenido="+contenido,
				success: function(dato){
					if( dato.resultado == "SUCCESSFUL" ){
						alertify.alert(dato.msj);

						var option = "<option value="+dato.id_contenido+">";
						option += dato.nombre_contenido;
						option += "</option>";

						$("#id_contenido").append(option);
					}
					else{
						alertify.error(dato.msj);
						anadirContenido();	
					}
				},
				error: function(){ alertify.error("Error"); }
			});
		}
		else if( contenido.length == 0 ){
			alertify.error("Empty Field");
			anadirContenido();
		}
		else if( contenido.length == 1 ){
			alertify.error("The field should contain more than 1 character");
			anadirContenido();
		}
	});
}

function anadirAgrupacion(){
	alertify.prompt("Enter the name of the grouping", function(c, agrupacion){
		if( c && agrupacion.length > 1 ){
			$.ajax({
				url: "../controlador/gestionar_agrupacion.php",
				type: "POST",
				async: true,
				dataType: "json",
				data: "incluirNuevoAgrupacion="+agrupacion,
				success: function(dato){
					if( dato.resultado == "EXITO" ){
						alertify.alert(dato.msj);

						var option = "<option value="+dato.id_agrupacion+">";
						option += dato.nombre_agrupacion;
						option += "</option>";

						$("#id_agrupacion").append(option);
					}
					else{
						alertify.error(dato.msj);
						anadirAgrupacion();	
					}
				},
				error: function(){ alertify.error("Error"); }
			});
		}
		else if( agrupacion.length == 0 ){
			alertify.error("Campo Vacio");
			anadirAgrupacion();
		}
		else if( agrupacion.length == 1 ){
			alertify.error("The field should contain more than 1 character");
			anadirAgrupacion();
		}
	});
}

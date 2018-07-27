
$(document).ready(function(){
	//Al iniciar el documento redireccionamos a la pestaña principal
	redireccionar("#uno");

	//Realizamos una busqueda al iniciar el documento
	buscarEstudiante();

	$("#cuerpo-tabla-maestro").disableSelection();
	$("#lista-seleccion-estudiante").disableSelection();
	$("#cuerpo-tabla-asignado").disableSelection();

	//Cada vez que se escriba en el campo "#buscar_alumno"
	$("#buscar_estudiante").keyup(function(){
		buscarEstudiante();		
	});

	$("#buscar").change(function(){
		consultarAsignacion($(this).val());
	});

	$(document).on("dblclick", ".seleccionEstudiante", function(){
		seleccionEstudiante($(this));
	});

	$(document).on("taphold", ".seleccionEstudiante", function(){
		seleccionEstudiante($(this));
	});

	$("#otro").click(function(){
		abilitar();
	});

	$("#id_seccion").change(function(){
		desabilitar();
	});

	$(document).on("dblclick", ".eliminarSeleccion", function(){
		eliminarSeleccion($(this));
	});

	$(document).on("taphold", ".eliminarSeleccion", function(){
		eliminarSeleccion($(this));
	});

	$(document).on("dblclick", ".seleccionModificar", function(){
		seleccionModificar($(this));
	});

	$(document).on("taphold", ".seleccionModificar", function(){
		seleccionModificar($(this));
	});

	$(document).on("click", "#asignar", function(){
		siguienteGrado();
	});
});

function consultarAsignacion(value){
	var buscar = {
		id_ano_escolar : value
	};

	$.ajax({
		url: "../controlador/gestionar_asignacion_estudiante.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultaAvanzada="+JSON.stringify(buscar),
		success: function(dato){
			$("#cuerpo-tabla-maestro tr").remove();

			if( dato.contador != 0 ){
				for( var i = 0; i < dato.contador; i++ ){
					var colum = "<td width='300px'>";
					colum += "<input type='hidden' value='"+dato.id_grado[i]+"' name='id_grado' />";
					colum += dato.nivel[i];
					colum += "</td>";

					colum += "<td width='300px'>";
					colum += "<input type='hidden' value='"+dato.id_seccion[i]+"' name='id_seccion' />";
					colum += dato.grupo[i];
					colum += "</td>";

					colum += "<td width='210px'>";
					colum += "<input type='hidden' value='"+dato.id_ano_escolar[i]+"' name='id_ano_escolar' />";
					colum += dato.cantidad_estudiante[i];
					colum += "</td>";
					
					$("#cuerpo-tabla-maestro").append("<tr class='seleccionModificar'>"+colum+"</tr>");
				}
			}

			if( dato.contador > 1 ){
				$("#total").text("Total of "+dato.contador+" Assignments Found");
			}
			else if( dato.contador == 1 ){
				$("#total").text("Total of "+dato.contador+" Assignments Found");
			}
			else{
				$("#total").text("Total of 0 Assignments Found");
			}
		},
		error: function(){ alertify.error("Error") }
	});
}

//Hacemos la respectiva busqueda
function buscarEstudiante(){
	//Capturamos los valores que necesitamos
	var buscar         = $("#buscar_estudiante").val();
	var id_seccion     = $("#id_seccion").val();
	var id_ano_escolar = $("#id_ano_escolar").val();

	//Lo guardamos en un array
	var cadena = {
		consultar: buscar,
		seccion: id_seccion,
		ano_escolar: id_ano_escolar
	};

	//Eliminamos las filas de la tabla para ingresar los valores nuevos
	eliminarFila("lista-seleccion-estudiante");

	//Pasamos hacer la respectiva busqueda
	$.ajax({
		url: "../controlador/gestionar_asignacion_estudiante.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultaDinamica="+JSON.stringify(cadena),
		success: anadirFila
	});

	if( !$("#modificar").is(":hidden")){
		$.ajax({
			url: "../controlador/gestionar_asignacion_estudiante.php",
			type: "POST",
			async: true,
			dataType: "json",
			data: "consultarModificar="+JSON.stringify(cadena),
			success: anadirFila
		});
	}
}

//eliminamos filas a la tabla de estudiantes
function eliminarFila(tablaId) {
	try {
		//Obtenemos la Tabla
		var tabla = document.getElementById(tablaId);
		//Verificamos el numero de filas que posee la tabla
		var contFila = tabla.rows.length;

		//Recorremos la tabla y eliminamos las filas
		for( var i = 0; i < contFila; i++ ) {
			tabla.deleteRow(i);
			contFila--;
			i--;
		}
	}
	catch(e){
		alertify.error(e);
	}
}

//Cada vez que se realice la consulta satisfactoriamente
//se añaden filas segun corresponda con la busqueda
function anadirFila(estudiante){
	//Capturamos el valor de la tabla
	var tabla = document.getElementById("lista-seleccion-estudiante");

	//Guardamos la catidad de fila que posee la tabla
	var contFila = tabla.rows.length;
	var comparo;

	if(estudiante != null){
		//Recorremos la consulta
		for(var i = 0; i<estudiante.length; i++){
			//Hacemos una comparacion de si el estudiante ya esta asignado
			comparo = compararEstudiante('cuerpo-tabla-asignado', estudiante[i].id_estudiante);
			
			if(comparo){
				//Insertamos una nueva fila
				var fila = tabla.insertRow(contFila);
				fila.title = "Doble click on the student that you want to assign";
				fila.className = "seleccionEstudiante";

				//Creamos lo que contendra la columna
				var colum = "<td width='395px'>";
				colum += "<input type='hidden' value='"+estudiante[i].id_estudiante+"' name='id_estudiante'/>";
				colum += "<input type='hidden' value='"+estudiante[i].cedula+"' name='cedula'/>";
				colum += "<input type='hidden' value='"+estudiante[i].nombre+" "+estudiante[i].apellido+"' name='nombre'/>";
				colum += estudiante[i].nombre+" "+estudiante[i].apellido;
				colum += "</td>";

				//Añadimos la columna a la fila
				fila.innerHTML = colum;
			}
		}
	}
	// else{
	// 	var fila = tabla.insertRow(contFila);

	// 	var colum = "<td>";
	// 	colum += "No se encontraron estudiantes";
	// 	colum += "</td>";

	// 	fila.innerHTML = colum;
	// }
}

//Comparo los id de los estudiantes
function compararEstudiante(tablaId, id){
	//Capturo los id de la tabla dond ya fueron asignados estudiantes
	var arregloId = capturarIdEstudiante(tablaId);
	var resul = true;

	//Si aun no se han asignado no entra al if
	if(arregloId.length != 0){
		//Recorro y comparo
		for(var i = 0; i<arregloId.length; i++){
			if(arregloId[i] == id){
				resul = false;
			}
		}
	}

	return resul;
}

//Capturo los Id de la tabla de los estudiante
function capturarIdEstudiante(tablaId){
	try {
		//Obtenemos la Tabla
		var tabla = document.getElementById(tablaId);

		//Verificamos el numero de filas que posee la tabla
		var contFila = tabla.rows.length;

		var id = [];
		var j = 0;

		//Recorremos la tabla
		for( var i = 0; i < contFila; i++ ) {
			//Obtenemos la fila
			var fila = tabla.rows[i];
			
			//Obtenemos el input de la fila
			var estudiante = fila.cells[0].childNodes[0];

			//Obtenemos el valor del input
			id[j] = estudiante.value;
			j++;			
		}

		return id;
	}
	catch(e){
		alertify.error(e);
	}
}

function siguienteGrado(){
	var id_ano_escolar;
	var ano_escolar;

	var id_grado = $("#id_grado").val();
	var grupo    = $("#id_seccion option:selected").text();

	$.ajax({
		url: "../controlador/gestionar_asignacion_estudiante.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultarAnoEscolarA=A",
		success: function (dato){
			id_ano_escolar = dato.id_ano_escolar;
			ano_escolar = dato.denominacion;

			$("#id_ano_escolar").val(id_ano_escolar);
			$("#ano_escolar").val(ano_escolar);
		},
		error: errorAjax
	});

	$.ajax({
		url: "../controlador/gestionar_asignacion_estudiante.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultarSiguienteGrado="+id_grado,
		success: function(dato){
			$("#id_grado").val(dato.grado[0]);

			$.ajax({
				url: "../cabecera/campos_de_seleccion/seccion.php",
				type: "get",
				async: true,
				dataType: "html",
				data: "consultar="+dato.grado[0],
				success: function(html){
					$("#id_seccion").html(html);

					$("#id_seccion").find("option[value='']").remove();

					var seccion = $('#id_seccion option:selected').text();
					var id_seccion = $('#id_seccion option:selected').val();

					if(seccion != ""){
						var resul = true;

						$("#id_seccion option").each(function(){
							if( $(this).text() == grupo ){
								resul = false;

								$(this).attr("selected", "selected");
								id_seccion = $(this).val();

								$("#id_seccion").attr("disabled", true);

								cambiarIdAsignacion(id_seccion);
							}
						});

						if(resul){
							cambiarIdAsignacion(id_seccion);
						}
					}
					else{
						errorCargarSeccion();
					}

					
				},
				error: errorAjax
			});
		},
		error: errorAjax
	});

	$("#id_grado").attr("disabled", true);
	
	$("#asignar").remove();

	$("#incluir").attr("hidden",false);
	$("#modificar").attr("hidden",true);
	$("#eliminar").attr("hidden", true);

	$("#otro").attr("hidden",false);
	$("#otro").attr("disabled","disabled");

	setTimeout(buscarEstudiante, 100);
}

function cambiarIdAsignacion(id_seccion){
	$("#cuerpo-tabla-asignado tr").each(function(){
		$(this).closest("tr").find("td:nth-child(1)").find("input[name='id_seccion_asignado[]']").val(id_seccion);
		$(this).closest("tr").find("td:nth-child(1)").find("input[name='id_ano_escolar_asignado[]']").val( $("#id_ano_escolar").val() );
	});
}

function seleccionEstudiante(fila){
	//Capturamos los valores de la fila seleccionada
	var id_estudiante = fila.closest("tr").find('td:nth-child(1)').find("input[name='id_estudiante']").val();
	var nombre    = fila.closest("tr").find('td:nth-child(1)').find("input[name='nombre']").val();

	asignarEstudiante(id_estudiante, nombre);

	eliminarSeleccion(fila);
}

function asignarEstudiante(id_estudiante, nombre){
	//Capturamos los valores de la seccion y el ano escolar
	var seccion        = $("#id_seccion").val();
	var id_ano_escolar = $("#id_ano_escolar").val();

	//Verificamos que los campos no esten vacios
	if(id_estudiante == "" || nombre == ""){
		alertify.error("An error occured when selecting the Student");
	}
	else if( id_ano_escolar == "" ){
		alertify.error("An error occured when loading the active school year");
	}
	else if( seccion == "" ){
		alertify.error("Select the Grade and the Section");
	}
	else{
		//Creamos la nueva columna
		var colum = "<td width='400px'>";
		colum += "<input type='hidden' name='id_estudiante_asignado[]' value='"+id_estudiante+"'/>";
		colum += "<input type='hidden' name='id_seccion_asignado[]' value='"+seccion+"'/>";
		colum += "<input type='hidden' name='id_ano_escolar_asignado[]' value='"+id_ano_escolar+"'/>";
		colum += nombre;
		colum += "</td>";

		//Añadimos la fila
		var tabla = document.getElementById("cuerpo-tabla-asignado");

		var contFila = tabla.rows.length;

		var fila = tabla.insertRow(contFila);
		fila.innerHTML = colum;
		fila.title = "Doble Click on the Assignment that you want to Delete";
		fila.className = "eliminarSeleccion";

		$("#cont").val( parseInt( $("#cont").val() ) + 1 );
	}
}

function seleccionModificar(fila){
	//Obtenemos el valor de la fila seleccionada
	var id_grado       = fila.closest("tr").find('td:nth-child(1)').find("input[name='id_grado']").val();
	var id_seccion     = fila.closest("tr").find('td:nth-child(2)').find("input[name='id_seccion']").val();
	var id_ano_escolar = fila.closest("tr").find('td:nth-child(3)').find("input[name='id_ano_escolar']").val();
	
	//Creamos un arreglo tipo json con los valores recojidos
	var cadena = {
		consultar: "",
		grado: id_grado,
		seccion: id_seccion,
		ano_escolar: id_ano_escolar
	};

	//Opciones de botones
	$("#id_grado").val(id_grado);
	$("#id_grado").attr("disabled", true);
	$("#id_seccion").attr("disabled", true);
	$("#otro").attr("hidden","hidden");

	//Para mostrar en la interfaz el año escolar que se esta consultando
	//con sul respectivo id para la busqueda avanzada
	$("#id_ano_escolar").val( $("#buscar option:selected").val() );
	$("#ano_escolar").val( $("#buscar option:selected").text() );

	//Colocar Consulta de año escolar, si es el actual el que 
	//se modificara habilitar modificar y eliminar, si no no mostrar nada
	//Colocar consulta de ejercicio, si los niños ya han hecho actividades
	//no permitir eliminar
	consultarAnoEscolarA(fila);

	//Cargamos el listado de los estudiantes que pertenecen a dicha seccion
	cargarSeccionModificar(cadena);

	eliminarFila("cuerpo-tabla-asignado");

	redireccionar("#dos");	
}

//Consultamos el año escolar para verificar que si el año escolar en el que 
//se le de doble click para visualizar la asignacion esta inactivo 
//el usuario no podra hacer modificaciones
function consultarAnoEscolarA(fila){
	$.ajax({
		url: "../controlador/gestionar_asignacion_estudiante.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultarAnoEscolarA=A",
		success: function (dato){
			//Capturamos los valores de la vista 
			var id_ano_escolar = fila.closest("tr").find('td:nth-child(3)').find("input[name='id_ano_escolar']").val();
			var ano_escolar    = $("#buscar option:selected").text();

			//Si el año escolar coincide con el activo, se le permite modificar
			if(id_ano_escolar == dato.id_ano_escolar){
				$("#incluir").attr("hidden",true);
				$("#modificar").attr("hidden",false);
				$("#eliminar").attr("hidden", false);
			}
			else{
				var ano1 = ano_escolar.split("-");
				var ano2 = dato.denominacion.split("-");
				
				var resul = ano2[1] - ano1[1];

				//Si no coinciden verificamos si el año escolar es el anterior
				//para permitir pasar alumnos de un grado a otro de forma automatica
				if(resul == 1){
					buscarEstudiante();

					$("#incluir").attr("hidden",true);
					$("#modificar").attr("hidden",true);
					$("#eliminar").attr("hidden", true);

					$("#asignar").remove();
					var boton = '<button type="button" id="asignar" name="asignar" title="Press to pass the students to the following grade" class="boton">Pasar</button>';
					$(".boton-maestro").prepend(boton);
				}
				else{
					$("#incluir").attr("hidden",true);
					$("#modificar").attr("hidden",true);
					$("#eliminar").attr("hidden", true);
				}				
			}
		},
		error: errorAjax 
	});
}

//Carga las secciones y selecciona a la que se va a modificar
function cargarSeccionModificar(cadena){
	$.ajax({
		url: "../cabecera/campos_de_seleccion/seccion.php",
		type: "POST",
		async: true,
		dataType: "html",
		data: "consultarModificar="+JSON.stringify(cadena),
		success: function(seccion){
				document.getElementById("id_seccion").innerHTML = seccion;
				cargarModificar(cadena);
			},
		error: errorAjax
	});
}

//Carga los estudiantes de la seccion seleccionada
function cargarModificar(cadena){
	$.ajax({
		url: "../controlador/gestionar_asignacion_estudiante.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultarModificar="+JSON.stringify(cadena),
		success: function(estudiante){
			if(estudiante != null){
				//Añadimos los estudiantes que pertenecen a la seccion
				for(var i = 0; i<estudiante.length; i++){
					asignarEstudiante(estudiante[i].id_estudiante, estudiante[i].nombre+" "+estudiante[i].apellido);
				}
			} 
		},
		error: errorAjax
	});
}

//Metodo en el cual  eliminamos una fila de la tabla de asignacion
function eliminarSeleccion(fila){
	fila.remove();

	buscarEstudiante();
}

function abilitar(){
	var contFila = $("#cuerpo-tabla-asignado tr").length;

	if(contFila == 0){
		$("#id_grado").attr("disabled", false);
		$("#id_seccion").attr("disabled", false);

		$("#id_grado").val("");
		$("#id_seccion").val("");
	}
	else{
		alertify.error("Please finish the Assignment of this Section");
	}
}

//Funcion que desabilita el campo grado y seccion
function desabilitar(){
	var grado   = $("#id_grado").val();
	var seccion = $("#id_seccion").val();

	if(grado != "" && seccion != ""){
		$("#id_grado").attr("disabled", true);
		$("#id_seccion").attr("disabled", true);
	}
	else{
		alertify.error("Please select the Grade and the Section");
	}
}

//Si ocurrio un error en la consulta con ajax
function errorAjax(){
	alertify.error("Error ");
}

function errorCargarSeccion(){
	alertify.error("No Sections are registered to this Grade");
	redireccionar("gestionar_asignacion_estudiante.php")
}

//Inicializamos el jquery
$(document).ready(function(){

	//Redireccionamos a la pestaña 1
	//redireccionar("#uno");
	//Realizamos una busqueda de los docentes que aun no se an asignado a una seccion
	buscarDocente("", "lista-seleccion-docente");

	//Desactivo el sombreado y seleccion
	$("#cuerpo-tabla-maestro").disableSelection();
	$("#lista-seleccion-docente").disableSelection();

	//Validaccion para cargar el boton para modificar la asignacion
	activarBotonM("");

	//Realizar la busqueda avanzada
	$("#buscar_docente").keyup(function(){
		buscarDocente($(this).val(), "lista-seleccion-docente");
	});

	//Cuando se cambie de grado cargara las secciones correspondientes al grado
	$("#id_grado").change(function(){
		cargarAsignacionSeccion();
	});

	//Realizamos una busqueda cuando se cambie el año escolar
	$("#buscar").change(function(){
		consultarAsignacion($(this).val());
		//busquedaAvanzada($(this).val(), "cuerpo-tabla-maestro", "../Controlador/ControladorGestionarAsignacionDocente.php", "consultaAvanzada");
	});

	//Cuando se pulse sobre una fila de la tabla donde se cargan los docentes
	$(document).on("dblclick", ".seleccionDocente", function(){
		seleccionDocente($(this));
	});
	
	$(document).on("taphold", ".seleccionDocente", function(){
		seleccionDocente($(this));
	});

	//Aki eliminamos a un docente que ya ah sido asignado
	$(document).on("dblclick", ".eliminarSeleccion", function(){
		$(this).remove();
		var nombre = $(this).find("td").eq(0).text();

		buscarDocente($("#buscar_docente").val(), "lista-seleccion-docente");

		$("#cont").val( parseInt($("#cont").val()) - 1 ); 

		var separar = nombre.split("-");
		nombre = separar[1];

		alertify.log("The teacher \"" + nombre.trim() + "\" has been unassigned");
	});
	
	$(document).on("taphold", ".eliminarSeleccion", function(){
		$(this).remove();
		var nombre = $(this).find("td").eq(0).text();

		buscarDocente($("#buscar_docente").val(), "lista-seleccion-docente");

		$("#cont").val( parseInt($("#cont").val()) - 1 ); 

		var separar = nombre.split("-");
		nombre = separar[1];

		alertify.log("The teacher \"" + nombre.trim() + "\" has been unassigned");
	});

	$("#ir_modificar").click(function(){
		redireccionar('#form-maestro');
		modificarAsignacion();
	});

	$("#incluir").click(function(){
		$("#form-docente-seccion").submit();
	});
});

function consultarAsignacion(value){
	var buscar = {
		id_ano_escolar : value
	};

	$.ajax({
		url: "../controlador/gestionar_asignacion_docente.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultaAvanzada="+JSON.stringify(buscar),
		success: function(dato){
			$("#cuerpo-tabla-maestro tr").remove();

			if( dato.contador != 0 ){
				for( var i = 0; i < dato.contador; i++ ){
					var columnas = "<td width='450px'>";
					columnas += "<input type='hidden' name='id_docente' value='"+dato.id_docente[i]+"'/>";
					columnas += " I.D : "+dato.cedula[i]+" - "+dato.nombre[i]+" "+dato.apellido[i]+"</td>";
					columnas += "<td width='250px'>"+dato.nivel[i]+"</td>";
					columnas += "<td width='110px'>";
					columnas += "<input type='hidden' name='id_seccion' value='"+dato.id_seccion[i]+"'/>"+dato.grupo[i]+"</td>";

					$("#cuerpo-tabla-maestro").append("<tr>"+columnas+"</tr>");
				}

				activarBotonM(value);
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
		error: error
	});
}

//Validamos que el año escolar este activo para poder hacer una modificacion
function activarBotonM(id){
	$("#ir_modificar").hide();
	//Verificamos que el campo no este vacio
	if($("#buscar").val() != ""){

		//Consultamos el id del año escolar
		$.ajax({
			url: "../controlador/gestionar_asignacion_docente.php",
			type: "POST",
			async: true,
			dataType: "json",
			data: "consultarIdAnoActivo="+id,
			success: function(dato){
				//Si el año escolar esta activo retorna A sino retorna A
				if(dato.estatus == "A"){
					$("#ir_modificar").fadeIn("fast");
				}
			},
			error: error
		});			
	}
}

function buscarDocente(buscar, tabla){
	eliminarFila(tabla);

	var id_ano_escolar = $("#id_ano_escolar").val();

	cadena = {
		consultar: buscar,
		ano_escolar: id_ano_escolar
	}

	$.ajax({
		url: "../controlador/gestionar_asignacion_docente.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultaDinamica="+JSON.stringify(cadena),
		success: anadirFila,
	});

	if( !$("#modificar").is(":hidden")){
		$.ajax({
			url: "../controlador/gestionar_asignacion_docente.php",
			type: "POST",
			async: true,
			dataType: "json",
			data: "consultarModificar="+JSON.stringify(cadena),
			success: anadirFila
		});
	}
}

//eliminamos filas a la tabla de docentes
function eliminarFila(tablaId) {
	try {
		//Obtenemos la Tabla
		var tabla = document.getElementById(tablaId);
		//Verificamos el numero de filas que posee la tabla
		var contFila = tabla.rows.length;

		//Recorremos la tabla
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

//anadimos filas a la tabla de docentes
function anadirFila(dato) {
	//Obtenemos la tabla
	var tabla = document.getElementById("lista-seleccion-docente");

	//Verificamos el numero de filas que posee la tabla
	var contFila = tabla.rows.length;
	var comparo;

	for(var i = 0; i<dato.length; i++){
		//Comparamos que el docente no este asignado a una seccion
		comparo = compararDocente('cuerpo-tabla-asignado', dato[i].id_docente);

		if(comparo){
			//Añadimos la fila
			var fila = tabla.insertRow(contFila);
			fila.title = "Select the teacher that you desire to assign";
			fila.className = "seleccionDocente";

			var colum = "<td width='395px'>";
			colum    += "<input type='hidden' value='"+dato[i].id_docente+"' name='id_docente'/>";
			colum    += "<input type='hidden' value='"+dato[i].cedula+"' name='cedula'/>";
			colum    += "<input type='hidden' value='"+dato[i].nombre+"' name='nombre'/>";
			colum    += "<input type='hidden' value='"+dato[i].apellido+"' name='apellido'/>";
			colum    += "C.I.: "+dato[i].cedula+" "+" - "+" "+dato[i].nombre+" "+dato[i].apellido;
			colum    += "</td>";
			
			fila.innerHTML = colum;
		}
	}	
}

//Comparo los id de los docentes
function compararDocente(tablaId, id){
	var resul = true;
	$("#cuerpo-tabla-asignado tr").each(function(){
		var id_docente = $(this).closest("tr").find("td:nth-child(1)").find("input[name='id_docente_asignado[]']").val();

		if( id_docente == id ){
			resul = false;
		}
	});

	return resul;
}

//Funcion para cargar las secciones q no han sido asignadas
function cargarAsignacionSeccion(id_grado){
	var id_grado       = $("#id_grado").val();
	var id_ano_escolar = $("#id_ano_escolar").val();

	var id = new Array();
	var j = 0;

	$("#cuerpo-tabla-asignado tr").each(function(){
		id[j] = $(this).closest("tr").find("td:nth-child(3)").find("input[name='id_seccion_asignado[]']").val();
		j++;
	});

	
	var cadena = {
		consultar: id_grado,
		seccion: id,
		ano_escolar: id_ano_escolar
	};

	if($("#modificar").is(":hidden")){
		$.ajax({
			url: "../controlador/gestionar_asignacion_docente.php",
			type: "POST",
			async: true,
			dataType: "html",
			data: "consultarSeccion="+JSON.stringify(cadena),
			success: function(dato){ document.getElementById("id_seccion").innerHTML = dato },
			error: error,
		});
	}
	else{
		$.ajax({
			url: "../controlador/gestionar_asignacion_docente.php",
			type: "POST",
			async: true,
			dataType: "html",
			data: "consultarSeccionModificar="+JSON.stringify(cadena),
			success: function(dato){ document.getElementById("id_seccion").innerHTML = dato },
			error: error,
		});
	}
	
}

//El docente que seleccione de la lista se pasa para el formulario
//donde se procede a asignarle una funcion
function seleccionDocente(fila){
	//Obtenemos los valores de la fila
	var id_docente = fila.closest("tr").find('td:nth-child(1)').find("input[name='id_docente']").val();
	var cedula     = fila.closest("tr").find('td:nth-child(1)').find("input[name='cedula']").val();
	var nombre     = fila.closest("tr").find('td:nth-child(1)').find("input[name='nombre']").val();
	var apellido     = fila.closest("tr").find('td:nth-child(1)').find("input[name='apellido']").val();
	
	//Los colocamos en el formulario
	$("#id_docente_seleccion").val(id_docente);
	$("#cedula_seleccion").val(cedula);
	$("#nombre_seleccion").val(nombre);
	$("#apellido_seleccion").val(apellido);
}

//Se procede a la asignacion del docente una vez llenado el formulario
function asignarDocente(){
	//Obtenemos los datos del formulario
	var id_docente     = $("#id_docente_seleccion").val();
	var cedula         = $("#cedula_seleccion").val();
	var nombre         = $("#nombre_seleccion").val();
	var apellido       = $("#apellido_seleccion").val();
	var grado          = $("#id_grado").val();
	var seccion        = $("#id_seccion").val();
	var id_ano_escolar = $("#id_ano_escolar").val();
	var ano_escolar    = $("#ano_escolar").val();

	//Verificamos que todos los campos esten llenos
	if(id_docente == "" || cedula == "" || nombre == "" || apellido == "" || grado == "" || seccion == "" || id_ano_escolar == "" || ano_escolar == ""){
		alertify.error("Please fill in all the fields");
	}
	else{
		//Creamos las columnas
		var colum = "<td width='450px'>";
		colum    += "<input type='hidden' name='id_docente_asignado[]' value='"+id_docente+"'/>";
		colum    += "I.D. Number: "+cedula+" "+" - "+" "+nombre+" "+apellido;
		colum    += "</td>";

		colum    += "<td width='250px'>";
		colum    += "<input type='hidden' name='id_ano_escolar_asignado[]' value='"+id_ano_escolar+"'/>";
		colum    +=	$("#id_grado option:selected").text();
		colum    += "</td>";

		colum    += "<td width='110px'>";
		colum    +=	"<input type='hidden' name='id_seccion_asignado[]' value='"+seccion+"'/>";
		colum    += $("#id_seccion option:selected").text();
		colum    += "</td>";

		var tabla = document.getElementById("cuerpo-tabla-asignado");

		var contFila = tabla.rows.length;

		//Agregamos la columna a la fila
		var fila = tabla.insertRow(contFila);
		fila.innerHTML = colum;
		fila.title = "Select the Assignment that you desire";
		fila.className = "eliminarSeleccion";

		//Limpiamos los campos
		$("#id_docente_seleccion").val("");
		$("#cedula_seleccion").val("");
		$("#nombre_seleccion").val("");
		$("#apellido_seleccion").val("");
		$("#id_grado").val("");
		$("#id_seccion").val("");
		$("#cont").val( parseInt($("#cont").val()) + 1 ); 

		//Volvemos a realizar la busqueda
		buscarDocente($("#buscar_docente").val(), "lista-seleccion-docente");
	}
}

function modificarAsignacion(){
	eliminarFila("cuerpo-tabla-asignado");
	eliminarFila("lista-seleccion-docente");

	$("#cont").val("0");

	$("#incluir").attr("hidden", true);
	$("#modificar").attr("hidden", false);
	$("#eliminar").attr("hidden", false);

	var id_ano_escolar = $("#buscar").val();

	$('#cuerpo-tabla-maestro tr').each(function () {
		var id_docente = $(this).find("td").eq(0).find("input[name='id_docente']").val();
		var nombre = $(this).find("td").eq(0).text();
		var grado = $(this).find("td").eq(1).text();
		var id_seccion = $(this).find("td").eq(2).find("input[name='id_seccion']").val();
		var letra_seccion = $(this).find("td").eq(2).text();
		
		//Creamos las columnas
		var colum = "<td width='450px'>";
		colum    += "<input type='hidden' name='id_docente_asignado[]' value='"+id_docente+"'/>";
		colum    += nombre + "</td>";

		colum    += "<td width='250px'>";
		colum    += "<input type='hidden' name='id_ano_escolar_asignado[]' value='"+id_ano_escolar+"'/>";
		colum    +=	grado;
		colum    += "</td>";

		colum    += "<td width='110px'>";
		colum    +=	"<input type='hidden' name='id_seccion_asignado[]' value='"+id_seccion+"'/>";
		colum    += letra_seccion;
		colum    += "</td>";

		var tabla = document.getElementById("cuerpo-tabla-asignado");

		var contFila = tabla.rows.length;

		//Agregamos la columna a la fila
		var fila = tabla.insertRow(contFila);
		fila.innerHTML = colum;
		fila.title = "Select on the Assignment that you wish to delete";
		fila.className = "eliminarSeleccion";

		$("#cont").val( parseInt($("#cont").val()) + 1 ); 
	});

	//Volvemos a realizar la busqueda
	buscarDocente($("#buscar_docente").val(), "lista-seleccion-docente");

	//redireccionar("#dos");
}

function error(){
	alertify.error("Error to load the teachers")
}

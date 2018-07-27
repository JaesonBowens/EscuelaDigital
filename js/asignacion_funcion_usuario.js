$(document).ready(function(){
	$("#incluir").click(function(){
		var valido = validar();

		if( valido ){
			alertify.confirm("Do you want to save the Type of User?", function(c){
				if(c){
					boton = document.getElementById("incluir");
					boton.type = "submit" ;
					boton.click();
				}
			});
		}
	});

	$("#modificar").click(function(){
		var valido = validar();

		if( valido ){
			alertify.confirm("Do you want to modify the Type of User?", function(c){
				if(c){
					boton = document.getElementById("modificar");
					boton.type = "submit" ;
					boton.click();
				}
			});
		}
	});

	$("#eliminar").click(function(){
		alertify.confirm("Do you want to delete the Type of User?", function(c){
			if(c){
				boton = document.getElementById("eliminar");
				boton.type = "submit" ;
				boton.click();
			}
		});
	});

	//Cada vez que se deje pulsado .seleccion por 750ms
	$(document).on("taphold", ".seleccion", function(){
		var id     = $(this).attr("id");
		var nombre = $(this).text();

		$("#id_tipo_usuario").val(id);
		$("#descripcion_tipo_usuario").val(nombre);

		consultarFuncionUsuario(id);

		desactivarIncluir();
	});

	//Cada vez que se deje pulsado .seleccion por 750ms
	$(document).on("dblclick", ".seleccion", function(){
		var id     = $(this).attr("id");
		var nombre = $(this).text();

		$("#id_tipo_usuario").val(id);
		$("#descripcion_tipo_usuario").val(nombre);

		consultarFuncionUsuario(id);

		desactivarIncluir();

		redireccionar('#form-maestro');
	});

	//Desactivo el sombreado y seleccion
	$("#cuerpo-tabla-maestro").disableSelection();

	//Pasar funcion de usuario
	$(document).on("swiperight", ".seleccion-funcion", function(){
		var id_funcion     = $(this).find("td").eq(0).find("input[name='id_funcion']").val();
		var nombre_funcion = $(this).find("td").eq(0).text();

		asignarFuncion(id_funcion, nombre_funcion);

		$(this).remove();
	});

	$(document).on("dblclick", ".seleccion-funcion", function(){
		var id_funcion     = $(this).find("td").eq(0).find("input[name='id_funcion']").val();
		var nombre_funcion = $(this).find("td").eq(0).text();

		asignarFuncion(id_funcion, nombre_funcion);

		$(this).remove();
	});

	//Eliminar funcion de usuario
	$(document).on("swipeleft", ".seleccion-asignacion", function(){
		var id_funcion     = $(this).find("td").eq(0).find("input[name='id_funcion_usuario']").val();
		var nombre_funcion = $(this).find("td").eq(0).text();

		eliminarAsignacion(id_funcion, nombre_funcion)		

		$(this).remove();
	});

	$(document).on("dblclick", ".seleccion-asignacion", function(){
		var id_funcion     = $(this).find("td").eq(0).find("input[name='id_funcion_usuario']").val();
		var nombre_funcion = $(this).find("td").eq(0).text();

		eliminarAsignacion(id_funcion, nombre_funcion)		

		$(this).remove();
	});
});

function validar(){
	var cont = 0;

	$("#cuerpo-asignacion-funcion tr").each(function(){
		cont++;
	});

	if( $("#descripcion_tipo_usuario").val() == "" ){
		alertify.error("You must indicate the name of the Type of User");
		$("#descripcion_tipo_usuario").focus();
		return false;
	}
	else if( cont == 0 ){
		alertify.error("You must assign functions to the Type of User");
		return false;
	}
	else{
		return true;
	}
}

function asignarFuncion(id_funcion, nombre_funcion){
	var fila = "<tr class='seleccion-asignacion' title='Doble Click to delete the Assignment'>";
	fila += "<td width='400px'><input type='hidden' name='id_funcion_usuario[]' value='"+id_funcion+"' />" + nombre_funcion + "</td>";
	fila += "</tr>";

	$("#cuerpo-asignacion-funcion").append(fila);

	document.getElementById("cont").value  = parseInt(document.getElementById("cont").value) + 1; 
}

function eliminarAsignacion(id_funcion, nombre_funcion){
	var fila = "<tr class='seleccion-funcion' title='Doble Click on the Function that you want to assign to the Type of User'>";
	fila += "<td width='395px'><input type='hidden' name='id_funcion' value='"+id_funcion+"' />" + nombre_funcion + "</td>";
	fila += "</tr>";

	$("#cuerpo-funcion-usuario").append(fila);

	document.getElementById("cont").value  = parseInt(document.getElementById("cont").value) - 1;
}

function consultarFuncionUsuario(id){
	$.ajax({
		url: "../cabecera/funcion_usuario.php",
		type: "GET",
		async: true,
		dataType: "json",
		data: "consultarUso="+id,
		success: cargarAsignacion,
		error: function(){ alertify.error("Error"); }
	});

	redireccionar("#form-maestro");
}

function cargarAsignacion(funcion){
	var tabla1 = document.getElementById("cuerpo-funcion-usuario");
	var tabla = document.getElementById("cuerpo-asignacion-funcion");

	limpiarTabla();

	for(var i = 0; i<funcion.length; i++){
		var colum = "<td width='400px'>";
		colum += "<input type='hidden' name='id_funcion_usuario[]' value='"+funcion[i].id_funcion_usuario+"' />"
		colum += funcion[i].nombre_funcion_usuario;
		colum += "</td>";

		nueva_fila = tabla.insertRow(tabla.rows.length);
		nueva_fila.title = "Doble Click to delete the Assignment";
		nueva_fila.className = "seleccion-asignacion";
		nueva_fila.innerHTML = colum;

		document.getElementById("cont").value  = parseInt(document.getElementById("cont").value) + 1; 
		
		for(var j = 0; j<tabla1.rows.length; j++){
			var fila = tabla1.rows[j].cells[0].childNodes[0].value;

			if(fila == funcion[i].id_funcion_usuario){
				tabla1.rows[j].remove();
			}
		}
	}
}

function limpiarTabla(){
	var tabla = document.getElementById("cuerpo-asignacion-funcion");

	for(var j = 0; j<tabla.rows.length; j++){
		eliminarAsignacion(tabla.rows[j]);
		j--;
	}
}

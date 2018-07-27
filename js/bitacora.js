//Recivimos lo que se va a buscar, el id del div donde se colocara la informacion
//y la direccion del controlador donde se ejecutara la busqueda
function busquedaAvanzadaBitacora(buscar, div, link, nombre){

	var buscar_fecha, buscar_tabla, buscar_operacion;

	if($("#buscar_fecha").val() != ""){
		buscar_fecha = $("#buscar_fecha").val();
	}else{
		buscar_fecha = "00/00/00";
	}
	
	buscar_tabla = $("#buscar_tabla").val();
	buscar_operacion = $("#buscar_operacion").val();

	conexion = iniciarAjax();

	conexion.onreadystatechange = function(){
		if(conexion.readyState == 4 && conexion.status == 200){
			document.getElementById(div).innerHTML = conexion.responseText;
		}
	}

	conexion.open("GET", link+"?"+nombre+"="+buscar+"&&fecha="+buscar_fecha+"&&tabla="+buscar_tabla+"&&operacion="+buscar_operacion, true);
	conexion.send();
}

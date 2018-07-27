//Recivimos lo que se va a buscar, el id del div donde se colocara la informacion
//y la direccion del controlador donde se ejecutara la busqueda
function busquedaAvanzadaLogSistema(buscar, div, link, nombre){

	var buscar_fecha;

	if($("#buscar_fecha_log").val() != ""){
		buscar_fecha = $("#buscar_fecha_log").val();
	}else{
		buscar_fecha = "00/00/00";
	}

	conexion = iniciarAjax();

	conexion.onreadystatechange = function(){
		if(conexion.readyState == 4 && conexion.status == 200){
			document.getElementById(div).innerHTML = conexion.responseText;
		}
	}

	conexion.open("GET", link+"?"+nombre+"="+buscar+"&&fecha="+buscar_fecha, true);
	conexion.send();
}

$(document).ready(function(){

	$("#respaldarBD").click(function(){
		var nombre_respaldo = $("#nombre_respaldo").val();

    		if( nombre_respaldo.length < 1 ){
    			alertify.error("You must enter the name of the Back-up");
    			$("#nombre_respaldo").focus();
    		}else{
			document.respaldarBaseDato.submit();
			limpiarCampoNombreRespaldo();
		}
    	});

	$("#cancelarRespaldarBD").click(function(){

		limpiarCampoNombreRespaldo();

    	});

    	$("#respaldar_tabla").click(function(){
		var nombre_tabla = $("#nombre_tabla").val();

    		if( nombre_tabla.length < 1 ){
    			alertify.error("You must select the table that you want to Back-up");
    			$("#nombre_tabla").focus();
    		}else{
			document.respaldarTablaBaseDato.submit();

			limpiarCampoTabla();
		}
    	});

	$("#cancelarRespaldarTablaBD").click(function(){

		limpiarCampoTabla();

    	});

    	$("#restaurar").click(function(){
    		if( $("#ficheroDeCopia").val() == "" ){
    			alertify.error("You must select the Data Base that you want to Restore");
    			$("#ficheroDeCopia").focus();
    		}else{

			$( '#nav' ).css({
    				pointerEvents: 'none'
			});

			cargarProcesoImagen("../imagen/icon/cargando.gif");
			document.restaurarBD.submit();
			//ejecutarProceso();
		}
    	});

	$("#cancelarRestaurarBD").click(function(){

		limpiarFicheroDeCopia();

    	});

});


function emitirResultado(dato){

	alertify.alert(dato.msj);

}

//Funcion para mostrar los mensajes
function cargarProcesoImagen(img){

	setTimeout(function(){
		$.blockUI({ message: '<br><br>Please Wait! It´s Loading<br><br><img src="'+img+'" class="img-mensaje" />' });
	}, 500);

}


/*function cargarProcesoImagen(){
	$(".alerta").css("display", "block");
}*/

function destruirProcesoImagen(){
	$(".alerta").css("display", "none");
}

//Limpia los campos
function limpiarCampoNombreRespaldo(){
	document.getElementById("nombre_respaldo").value = "";
}

function limpiarCampoTabla(){
	document.getElementById("nombre_tabla").value = "";
}

function limpiarFicheroDeCopia(){
	document.getElementById('ficheroDeCopia').value=null;
}

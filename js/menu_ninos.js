$(document).ready(function(){	

	$(".matematica").mouseover(function(){
		$("#ico-matematica").hide();
		$("#ico-video-matematica").show();				
	});

	$(".matematica").mouseout(function(){
		$("#ico-matematica").show();
		$("#ico-video-matematica").hide();				
	});

	$(".lenguaje").mouseover(function(){
		$("#ico-lenguaje").hide();
		$("#ico-video-lenguaje").show();				
	});

	$(".lenguaje").mouseout(function(){
		$("#ico-lenguaje").show();
		$("#ico-video-lenguaje").hide();				
	});

	$("#cambiar-contenido").click(function(){
		let url = "../cabecera/campos_de_seleccion/contenido.php";

		$.post(url, {contenido : true}, function(data){
			if(data){
				$("#asig-contenido tr").remove();
				$("#asig-contenido").append(data);
				$("#section-asig-contenido").show();
			}
		})
	});

	$("#seleccion-todo").click(function(){
		comprobarSeleccion() ? deseleccionarTodo() : seleccionarTodo();
	});

	$("#cerrar").click(function(){
		$("#section-asig-contenido").hide();
	});

	$("#actualizar").click(function(){
		seleccion();
	});
});

const seleccion = () => {
	let id = new Array();

	$("#asig-contenido tr").each(function(){
		$(this).find("td").eq(0).find("input[name='seleccion']").is(':checked') ? id.push($(this).find("td").eq(0).find("input[name='seleccion']").val()) : false;
	});

	if(id.length != 0){
		var dato = {
			contenido : id
		};

		$.post("../controlador/asignacion_pc.php", { comprobarActividad : JSON.stringify(dato) }, function(data){
			data = JSON.parse(data);

			( data.resultado == "YES" ) ? window.location = "../controlador/asignacion_pc.php?actualizar=true&&contenido="+JSON.stringify(dato) : alertify.error(data.msj);
		});
	}
	else{
		alertify.error("Please select Contents for the Activities!");
	}
}

const comprobarSeleccion = () => {
	let resul = true;

	$("#asig-contenido tr").each(function(){
		let checked = $(this).find("td").eq(0).find("input[name='seleccion']").is(':checked') ? true : resul = false;
	});
	
	return resul;
}

const seleccionarTodo = () => {
	$("#asig-contenido tr").each(function(){
		$(this).find("td").eq(0).find("input[name='seleccion']").prop("checked", true);
	});
}

const deseleccionarTodo = () => {
	$("#asig-contenido tr").each(function(){
		$(this).find("td").eq(0).find("input[name='seleccion']").prop("checked", false);
	});
}
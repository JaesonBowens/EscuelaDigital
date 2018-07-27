function cambiarId(){
	var nav = document.getElementById("menu-admin");
	var section = document.getElementById("menu-infor");

	if(nav.className == "abrir-menu-admin" && section.className == "abrir-menu-infor"){
		nav.className = "ocultar-menu-admin";
		section.className = "ocultar-menu-infor";
	}
	else if(nav.className == "ocultar-menu-admin" && section.className == "ocultar-menu-infor"){
		nav.className = "abrir-menu-admin";
		section.className = "abrir-menu-infor";
	}
}

//Redirecciona
function redireccionar(link){
	window.location = link;
}

//Iniciamos la conexion con ajax
function iniciarAjax(){
	var conexion;

	if(window.XMLHttpRequest){
		conexion = new XMLHttpRequest();
	}
	else{
		conexion = new ActiveXObject("Microsotf.XMLHTTP");
	}

	return conexion;
}

//Captura la seleccion de la tabla ademas recive los nombres de los 
//inputs donde colocara los datos
function seleccion(tr, input1, input2){
	var id     = tr.id;
	var nombre = tr.innerHTML;

	document.getElementById(input1).value = id;
	document.getElementById(input2).value = nombre;

	desactivarIncluir();
}

//Captura la seleccion de la tabla ademas recive los nombres de los 
//inputs donde colocara los datos
function seleccionFilaCat(tr){
	
	var id_est     = tr.id;

	var ano_escolar = $("#id_ano_escolar").val();
	var nivel 	= $("#id_grado").val();
	var grupo 	= $("#id_seccion").val();

	$("#id_ano_escolar_rep").val(ano_escolar);
	$("#id_grado_rep").val(nivel);

	busquedaAvanzadaRapido(nivel, grupo, "id_seccion_rep", "../cabecera/campos_de_seleccion/seccion.php", "consultar_seleccionada");

	$("#id_est_rep").val(id_est);

	document.getElementById("reporte").hidden = "";

	redireccionar("#form-maestro");
}


//Limpia los campos
function limpiar(input){
	for(i=0; i<input.length; i++){
		document.getElementById(input[i]).value = "";
	}

	activarIncluir();
}

//Limpia los campos solo del ejercicio
function limpiarEjercicio(input){
	for(i=0; i<input.length; i++){
		document.getElementById(input[i]).value = "";
		
		if(input[i] == "respuesta" || input[i] == "mensaje" ){
			document.getElementById(input[i]).disabled = 'disabled';
		}
		else{
			document.getElementById(input[i]).disabled = '';	
		}
	}

	activarIncluir();
}


function activarCampoEjercicio(input){
	for(i=0; i<input.length; i++){
		
		document.getElementById(input[i]).disabled = '';	
		
	}
}


//Oculta el boton incluir y coloca visible modificar y eliminar
function desactivarIncluir(){
	document.getElementById("incluir").hidden   = "hidden";
	document.getElementById("modificar").hidden = "";
	document.getElementById("eliminar").hidden  = "";
}

//Recive como parametro los nombres de los inputs del furmolario y los vacia
//ademas oculta los botones modificar y eliminar y coloca visible el de incluir
function activarIncluir(){
	document.getElementById("incluir").hidden   = "";
	document.getElementById("modificar").hidden = "hidden";
	document.getElementById("eliminar").hidden  = "hidden";
}


function actualizarCampoUsuario(input1){
	document.getElementById("nombre_usuario").value = input1;

	var nombre_usuario = $("#nombre_usuario").val();

	var id_usuario = $("#id_usuario").val();

	verificarNombreUsuario(id_usuario, nombre_usuario);
}
//****************************************************//
//Funciones con AJAX
//****************************************************//

//Recivimos lo que se va a buscar, el id del div donde se colocara la informacion
//y la direccion del controlador donde se ejecutara la busqueda
function busquedaAvanzada(buscar, div, link, nombre){
	conexion = iniciarAjax();

	conexion.onreadystatechange = function(){
		if(conexion.readyState == 4 && conexion.status == 200){
			document.getElementById(div).innerHTML = conexion.responseText;
		}
	}

	conexion.open("GET", link+"?"+nombre+"="+buscar, true);
	conexion.send();
}


//Recivimos lo que se va a buscar, el id del div donde se colocara la informacion
//y la direccion del controlador donde se ejecutara la busqueda
function busquedaAvanzadaSeccionSelect(buscar, buscar2, div, link, nombre){
	conexion = iniciarAjax();

	conexion.onreadystatechange = function(){
		if(conexion.readyState == 4 && conexion.status == 200){
			document.getElementById(div).innerHTML = conexion.responseText;
		}
	}

	conexion.open("GET", link+"?"+nombre+"="+buscar+"&&id_seccion="+buscar2, true);
	conexion.send();
}

//Recivimos lo que se va a buscar, el id del div donde se colocara la informacion
//y la direccion del controlador donde se ejecutara la busqueda
function busquedaAvanzadaEstudiantil(buscarEst, divEst, linkEst, nombreEst){
	
	var ano_escolar = $("#id_ano_escolar").val();
	
	var grado = $("#id_grado").val();

	conexion = iniciarAjax();

	conexion.onreadystatechange = function(){
		if(conexion.readyState == 4 && conexion.status == 200){
			document.getElementById(divEst).innerHTML = conexion.responseText;
		}
	}

	conexion.open("GET", linkEst+"?"+nombreEst+"="+buscarEst+"&&ano_escolar="+ano_escolar+"&&grado="+grado, true);
	conexion.send();

}

//Capturamos la el id de la fila seleccionada y consultamos los datos 
function seleccionFila(tr, div, link, nombre){
	var id = tr.id;

	busquedaAvanzada(id, div, link, nombre);

	desactivarIncluir();

}

function cargarGrado(denominacion){

	$("#id_seccion").val("");

	busquedaAvanzada(denominacion, "id_grado", "../cabecera/campos_de_seleccion/grado.php", "consultar");

}

function cargarSeccion(nivel){
	busquedaAvanzada(nivel, "id_seccion", "../cabecera/campos_de_seleccion/seccion.php", "consultar");
}

function cargarSeccionCatalogoImagen(nivel){
	busquedaAvanzada(nivel, "buscar_seccion", "../cabecera/campos_de_seleccion/seccion.php", "consultar");
}

function limpiarTablaMaestro(){

	document.getElementById("cuerpo-tabla-maestro").innerHTML = "";

}


function consultarCedulaDocente(cedula){
	var resul = buscarJson(cedula, "../controlador/gestionar_docente.php", "consultarCedula", "lista_cedula");
}

function buscarJson(buscar, link, nombre, datalist){
	conexion = iniciarAjax();

	var arreglo = {consultar: buscar};

	var cadena = arreglo.toJSONString();

	conexion.onreadystatechange = function(){
		if(conexion.readyState == 4 && conexion.status == 200){
			var docente =  conexion.responseText.parseJSON();
			cargarDataList(docente, datalist);
		}
	}

	conexion.open("GET", link + "?" + nombre +"="+ cadena, true);
	conexion.send();	
}

/*function cargarDataList(lista, id){
	var option;
	for(var i = 0; i < lista.length; i++){
		option = option + "<option value='"+ lista[i].cedula +"' label='"+ lista[i].cedula +"'/>";
	}

	document.getElementById(id).innerHTML = "";
	document.getElementById(id).innerHTML = option;
}*/

function imagenPredeterminada(){
	document.getElementById('id_mostrar_imagen').src = "../imagen/default-imagen.jpg";
}

function cargarSeccionSeleccion(nivel_grado, grupo_seccion){
	busquedaAvanzadaRapido(nivel_grado, grupo_seccion, "id_seccion", "../cabecera/campos_de_seleccion/seccion.php", "consultar_seleccionada");
}


//Recivimos lo que se va a buscar, el id del div donde se colocara la informacion
//y la direccion del controlador donde se ejecutara la busqueda
function busquedaAvanzadaRapido(buscar, buscar2, div, link, nombre){
	conexion = iniciarAjax();

	conexion.open("GET", link+"?"+nombre+"="+buscar+"&&seleccion="+buscar2, false);
	conexion.send();
	document.getElementById(div).innerHTML = conexion.responseText;
}



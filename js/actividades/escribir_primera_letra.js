var lng_sena;

$(document).ready(function(){
	//declaracion de variables globales
	var id_img, imagen, audio, pregunta, respuesta, primera_letra;
	var comienzo, fin, tiempo_llevado;

	//Iniciamos la actividad
	cargarActividad("");

	//Cunado el Usuario pulse uno de las letras se activa el evento
	$(document).on("click", ".boton-letra", function(){
		letra($(this).text().charCodeAt());
	});

	//Cada vez que el usuario envie la respuesta
	$("#enviarRespuesta").click(function(){
		var campoRespuesta = $("#campoRespuesta-letra").val().toUpperCase();
	
		letra(campoRespuesta);
	});
	
	$("#campoRespuesta-letra").keyup(function (e) {
    		if (e.keyCode == 13) {
        		var campoRespuesta = $("#campoRespuesta-letra").val().toUpperCase();
	
			letra(campoRespuesta);
    		}
	});

	$("#informacion-texto").click(function(){
		detenerVideo("lenguaje/escribir_primera_letra/escribir_primera_letra.webm");
		detenerVideo("lenguaje/escribir_primera_letra/lenguaje_signo/escribir_primera_letra.webm");

		$(".video").hide();

		$(".guia").fadeIn(500);
	});

	$("#informacion-video").click(function(){
		cargarVideoFullScreen("lenguaje/escribir_primera_letra/escribir_primera_letra.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$("#informacion-lenguaje-signo").click(function(){
		cargarVideo("lenguaje/escribir_primera_letra/lenguaje_signo/escribir_primera_letra.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$("#img-cargar").mouseover(function(){

		var snd = document.getElementById("tocar-audio"); 
		
		snd.play();	

		var ext = lng_sena.substring(lng_sena.lastIndexOf('.') + 1).toLowerCase();

		if(ext == "ogg" || ext == "webm" || ext == "mp4"){

			cargarVideo(lng_sena);

			$(".guia").hide();

			$(".video").fadeIn(500);

		}else if(ext == "gif" || ext == "png" || ext == "bmp" || ext == "jpeg" || ext == "jpg"){

			$(".lenguaje_sena_img").attr("src", lng_sena);

			$(".guia").hide();

			$(".video").hide();

			$(".lenguaje_sena_img").fadeIn(500);

		}		
	});

	$('#act-video').on('ended',function(){

		if(document.mozCancelFullScreen){
        		document.mozCancelFullScreen();
      		}else if(vid.webkitExitFullScreen){
        		document.webkitExitFullScreen();
      		}
			
			$(".video").hide();

		    $(".lenguaje_sena_img").hide();

		    $(".guia").fadeIn(500);
   	});

});

function validarLetra(e){
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key).toUpperCase();
	letras = " ÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
	especiales = [8,164,13,165, 37, 38, 39, 40, 13];

	tecla_especial = false
	for(var i in especiales){
		if(key == especiales[i]){
			tecla_especial = true;
			break;
		}
	}

	if(letras.indexOf(tecla)==-1 && !tecla_especial){
		return false;
	}	
}

//Funcion para ejecutar eventos que se activaran con el teclado
function letra(key){
	if(primera_letra == key){

		mostrarMensaje("../../imagen/icon/exito.png","lenguaje/felicitaciones.webm","../../audio/efecto_sonido/felicitaciones.ogg");

		fin = getActual();	

		anotarDesempeno();

		setTimeout(function(){
			cargarActividad();
		}, 3000);

		$("#intentoCont").val(0);
	}
	else{
		mostrarMensaje("../../imagen/icon/fracaso1.png","lenguaje/error_repetir.webm","../../audio/efecto_sonido/error_repetir.ogg");

		$("#campoRespuesta-letra").val("");

		$("#intentoCont").val( parseInt($("#intentoCont").val()) + 1 );
	}
}

//Funcion para mostrar los mensajes
function mostrarMensaje(img,lng_sign,sonido){
	setTimeout(function(){
		$.blockUI({ message: '<img src="'+img+'" class="img-mensaje" />' });

		$(".guia").hide();

		$(".video").fadeIn(100);

		cargarVideo(lng_sign);
	}, 500);

	/*setTimeout(function(){
		$.blockUI({ message: '<video class="video-mensaje" autoplay="autoplay"><source src="'+lng_sign+'" type="video/mp4" /></video>' });
	}, 500);*/

	var snd = new Audio(sonido); // buffers automatically when created
	snd.play();

	setTimeout(function(){
		$.unblockUI();
		$(".video").hide();

		$(".guia").fadeIn(500);
	}, 5000);

}

//Funcion para cargar la actividad con ajax
function cargarActividad(){
	//Llamamos al controlador para que se active la actividad
	//Reciviendo como respuesta variables tipo JSON
	//y cargando las funciones respectivas
	$.ajax({
		url: "../../controlador/actividades/escribir_primera_letra.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "consultarActividad=",
		success: mostrarActividad,
		error: cargarError
	}); 

	comienzo = getActual();
}

//Funcion para mosrar la actividad
function mostrarActividad(data){
	if(data.id_img == "exit"){
		window.location = "../menu_ninos_lenguaje.php";
	}
	
	//Recivimos las respuestas del Controlador
	id_img = data.id_img;
	imagen    = data.direccion;
	lng_sena = data.lng_sena;
	audio     = data.audio;
	pregunta  = data.pregunta;

	//Descomponemos la palabra
	var descomponer = pregunta.split("");
	//Guardamos la primera letra
	primera_letra = descomponer[0];

	$("#resto-palabra").text("");

	for( var i = 1; i < descomponer.length; i++ ){
		$("#resto-palabra").append(descomponer[i]);
	}

	$("#img-cargar").attr("src", imagen);
	$("#tocar-audio").attr("src", audio);
	$("#campoRespuesta-letra").val("");
}

//Los que mostramos si la consulta Ajax no se ejecuto perfect
function cargarError(){
	alert("Error requesting information from the server");
}

//Funcion anotar desempeno
function anotarDesempeno(){

	var intento = $("#intentoCont").val();
	var tiempo_llevado = getTiempoLlevado(comienzo, fin); 
	var id = id_img;
	
	var parametros = {
		intentoP : intento,
		tiempo_llevadoP : tiempo_llevado,
		id_imagen : id_img
	}

	$.ajax({
		url: "../../controlador/actividades/escribir_primera_letra.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "anotar="+JSON.stringify(parametros)
        	
	});

}

function getTiempoLlevado(c, f) {
    var dif = f - c;
    var dif2 = new Date(dif);
    var hora    = dif2.getHours();
    var minuto  = dif2.getMinutes();
    var segundo  = dif2.getSeconds(); 
      
    if(hora.toString().length == 1) {
        var hora = '0'+hora;
    }else if(hora == 20){
	var hora ='00';
    }
    if(minuto.toString().length == 1) {
        var minuto = '0'+minuto;
    }
    if(segundo.toString().length == 1) {
        var segundo = '0'+segundo;
    }   

    var dif3 = hora+':'+minuto+':'+segundo;   
    return dif3;
}

function getActual() {
    var ahora     = new Date();
    var ano    = ahora.getFullYear();
    var mes   = ahora.getMonth()+1; 
    var dia     = ahora.getDate(); 
    var hora    = ahora.getHours();
    var minuto  = ahora.getMinutes();
    var segundo  = ahora.getSeconds(); 
     
    if(mes.toString().length == 1) {
        var mes = '0'+mes;
    }
    if(dia.toString().length == 1) {
        var dia = '0'+dia;
    }  
    if(hora.toString().length == 1) {
        var hora = '0'+hora;
    }
    if(minuto.toString().length == 1) {
        var minuto = '0'+minuto;
    }
    if(segundo.toString().length == 1) {
        var segundo = '0'+segundo;
    }   

   /* var actual = ano+'/'+mes+'/'+dia+' '+hora+':'+minuto+':'+segundo;   
    return actual;*/

    var actual = new Date(ano+'/'+mes+'/'+dia+' '+hora+':'+minuto+':'+segundo);  
    var millisegundos    = actual.getTime();
    return millisegundos;
}

function cargarVideo(nombre_video){
	$("#act-video").attr("src", "../../video/"+nombre_video);

	var vid = document.getElementById("act-video");

	vid.autoplay = true;
    	vid.load();

}

function cargarVideoFullScreen(nombre_video){
	$("#act-video").attr("src", "../../video/"+nombre_video);

	var vid = document.getElementById("act-video");

	vid.autoplay = true;
    	vid.load();

	if(vid.requestFullscreen) {
              //alert("requestFullscreen");
               vid.requestFullscreen();
        }else if (vid.mozRequestFullScreen) {
               //alert("mozRequestFullScreen");
               vid.mozRequestFullScreen();
        }else if (vid.webkitRequestFullScreen) {
               //alert("webkitRequestFullScreen");
               vid.webkitRequestFullScreen();
        }
}

function detenerVideo(nombre_video){

	$("#act-video").attr("src", "../../video/"+nombre_video);

	var vid = document.getElementById("act-video");

	vid.autoplay = false;
    	vid.load();
}




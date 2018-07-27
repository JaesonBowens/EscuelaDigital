var lng_sena;

$(document).ready(function(){
	//declaracion de variables globales
	var id_img, imagen, audio, respuesta;
	var comienzo, fin, tiempo_llevado;

	//Iniciamos la actividad
	cargarActividad("");

	$("#hora").keyup(function() {
		var min = 1;
		var max = 12;

		var value = $("#hora").val();

		if( value < min ){
			$("#hora").val("");
		}
		else if( value > max ){
			$("#hora").val("");
		}
	});

	$("#minuto").keyup(function(){
		var min = 0;
		var max = 59;

		var value = $("#minuto").val();

		if( value < min ){
			$("#minuto").val("");
		}
		else if( value > max ){
			$("#minuto").val("");
		}
	});

	//Cada vez que el usuario envie la respuesta
	$("#enviarRespuesta7").click(function(){
		var hora   = $("#hora").val().toUpperCase();
		var minuto = $("#minuto").val().toUpperCase();
		var segundo = 00;

		var campoRespuesta = hora+":"+minuto;

		numero(campoRespuesta);
	});

	$("#informacion-texto").click(function(){
		detenerVideo("matematica/hora/hora.webm");
		detenerVideo("matematica/hora/lenguaje_signo/hora.webm");

		$(".video").hide();

		$(".guia").fadeIn(500);
	});

	$("#informacion-video").click(function(){
		cargarVideoFullScreen("matematica/hora/hora.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$("#informacion-lenguaje-signo").click(function(){
		cargarVideo("matematica/hora/lenguaje_signo/hora.webm");

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

function validarNumero(e){
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key).toUpperCase();
	letras = " 0123456789";
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
function numero(key){
	if(respuesta == key){

		mostrarMensaje("../../imagen/icon/exito.png","matematica/felicitaciones.webm","../../audio/efecto_sonido/felicitaciones.ogg");

		fin = getActual();	

		anotarDesempeno();

		setTimeout(function(){
			cargarActividad();
			$("#hora").val("");
			$("#minuto").val("");
		}, 3000);

		$("#intentoCont").val(0);			
	}
	else{
		mostrarMensaje("../../imagen/icon/fracaso1.png","matematica/error_repetir.webm","../../audio/efecto_sonido/error_repetir.ogg");

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
		url: "../../controlador/actividades/escribir_hora.php",
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
		window.location = "../menu_ninos_matematica.php";
	}

	//Recivimos las respuestas del Controlador
	id_img = data.id_img;
	imagen    = data.direccion;
	lng_sena = data.lng_sena;
	audio     = data.audio;
	respuesta = data.respuesta;

	//Limpiamos los elementos
	$(".preg-actividad-1 p").remove();

	//Mostramos en pantalla
	$("#img-cargar").attr("src", imagen);
	$("#tocar-audio").attr("src", audio);
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
		url: "../../controlador/actividades/escribir_hora.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "anotar="+JSON.stringify(parametros)
        	
	});

}

function getTiempoLlevado(c, f) {
    var dif = f - c;
    var dif2 = new Date(dif);
    var horaDif    = dif2.getHours();
    var minutoDif  = dif2.getMinutes();
    var segundoDif  = dif2.getSeconds(); 
      
    if(horaDif.toString().length == 1) {
        var horaDif = '0'+horaDif;
    }else if(horaDif == 20){
	var horaDif ='00';
    }
    if(minutoDif.toString().length == 1) {
        var minutoDif = '0'+minutoDif;
    }
    if(segundoDif.toString().length == 1) {
        var segundoDif = '0'+segundoDif;
    }   

    var dif3 = horaDif+':'+minutoDif+':'+segundoDif;   
    return dif3;
}

function getActual() {
    var ahora     = new Date();
    var ano    = ahora.getFullYear();
    var mes   = ahora.getMonth()+1; 
    var dia     = ahora.getDate(); 
    var horaActual    = ahora.getHours();
    var minutoActual  = ahora.getMinutes();
    var segundoActual  = ahora.getSeconds(); 
     
    if(mes.toString().length == 1) {
        var mes = '0'+mes;
    }
    if(dia.toString().length == 1) {
        var dia = '0'+dia;
    }  
    if(horaActual.toString().length == 1) {
        var horaActual = '0'+horaActual;
    }
    if(minutoActual.toString().length == 1) {
        var minutoActual = '0'+minutoActual;
    }
    if(segundoActual.toString().length == 1) {
        var segundoActual = '0'+segundoActual;
    }   

    var actual = new Date(ano+'/'+mes+'/'+dia+' '+horaActual+':'+minutoActual+':'+segundoActual);  
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

var abc_ordenado = new Array();
var letra;
var id_img;
var lng_sena;


$(document).ready(function(){
	//declaracion de variables globales
	var comienzo, fin, tiempo_llevado;

	//Iniciamos la actividad
	cargarActividad("");

	$("#lista-ordenable").sortable({
		axis: "x",
		update: function(){
			/*$("#lista-ordenable li").each(function(){
				var elemento = $(this).text().trim();
				alert("\""+elemento+"\"");
			});*/
		}
	});

	$("#lista-ordenable").css("cursor", "pointer");
	$("#lista-ordenable").disableSelection();

	$("#informacion-texto").click(function(){
		detenerVideo("lenguaje/ordenar_palabra/ordenar_palabra.webm");
		detenerVideo("lenguaje/ordenar_palabra/lenguaje_signo/ordenar_palabra.webm");

		$(".video").hide();

		$(".guia").fadeIn(500);
	});

	$("#informacion-video").click(function(){
		cargarVideoFullScreen("lenguaje/ordenar_palabra/ordenar_palabra.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$("informacion-lenguaje-signo").click(function(){
		cargarVideo("lenguaje/ordenar_palabra/lenguaje_signo/ordenar_palabra.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$("#img-ordenar-palabra").mouseover(function(){

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

	$("#enviarRespuesta6").click(function(){
		verificar_abc();
	});

});

//Funcion para verificar lo que el usuario ordeno
function verificar_abc(){

	var resul = validarOrden();

	if(resul){

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

		$("#intentoCont").val( parseInt($("#intentoCont").val()) + 1 );
	}
}

function validarOrden(){
	var i = 0;
	var resul = true;

	//Recorremos la fraccion del abcedario y comparamos
	$("#lista-ordenable li").each(function(){
		var abc = $(this).text();

		if( abc != abc_ordenado[i] ){
			resul = false;
		}

		i++;
	});

	return resul;
}

//Funcion anotar desempeno
function anotarDesempeno(){

	var abc = new Array();

	abc = abc_ordenado;

	var intento = $("#intentoCont").val();
	var tiempo_llevado = getTiempoLlevado(comienzo, fin);
	var id = id_img;
	
	var parametros = {
		intentoP : intento,
		tiempo_llevadoP : tiempo_llevado,
		id_imagen : id_img
	}

	$.ajax({
		url: "../../controlador/actividades/ordenar_palabra.php",
		type: "POST",
		async: true,
		dataType: "json",
		data: "anotar="+JSON.stringify(parametros)
        	
	});

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
		url: "../../controlador/actividades/ordenar_palabra.php",
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
	id_img    = data.id_img;
	imagen    = data.direccion;
	lng_sena = data.lng_sena;
	audio     = data.audio;
	pregunta  = data.pregunta;

	var letra = pregunta.split("");

	palabra = cargarLetras(pregunta);

	var palabra_desorden = palabra;
	
	palabra_desorden = palabra_desorden.sort(function(){
		return Math.random() - 0.5;
	});

	$("#lista-ordenable li").remove();

	for( var i = 0; i < palabra_desorden.length; i++ ){
		$("#lista-ordenable").append("<li>" + palabra_desorden[i] + "</li>");
	}

	$("#img-ordenar-palabra").attr("src", imagen);
	$(".resp-actividad-8").text("Starting with the " + letra[0] );
}

//Cargo solo una fraccion de 5 letras del abecedario
function cargarLetras(pregunta){
	var abc = pregunta.split("");

	abc_mostrar = new Array();

	//Recorremos el abc
	for( var i = 0; i < abc.length; i++ ){
		abc_mostrar[i] = abc[i];
		abc_ordenado[i] = abc[i];
	}

	return abc_mostrar;
}


//Los que mostramos si la consulta Ajax no se ejecuto perfect
function cargarError(){
	alert("Error al Solicitar la Información al Servidor");
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

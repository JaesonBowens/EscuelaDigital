var lng_sena;

$(document).ready(function(){
	//declaracion de variables globales
	var id_img, imagen, audio, pregunta, respuesta, primera_letra;
	var comienzo, fin, tiempo_llevado;

	//Iniciamos la actividad
	cargarActividad("");

	//Entramos en el documento cada vez que el usuario pulse una tecla
	$(document).keydown(function(key){
		//Llamamos la funcion letra pasando como parametro lo que el usaurio pulse
		letra(key.which);
	});

	//Cunado el Usuario pulse uno de las letras se activa el evento
	$(document).on("click", ".boton-vocal", function(){
		letra($(this).text().charCodeAt());
	});

	//Cuando el Usuario pulse uno de las letras se activa el evento
	$(document).on("mouseover", ".boton-vocal", function(){
		letraLenguajeSena($(this).text().charCodeAt());
	});

	//Cuando el Usuario pulse uno de las letras se activa el evento
	$(document).on("mouseout", ".boton-vocal", function(){
		$(".resp-lng-sena").fadeOut(10);
	});

	$("#informacion-texto").click(function(){

		detenerVideo("lenguaje/falta_vocales/falta_vocales.webm");
		detenerVideo("lenguaje/falta_vocales/lenguaje_signo/falta_vocales.webm");

		$(".video").hide();

		$(".guia").fadeIn(500);
	});

	$("#informacion-video").click(function(){
		cargarVideoFullScreen("lenguaje/falta_vocales/falta_vocales.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$("#informacion-lenguaje-signo").click(function(){
		cargarVideo("lenguaje/falta_vocales/lenguaje_signo/falta_vocales.webm");

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

function letraLenguajeSena(key){

	var letra = String.fromCharCode(key);

	$(".resp-lng-sena").fadeIn(10);

	if(letra == 'A'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/a.png");
	}

	if(letra == 'E'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/e.png");
	}

	if(letra == 'I'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/i.png");
	}

	if(letra == 'O'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/o.png");
	}

	if(letra == 'U'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/u.png");
	}

}

//Funcion para ejecutar eventos que se activaran con el teclado
function letra(key){
	var validar = validarLetraPulsada(key);

	if(validar){
		var letra_pulsada = String.fromCharCode(key);

		var resultado = compararLetras(letra_pulsada);

		if(resultado){

			mostrarMensaje("../../imagen/icon/exito.png","lenguaje/felicitaciones.webm","../../audio/efecto_sonido/felicitaciones.ogg");

			fin = getActual();	

			anotarDesempeno();

			var palabra = $(".preg-actividad-1 p").text();

			if(palabra == pregunta){
				setTimeout(function(){
					cargarActividad();
				}, 3000);
				
				$("#intentoCont").val(0);
			}			
		}
	}
	else{
		setTimeout(function(){
			$(".resp-actividad-1").css("box-shadow", "0px 0px 20px blue");
		}, 500);

		setTimeout(function(){
			$(".resp-actividad-1").css("box-shadow", "0px 0px 5px black");
		}, 2500);

	}
}

//Compara las letras que pulsamos con la de la palabra original
function compararLetras(letra_pulsada){
	//descomponemos la palabra original
	var descomponer = pregunta.split("");

	//obtenemos la palabra descompuesta en pantalla
	var palabra = $(".preg-actividad-1 p").text();

	//descomponemos la palabra que mostramos en pantalla
	var letras = palabra.split("");

	var resul = false;

	//verificamos que las letras que se pulsen se encuentren en la palabra original
	//y si es verdadero pues la colocamos
	for(var i = 0; i<descomponer.length; i++){
		//Verificamos que estemos en la posicion donde esta el signo de ?
		if(letras[i] == "?"){
			//Comparamos si la letra que se pulso corresponde a la letra de la palabra original
			//O sea, la letra que va en el signo de ?
			if(descomponer[i] == letra_pulsada){
				letras[i] = letra_pulsada;

				$(".preg-actividad-1 p").text(new String(letras).replace(/,/g,""));

				//Recorremos la palabra que se muestra en pantalla buscando el siguiente "_"
				//Para cambiarlo por "?"
				for(var j = 0; j < letras.length; j++){
					if(letras[j] == "_"){
						letras[j] = "?";

						$(".preg-actividad-1 p").text(new String(letras).replace(/,/g,""));

						return;
					}
				}
			}
			else{

				letras[i] = "x";

				$(".preg-actividad-1 p").text(new String(letras).replace(/,/g,""));
				setTimeout(function(){
					letras[i] = "?";

					$(".preg-actividad-1 p").text(new String(letras).replace(/,/g,""));
				}, 1000);

				$("#intentoCont").val( parseInt($("#intentoCont").val()) + 1 );

				return;
			}
		}
	}

	if($(".preg-actividad-1 p").text() == pregunta){
		resul = true;
	}

	return resul;
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

function validarLetraPulsada(key){
	//Capturamos lo que contenga la respuesta
	var respuesta = $(".resp-actividad-1 button").text();

	//Lo separamos 
	var letras = respuesta.split("");

	for(var i = 0; i<letras.length; i++){
		var l = letras[i].charCodeAt();

		//Verificamos que se halla pulsado almenos uno de las letras que se muestran
		if(l == key){
			return true;
		}
	}

	return false;
}

//Funcion para cargar la actividad con ajax
function cargarActividad(){
	//Llamamos al controlador para que se active la actividad
	//Reciviendo como respuesta variables tipo JSON
	//y cargando las funciones respectivas
	$.ajax({
		url: "../../controlador/actividades/colocar_vocales.php",
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

	//Declaramos una variable palabra que servira para colocar la interrogante de la actividad
	//Tendra como valor principal "_" ya que no mostraremos la primera letra
	var palabra = "";

	//Asignamos la palabra descompuesta a la variable palabra, sin la primera letra
	for(var i = 0; i < descomponer.length; i++){
		if(descomponer[i] == "A" || descomponer[i] == "E" || descomponer[i] == "I" || descomponer[i] == "O" || descomponer[i] == "U"){
			var signo = false;

			//Recorremos la palabra para saber si existen signos de interrogacion
			//De no poseer pues lo coloca
			for(var j = 0; j < palabra.length; j++){
				if(palabra[j] == "?"){
					signo = true;
				}
			}

			if(signo){
				palabra += "_";
			}
			else{
				palabra += "?";
			}
			
		}
		else{
			palabra += descomponer[i];
		}
	}

	//Limpiamos los elementos
	$(".preg-actividad-1 p").remove();

	//Mostramos en pantalla
	$("#img-cargar").attr("src", imagen);
	$("#tocar-audio").attr("src", audio);
	$(".preg-actividad-1").append("<p>"+palabra+"</p>");
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
		url: "../../controlador/actividades/colocar_vocales.php",
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

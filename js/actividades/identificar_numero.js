var lng_sena;

$(document).ready(function(){
	//declaracion de variables globales
	var id_img, imagen, audio, respuesta;
	var comienzo, fin, tiempo_llevado;

	//Iniciamos la actividad
	cargarActividad("");

	//Entramos en el documento cada vez que el usuario pulse una tecla
	$(document).keydown(function(key){
		//Llamamos la funcion numero pasando como parametro lo que el usuario pulse
		numero(String.fromCharCode(key.which));
	});

	//Cunado el Usuario pulse uno de las letras se activa el evento
	$(document).on("click", ".boton-numero", function(){
		numero($(this).text());
	});

	//Cuando el Usuario pulse uno de las letras se activa el evento
	$(document).on("mouseover", ".boton-numero", function(){
		numeroLenguajeSena($(this).text());
	});

	//Cuando el Usuario pulse uno de las letras se activa el evento
	$(document).on("mouseout", ".boton-numero", function(){
		$(".resp-lng-sena").fadeOut(10);
		$(".resp-lng-sena-doble").fadeOut(10);
	});

	$("#informacion-texto").click(function(){

		detenerVideo("matematica/numero_en_palabra/numero_en_palabra.webm");
		detenerVideo("matematica/numero_en_palabra/lenguaje_signo/numero_en_palabra.webm");

		$(".video").hide();

		$(".guia").fadeIn(500);
	});

	$("#informacion-video").click(function(){
		cargarVideoFullScreen("matematica/numero_en_palabra/numero_en_palabra.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$("#informacion-lenguaje-signo").click(function(){
		cargarVideo("matematica/numero_en_palabra/lenguaje_signo/numero_en_palabra.webm");

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

function numeroLenguajeSena(key){

	var numero = key;

	if(numero == '0'){
		$(".resp-lng-sena").fadeIn(10);
		$("#img-resp-lng-sena").attr("src", "../../imagen/num_lng_sena/0.png");
	}

	if(numero == '1'){
		$(".resp-lng-sena").fadeIn(10);
		$("#img-resp-lng-sena").attr("src", "../../imagen/num_lng_sena/1.png");
	}

	if(numero == '2'){
		$(".resp-lng-sena").fadeIn(10);
		$("#img-resp-lng-sena").attr("src", "../../imagen/num_lng_sena/2.png");
	}

	if(numero == '3'){
		$(".resp-lng-sena").fadeIn(10);
		$("#img-resp-lng-sena").attr("src", "../../imagen/num_lng_sena/3.png");
	}

	if(numero == '4'){
		$(".resp-lng-sena").fadeIn(10);
		$("#img-resp-lng-sena").attr("src", "../../imagen/num_lng_sena/4.png");
	}

	if(numero == '5'){
		$(".resp-lng-sena").fadeIn(10);
		$("#img-resp-lng-sena").attr("src", "../../imagen/num_lng_sena/5.png");
	}

	if(numero == '6'){
		$(".resp-lng-sena-doble").fadeIn(10);
		$("#img-resp-lng-sena-1").attr("src", "../../imagen/num_lng_sena/1.png");
		$("#img-resp-lng-sena-2").attr("src", "../../imagen/num_lng_sena/5.png");
	}

	if(numero == '7'){
		$(".resp-lng-sena-doble").fadeIn(10);
		$("#img-resp-lng-sena-1").attr("src", "../../imagen/num_lng_sena/2.png");
		$("#img-resp-lng-sena-2").attr("src", "../../imagen/num_lng_sena/5.png");
	}

	if(numero == '8'){
		$(".resp-lng-sena-doble").fadeIn(10);
		$("#img-resp-lng-sena-1").attr("src", "../../imagen/num_lng_sena/3.png");
		$("#img-resp-lng-sena-2").attr("src", "../../imagen/num_lng_sena/5.png");
	}

	if(numero == '9'){
		$(".resp-lng-sena-doble").fadeIn(10);
		$("#img-resp-lng-sena-1").attr("src", "../../imagen/num_lng_sena/4.png");
		$("#img-resp-lng-sena-2").attr("src", "../../imagen/num_lng_sena/5.png");
	}

	if(numero == '10'){
		$(".resp-lng-sena-doble").fadeIn(10);
		$("#img-resp-lng-sena-1").attr("src", "../../imagen/num_lng_sena/5.png");
		$("#img-resp-lng-sena-2").attr("src", "../../imagen/num_lng_sena/5.png");
	}

}

//Funcion para ejecutar eventos que se activaran con el teclado
function numero(key){
	var validar = validarNumeroPulsado(key);

	if(validar){
		if(respuesta == key){

			mostrarMensaje("../../imagen/icon/exito.png","matematica/felicitaciones.webm","../../audio/efecto_sonido/felicitaciones.ogg");
			
			fin = getActual();	

			anotarDesempeno();

			setTimeout(function(){
				cargarActividad();
			}, 3000);

			$("#intentoCont").val(0);			
		}
		else{
			mostrarMensaje("../../imagen/icon/fracaso1.png","matematica/error_repetir.webm","../../audio/efecto_sonido/error_repetir.ogg");

			$("#intentoCont").val( parseInt($("#intentoCont").val()) + 1 );

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

function validarNumeroPulsado(key){
	//Capturamos lo que contenga la respuesta
	//var respuesta = $(".resp-actividad-1 button").text();

	var respuesta = "";

	$(".resp-actividad-1 button").each(function(){
		respuesta += $(this).text() + ",";
	});

	//Lo separamos 
	var numeros = respuesta.split(",");

	for(var i = 0; i<numeros.length; i++){
		//Verificamos que se halla pulsado almenos uno de los numeros que se muestran
		if(numeros[i] == key){
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
		url: "../../controlador/actividades/identificar_numero.php",
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
	lng_sena  = data.lng_sena;
	audio     = data.audio;
	respuesta = data.respuesta;

	//Hacemos el llamado a numerosAleatorias, para mostrar numeros al azar
	var numeros = numerosAleatorias();

	//Limpiamos los elementos
	$(".preg-actividad-1 p").remove();
	$(".resp-actividad-1 button").remove();

	//Mostramos en pantalla
	$("#img-cargar").attr("src", imagen);
	$("#tocar-audio").attr("src", audio);
	
	for(var i = 0; i < numeros.length; i++){
		$(".resp-actividad-1").append("<button class='boton-numero'>"+numeros[i]+"</button>");
	}
}

//Los que mostramos si la consulta Ajax no se ejecuto perfect
function cargarError(){
	alert("Error requesting information from the server");
}

//Funcion para cargar las numeros aleatorias
function numerosAleatorias(){
	//Creamos un array vacio
	var numeros = new Array();
	//Creamos una variable con las numeros que se podran cargar
	var posible = "0123456789";
	var validar;

	//Ya que solo se podra cargar solo 5 numeros el ciclo sera de 5 iteraciones
	//puede cambiar
	for(var i = 0; i<5; i++){
		//un numero aleatorio entre 0 y 4
		var num = parseInt(Math.random() * (5 - 1));

		//Cada vez que el numero sea 2 
		if(num == 2){
			//Validamos que el numero no este en el arreglo
			validar = validarNumeroResp(numeros);

			//Si no esta en el arreglo pues la añadimos
			if(validar){
				numeros[i] = respuesta;
			}
			//Si no esta en el arreglo
			else{
				//En este caso si la posicion es 5 (ultima) y no existe
				if(numeros.length == 4 && validar){
					//Colocamos la primera letra
					numeros[i] = respuesta;
				}
				//De no ser asi
				else{
					//Creamos el numero aleatorio
					numeros[i] = validarNumero(numeros);
				}				
			}
		}
		//Mientra el array numeros no sea 0
		else if(numeros.length != 0){
			validar = validarNumeroResp(numeros);
				
			if(numeros.length == 4 && validar){
				numeros[i] = respuesta;
			}
			else{
				numeros[i] = validarNumero(numeros);
			}	
		}
		//Si el arreglo esta vacio
		else{
			//Creamos la letra
			numeros[i] = posible.charAt(Math.floor(Math.random() * posible.length));
		}
	}

	return numeros;
}

//Funcion para crear la letra
function validarNumero(numeros){
	var nuevaLetra = "";
	var posible    = "0123456789";

	//Cargamos la letra aleatoria
	nuevoNumero = posible.charAt(Math.floor(Math.random() * posible.length));

	for(var i = 0; i<numeros.length; i++){
		//validamos que no este en el arreglo
		if(numeros[i] == nuevoNumero){
			return validarNumero(numeros);
		}
	}

	return nuevoNumero;
}

//Funcion para validar la primera letra
function validarNumeroResp(numeros){
	for(var i = 0; i<numeros.length; i++){
		//Si eno se encuentra el numero
		if(numeros[i] == respuesta){
			return false;
		}
	}

	return true;
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
		url: "../../controlador/actividades/identificar_numero.php",
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

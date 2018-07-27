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

	//Cuando el Usuario pulse uno de las letras se activa el evento
	$(document).on("click", ".boton-letra", function(){
		letra($(this).text().charCodeAt());
	});

	//Cuando el Usuario pulse uno de las letras se activa el evento
	$(document).on("mouseover", ".boton-letra", function(){
		letraLenguajeSena($(this).text().charCodeAt());
	});

	//Cuando el Usuario pulse uno de las letras se activa el evento
	$(document).on("mouseout", ".boton-letra", function(){
		$(".resp-lng-sena").fadeOut(10);
	});

	$("#informacion-texto").click(function(){

		detenerVideo("lenguaje/primera_letra/primera_letra.webm");
		detenerVideo("lenguaje/primera_letra/lenguaje_signo/primera_letra.webm");

		$(".video").hide();

		$(".lenguaje_sena_img").hide();

		$(".guia").fadeIn(500);
	});

	$("#informacion-video").click(function(){
		cargarVideoFullScreen("lenguaje/primera_letra/primera_letra.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);
						
	});

	$("#informacion-lenguaje-signo").click(function(){
		cargarVideo("lenguaje/primera_letra/lenguaje_signo/primera_letra.webm");

		$(".guia").hide();

		$(".lenguaje_sena_img").hide();

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
      		}else if(document.webkitExitFullScreen){
        		document.webkitExitFullScreen();
      		}else if(document.exitFullscreen) {
              		//alert("requestFullscreen");
               		document.exitFullscreen();
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

	if(letra == 'B'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/b.png");
	}

	if(letra == 'C'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/c.png");
	}

	if(letra == 'D'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/d.png");
	}

	if(letra == 'E'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/e.png");
	}

	if(letra == 'F'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/f.png");
	}

	if(letra == 'G'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/g.png");
	}

	if(letra == 'H'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/h.png");
	}

	if(letra == 'I'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/i.png");
	}

	if(letra == 'J'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/j.png");
	}

	if(letra == 'K'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/k.png");
	}

	if(letra == 'L'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/l.png");
	}

	if(letra == 'M'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/m.png");
	}

	if(letra == 'N'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/n.png");
	}

	if(letra == 'O'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/o.png");
	}

	if(letra == 'P'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/p.png");
	}

	if(letra == 'Q'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/q.png");
	}

	if(letra == 'R'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/r.png");
	}

	if(letra == 'S'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/s.png");
	}

	if(letra == 'T'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/t.png");
	}

	if(letra == 'U'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/u.png");
	}

	if(letra == 'V'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/v.png");
	}

	if(letra == 'W'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/w.png");
	}

	if(letra == 'X'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/x.png");
	}

	if(letra == 'Y'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/y.png");
	}

	if(letra == 'Z'){
		$("#img-resp-lng-sena").attr("src", "../../imagen/letra_lng_sena/z.png");
	}

}

//Funcion para ejecutar eventos que se activaran con el teclado
function letra(key){
	var validar = validarLetraPulsada(key);

	if(validar){
		var letra_pulsada = String.fromCharCode(key);

		if(primera_letra == key){

			mostrarRespuesta(letra_pulsada, "SI");

			mostrarMensaje("../../imagen/icon/exito.png","lenguaje/felicitaciones.webm","../../audio/efecto_sonido/felicitaciones.ogg");

			fin = getActual();	

			anotarDesempeno();

			setTimeout(function(){
				cargarActividad();
			}, 3000);
	
			$("#intentoCont").val(0);
		}
		else{
			mostrarRespuesta(letra_pulsada, "NO");

			mostrarMensaje("../../imagen/icon/fracaso1.png","lenguaje/error_repetir.webm","../../audio/efecto_sonido/error_repetir.ogg");

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

//Funcion para mostrar el resultado al usuario haber pulsado una tecla valida
function mostrarRespuesta(letra_pulsada, valida){
	var palabra = $(".preg-actividad-1 p").text();

	var letras = palabra.split("");

	letras[0] = letra_pulsada;

	$(".preg-actividad-1 p").text(new String(letras).replace(/,/g,""));

	if(valida == "NO"){
		setTimeout(function(){
			$(".preg-actividad-1 p").text(palabra);
		}, 2500);		
	}
}

//Funcion para mostrar los mensajes
function mostrarMensaje(img,lng_video,sonido){
	setTimeout(function(){
		$.blockUI({ message: '<img src="'+img+'" class="img-mensaje" />' });

		cargarVideo(lng_video);

		$(".guia").hide();

		$(".lenguaje_sena_img").hide();

		$(".video").fadeIn(500);

	}, 500);

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
		url: "../../controlador/actividades/colocar_primera_letra.php",
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
	audio     = data.audio;
	lng_sena  = data.lng_sena;
	pregunta  = data.pregunta;

	//Descomponemos la palabra
	var descomponer = pregunta.split("");
	//Guardamos la primera letra
	primera_letra = descomponer[0];
	//Declaramos una variable palabra que servira para colocar la interrogante de la actividad
	//Tendra como valor principal "_" ya que no mostraremos la primera letra
	var palabra = "?";

	//Hacemos el llamado a letraAleatorias, para mostrar letras al azar
	var letras = letrasAleatorias(primera_letra);

	//Asignamos la palabra descompuesta a la variable palabra, sin la primera letra
	for(var i = 1; i < descomponer.length; i++){
		palabra += descomponer[i];		
	}

	//Limpiamos los elementos
	$(".preg-actividad-1 p").remove();
	$(".resp-actividad-1 button").remove();

	//Mostramos en pantalla
	$("#img-cargar").attr("src", imagen);
	$("#tocar-audio").attr("src", audio);

	$(".preg-actividad-1").append("<p>"+palabra+"</p>");
	
	for(var i = 0; i < letras.length; i++){
		$(".resp-actividad-1").append("<button class='boton-letra'>"+letras[i]+"</button>");
	}

	//Guardamos en la variable global el codigo de la primera letra
	//para comprar con el evento letra()
	primera_letra = primera_letra.charCodeAt();
}

//Los que mostramos si la consulta Ajax no se ejecuto perfect
function cargarError(){
	alert("Error requesting information from the server");
}

//Funcion para cargar las letras aleatorias
function letrasAleatorias(primera_letra){
	//Creamos un array vacio
	var letras = new Array();
	//Creamos una variable con las letras que se podran cargar
	var posible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var validar;

	//Ya que solo se podra cargar solo 5 letras el ciclo sera de 5 iteraciones
	//puede cambiar
	for(var i = 0; i<5; i++){
		//un numero aleatorio entre 0 y 4
		var num = parseInt(Math.random() * (5 - 1));

		//Cada vez que el numero sea 2 
		if(num == 2){
			//Validamos que la primera letra no este en el arreglo
			validar = validarPrimeraLetra(letras);

			//Si no esta en el arreglo pues la añadimos
			if(validar){
				letras[i] = primera_letra;
			}
			//Si no esta en el arreglo
			else{
				//En este caso si la posicion es 5 (ultima) y no existe
				if(letras.length == 4 && validar){
					//Colocamos la primera letra
					letras[i] = primera_letra;
				}
				//De no ser asi
				else{
					//Creamos la letra aleatoria
					letras[i] = validarLetra(letras);
				}				
			}
		}
		//Mientra el array letras no sea 0
		else if(letras.length != 0){
			validar = validarPrimeraLetra(letras);
				
			if(letras.length == 4 && validar){
				letras[i] = primera_letra;
			}
			else{
				letras[i] = validarLetra(letras);
			}	
		}
		//Si el arreglo esta vacio
		else{
			//Creamos la letra
			letras[i] = posible.charAt(Math.floor(Math.random() * posible.length));
		}
	}

	return letras;
}

//Funcion para crear la letra
function validarLetra(letras){
	var nuevaLetra = "";
	var posible    = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

	//Cargamos la letra aleatoria
	nuevaLetra = posible.charAt(Math.floor(Math.random() * posible.length));

	for(var i = 0; i<letras.length; i++){
		//validamos que no este en el arreglo
		if(letras[i] == nuevaLetra){
			return validarLetra(letras);
		}
	}

	return nuevaLetra;
}

//Funcion para validar la primera letra
function validarPrimeraLetra(letras){
	for(var i = 0; i<letras.length; i++){
		//Si en las letra no esta la primera letra
		if(letras[i] == primera_letra){
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
		url: "../../controlador/actividades/colocar_primera_letra.php",
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

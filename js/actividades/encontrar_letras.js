$(document).ready(function(){
	//declaracion de variables globales
	//contB = Contador de letras a buscar
	//contP = COntador de letras pulsadas que coinciden
	var respuesta, letra_buscar, contB, contP;
	var comienzo, fin, tiempo_llevado;

	//Iniciamos la actividad
	cargarActividad("");

	//Cunado el Usuario pulse uno de las letras se activa el evento
	$(document).on("click", ".sopa", function(){
		letra( $(this) );
	});

	$("#informacion-texto").click(function(){
		detenerVideo("lenguaje/buscar_letras_iguales/buscar_letras_iguales.webm");
		detenerVideo("lenguaje/buscar_letras_iguales/lenguaje_signo/buscar_letras_iguales.webm");

		$(".video").hide();

		$(".guia").fadeIn(500);
	});

	$("#informacion-video").click(function(){
		cargarVideoFullScreen("lenguaje/buscar_letras_iguales/buscar_letras_iguales.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$("#informacion-lenguaje-signo").click(function(){
		cargarVideo("lenguaje/buscar_letras_iguales/lenguaje_signo/buscar_letras_iguales.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$('#act-video').on('ended',function(){

		if(document.mozCancelFullScreen){
        		document.mozCancelFullScreen();
      		}else if(vid.webkitExitFullScreen){
        		document.webkitExitFullScreen();
      		}
   	});

});

//Funcion para ejecutar eventos que se activaran con el teclado
function letra(key){
	if(letra_buscar == key.text()){

		key.css("background-color", "green");

		contP++;

		if(contB == contP){

			mostrarMensaje("../../imagen/icon/exito.png","lenguaje/felicitaciones.webm","../../audio/efecto_sonido/felicitaciones.ogg");

			fin = getActual();	

			anotarDesempeno();

			setTimeout(function(){
				cargarActividad();
			}, 3000);

			$("#intentoCont").val(0);
			contP = 0;
		}
	}
	else{
		key.css("background-color", "red");

		setTimeout(function(){
			key.css("background-color", "#81c8ce");
		}, 3000);

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

	mostrarActividad(); 

	comienzo = getActual();

}

//Funcion para mosrar la actividad
function mostrarActividad(){
	$(".sopa").remove();

	//Creamos una variable con las letras que se podran cargar
	var posible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var cont = 0;

	//Creamos aleatoriamente la letra a buscar
	letra_buscar = posible.charAt(Math.floor(Math.random() * posible.length));

	var letras = letrasAleatorias(letra_buscar);

	for(var i = 0; i<letras.length; i++){
		if(letras[i] == letra_buscar){
			cont++;
		}

		$(".contenedor-sopa").append("<p class='sopa'>"+letras[i]+"</p>");
	}

	$(".resp-actividad-8").text("Busca las \""+letra_buscar+"\"");

	contB = cont;
	contP = 0;
	letra_buscar = letra_buscar;
}

//Funcion anotar desempeno
function anotarDesempeno(){

	//Modificar para la letra
	var intento = $("#intentoCont").val();
	var tiempo_llevado = getTiempoLlevado(comienzo, fin); 
	var caracter = letra_buscar;
	
	var parametros = {
	 	intentoP : intento,
	 	tiempo_llevadoP : tiempo_llevado,
	 	caracterP : caracter
	}

	$.ajax({
	 	url: "../../controlador/actividades/encontrar_letras.php",
	 	type: "POST",
	 	async: true,
	 	dataType: "json",
	 	data: "anotar="+JSON.stringify(parametros)	
	 });

}


//Los que mostramos si la consulta Ajax no se ejecuto perfect
function cargarError(){
	alert("Error requesting information from the server");
}

//Funcion para cargar las letras aleatorias
function letrasAleatorias(letra_buscar){
	//Creamos un array vacio
	var letras = new Array();
	//Creamos una variable con las letras que se podran cargar
	var posible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var validar = false;
	var cont = 0;
	
	//Llenamos el arreglo con letras aleatorias
	for(var i = 0; i<24; i++){
		letras[i] = posible.charAt(Math.floor(Math.random() * posible.length));
	}

	//Validamos que exista en el arreglo la letra a buscar
	for(var i = 0; i<letras.length; i++){
		if(letras[i] == letra_buscar){
			validar = true;
			cont++;
		}
	}

	if(!validar || cont < 4){
		return letrasAleatorias(letra_buscar);
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
/*function validarPrimeraLetra(letras){
	for(var i = 0; i<letras.length; i++){
		//Si en las letra no esta la primera letra
		if(letras[i] == primera_letra){
			return false;
		}
	}

	return true;
}*/


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

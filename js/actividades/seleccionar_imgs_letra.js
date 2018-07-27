var primera_letra;

$(document).ready(function(){
	//declaracion de variables globales
	var id_imagen = new Array();
	var palabra, letra_buscada, contL, contP;
	var comienzo, fin, tiempo_llevado;

	//Iniciamos la actividad
	cargarActividad("");

	//Capturamos lo que el usuario pulse
	$(document).on("click", ".seleccion", function(){
		letra( $(this) );
	});

	$("#informacion-texto").click(function(){
		detenerVideo("lenguaje/seleccionar_imgs_letra/seleccionar_imgs_letra.webm");
		detenerVideo("lenguaje/seleccionar_imgs_letra/lenguaje_signo/seleccionar_imgs_letra.webm");

		$(".video").hide();

		$(".guia").fadeIn(500);
	});

	$("#informacion-video").click(function(){
		cargarVideo("lenguaje/seleccionar_imgs_letra/seleccionar_imgs_letra.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$("#informacion-lenguaje-signo").click(function(){
		cargarVideo("lenguaje/seleccionar_imgs_letra/lenguaje_signo/seleccionar_imgs_letra.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);			
	});

	$(".img-cargar13").mouseover(function(e){

		//var snd = document.getElementById("tocar-audio"); 
		
		//snd.play();	
		var id_imag = this.id;
		
		var lng_sena = $(this).attr('alt');
		
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

//Funcion para ejecutar eventos que se activaran con el teclado
function letra(palabra){
	var cont = 0;
	var descomponer = palabra.find("p").text().split("");
	var letra = descomponer[0];

	var resul = validarLetra(letra);

	if(resul){
		palabra.css("background-color", "#3ADF00");

		contP++;	

		if(contL == contP){

			mostrarMensaje("../../imagen/icon/exito.png","lenguaje/felicitaciones.webm","../../audio/efecto_sonido/felicitaciones.ogg");

			fin = getActual();	

			anotarDesempeno();

			setTimeout(function(){
				cargarActividad();
				//enviarRespuesta(true);
			}, 3000);

			$("#intentoCont").val(0);
		}
	}
	else{
		palabra.css("background-color", "#FF0000");

		setTimeout(function(){
			palabra.css("background-color", "#D8D8D8");
		}, 2000);

		$("#intentoCont").val( parseInt($("#intentoCont").val()) + 1 );
	}
}

//Funcion anotar desempeno
function anotarDesempeno(){

	var intento = $("#intentoCont").val();
	var tiempo_llevado = getTiempoLlevado(comienzo, fin); 
	var primera_letra = letra_buscada;
	
	var parametros = {
		intentoP : intento,
		tiempo_llevadoP : tiempo_llevado,
		caracterP : primera_letra,
		id_imagenP1 : id_imagen[0],
                id_imagenP2 : id_imagen[1],
		id_imagenP3 : id_imagen[2],
		id_imagenP4 : id_imagen[3],
		id_imagenP5 : id_imagen[4],
		id_imagenP6 : id_imagen[5]
	}

	$.ajax({
		url: "../../controlador/actividades/seleccionar_imgs_letra.php",
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

	var snd = new Audio(sonido); // se carga automaticamente cuando está creado
	snd.play();

	setTimeout(function(){
		$.unblockUI();
		$(".video").hide();

		$(".guia").fadeIn(100);
	}, 5000);
}

function validarLetra(letra){
	if(letra == primera_letra){
		return true;
	}
	else{
		return false;
	}
}

//Funcion para cargar la actividad con ajax
function cargarActividad(){
	//Llamamos al controlador para que se active la actividad
	//Reciviendo como respuesta variables tipo JSON
	//y cargando las funciones respectivas
	$.ajax({
		url: "../../controlador/actividades/seleccionar_imgs_letra.php",
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
	var cont = 0;
	var monton_letra = new Array();

	id_imagen = data.id_img.slice(0);

	$(".seleccion").css("background-color","#D8D8D8");

	for(var i=0; i<data.id_img.length; i++){
		var descomponer = data.palabra[i].split("");
		monton_letra[i] = descomponer[0];

		var largo = monton_letra.length;

		primera_letra = monton_letra[ parseInt(Math.random() * largo) ];
	}

	for(var i=0; i<data.id_img.length; i++){
		//Mostramos en pantalla
		var num = i;
		$("#img-cargar13-" + (num+1)).attr("src", data.direccion[i]);
		$("#img-cargar13-" + (num+1)).attr("alt", data.lng_sena[i]);
		$("#palabra" + (num+1)).text(data.palabra[i]);

		//Sacamos la primera letra
		var descomponer = data.palabra[i].split("");
		var letra = descomponer[0];

		//Verificamos que cominece con consonante
		var resul = validarLetra(letra);
		//De ser verdadero aumentamos el contador
		if(resul){
			cont++;
		}
	}

	$(".resp-actividad-8").text("That starts with \""+primera_letra+"\"");

	letra_buscada = primera_letra;

	contP = 0;
	contL = cont;
}


//Los que mostramos si la consulta Ajax no se ejecuto perfect
function cargarError(){
	alert("Error requesting information from the server");
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

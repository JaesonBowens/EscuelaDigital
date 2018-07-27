
var palabra_encontrar;

$(document).ready(function(){
	//declaracion de variables globales
	var comienzo, fin, tiempo_llevado;

	//Iniciamos la actividad
	cargarActividad("");

	//Capturamos lo que el usuario pulse
	$(document).on("click", ".seleccion-uno", function(){
		comparar_palabra( $(this) );
	});

	$("#informacion-texto").click(function(){
		detenerVideo("matematica/seleccionar_img_palabra/seleccionar_img_palabra.webm");
		detenerVideo("matematica/seleccionar_img_palabra/lenguaje_signo/seleccionar_img_palabra.webm");

		$(".video").hide();

		$(".guia").fadeIn(500);
	});

	$("#informacion-video").click(function(){
		cargarVideoFullScreen("matematica/seleccionar_img_palabra/seleccionar_img_palabra.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$("#informacion-lenguaje-signo").click(function(){
		cargarVideo("matematica/seleccionar_img_palabra/lenguaje_signo/seleccionar_img_palabra.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);			
	});
	
	$(".imagen").mouseover(function(e){

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
function comparar_palabra(palabra){
	var pal = palabra.attr("title");

	if( pal == palabra_encontrar ){
		palabra.css("background-color", "#3ADF00");

		fin = getActual();	

		anotarDesempeno();

		mostrarMensaje("../../imagen/icon/exito.png","lenguaje/felicitaciones.webm","../../audio/efecto_sonido/felicitaciones.ogg");

		setTimeout(function(){
			cargarActividad();
		}, 3000);

		$("#intentoCont").val(0);
	}
	else{
		palabra.css("background-color", "#FF0000");
		mostrarMensaje("../../imagen/icon/fracaso1.png","lenguaje/error_repetir.webm","../../audio/efecto_sonido/error_repetir.ogg");

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
	//var id = id_img;
	
	var parametros = {
		intentoP : intento,
		tiempo_llevadoP : tiempo_llevado,
		id_imagenP1 : id_imagen[0],
                id_imagenP2 : id_imagen[1],
		id_imagenP3 : id_imagen[2],
		id_imagenP4 : id_imagen[3]
	}

	$.ajax({
		url: "../../controlador/actividades/seleccionar_img_palabra.php",
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
		url: "../../controlador/actividades/seleccionar_img_palabra.php",
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

	id_imagen = data.id_img.slice(0);

	$(".seleccion-uno").remove();
	var num = 0;

	for(var i=0; i<data.id_img.length; i++){
		//Mostramos en pantalla
		$(".contenedor-seleccion-uno").append("<div class='seleccion-uno' title='"+data.palabra[i]+"'><img class='imagen'  src='"+data.direccion[i]+"' alt='"+data.lenguaje_sena[i]+"'/></div>");
	}

	var monton_palabra = new Array();

	for(var i=0; i<data.id_img.length; i++){
		monton_palabra[i] = data.palabra;
	}

	var largo = data.palabra.length;

	palabra_encontrar = data.palabra[ parseInt(Math.random() * largo) ];

	$(".resp-actividad-8").text("\""+palabra_encontrar+"\"");
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

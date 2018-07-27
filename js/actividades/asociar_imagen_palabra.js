var palabras = new Array();
var cont_resp = 0;

$(document).ready(function(){
	//declaracion de variables globales
	var comienzo, fin, tiempo_llevado;

	//Iniciamos la actividad
	cargarActividad("");

	$("#arrastrable1").draggable();
	$("#arrastrable2").draggable();
	$("#arrastrable3").draggable();
	$("#arrastrable4").draggable();

	$("#soltar1").droppable({
		drop: function(evento, ui){
			comparar(ui.draggable, $(this));
		}
	});

	$("#soltar2").droppable({
		drop: function(evento, ui){
			comparar(ui.draggable, $(this));
		}
	});

	$("#soltar3").droppable({
		drop: function(evento, ui){
			comparar(ui.draggable, $(this));
		}
	});

	$("#soltar4").droppable({
		drop: function(evento, ui){
			comparar(ui.draggable, $(this));
		}
	});

	$("#informacion-texto").click(function(){
		detenerVideo("lenguaje/asociar_palabra_img/asociar_palabra_img.webm");
		detenerVideo("lenguaje/asociar_palabra_img/lenguaje_signo/asociar_palabra_img.webm");

		$(".video").hide();

		$(".guia").fadeIn(500);
	});

	$("#informacion-video").click(function(){
		cargarVideoFullScreen("lenguaje/asociar_palabra_img/asociar_palabra_img.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$("#informacion-lenguaje-signo").click(function(){
		cargarVideo("lenguaje/asociar_palabra_img/lenguaje_signo/asociar_palabra_img.webm");

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
function comparar(arrast, elem){
	var palabra = arrast.text();
	var img = elem.attr("title");

	if( palabra == img ){
		elem.css("background-color", "#3ADF00");
		elem.find("p").text(palabra);

		arrast.remove();

		cont_resp++;

		if( cont_resp == 4 ){
			fin = getActual();	

			anotarDesempeno();

			mostrarMensaje("../../imagen/icon/exito.png","lenguaje/felicitaciones.webm","../../audio/efecto_sonido/felicitaciones.ogg");

			setTimeout(function(){
				cargarActividad();
				$(".imagen-asociar").css("background-color", "#A4A4A4");
			}, 3000);

			$("#intentoCont").val(0);

			cont_resp = 0;
		}
	}
	else{
		elem.css("background-color", "#FF0000");
		mostrarMensaje("../../imagen/icon/fracaso1.png","lenguaje/error_repetir.webm","../../audio/efecto_sonido/error_repetir.ogg");

		setTimeout(function(){
			elem.css("background-color", "#A4A4A4");
		}, 2000);

		$("#intentoCont").val( parseInt($("#intentoCont").val()) + 1 );

		var id_p = arrast.attr("id");

		if( id_p == "arrastrable1" ){
			var arrastrable1 = $('<p class="der" id="arrastrable1">'+arrast.text()+'</p>');
			arrastrable1.draggable();

			$("#superior").append(arrastrable1);

			arrast.remove();
		}
		else if( id_p == "arrastrable2" ){
			var arrastrable2 = $('<p class="izq" id="arrastrable2">'+arrast.text()+'</p>');
			arrastrable2.draggable();

			$("#superior").append(arrastrable2);

			arrast.remove();
		}
		else if( id_p == "arrastrable3" ){
			var arrastrable3 = $('<p class="der" id="arrastrable3">'+arrast.text()+'</p>');
			arrastrable3.draggable();

			$("#inferior").append(arrastrable3);

			arrast.remove();
		}
		else if( id_p == "arrastrable4" ){
			var arrastrable4 = $('<p class="izq" id="arrastrable4">'+arrast.text()+'</p>');
			arrastrable4.draggable();

			$("#inferior").append(arrastrable4);

			arrast.remove();
		}
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
		url: "../../controlador/actividades/encontrar_mas_objetos.php",
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
		url: "../../controlador/actividades/asociar_imagen_palabra.php",
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
	var i = 0;

	id_imagen = data.id_img.slice(0);

	$(".contenedor-seleccion-uno div").each(function(){
		$(this).find("img").attr("src", data.direccion[i]);
		$(this).find("img").attr("title", data.palabra[i]);
		$(this).find("img").attr("alt", data.lng_sena[i]);
		$(this).attr("title", data.palabra[i]);

		i++;
	});

	$(".contenedor-seleccion-uno p").each(function(){
		$(this).text("");
	});

	/*for(var i=0; i<data.id_img.length; i++){
		//Mostramos en pantalla
		$(".contenedor-seleccion-uno").append("<div class='seleccion-uno' title='"+data.palabra[i]+"' id='soltar'><img src='"+data.direccion[i]+"'/></div>");
	}*/

	palabras = [];

	while( palabras.length != 4 ){
		for(var i = 0; i < data.palabra.length; i++){
			var retorno = true;
			var largo = data.palabra.length;

			//Capturamos una palabra al azar
			var palabra = data.palabra[ parseInt(Math.random() * largo) ];

			//Verificamos que la palabra no este en el arreglo a mostrar
			for( var j = 0; j < palabras.length; j++ ){
				if( palabra == palabras[j] ){
					retorno = false;
				}
			}

			//Si no se encontro la palabra se agrega al arreglo
			if( retorno ){
				j++;
				palabras[palabras.length] = palabra;
			}
		}
	}

	$("#superior p").remove();
	$("#inferior p").remove();

	var arrastrable1 = $('<p class="der" id="arrastrable1"></p>');
	arrastrable1.draggable();

	var arrastrable2 = $('<p class="izq" id="arrastrable2"></p>');
	arrastrable2.draggable();
	
	$("#superior").append(arrastrable1);
	$("#superior").append(arrastrable2);

	var arrastrable3 = $('<p class="der" id="arrastrable3"></p>');
	arrastrable3.draggable();

	var arrastrable4 = $('<p class="izq" id="arrastrable4"></p>');
	arrastrable4.draggable();
	
	$("#inferior").append(arrastrable3);
	$("#inferior").append(arrastrable4);

	var i = 0;

	$(".resp-actividad-asociar-img-pal p").each(function(){
		$(this).text("");
		$(this).text( palabras[i] );
		$(this).attr("title", "");
		$(this).attr("title", palabras[i]);

		i++;
	});
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


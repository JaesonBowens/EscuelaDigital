var num_ordenado = new Array();
var num_aleatoria;

$(document).ready(function(){
	//declaracion de variables globales
	var comienzo, fin, tiempo_llevado;

	//Iniciamos la actividad
	cargarActividad("");

	$("#informacion-texto").click(function(){
		detenerVideo("matematica/secuencia/secuencia.webm");
		detenerVideo("matematica/secuencia/lenguaje_signo/secuencia.webm");

		$(".video").hide();

		$(".guia").fadeIn(500);
	});

	$("#informacion-video").click(function(){
		cargarVideoFullScreen("matematica/secuencia/secuencia.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	$("#informacion-lenguaje-signo").click(function(){
		cargarVideo("matematica/secuencia/lenguaje_signo/secuencia.webm");

		$(".guia").hide();

		$(".video").fadeIn(500);				
	});

	//Entramos en el documento cada vez que el usuario pulse una tecla
	$(document).keydown(function(key){
		//Llamamos la funcion numero pasando como parametro lo que el usaurio pulse
		var num = key.keyCode || key.which;

		numero(num);
	});

	$('#act-video').on('ended',function(){

		if(document.mozCancelFullScreen){
        		document.mozCancelFullScreen();
      		}else if(vid.webkitExitFullScreen){
        		document.webkitExitFullScreen();
      		}
   	});
});

//Funcion para verificar lo que el usuario ordeno
function numero(key){
	var resul = compararNumero(String.fromCharCode(key));

	if(resul){

			fin = getActual();	

			anotarDesempeno();

			mostrarMensaje("../../imagen/icon/exito.png","matematica/felicitaciones.webm","../../audio/efecto_sonido/felicitaciones.ogg");

			setTimeout(function(){
				cargarActividad();
			}, 3000);

			$("#intentoCont").val(0);
	}
	else{
		//mostrarMensaje("../Imagen/Icon/fracaso1.png","../SoundEffects/fracaso.mp3");

		$("#intentoCont").val( parseInt($("#intentoCont").val()) + 1 );
	}
}

//Compara los numeros que pulsamos con los de la fraccion original
function compararNumero(num_pulsado){	
	var resul = false;
	var bien;
	var i = 0, j = 0;

	var numero = Array();

	$("#lista-ordenable li").each(function(){
		numero[j] = $(this).text();
		j++
	});


	for( i = 0; i < numero.length; i++ ){
		//Verificamos que estemos en la posicion donde esta el signo de ?
		if( numero[i] == "?" ){
			//Comparamos si el numero que se pulso corresponde a el numero de la fraccion original
			//O sea, el numero que va en el signo de ?
			if(num_ordenado[i] == num_pulsado){
				numero[i] = num_pulsado;

				$("#lista-ordenable li").remove();

				for( i = 0; i < numero.length; i++ ){
					$("#lista-ordenable").append("<li>" + numero[i] + "</li>");
				}

				//Recorremos los numeros que se muestra en pantalla buscando el siguiente "_"
				//Para cambiarlo por "?"
				for( j = 0; j < numero.length; j++  ){
					
					if( numero[j] == "_" ){
						numero[j] = "?";

						$("#lista-ordenable li").remove();

						for( i = 0; i < numero.length; i++ ){
							$("#lista-ordenable").append("<li>" + numero[i] + "</li>");
						}

						return;
					}
				}
			}
			else{
				numero[i] = "x";

				$("#lista-ordenable li").remove();

				for( j = 0; j < numero.length; j++ ){
					$("#lista-ordenable").append("<li>" + numero[j] + "</li>");
				}
				
				setTimeout(function(){
					numero[i] = "?";

					$("#lista-ordenable li").remove();

					for( j = 0; j < numero.length; j++ ){
						$("#lista-ordenable").append("<li>" + numero[j] + "</li>");
					}
				}, 1000);

				$("#intentoCont").val( parseInt($("#intentoCont").val()) + 1 );

				return;
			}
		}
	}

	i = 0;

	$("#lista-ordenable li").each(function(){
		var num = $(this).text();

		if( num == num_ordenado[i] ){
			bien = true;
		}
		else{
			bien = false;
		}
		i++;
	});

	if( bien ){
		resul = true;
	}

	return resul;
}

//Funcion anotar desempeno
function anotarDesempeno(){

	var num = new Array();

	num = num_ordenado;

	var intento = $("#intentoCont").val();
	var tiempo_llevado = getTiempoLlevado(comienzo, fin); 
	var secuencia = num.join(" - ");
	
	var parametros = {
		intentoP : intento,
		tiempo_llevadoP : tiempo_llevado,
		secuenciaP : secuencia
	}

	$.ajax({
		url: "../../controlador/actividades/completar_secuencia.php",
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
	
	mostrarActividad();

	comienzo = getActual();
}

//Funcion para mosrar la actividad
function mostrarActividad(){

	num = cargarNumero();

	$("#lista-ordenable li").remove();

	for( var i = 0; i < num.length; i++ ){
		$("#lista-ordenable").append("<li>" + num[i] + "</li>");
	}

	$(".resp-actividad-8").text("Comience desde el " + num_aleatoria);
}

//Cargo solo una fraccion de 5 numeros
function cargarNumero(){
	var numero = "0123456789";
	var num = numero.split("");
	var signo;
	var oculto = false;

	//Elegimos una numero aleatorio
	num_aleatoria = numero.charAt(Math.floor(Math.random() * numero.length));

	num_mostrar = new Array();

	//Recorremos el nu,
	for( var i = 0; i < num.length; i++ ){
		//Cuando el num coincida con el numero que elegimos de forma aleatoria
		if( num_aleatoria == num[i] ){

			//Recorremos las 5 letras siguientes de la que elegimos
			for( var j = 0; j < 5; j++ ){
				//Si el num no esta vacio
				if( num[i] != null && num[i] != "" ){
					//Creamos un numero aleatorio entre 0 y 1
					var aux = parseInt(Math.random() * (3 - 1));
					
					if( aux == 0 ){
						num_mostrar[j] = num[i];
					}
					else{
						//Recorremos la palabra para saber si existen signos de interrogacion
						//De no poseer pues lo coloca
						for(var j = 0; j < num_mostrar.length; j++){
							if(num_mostrar[j] == "?"){
								signo = true;
							}
						}

						if(signo){
							num_mostrar[j] = "_";
						}
						else{
							num_mostrar[j] = "?";
						}
					}
					
					num_ordenado[j] = num[i];
					num[i++];

				}
				//Si una posicion esta vacia, volvemos a cargar las letras
				else{
					return cargarNumero();
				}
			}

			//Validamos que halla almenos una incognita
			for( var i = 0; i < num_mostrar.length; i++ ){
				if( num_mostrar[i] == "?" ){
					oculto = true;
				}
			}

			if( oculto ){
				//Retornamos el num a mostrar			
				return num_mostrar;
			}
			else{
				return cargarNumero();
			}
		}
	}
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

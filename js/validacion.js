function validarLetra(e){
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key).toUpperCase();
	letras = " ÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
	especiales = [8, 9, 164,13,165, 37, 38, 39, 40, 13];

	tecla_especial = false
	for(var i in especiales){
		if(key == especiales[i]){
			tecla_especial = true;
			break;
		}
	}

	if(letras.indexOf(tecla)==-1 && !tecla_especial){
		alertify.error("Sorry, This field accepts only letters");
		return false;
	}	
}

function validarNumero(e){
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key).toUpperCase();
	letras = " 0123456789";
	especiales = [8, 9,164,13,165, 37, 38, 39, 40, 13];
	
	tecla_especial = false
	for(var i in especiales){
		if(key == especiales[i]){
			tecla_especial = true;
			break;
		}
	}

	if(letras.indexOf(tecla)==-1 && !tecla_especial){
		alertify.error("Sorry, This field accepts only numbers");
		return false;
	}	
}

function validarLongitud(valor, max){
	if(valor.length > max){
		alertify.error("Sorry, yo have entered the maximum number of characteres");
	}
}

function confirmarOpcion(boton, mensaje){
	if(boton.type == "button"){
		var confimar = confirm(mensaje);

		if(confimar){
			boton.onClick = "";
			boton.type = "submit" ;
			boton.click();
		}
	}
}

function confirmarOpcionDocente(boton, mensaje){
	if(boton.type == "button"){

		var valido = true;

		if(validarClave() == false){
			valido = false;
		}

		if(valido){
			var confimar = confirm(mensaje);

			if(confimar){
				boton.onClick = "";
				boton.type = "submit" ;
				boton.click();
			}
		}
	}
}

function ValidarImagenSubir() {

	var fuData = document.getElementById('id_archivo');
	var FileUploadPath = fuData.value;

	if (FileUploadPath == '') {
    		alertify.error("Please upload a image");

	} else {
    		var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

		if (Extension == "gif" || Extension == "png" || Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {

			if (fuData.files && fuData.files[0]) {

                		var size = fuData.files[0].size;

                		if(size > 5200000000){
                    			alertify.error("The size of the file is more than the maximum allowed");
					document.getElementById('id_archivo').value=null;
                    			return;
                		}else{
					var tmppath = URL.createObjectURL(fuData.files[0]);
                        		document.getElementById('id_mostrar_imagen').src = tmppath;		
                    		}
                	}
		
        	}else {
        		alertify.error("You can only upload these types of files: GIF, PNG, JPG, JPEG y BMP. ");
			document.getElementById('id_archivo').value=null;
			document.getElementById('id_mostrar_imagen').src = "../imagen/default-imagen.jpg";
    		}
	}
}

function ValidarAudioSubir() {

	var fuData = document.getElementById('id_archivo_audio');
	var FileUploadPath = fuData.value;

	if (FileUploadPath == '') {
    		alertify.error("Please upload an audio");

	} else {
    		var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

		document.getElementById('extension_audio').value = Extension;

		if (Extension == "ogg" || Extension == "wav" || Extension == "mp3") {

			if (fuData.files && fuData.files[0]) {

                		var size = fuData.files[0].size;

                		if(size > 520000000){
                    			alertify.error("The size of the file is more than the maximum allowed");
					document.getElementById('id_archivo_audio').value=null;
                    			return;
                		}else{
					var tmppath = URL.createObjectURL(fuData.files[0]);
					$('#area_audio').hide();
					$('#id_tocar_audio').show();
                        		document.getElementById('id_tocar_audio').src = tmppath;
					$('#quitar_audio').show();		
                    		}
                	}
		
        	}else {
        		alertify.error("You can only upload these types of files: OGG, WAV y MP3. ");
			document.getElementById('id_archivo_audio').value=null;
			$('#id_tocar_audio').hide();
			document.getElementById('id_tocar_audio').src = "";
			$('#area_audio').show();
			$('#quitar_audio').hide();
    		}
	}
}

function ValidarLenguajeSigno() {

	var fuData = document.getElementById('lenguaje_signo');
	var FileUploadPath = fuData.value;

	if (FileUploadPath == '') {
    		alertify.error("Please upload a file");


	} else {
    		var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

		document.getElementById('extension_lng_sign').value = Extension;

		if (Extension == "ogg" || Extension == "webm" || Extension == "mp4") {

			if (fuData.files && fuData.files[0]) {

                		var size = fuData.files[0].size;

                		if(size > 520000000000){
                    			alertify.error("The size of the file is more than the maximum allowed");
					document.getElementById('lenguaje_signo').value=null;
                    			return;
                		}else{
					var tmppath = URL.createObjectURL(fuData.files[0]);
					$('#img_lenguaje_signo').hide();
					$('#video_lenguaje_signo').show();

					document.getElementById('video_lenguaje_signo').src = tmppath;
					document.getElementById('lenguaje_signo').src = tmppath;

					$('#quitar_lng_sign').show();		
                    		}
                	}
		
        	}else if(Extension == "gif" || Extension == "png" || Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {

			if (fuData.files && fuData.files[0]) {

                		var size = fuData.files[0].size;

                		if(size > 25200000000){
                    			alertify.error("The size of the file is more than the maximum allowed");
					document.getElementById('lenguaje_signo').value=null;
                    			return;
                		}else{
					var tmppath = URL.createObjectURL(fuData.files[0]);
					$('#img_lenguaje_signo').show();
					$('#video_lenguaje_signo').hide();

					document.getElementById('video_lenguaje_signo').src = '';

					document.getElementById('img_lenguaje_signo').src = tmppath;

					document.getElementById('lenguaje_signo').src = tmppath;

					$('#quitar_lng_sign').show();		
                    		}
                	}
		
        	}else {
        		alertify.error("You can only upload these types of files: OGG, WAV, MP3, GIF, PNG, JPG, JPEG y BMP. ");
			document.getElementById('lenguaje_signo').value=null;
			$('#video_lenguaje_signo').hide();
			document.getElementById('img_lenguaje_signo').src = "../imagen/Icon/lenguaje_signo.jpg";
			$('#quitar_lng_sign').hide();
    		}
	}
}

function ValidateFileUploadUno() {

	var fuData = document.getElementById('id_archivo_uno');
	var FileUploadPath = fuData.value;

	if (FileUploadPath == '') {
    		alertify.error("Please upload an image!");

	} else {
    		var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

		if (Extension == "gif" || Extension == "png" || Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {

			if (fuData.files && fuData.files[0]) {

                		var size = fuData.files[0].size;

                		if(size > 520000000){
                    			alertify.error("The size of the file is more than the maximum allowed");
					document.getElementById('id_archivo_uno').value=null;
                    			return;
                		}else{
					var tmppath = URL.createObjectURL(fuData.files[0]);
                        		document.getElementById('mostrar_imagen_uno').src = tmppath;		
                    		}
                	}
		
        	}else {
        		alertify.error("You can only upload these types of files: GIF, PNG, JPG, JPEG y BMP. ");
			document.getElementById('id_archivo_uno').value=null;
			document.getElementById('mostrar_imagen_uno').src = "../imagen/default-imagen.jpg";
    		}
	}
}

function ValidateFileUploadDos() {

	var fuData = document.getElementById('id_archivo_dos');
	var FileUploadPath = fuData.value;

	if (FileUploadPath == '') {
    		alertify.error("Please upload a file!");

	} else {
    		var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

		if (Extension == "gif" || Extension == "png" || Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {

			if (fuData.files && fuData.files[0]) {

                		var size = fuData.files[0].size;

                		if(size > 520000000){
                    			alertify.error("The size of the file is more than the maximum allowed");
					document.getElementById('id_archivo_dos').value=null;
                    			return;
                		}else{
					var tmppath = URL.createObjectURL(fuData.files[0]);
                        		document.getElementById('mostrar_imagen_dos').src = tmppath;		
                    		}
                	}
		
        	}else {
        		alertify.error("You can only upload these types of files: GIF, PNG, JPG, JPEG y BMP. ");
			document.getElementById('id_archivo_dos').value=null;
			document.getElementById('mostrar_imagen_dos').src = "../imagen/default-imagen.jpg";
    		}
	}
}

function ValidarBaseDatoSubir() {

	var fuData = document.getElementById('ficheroDeCopia');
	var FileUploadPath = fuData.value;

	if (FileUploadPath == '') {
    		alertify.error("Please upload the back-up file");

	} else {
    		var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

		if (Extension != "sql") {
			alertify.error("You can only upload files with the extention: SQL o sql. ");
			document.getElementById('ficheroDeCopia').value = null;	
        	}
	}
}

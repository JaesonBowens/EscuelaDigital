<?php
	session_start();

	if(isset($_SESSION["autenticado"])){
		unset($_SESSION["autenticado"]);
	}

	include("cabecera/titulo.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<?php titulo(); ?>
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<link rel="stylesheet" href="css/librerias/alertify.core.css" type="text/css" />
		<link rel="stylesheet" href="css/librerias/alertify.default.css" type="text/css" />

		<script language="javascript" type="text/javascript" src="js/librerias/alertify.js"></script>
		<script type="text/javascript" src="js/librerias/jquery -v1.11.2.js"></script>

		<script>
			$(document).ready(function(){
				$("#img_asig_pc").click(function(){
					var asig_pc = $("#asig_pc").val();

					if(asig_pc == "NO"){
						$("#asig_pc").val("SI");
						$("#img_asig_pc").attr("src", "imagen/icon/007.png");
					}
					else{
						$("#asig_pc").val("NO");
						$("#img_asig_pc").attr("src", "imagen/icon/006.png");	
					}
				})
			})
		</script>
	</head>

	<body>
		<div id="cuerpoinicio">

			<div id="contenedor-form-inicio">
						<h3><span class="fontawesome-lock"></span>Start Session</h3>

				<form action="controlador/index.php" method="POST">
								<input type="text" id="nombre_usuario" name="nombre_usuario" size="15px" placeholder="USER'S NAME" title="Enter user's name" maxlength="25" onpaste="alert('You can't paste information into the fields'); return false;" required />

								<div class="bar">
									<i></i>
								</div>
								<input type="password" id="clave_usuario" name="clave_usuario" size="15px" placeholder="PASSWORD" title="Enter user's password" maxlength="16" onpaste="alert('You can't paste information into the fields'); retrun false" required />
								<div class="asig-pc">
								<img src="imagen/icon/006.png" id="img_asig_pc" alt="Asigna PC" width=40px heigth=60px title="Press if you desire to assign computer to a student" style="cursor: pointer" />
								<input type="hidden" name="asig_pc" id="asig_pc"  value="NO" />
								</div>

						<button type="submit" id="entrar" name="entrar" title="Press to enter" class="boton-entrar"><img class='ico' src='imagen/icono_boton/ib-1.png' alt='Icon'>  Enter</button>
						<button type="reset" name="entrar" title="Press to cancel" class="boton-entrar"><img class='ico' src='imagen/icono_boton/ib-2.png' alt='Icon'>  Cancel</button>
				</form>
			</div>
		</div>
	</body>
</html>
<?php
	if(isset($_SESSION["mensaje"])){
		//Incluimos e instanciamos la clase mensajes para poder mostrar los mensajes que enviemos
		//del controlador mediante la variable de $_SESSION["mensaje"];
		include("cabecera/librerias/mensaje.php");
		$mensaje = new CabeceraMensaje;
		$mensaje -> mensaje = $_SESSION["mensaje"];
		$mensaje -> mostrarMensaje();
		unset($_SESSION["mensaje"]);
	}
?>

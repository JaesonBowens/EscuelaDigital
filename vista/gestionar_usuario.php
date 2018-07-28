<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){
		//echo "<meta http-equiv='refresh' content='0 url=../index.php'/>";	
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../cabecera/menu.php");
	include("../cabecera/titulo.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	if(isset($_SESSION["accion"])){
		$accion = $_SESSION["accion"];
		unset($_SESSION["accion"]);
	}
	else{
		$accion = "";
	}	
?>

<!DOCTYPE html>
<html >
 
<head>
    <meta charset="UTF-8"/>

    <?php titulo(); ?>

    <link href="../css/estilo_gestion.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
	<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />

	<script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
    <script language="javascript" type="text/javascript" src="../js/usuario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>

</head>

<body>
<div id="cabecera">
		<div class="nombre_sistema">
			<?php include("../cabecera/cabecera.php"); ?>
		</div>
		<div id="nav">
			<?php menu(); ?>
		</div>
</div>

<div id="contenido_principal">
	<section class="nombre_maestro">
		<h5>Secrurity(User in session)</h5>
	</section>

	<fieldset id="form-maestro">
						<legend>Manage User</legend>

							<form action="../controlador/gestionar_municipio.php" method="POST">

							<section class="form-cent">
							<section class="contenedor-label">
									<label for="nombre_usuario">User:</label>
										<input type="hidden" id="id_usuario" name="id_usuario" <?php echo "value='".$_SESSION["ses_id_usuario"]."'";?>/>
										<input type="text" id="nombre_usuario" name="nombre_usuario" value="" size="15px" placeholder="USER'S NAME"  pattern="[A-Za-z\s]*" maxlength="25" title="Enter user's name" onKeypress="return validarLetra(event)" /><div id="msj-consulta-uno"><p id="msj-p-uno"></p></div>
							</section>
							
							<section class="contenedor-label">
									<label for="clave_usuario">Clave:</label>
										<input type="password" id="clave_usuario" name="clave_usuario" size="15px" placeholder="PASSWORD" title="Enter user's password" maxlength="16" /><div id="msj-consulta-dos-A"><p id="msj-p-dos-A"></p></div>
							</section>
							
							<section class="contenedor-label">
										<label for="clave_usuario_repetida">Repita la Clave:</label>
											<input type="password" id="clave_usuario_repetida" name="clave_usuario_repetida" value="" size="15px" placeholder="REPEAT PASSWORD" maxlength="16" title="Repeat user's password" /><div id="msj-consulta-tres"><p id="msj-p-tres"></p></div>
							</section>
							</section>
							
							<br class="clearFloat"/>
	
							<section class="boton-maestro-dos">
									<button type="button" id="modificar" name="modificar" title="Press to modify" class="boton"><img class='ico' src='../imagen/icono_boton/ib-9.png' alt='Icon'>  Modify</button>
									<button type="button" id="cancelar" name="cancelar" title="Press to cancel"  class="boton"><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'>  Cancel</button>
							</section>
							</form>			
	</fieldset>

</div>

<div id="pie">
	<?php include("../cabecera/pie.php"); ?>
</div>
 
</body>
</html>

<?php
	cierrePorInactividad("../controlador/salir.php");

	if(isset($_SESSION["mensaje"])){
		//Incluimos e instanciamos la clase mensajes para poder mostrar los mensajes que enviemos
		//del controlador mediante la variable de $_SESSION["mensaje"];
		include("../cabecera/librerias/mensaje.php");
		$mensaje = new CabeceraMensaje;
		$mensaje -> mensaje = $_SESSION["mensaje"];
		$mensaje -> mostrarMensaje();
		unset($_SESSION["mensaje"]);
	}
?>

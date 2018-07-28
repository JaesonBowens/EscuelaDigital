<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){
		//echo "<meta http-equiv='refresh' content='0 url=../index.php'/>";	
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../modelo/conexion_bd.php");

	$conexion = new conexionBD;

	$conexion -> conexion();

	include("../cabecera/campos_de_seleccion/ano_escolar.php");
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
    <script type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
		<script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
		<script language="javascript" type="text/javascript" src="../js/validacion.js"></script>

		<script type="text/javascript">
		$(document).ready(function(){
			$("#id_ano_escolar").change(function(){
				var id_ano_escolar = $(this).val();
				var ano_escolar    = $("#id_ano_escolar option:selected").text();

				if(id_ano_escolar != ""){
					$("#reporte").attr("hidden", false);
					$("#link_reporte").attr("href", "../controlador/reporte_estudiante.php?id_ano_escolar="+id_ano_escolar+"&&ano_escolar="+ano_escolar);
				}
				else{
					$("#reporte").attr("hidden", true);
					$("#link_reporte").attr("href", "#");
				}
			});
		});
    </script>

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
		<h5>Report (List of Students)</h5>
	</section>

	<fieldset id="catalogo-maestro">
							<legend>Generate report of the assignded studnts</legend>
										<section class="form-cent">
										<section class="reporte-label">
										<label for="id_ano_escolar">School Year:</label>
										<select id="id_ano_escolar" name="id_ano_escolar" title="Select the school year" class="buscar-ano-escolar">
											<option value="">SELECT</option>
											<?php
												cargarAnoEscolar();
											?>
										</select>
										<a id="link_reporte" href="#" target="reporte">
											<button type="button" id="reporte" name="reporte" title="Press to generate the report of the students assigned in the school year selected" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-13.png' alt='Icon'>  Generar</button>
											</a>
										</section>
										</section>

										<section class="lista-reporte">
										<iframe src="" name="reporte" ></iframe>
										</section>

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


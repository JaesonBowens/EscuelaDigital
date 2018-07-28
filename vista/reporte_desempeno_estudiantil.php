<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../modelo/conexion_bd.php");

	include("../cabecera/campos_de_seleccion/area.php");
	include("../cabecera/campos_de_seleccion/grado.php");
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
    <link rel="stylesheet" type="text/css" href="../css/librerias/estilo_calendario.css" media="all" />
    <link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
	<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />

	<script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
		<script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
		
		<script language="javascript" type="text/javascript" src="../js/librerias/calendario.js"></script>


		 <script type="text/javascript">
				$(document).ready(function(){
					$(".calendario").calendarioDW();
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
		<h5>Report (Student's Performance)</h5>
	</section>

	<form action="../controlador/reporte_desempeno_estudiantil.php" method="POST">

	<fieldset id="catalogo-maestro">
							<legend>Catalog</legend>
										<section class="buscar-maestro-label">
										<label for="id_ano_escolar" class="label-docente">School Year:</label>
										<select id="id_ano_escolar" name="id_ano_escolar" title="Seleccione el Año Escolar" class="buscar-ano-escolar" onChange="cargarGrado(this.value);limpiarTablaMaestro()">
											<option value="">SELECT</option>
											<?php
												cargarAnoEscolar();
											?>
										</select>
									<label for="id_grado" class="label-docente">Grade:</label>
										<select id="id_grado" name="id_grado" title="Seleccione el Grado" class="buscar-ano-escolar" onChange="cargarSeccion(this.value);limpiarTablaMaestro()">
											<option value="">SELECT</option>
										</select>
										<label for="id_seccion" class="label-docente">Section:</label>
													<select id="id_seccion" name="id_seccion" class="select-estudiante" title="Select the section" onChange="busquedaAvanzadaEstudiantil(this.value, 'cuerpo-tabla-maestro', '../controlador/reporte_desempeno_estudiantil.php', 'consultaAvanzada')">
														<option value="">SELECT</option>
													</select>
										</section>

										<table class="tabla-maestro" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="400px">Name</th>
														<th width="200px">Surname</th>
														<th width="200px">Sex</th>
													</tr>
												</thead>

												<tbody class="cuerpo-tabla-maestro" id="cuerpo-tabla-maestro">
													
												</tbody>
											</table>
	</fieldset>

	</form>

	<fieldset id="form-maestro">
							<legend>Generate performance report of a student</legend>

										<section class="reporte-label">
											<input type="hidden" name="id_est_rep" id="id_est_rep"/>
											<label for="fecha_consultar" ><input type="checkbox" id="por_fecha" name="por_fecha" value="Por Fecha" title="Select to search by date">By Date </label>
														<span name="area_fecha" hidden >:
														<input type="text" id="fecha_consultar" name="fecha_consultar" class="calendario" size="4px" placeholder=""  title="Select the date when the student executed the activity" /></span>
										</section>

										<section class="reporte-label">
									
									<label for="id_ano_escolar_rep" class="label-docente">School Year:</label>
										<select id="id_ano_escolar_rep" name="id_ano_escolar_rep" title="Select the school year" class="buscar-ano-escolar" disabled>
											<option value="">SELECT</option>
											<?php
												cargarAnoEscolar();
											?>
										</select>
									<label for="id_grado_rep" class="label-docente">Grade:</label>
										<select id="id_grado_rep" name="id_grado_rep" title="Select the grade" class="buscar-ano-escolar" onChange="cargarSeccion(this.value)" disabled>
											<option value="">SELECT</option>
											<?php
												cargarGrado();
											?>
										</select>

										</section>

										<section class="reporte-label">
									<label for="id_seccion_rep" class="label-docente">Section:</label>
													<select id="id_seccion_rep" name="id_seccion_rep" class="buscar-ano-escolar" title="Select the section" disabled>
														<option value="">SELECT</option>
													</select>	

									<label for="id_area">Area:</label>
														<select id="id_area_rep" name="id_area_rep" title="Select the area" class="select-izquierda" />
															<option value="">SELECT</option>
															<?php
																cargarArea();
															?>
														</select>

									<label for="id_actividad">Activity:</label>
														<select id="id_actividad_rep" name="id_actividad_rep" title="Select the activities to search by" class="select-izquierda" />
															<option value=" ">SELECT</option>
														</select>
										
										<a id="link_reporte" href="#" target="reporte">
											<button type="button" id="reporte" name="reporte" title="Press to generate report of student's performance" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-13.png' alt='Icon'>  Generate</button>
											</a>
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
<script language="javascript" type="text/javascript" src="../js/desempeno_estudiantil.js"></script>
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


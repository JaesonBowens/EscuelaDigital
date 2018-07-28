<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../modelo/conexion_bd.php");

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
    <link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
	<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />

	<script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
	<script language="javascript" type="text/javascript" src="../js/librerias/jquery.touch.js"></script>
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
    <script language="javascript" type="text/javascript" src="../js/asignacion_estudiante.js"></script>

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
		<h5>Assignment of students</h5>
	</section>

	<form action="../controlador/gestionar_asignacion_estudiante.php" method="POST">

	<fieldset id="catalogo-maestro">
							<legend>List of Assignments</legend>
										<section class="buscar-maestro-label">
											<label for="buscar">Search:</label>
												<select id="buscar" name="buscar" title="Select school year" class="buscar-ano-escolar">
													<option value="">SELECT</option>
													<?php
														cargarAnoEscolar();
													?>
												</select>
										</section>

										<table class="tabla-maestro" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="300px">Grade</th>
														<th width="300px">Section</th>
														<th width="210px">Nº of Students</th>
													</tr>
												</thead>

												<tbody class="cuerpo-tabla-maestro" id="cuerpo-tabla-maestro">
													
												</tbody>

												<tfoot class='pie-tabla-maestro'>
						    						<tr>
														<th width='150px'></th>
														<th width='200px'></th>
														<th width='200px'></th>
														<th width='260px' id="total"></th>
						    						</tr>
						  			      		</tfoot>
									  </table>
		</fieldset>

		<fieldset id="form-maestro">
										<legend>Assign Section</legend>
											<section class="form-sup">
												<label for="id_grado" >Grade:</label>
													<select id="id_grado" name="id_grado" class="select-estudiante" title="Select grade" onChange="cargarSeccion(this.value)">
														<option value="">SELECT</option>
														<?php
															if($accion == "incluir" || $accion == ""){
																cargarGrado();
															}
															else if($accion == "modificar"){
																cargarGradoSeleccion($_SESSION["id_grado"]);
															}
																
														?>
													</select>

												<label for="id_seccion" >Section:</label>
													<select id="id_seccion" name="id_seccion" class="select-estudiante" title="Select the section" >
														<option value="">SELECT</option>
													</select>

												<label for="ano_escolar" >School Year:</label>
													<?php
														mostrarAnoEscolar();
													?>

												<button type="button" id="otro" name="otro" title="Press to change grade or section" class="boton">Other</button>							
											</section>
											<section class="form-izq">
													<section class="buscar-est-label">
														<label for="buscar">Search:</label>
														<input type="text" size="15px" id="buscar_estudiante" name="buscar_estudiante" onKeyPress="return validarLetra(event)"  />
													</section>

													<!--<section class="contenedor-busqueda-asig">-->
													<table class="busqueda-asignacion" frame="box" rules="*" cellpadding="7">
																<thead class="cabecera-busqueda-asignacion">
																	<tr>
																			<th width="395px">Students not assigned</th>														
																	</tr>
																</thead>
													
																<tbody class="lista-seleccion-estudiante" id="lista-seleccion-estudiante">
														
																</tbody>
													</table>	
										
											</section>

											<section class="asig-der">
												<table id="estudiante-asignado" border="1px" align="center" frame="box" rules="*" cellpadding="7">
													<thead>
														<tr>
															<th width="400px" colspan="3">Assigned Students</th>													
														</tr>
													</thead>

													<tbody id="cuerpo-tabla-asignado">
														
													</tbody>
												</table>
												<input type="hidden" id="cont" name="cont" value="0" />
												
											</section>

											<br class="clearFloat"/>	

									<section class="boton-maestro">
											<button type="submit" id="incluir" name="incluir" title="Press to save assignment" class="boton"><img class='ico' src='../imagen/icono_boton/ib-7.png' alt='Icon'>  Save</button>
											<button type="submit" id="modificar" name="modificar" title="Press to modify assignment" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-9.png' alt='Icon'>  Modify</button>
											<button type="submit" id="eliminar" name="eliminar" title="Press to delete assignment" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-8.png' alt='Icon'>  Delete</button>
											<button type="submit" id="cancelar" name="cancelar" title="Press to cancel assignment" class="boton"><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'>  Cancel</button>				
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

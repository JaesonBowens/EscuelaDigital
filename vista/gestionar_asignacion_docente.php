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
    <link rel="stylesheet" type="text/css" href="../css/librerias/estilo_calendario.css" media="all" />
    <link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
	<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />

	<script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
	<script language="javascript" type="text/javascript" src="../js/librerias/jquery.touch.js"></script>
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
    <script language="javascript" type="text/javascript" src="../js/asignacion_docente.js"></script>

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
		<h5>Assignment of Teacher</h5>
	</section>

	<form action="../controlador/gestionar_asignacion_docente.php" method="POST">

				<fieldset id="catalogo-maestro">
							<legend>List of Assignments</legend>
										<section class="buscar-maestro-label">
											<label for="buscar">Academic Period:</label>
												<select id="buscar" name="buscar" title="Search list of assignments by academic period" class="buscar-ano-escolar" >
													<option value="">SEARCH</option>
													<?php
														cargarAnoEscolar();
													?>
												</select>
										</section>

										<table class="tabla-maestro" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="450px">Teacher</th>
														<th width="250px">Grade</th>
														<th width="110px">Section</th>
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

										<section class="boton-maestro">
											<button type="button" id="ir_modificar" name="ir_modificar" title="Press to modify assignment" class="boton"><img class='ico' src='../imagen/icono_boton/ib-9.png' alt='Icon'>  Modify</button>
										</section>
		</fieldset>

		<fieldset id="form-maestro">
										<legend>Assign Section</legend>
											<section class="form-izq">
													<section class="busqueda-asig-docente">
															<label for="buscar">Search:</label>
															<input type="text" size="21px" id="buscar_docente" title="Search list of assignments by academic period" name="buscar_docente" onKeyPress="return validarLetra(event)"  />
													</section>

													<!--<section class="contenedor-busqueda-asig">-->
													<table class="busqueda-asignacion" frame="box" rules="*" cellpadding="7">
																<thead class="cabecera-busqueda-asignacion">
																	<tr>
																			<th width="395px">Teacher</th>														
																	</tr>
																</thead>
													
																<tbody class="lista-seleccion-docente" id="lista-seleccion-docente">
														
																</tbody>
													</table>	
										
											</section>

											<section class="asig-der">
													<section class="contenedor-label">
												<label for="cedula_seleccion" class="label-docente">I.D. Number:</label>
													<input type="hidden" id="id_docente_seleccion" name="id_docente_seleccion" />
													<input type="text" id="cedula_seleccion" name="cedula_seleccion" size="21px" placeholder="" maxlength="9" title="Enter the teacher's I.D. Number" onKeypress="return validarNumero(event)" disabled="disabled" />
											</section>

											<section class="contenedor-label">
												<label for="nombre_seleccion" class="label-docente">Name:</label>
													<input type="text" id="nombre_seleccion" name="nombre_seleccion" size="21px" placeholder="" maxlength="50" title="Enter teacher's name" onKeyPress="return validarLetra(event)" disabled="disabled" />
											</section>

											<section class="contenedor-label">
												<label for="apellido_seleccion" class="label-docente">Surname:</label>
													<input type="text" id="apellido_seleccion" name="apellido_seleccion" size="21px" placeholder="" maxlength="50" title="Enter teacher's surname" onKeyPress="return validarLetra(event)" disabled="disabled" />
											</section>

											<section class="contenedor-label">
												<label for="id_grado" class="label-docente">Grade:</label>
													<select id="id_grado" name="id_grado" class="select-docente" title="Select grade" >
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
											</section>

											<section class="contenedor-label">
												<label for="id_seccion" class="label-docente">Section:</label>
													<select id="id_seccion" name="id_seccion" class="select-docente" title="Select section" >
														<option value="">SELECT</option>
													</select>
											</section>

											<section class="contenedor-label">
												<label for="ano_escolar" class="label-docente">Academic Period:</label>
													<?php
														mostrarAnoEscolar();
													?>

													
											</section>

											<section class="asig-der-boton">
												<button type="button" align="center" id="asignar" name="asignar" title="Press to assign the teacher to the section" class="boton" onClick="asignarDocente()"><img class='ico' src='../imagen/icono_boton/ib-14.png' alt='Icon'>  Assign</button>	
											</section>	
											
												
											</section>
											<br class="clearFloat"/>
											<section class="asig-cent">
												<section class="contenedor-docente-asig">
												<table id="docente-asignado" frame="box" rules="*" cellpadding="7">
													<thead>
														<tr>
															<th width="450px">Teacher</th>
															<th width="250px">Grade</th>
															<th width="110px">Section</th>														
														</tr>
													</thead>

													<tbody id="cuerpo-tabla-asignado">
														
													</tbody>
												</table>
												<input type="hidden" id="cont" name="cont" value="0" />										
												</section>
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

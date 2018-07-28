<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../modelo/conexion_bd.php");
	include("../cabecera/campos_de_seleccion/grado.php");
	include("../cabecera/campos_de_seleccion/codigo_telefono.php");
	include("../cabecera/campos_de_seleccion/ano_escolar.php");
	include("../cabecera/campos_de_seleccion/tipo_usuario.php");
	include("../cabecera/menu.php");
	include("../cabecera/titulo.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");
	
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
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
	<script language="javascript" type="text/javascript" src="../js/librerias/jquery.touch.js"></script>
	<script language="javascript" type="text/javascript" src="../js/docente.js"></script>

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
		<h5>Personal</h5>
	</section>

						<fieldset id="catalogo-maestro">
										<legend>Catalog</legend>

										<section class="buscar-maestro-label">
											<label for="sexo">Status:</label>
														<input type="radio" id="estatus1" name="estatus" value="A y I" size="" placeholder="" title="Active y Not Active" onclick="busquedaAvanzadaDocente()" checked  /><span class="opcion_radio" for="opcion_activo_y_inactivo"> All</span>
														<input type="radio" id="estatus2" name="estatus" value="A" size="" placeholder="" title="Active" onclick="busquedaAvanzadaDocente()" /><span class="opcion_radio" for="opcion_activo"> Active</span>
														<input type="radio" id="estatus3" name="estatus" value="I" size="" placeholder="" title="Not Active"  onclick="busquedaAvanzadaDocente()"/><span class="opcion_radio" for="opcion_inactivo"> Not Active</span>

										</section>

										<section class="buscar-maestro-label">
											<label for="buscar">ID Number:</label>
												<input type="text" id="buscar_cedula" name="buscar_cedula" value="" size="15px" title="Enter ID Number to search for" maxlength="25" onKeypress="return validarNumero(event)" onKeyup="busquedaAvanzadaDocente(); validarLongitud(this.value, '9')" />
												<label for="buscar">Name:</label>
												<input type="text" id="buscar_nombre" name="buscar_nombre" value="" size="15px" title="Enter name to search for" maxlength="25" onKeypress="return validarLetra(event)" onKeyup="busquedaAvanzadaDocente(); validarLongitud(this.value, '25')" />
												<label for="buscar">Surname:</label>
												<input type="text" id="buscar_apellido" name="buscar_apellido" value="" size="15px" title="Enter surname to search for" maxlength="25" onKeypress="return validarLetra(event)" onKeyup="busquedaAvanzadaDocente(); validarLongitud(this.value, '25')" />
										</section>
										<div id="listado-catalogo">
											<table class="tabla-maestro" id="tabla-maestro" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="150px">I.D. Number</th>
														<th width="230px">Name</th>
														<th width="230px">Surname</th>
														<th width="200px">Status</th>
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
										</div>
								</fieldset>

								<fieldset id="form-maestro">
										<legend>Manage Personal</legend>
											<form action="../controlador/gestionar_docente.php" method="POST">
											<div class="instruccion">All field with asteric ( * ) are obligatory</div>
											<section class="form-izq">
													<section class="contenedor-label">
													<label for="cedula">ID Number * :</label>
														<input type="hidden" id="id_docente" name="id_docente" />
														<input list="lista_cedula" type="text" id="cedula" name="cedula" size="21px" placeholder="ID NUMBER" pattern="[0-9]*" maxlength="8" title="Enter ID Number of the teacher" onKeypress="return validarNumero(event)" onKeyup="validarLongitud(this.value, '11')" autocomplete="off" />
														<datalist id="lista_cedula"></datalist>
												</section>

												<section class="contenedor-label">
													<label for="nombre">Name * :</label>
														<input type="text" id="nombre" name="nombre" class="texto" size="21px" placeholder="TEACHER'S NAME" pattern="[A-Za-z\s]*" maxlength="25" title="Enter the name of the teacher" onKeyPress="return validarLetra(event)" disabled='disabled' onKeyup="actualizarCampoUsuario(this.value)" />
												</section>

												<section class="contenedor-label">
													<label for="apellido">Surname * :</label>
														<input type="text" id="apellido" name="apellido" class="texto" size="21px" placeholder="TEACHER'S SURNAME" pattern="[A-Za-z\s]*" maxlength="25" title="Enter the teacher's surname" onKeyPress="return validarLetra(event)"  disabled='disabled' />
												</section>

												<section class="contenedor-label">
													<label for="id_codigo_tele">Telephone:</label>
														<input type="hidden" id="id_telefono" name="id_telefono" />
														<select id="id_codigo_tele" name="id_codigo_tele" title="Select the telephone code" disabled='disabled' >
															<option value="">####</option>
															<?php

																	cargarCodigoTelefono();
																
															?>
														</select>
														<input type="text" id="numero" name="numero" size="10px" placeholder="TELEPHONE" pattern="[0-9]*" maxlength="7" title="Enter teacher's telephone number" onKeyPress="return validarNumero(event)" disabled='disabled' />
												</section>

												<section class="contenedor-label">
													<label for="estatus">Status:</label>
														<input type="text" id="estatus" name="estatus" disabled="disabled" size="21px" placeholder="STATUS" />
												</section>	
												
												<section class="contenedor-label">
													<label for="asignado">Assigned:</label>
														<input type="text" id="asignado" name="asignado" size="21px"  placeholder="ASSIGNED" disabled='disabled' />
															
												</section>
										
											</section>

											<section class="form-der">
		
												<section id="asignado-label-grado" class="asignado-label">
													<label for="id_grado" >Grade:</label>
													<select id="id_grado" name="id_grado" onChange="cargarSeccion(this.value)" disabled='disabled'>
														<option value="">SELECT</option>
														<?php

																cargarGrado();
													
														?>
													</select>
												</section>

												<section id="asignado-label-seccion" class="asignado-label">
													<label for="id_seccion" >Section:</label>
													<select id="id_seccion" name="id_seccion" disabled='disabled'>
														<option value="">SELECT</option>
													
													</select>
												</section>

												<section class="contenedor-label">
													<label for="nombre_usuario">User * :</label>
														<input type="hidden" id="id_usuario" name="id_usuario" />
														<input type="text" id="nombre_usuario" name="nombre_usuario" size="21px" placeholder="USER'S NAME" maxlength="25" title="Enter the user's name"  disabled='disabled' /><div id="msj-consulta-uno"><p id="msj-p-uno"></p></div>
												</section>

												<section class="contenedor-label">
													<label for="clave_usuario">Password * :</label>
														<input type="password" id="clave_usuario" name="clave_usuario" size="21px" placeholder="USER'S PASSWORD" maxlength="16" title="Enter the user's password" disabled='disabled' /><div id="msj-consulta-dos-A"><p id="msj-p-dos-A"></p></div>
												</section>

												<section class="contenedor-label">
													<label for="id_tipo_usuario">Type of user * :</label>
														<select id="id_tipo_usuario" name="id_tipo_usuario" title="Select the type of user" disabled='disabled'>
										
															<?php																	

																	cargarTipoUsuario();
															
															?>	
														</select>
												</section>

												<div id="result">&nbsp;</div>
											</section>

											<input id="form_accion" type="hidden" name="form_accion" size="10">

											<br class="clearFloat"/>

										<section class="boton-maestro">
											<button type="button" id="consultar" name="consultar" title="Press to consult" class="boton"><img class='ico' src='../imagen/icono_boton/ib-5.png' alt='Icon'>  Consult</button>
											<button type="button" id="activar" name="activar" title="Press to activate teacher's registro" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-6.png' alt='Icon'>  Activate</button>
											<button type="button" id="incluir" name="incluir" title="Press to save" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-7.png' alt='Icon'>  Save</button>
											<button type="button" id="modificar" name="modificar" title="Press to modify" class="boton" hidden="hidden" ><img class='ico' src='../imagen/icono_boton/ib-9.png' alt='Icon'>  Modify</button>
											<button type="button" id="eliminar" name="eliminar" title="Press to delete" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-8.png' alt='Icon'>  Delete</button>
											<button type="button" id="cancelar" name="cancelar" title="Press to cancel" class="boton" onClick="limpiarCamposDocente(id = ['id_docente', 'cedula', 'nombre', 'apellido', 'id_codigo_tele', 'id_telefono', 'numero', 'id_usuario', 'nombre_usuario', 'clave_usuario', 'id_tipo_usuario', 'estatus', 'asignado', 'id_grado', 'id_seccion'])"><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'>  Cancel</button>		
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

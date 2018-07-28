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
	include("../cabecera/campos_de_seleccion/discapacidad.php");
	include("../cabecera/menu.php");
	include("../cabecera/titulo.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");
?>

<!DOCTYPE html>
<html >
 
<head>
    <meta charset="UTF-8"/>

    <?php titulo(); ?>

    <link rel="stylesheet" type="text/css" href="../css/estilo_gestion.css" media="all" />
    <link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
	<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />
	<link rel="stylesheet" href="../js/librerias/jquery-ui-1.12.1/jquery-ui.css">

	<script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery.touch.js"></script>
	<script language="javascript" type="text/javascript" src="../js/estudiante.js"></script>
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery-ui-1.12.1/jquery-ui.js"></script>
	
	<script>
		$( function() {
			
			$( "#fecha_nac" ).datepicker({
				changeMonth: true,
				changeYear: true, 
				showWeek: true,
				weekHeader: 'Wk',
				maxDate: '+0d',
				onSelect: function(value, ui) {
					var today = new Date(), 
					dob = new Date(value), 
					age = new Date(today - dob).getFullYear() - 1970;
					
					if(age == 0 || age < 4){
						
						alert("Student should be more than 4yrs old");
						$('#fecha_nac').val("");
						$('#edad').val("");
						
					}else{
						
						$('#edad').val(age);
						
					}	
				}	
			});
			
			$( "#fecha_nac" ).datepicker( "option", "dateFormat", "yy-mm-dd" );		
   
		} );
		
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
		<h5>Student</h5>
	</section>

							<fieldset id="catalogo-maestro">
										<legend>Catalog</legend>

										<section class="buscar-maestro-label">
											<label for="sexo">Status:</label>
														<input type="radio" id="estatus1" name="estatus" value="A y I" size="" placeholder="" title="Active y Not Active" onclick="busquedaAvanzadaEstudiante()" checked  /><span class="opcion_radio" for="opcion_activo_y_inactivo"> All</span>
														<input type="radio" id="estatus2" name="estatus" value="A" size="" placeholder="" title="Active" onclick="busquedaAvanzadaEstudiante()" /><span class="opcion_radio" for="opcion_activo"> Active</span>
														<input type="radio" id="estatus3" name="estatus" value="I" size="" placeholder="" title="Not Active"  onclick="busquedaAvanzadaEstudiante()"/><span class="opcion_radio" for="opcion_inactivo"> Not Active</span>
														
														<label for="buscar">Name:</label>
												<input type="text" id="buscar_nombre" name="buscar_nombre" value="" size="15px" title="Enter teacher's name to search for" maxlength="25" onKeypress="return validarLetra(event)" onKeyup="busquedaAvanzadaEstudiante(); validarLongitud(this.value, '25')" />
												<label for="buscar">Surname:</label>
												<input type="text" id="buscar_apellido" name="buscar_apellido" value="" size="15px" title="Enter teacher's name to search for" maxlength="25" onKeypress="return validarLetra(event)" onKeyup="busquedaAvanzadaEstudiante(); validarLongitud(this.value, '25')" />
										
										</section>										

										<section class="buscar-maestro-label">
												</section>

										<div id="listado-catalogo">
											<table class="tabla-maestro" id="tabla-maestro" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="20px" hidden>ID Estudiante</th>
														<th width="230px">Name</th>
														<th width="230px">Surname</th>
														<th width="150px">Sex</th>
								            			<th width="150px">Status</th>
													</tr>
												</thead>

												<tbody class="cuerpo-tabla-maestro" id="cuerpo-tabla-maestro">
													
												</tbody>

												<tfoot class="pie-tabla-maestro">
					    							<tr>
														<th width="20px"></th>
					      								<th width="230px"></th>
														<th width="230px"></th>
														<th width="150px"></th>
					                    				<th width="150px" id="total"></th>
					    							</tr>
					  			      			</tfoot>
					  			      		</table>
										</div>
								</fieldset>

								<fieldset id="form-maestro">
										<legend>Manage Student</legend>
											<form action="../controlador/gestionar_estudiante.php" method="POST" enctype="multipart/form-data">
											<div class="instruccion">All field with asteric ( * ) are obligatory</div>
											<section class="form-izq">

												<section class="contenedor-label">
													<label for="nombre">Name * :</label>
														<input type="hidden" id="id_estudiante" name="id_estudiante" />
														<input type="text" id="nombre" name="nombre" class="texto" size="21px" placeholder="NAME" pattern="[A-Za-z\s]*" maxlength="25" title="Enter the student's name" onKeyPress="return validarLetra(event)" />
												</section>

												<section class="contenedor-label">
													<label for="apellido">Surname * :</label>
														<input type="text" id="apellido" name="apellido" class="texto" size="21px" placeholder="SURNAME" pattern="[A-Za-z\s]*" maxlength="25" title="Enter the student's surname" onKeyPress="return validarLetra(event)" />
												</section>

												<section class="contenedor-label">
													<label for="fecha_nac">D.O.B * :</label>
														<input type="text" id="fecha_nac" name="fecha_nac" size="21px" placeholder="D.O.B" maxlength="" title="Select the student's date of birth" />
												</section>

												<section class="contenedor-label">
													<label for="edad">Age:</label>
														<input type="text" id="edad" name="edad" disabled size="7px" placeholder="AGE"/>
												</section>

												<section class="contenedor-label">
													<label for="sexo">Sex * :</label>
														<input type="radio" id="sexo1" name="sexo" value="F" size="" placeholder="" title="Femenino" /><span class="opcion_radio" for="opcion_femenina"> F</span>
														<input type="radio" id="sexo2" name="sexo" value="M" size="" placeholder="" title="Masculino" /><span class="opcion_radio" for="opcion_masculino"> M</span>
														
												</section>

												<section class="contenedor-label">
													<label for="id_codigo_tele">Telephone:</label>
														<input type="hidden" id="id_telefono" name="id_telefono" />
														<select id="id_codigo_tele" name="id_codigo_tele" title="Select the telephone code" >
															<option value="">####</option>
															<?php
															
																	cargarCodigoTelefono();
																
															?>
														</select>
														<input type="text" id="numero" name="numero" size="10px" placeholder="TELEPHONE" pattern="[0-9]*" maxlength="7" title="Enter the student's telephone number" onKeyPress="return validarNumero(event)" />
												</section>

												<section class="contenedor-label">
													<label for="id_diversidad">Discapacity * :</label>
														<select id="id_discapacidad" name="id_discapacidad" title="Select the discapacity" >
															<option value="">SELECT</option>
															<?php

																	cargarDiscapacidad();
																																
															?>
														</select>
														<a id="anadir-discapacidad" href='#' class="img_boton_ico" title="Press to add discapacity"><span></span></a>
												</section>

												<section class="contenedor-label">
													<label for="estatus">Status:</label>
														<input type="text" id="estatus" name="estatus" size="15px" placeholder="STATUS" disabled='disabled' value='ACTIVE'/>
												</section>

											</section>

											<section class="form-der">

												<section class="contenedor-label">
													<label for="asignado">Assigned:</label>
														<input type="text" id="asignado" name="asignado" size="21px"  placeholder="ASSIGNED" disabled='disabled' value='NO'/>
															
												</section>
		
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
												
												<div id="result">&nbsp;</div>
											</section>

											<input id="form_accion" type="hidden" name="form_accion" size="10">

											<br class="clearFloat"/>

									<section class="boton-maestro">											
											
											<button type="button" id="activar" name="activar" title="Press to activate the student" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-6.png' alt='Icon'>  Activate</button>
											<button type="button" id="incluir" name="incluir" title="Press to save" class="boton"><img class='ico' src='../imagen/icono_boton/ib-7.png' alt='Icon'>  Save</button>
											<button type="button" id="modificar" name="modificar" title="Press to modify" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-9.png' alt='Icon'>  Modify</button>
											<button type="button" id="eliminar" name="eliminar" title="Press to delete" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-8.png' alt='Icon'>  Delete</button>													
											<button type="button" id="cancelar" name="cancelar" title="Press to cancel" class="boton" onClick="limpiarCamposEstudiante(id = ['id_estudiante', 'nombre', 'apellido', 'fecha_nac', 'edad', 'id_codigo_tele', 'id_telefono', 'numero', 'id_discapacidad', 'estatus', 'asignado', 'id_grado', 'id_seccion'])"><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'>  Cancel</button>
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

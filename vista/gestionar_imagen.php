<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){
		//echo "<meta http-equiv='refresh' content='0 url=../index.php'/>";	
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../modelo/conexion_bd.php");
	include("../cabecera/campos_de_seleccion/grado.php");
	include("../cabecera/campos_de_seleccion/area.php");
	include("../cabecera/campos_de_seleccion/contenido.php");
	include("../cabecera/campos_de_seleccion/agrupacion.php");
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
    <link rel="stylesheet" type="text/css" href="../css/librerias/jquery.ptTimeSelect.css" />
	<link rel="stylesheet" type="text/css" href="../css/librerias/jquery-ui.css" />
	<link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
	<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />

	<script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
	<script language="javascript" type="text/javascript" src="../js/librerias/jquery.touch.js"></script>
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery.ptTimeSelect.js"></script>
    <script language="javascript" type="text/javascript" src="../js/imagen.js"></script>

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
		<h5>Associated images to the activities</h5>
	</section>

	<form action="../controlador/gestionar_imagen.php" id="form-image" method="POST" enctype="multipart/form-data">

		<fieldset id="catalogo-maestro">
										<legend>Catalog</legend>

										<section class="catalogo-buscar-izq">
													<section class="catalogo-label"> 
															<label for="buscar_area">Area:</label>
														<select id="buscar_area" name="buscar_area" title="Select the area" />
															<option value="">SELECT</option>
															<?php
																cargarArea();
															?>
														</select>
													</section>

													<section class="catalogo-label"> 
															<label for="buscar_actividad">Activity:</label>
														<select id="buscar_actividad" name="buscar_actividad" title="Select the activity to search for" onChange="busquedaAvanzadaImagen(this.value, 'listado-catalogo', '../controlador/gestionar_imagen.php', 'consultaAvanzada')"/>
															<option value="">SELECT</option>
														</select>
													</section>

													<section class="catalogo-label">
																<label for="buscar">Word:</label>
												<input type="text" id="buscar_palabra" name="buscar_palabra" value="" size="10px" title="Enter the word that is associated to the exercise" maxlength="25" onKeypress="return validarLetra(event)" onKeyup="busquedaAvanzadaImagen( '', 'listado-catalogo', '../controlador/gestionar_imagen.php', 'consultaAvanzada'); validarLongitud(this.value, '11')" />
													</section>
										</section>

										<section class="catalogo-buscar-cent">
													<section class="catalogo-label"> 
															<label for="buscar_contenido">Content:</label>
														<select id="buscar_contenido" name="buscar_contenido" title="Select the content that's asociated to the image to search for" onChange="busquedaAvanzadaImagen(this.value, 'listado-catalogo', '../controlador/gestionar_imagen.php', 'consultaAvanzada')"/>
															<option value="">SELECT</option>
															<?php
																cargarContenido();
															?>
														</select>
													</section>
													<section class="catalogo-label"> 
															<label for="buscar_agrupacion">Grouping:</label>
														<select id="buscar_agrupacion" name="buscar_agrupacion" title="Select the grouping" onChange="busquedaAvanzadaImagen(this.value, 'listado-catalogo', '../controlador/gestionar_imagen.php', 'consultaAvanzada')"/>
															<option value="">SELECT</option>
															<?php
																cargarAgrupacion();
															?>
														</select>
													</section>
													<section class="catalogo-label">
															<label for="buscar">Number:</label>
												<input type="number" id="buscar_numero" name="buscar_numero" value="" size="10px" title="Enter the number that's associated to the exercise to search for" maxlength="25" onKeypress="return validarNumero(event)" onKeyup="busquedaAvanzadaImagen( '', 'listado-catalogo', '../controlador/gestionar_imagen.php', 'consultaAvanzada'); validarLongitud(this.value, '25')" onChange="busquedaAvanzadaImagen( '', 'listado-catalogo', '../controlador/gestionar_imagen.php', 'consultaAvanzada'); validarLongitud(this.value, '25')" />
													</section>
										</section>

										<section class="catalogo-buscar-der">
													<section class="catalogo-label"> 
															<label for="buscar_grado">Grade:</label>
														<select id="buscar_grado" name="buscar_grado" title="Select the grade to search for" onChange="cargarSeccionCatalogoImagen(this.value)"/>
															<option value="">SELECT</option>
															<?php
																cargarGrado();
															?>
														</select>
													</section>
													<section class="catalogo-label"> 
															<label for="buscar_seccion" >Section:</label>
															<select id="buscar_seccion" name="buscar_seccion" title="Select the section to search for" onChange="busquedaAvanzadaImagen(this.value, 'listado-catalogo', '../controlador/gestionar_imagen.php', 'consultaAvanzada')">
																	<option value="">SELECT</option>
															</select>
													</section>
													<section class="catalogo-label">
															<label for="buscar">Time:</label>
 												<input type="text" id="buscar_hora" name="buscar_hora" value="" size="10px" title="Enter the time that's associated to the exercise to search for" maxlength="25" onKeypress="return validarNumero(event)" onmouseleave="busquedaAvanzadaImagen( '', 'listado-catalogo', '../controlador/gestionar_imagen.php', 'consultaAvanzada'); validarLongitud(this.value, '5')" />
													</section>
										</section>

										<br class="clearFloat"/>

										<section class="buscar-maestro-label">
											
											
											
										</section>

											<div id="listado-catalogo">
											<table class="tabla-maestro" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="160px">Image</th>
														<th width="200px">Word</th>
														<th width="90px">Number</th>
														<th width="100px">Time</th>
														<th width="150px">Nº Activity</th>
														<th width="110px">Nº Themes</th>
													</tr>
												</thead>

												<tbody class="cuerpo-tabla-maestro" id="cuerpo-tabla-maestro">
													
												</tbody>
											</table>
										</div>
	 </fieldset>

	 <fieldset id="form-maestro">
										<legend>Manage Image</legend>
											<section class="form-izq">
												<section class="contenedor-label">
													<label for="imagen">Image:</label>
														<input type="hidden" id="id_imagen" name="id_imagen"/>
														<input type="hidden" id="direccion_imagen" name="direccion_imagen" />
														<img id="id_mostrar_imagen" width="185px" height="170px" src="../imagen/default-imagen.jpg" onclick="document.getElementById('id_archivo').click(); return false;" title="Click to upload image" />
														<input type="file" id="id_archivo" name="miarchivo" style="visibility: hidden; display: none;" style="height:28px; width:250px;" onchange="return ValidarImagenSubir()" />
												</section>
												</section>		
											</section>

											<section class="form-der"/>
														<section class="contenedor-label">
																<label for="lenguaje_signo">Sign language:</label>
																<input type="hidden" id="direccion_lng_sena" name="direccion_lng_sena" />
																 <video id="video_lenguaje_signo" hidden width="200" height="170" controls>
																			<source src="1" type="video/ogg" class="src-video-ogg"/>
																			<source src="2" type="video/mp4" class="src-video-mp4"/>
																			<source src="3" type="video/webm" class="src-video-webm"/>
																	</video>

																	<img id="img_lenguaje_signo" width="185px" height="170px" src="../imagen/icon/lenguaje-signo.png" /> 
														</section>
														<section class="boton-subir">
														<button id='subir_lenguaje_signo' onclick="document.getElementById('lenguaje_signo').click(); return false;" title="Press to upload sign language" class="boton" ><img class='ico' src='../imagen/icono_boton/ib-17.png' alt='Icon'>  Upload</button> 
														
														<input type="file" id="lenguaje_signo" name="lenguaje_signo" style="visibility: hidden; display: none;" style="height:28px; width:250px;" onchange="return ValidarLenguajeSigno()" />
														<input type="text" id="extension_lng_sign" name="extension_lng_sign" size="14px" hidden />
														<button type="button" id='quitar_lng_sign' title="Press to remove sign language" class="boton" hidden ><img class='ico' src='../imagen/icono_boton/ib-19.png' alt='Icon'>  Remove</button> 
												</section>
											</section>

											<br class="clearFloat"/>

											<section class="form-izq">
													<section class="contenedor-label">
													<label for="hora">Time:</label>
														<input type="text" id="hora" name="hora" size="14px" placeholder="TIME" maxlength="25" title="Enter the time that's associated to the image" />
												</section>
												<section class="contenedor-label">
													<label for="palabra">Word:</label>
														<input type="text" id="palabra" name="palabra" class="texto" size="14px" placeholder="WORD" maxlength="25"  title="Enter the word that's associated to the image" onKeypress="return validarLetra(event)"/>
												</section>
												<section class="contenedor-label">
													<label for="numero">Number:</label>
														<input type="text" id="numero" name="numero" size="14px" placeholder="NUMBER" maxlength="25" title="Enter the number that's associated to the image" onKeypress="return validarNumero(event)" onKeyup="validarLongitud(this.value, '3')"/>
												</section>
												<section class="contenedor-label">
													<label for="sonido">Audio:</label>
														<div id="area_audio">
																<img class='ico_no_audio' src='../imagen/icon/no_audio.png' alt='Icon'>  There's No Audio
														</div>
														<audio controls id="id_tocar_audio" src=" " >
														</audio>
														<input type="hidden" id="direccion_audio" name="direccion_audio" />
												</section>
												<section class="boton-subir">
														<button id='subir_audio' onclick="document.getElementById('id_archivo_audio').click(); return false;" title="Press to upload audio" class="boton" ><img class='ico' src='../imagen/icono_boton/ib-12.png' alt='Icon'>  Upload</button> 
														<input type="file" id="id_archivo_audio" name="miarchivoaudio" style="visibility: hidden; display: none;" style="height:28px; width:250px;" onchange="return ValidarAudioSubir()" />
														<input type="text" id="extension_audio" name="extension_audio" size="14px" hidden/>
														<button type="button" id='quitar_audio' title="Press to remove audio" class="boton" hidden ><img class='ico' src='../imagen/icon/no_audio.png' alt='Icon'>  No Audio</button> 
												</section>
											</section>

											<section class="form-der">
													<section class="contenedor-label">
													<label for="id_area">Area:</label>
														<select id="id_area" name="id_area" title="Select the Area" />
															<option value="">SELECT</option>
															<?php
																cargarArea();
															?>
														</select>
												</section>

												<section class="contenedor-label">
													<label for="id_actividad">Activity:</label>
														<select id="id_actividad" name="id_actividad" title="Select the activities that are to be associated to the image" />
															<option value="">SELECT</option>
														</select>
												</section>

												<!--<section class="asignacion-actividad">-->
													<table class="tabla-asig-actividad" align="center" frame="box" rules="*" cellpadding="7">
														<thead>
															<tr>
																<th width="300px">Assignment of activity</th>
															</tr>
														</thead>

														<tbody class="asig-actividad" id="asig-actividad">
															
														</tbody>
													</table>
													<input type="hidden" name="contActividad" id="actividadCont" value="0" />
												<!--</section>-->
											</section>
					
											<br class="clearFloat"/>

											<section class="form-izq">
												<section class="contenedor-label">
													<label for="id_contenido">Content:</label>
														<select id="id_contenido" name="id_contenido" title="Select contents that are o be associted to the image" />
															<option value="">SELECT</option>
															<?php
																cargarContenido();
															?>
														</select>
														<a id="anadir-contenido" href='#' class="img_boton_ico" title="Press to add a content"><span></span></a>
														
												</section>

												<section class="asignacion-contenido">
													<table class="tabla-asig-contenido" align="center" frame="box" rules="*" cellpadding="7">
														<thead>
															<tr>
																<th width="300px">Assignment of Theme</th>
															</tr>
														</thead>

														<tbody class="asig-contenido" id="asig-contenido">
															
														</tbody>
													</table>
													<input type="hidden" name="contContenido" id="contenidoCont" value="0" />
												</section>
											
											</section>

											<section class="form-der">
												<section class="contenedor-label">
													<label for="id_agrupacion">Grouping:</label>
														<select id="id_agrupacion" name="id_agrupacion" title="Select the grouping that's to be associated" />
															<option value="">SELECT</option>
															<?php
																cargarAgrupacion();
															?>
														</select>
														<a id="anadir-agrupacion" href='#' class="img_boton_ico" title="Press to add a grouping"><span></span></a>
												</section>

												<section class="asignacion-agrupacion">
													<table class="tabla-asig-agrupacion" align="center" frame="box" rules="*" cellpadding="7">
														<thead>
															<tr>
																<th width="300px">Asignnemt that associated</th>
															</tr>
														</thead>

														<tbody class="asig-agrupacion" id="asig-agrupacion">
															
														</tbody>
													</table>
													<input type="hidden" name="contAgrupacion" id="agrupacionCont" value="0" />
												</section>
											
											</section>

											<section class="form-izq">
												<section class="contenedor-label">
													<label for="id_grado">Grade:</label>
														<select id="id_grado" name="id_grado" title="Seleccione el grado al que se Asocia la Imagen" />
															<option value="">SELECT</option>
															<?php
																cargarGrado();
															?>
														</select>
						
												</section>

												<section class="contenedor-label">
														<label for="id_seccion" class="label-seccion">Section:</label>
															<select id="id_seccion" name="id_seccion" class="select-imagen" title="Select the section" >
															<option value="">SELECT</option>
														</select>
												</section>
											
											</section>

											<section class="asignacion-sec-img">
													<table class="tabla-asig-sec-img" align="center" frame="box" rules="*" cellpadding="7">
														<thead>
															<tr>
																<th width="700px">Assignment of Section</th>
															</tr>
														</thead>

														<tbody class="asig-sec-img" id="asig-sec-img">
															
														</tbody>
													</table>
													<input type="hidden" name="contSeccion" id="seccionCont" value="0" />
											</section>

											<br class="clearFloat"/>

									<section class="boton-maestro">
											<button type="button" id="incluir" name="incluir" title="Press to save" class="boton" ><img class='ico' src='../imagen/icono_boton/ib-7.png' alt='Icon'>  Save</button>
											<button type="button" id="modificar" name="modificar" title="Press to modify" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-9.png' alt='Icon'>  Modify</button>
											<button type="button" id="eliminar" name="eliminar" title="Press to delete" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-8.png' alt='Icon'>  Delete</button>
											<button type="button" id="cancelar" name="cancelar" title="Press to cancel" class="boton"><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'>  Cancel</button>		
									</section>

				</fieldset>

</div>

<div id="pie">
			<?php include("../cabecera/pie.php"); ?>
</div>

<script type="text/javascript">
        $(document).ready(function(){
        		// encontrar los campos de entrada y aplicar el tiempo de selección para ellos.
            $('#hora').ptTimeSelect({
               
            }); //fin de la función ptTimeSelect()

						// encontrar los campos de entrada y aplicar el tiempo de selección para ellos.
            $('#buscar_hora').ptTimeSelect({
               
            }); //fin de la función ptTimeSelect()
       	}); // fin de la función ready()
</script>

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

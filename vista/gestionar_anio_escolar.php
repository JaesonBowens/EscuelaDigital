<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

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
    <!--<link rel="stylesheet" type="text/css" href="../css/librerias/estilo_calendario.css" media="all" />-->
    <link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
	<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />
	<link rel="stylesheet" href="../js/librerias/jquery-ui-1.12.1/jquery-ui.css">

    <script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>		
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
    <script language="javascript" type="text/javascript" src="../js/anio_escolar.js"></script>

    <script language="javascript" type="text/javascript" src="../js/librerias/jquery-ui-1.12.1/jquery-ui.js"></script>

	
    <script>
		$( function() {
			
			$( "#fecha_inicio" ).datepicker({
				changeMonth: true,
				changeYear: true, 
				maxDate: "+2Y",
				showWeek: true,
				weekHeader: 'Wk',
				onSelect: function( fechaSeleccionada ) {
					$( "#fecha_fin" ).datepicker("option", "minDate", fechaSeleccionada );
					setTimeout(function(){
						$( "#fecha_fin" ).datepicker('show');
						$("#fecha_fin").attr('disabled', false);
					}, 16);     
				}
				
			});
			
			$("#fecha_fin").datepicker({
				changeMonth: true,
				changeYear: true,
				maxDate: "+2Y",
				showWeek: true,
				weekHeader: 'Wk'
			});
			
			$( "#fecha_inicio" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
			
			$("#fecha_fin").attr('disabled', true);
			
			$("#fecha_fin").datepicker( "option", "dateFormat", "yy-mm-dd" );			
   
		} );
		
    </script>
	
</head>

<body onLoad="busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_anio_escolar.php', 'consultaAvanzada')" >

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
		<h5>Academic Period</h5>
	</section>

		<fieldset id="catalogo-maestro">
							<legend>Catalog</legend>
										<section class="buscar-maestro-label">
											<label for="buscar">Search:</label>
												<input list="lista" type="text" id="buscar" name="buscar" value="" size="15px" title="Enter school year to search for" maxlength="10" onKeyup="busquedaAvanzada(this.value, 'cuerpo-tabla-maestro', '../controlador/gestionar_anio_escolar.php', 'consultaAvanzada'); validarLongitud(this.value, '10')" />
										</section>

										<table class="tabla-maestro" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="200px">Academic Period</th>
														<th width="200px">Start of Academic Period</th>
														<th width="200px">End of Academic Period</th>
														<th width="210px">Status</th>
													</tr>
												</thead>

												<tbody class="cuerpo-tabla-maestro" id="cuerpo-tabla-maestro">
													
												</tbody>
											</table>
		</fieldset>
		
		

		<fieldset id="form-maestro">
										<legend>Manage Academic Period</legend>
											<form action="../controlador/gestionar_anio_escolar.php" method="POST">
											<section class="form-cent">
													<section class="contenedor-label">
														<label for="fecha_inicio">Start of Period:</label>
														<input type="hidden" id="id_ano_escolar" name="id_ano_escolar" > 
														<input type="text" id="fecha_inicio" class="calendario1" name="fecha_inicio" onpaste="alert('You can't paste information in the field');return false" size="15px" value="" placeholder="STARTS" maxlength="" title="Select the date when the school year starts" value="" />
													</section>

													<section class="contenedor-label">
														<label for="fecha_fin">End of Period:</label>
														<input type="text" id="fecha_fin" name="fecha_fin" class="calendario2" onpaste="alert('You can't paste information in the field');return false" size="15px" value="" placeholder="ENDS" maxlength="" title="Select the date when the school year ends" value=" " />
													</section>

													<section class="contenedor-label">
														<label for="ano_escolar">Academic Period:</label>
														<input type="text" id="ano_escolar" name="ano_escolar" onpaste="alert('You can't paste information in the field');return false" size="15px" placeholder="SCHOOL YEAR" maxlength="" title="School year" value="" disabled="disabled" />
													</section>

											</section>

											<br class="clearFloat"/>

									<section class="boton-maestro">
											<button type="button" id="incluir" name="incluir" title="Press to save" class="boton"><img class='ico' src='../imagen/icono_boton/ib-7.png' alt='Icon'> Save</button>
											<button type="button" id="modificar" name="modificar" title="Press to modify" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-9.png' alt='Icon'>  Modify</button>
											<button type="button" id="eliminar" name="eliminar" title="Press to delete" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-8.png' alt='Icon'>  Delete</button>
											<button type="button" id="cancelar" name="cancelar" title="Press to cancel" class="boton" onClick="limpiarCamposAnioEscolar(id = ['id_ano_escolar', 'fecha_inicio', 'fecha_fin', 'ano_escolar'])"><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'>  Cancel</button>				
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

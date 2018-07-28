<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){	
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../modelo/conexion_bd.php");
	include("../cabecera/titulo.php");
	include("../cabecera/campos_de_seleccion/contenido.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<?php titulo(); ?>

		<meta charset="UTF-8"/>
		<link rel="stylesheet" type="text/css" href="../css/asignacion_pc.css" media="all" />
		<link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
		<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />

		<script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>
		<script type="text/javascript" src="../js/formulario.js"></script>
		<script type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
		<script type="text/javascript" src="../js/librerias/jquery.touch.js"></script>
		<script type="text/javascript" src="../js/asignacion_pc.js"></script>
	</head>

	<body onLoad="redireccionar('#uno')">
		<div id="cuerpo-asig-pc">			
			<form>
				<div id="contenedor-form-asig-pc">

					<div id="cabecera-label">
						<div class="cabecera-der">
							<a href="../controlador/cerrar_sesion_est.php"><button type="button" id="boton-cerrar" name="boton-cerrar" title="Cerrar" class="boton-cerrar">X</button></a>
						</div>

						<h5>Assigning a student to the computer</h5>
					</div>

					<div class="asig-pc-dato-docente">
						<label for="nombre_docente" class="label-docente">Teacher:</label>
							<input type="text" id="nombre_docente" name="nombre_docente" <?php if(isset($_SESSION["nombre_d"])){ echo "value='".$_SESSION["nombre_d"]."'"; } ?> size="20px" disabled="disabled" />

						<label for="id_grado" class="label-docente">Grade:</label>
							<select id="id_grado" name="id_grado" disabled="disabled" style="width:17%">
								<?php
									if(isset($_SESSION["nivel"])){
										echo "<option value='".$_SESSION["nivel"]."'>".$_SESSION["nivel"]."</option>";
									}
								?>
							</select>

						<label for="id_seccion" class="label-docente">Section:</label>
							<select id="id_seccion" name="id_seccion" disabled="disabled" style="width:17%">
								<?php
									if(isset($_SESSION["grupo"])){
										echo "<option value='".$_SESSION["id_seccion"]."'>".$_SESSION["grupo"]."</option>";
									}
								?>
							</select>

					</div>

					<section class="asig-pc-izq">
						<table class="tabla-maestro" frame="box" rules="*" cellpadding="7">
							<thead class="cabecera-tabla-maestro">
								<tr>
									<th width=50px hidden >ID Estudiante</th>
									<th width=405px >Name and Surname</th>
								</tr>
							</thead>

							<tbody class="cuerpo-tabla-maestro" id="cuerpo-tabla-maestro">
								<?php
									if(isset($_SESSION["id_estudiante"])){
										for($i = 0; $i <count($_SESSION["id_estudiante"]); $i++){
							
											$colum1  = "<td width=50px hidden>";
											$colum1 .= "<input type='hidden' name='id_estudiante' value='".$_SESSION["id_estudiante"][$i]."' />";
											
											$colum1 .= "</td>";

											$colum2  = "<td width=400px>";
											$colum2 .= $_SESSION["nombre_est"][$i];
											$colum2 .= "</td>";

											echo "<tr class='seleccion' title='Select the student to be assigned to this PC'>".$colum1.$colum2."</tr>";
										}
									}
								?>
							</tbody>
						</table>
					</section>

					<section class="asig-contenido-der">
						<table class="tabla-asig-contenido" frame="box" rules="*" cellpadding="7">
							<thead class="cabecera-tabla-asig-contenido">
								<tr>
									<th width="90px"><input type="button" id="seleccion-todo" title="Press to select all of the themes" value="All" /></th>
									<th width="250px">List of Themes</th>
								</tr>
							</thead>

							<tbody class="asig-contenido" id="asig-contenido">
								<?php
									cargarContenidoAsignacionPC();
								?>
							</tbody>
						</table>
					</section>
				</div>				
			</form>			
		</div>
	</body>
</html>

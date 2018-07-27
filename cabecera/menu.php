<?php

function menu(){
	echo '<script>
			function salir(){
				alertify.confirm("Are you sure that you would like to exit Mi Escuela Digital?", function(c){
					if(c){
						window.location.href = "../controlador/salir.php";
					}
					else{

					}
				});
			}
		</script>
			
		<div id="nav_wrapper">
			<ul>';

	if($_SESSION["tipo_usuario"] == "ADMINISTRATOR"){
		menuAdmin();
	
					echo "
							<li>
								<a href='#' class='sub' tabindex='1'><img class='ico_menu' src='../imagen/icono_menu/i-1.png' alt='Icon'>  Profile <img class= 'flecha' src='../imagen/icon/flecha.png' /></a>
								
								<ul>
									<li><a href='#'>User logged in: ".$_SESSION["ses_nombre_usuario"]."</a></li>
									<li><a href='../vista/menu_principal.php'><img class='ico_sub_menu' src='../imagen/icono_menu/i-2.png' alt='Icon'>  Start</a></li>
									<li><a href='../vista/gestionar_usuario.php'><img class='ico_sub_menu' src='../imagen/icono_menu/i-4.png' alt='Icon'>  Security</a></li>
									<li><a href='#' onClick='salir()'><img class='ico_sub_menu' src='../imagen/icono_menu/i-6.png' alt='Icon'>  Close Session</a></li>
								</ul>
							</li> ";
				  echo '
				  		</ul>'; 

					
				
					echo '
					</div>
					';

												return true;
	}
	else{
												//menuDinamico($_SESSION["id_funcion_usuario"][$i]);
												menuDinamico();
												echo "
												<li>
													<a href='#' class='sub' tabindex='1'><img class='ico_menu' src='../imagen/icono_menu/i-1.png' alt='Icon'>  Profile <img class= 'flecha' src='../imagen/icon/flecha.png' /></a>
													
													<ul>
														<li><a href='#'>Usuario en sesión: ".$_SESSION["ses_nombre_usuario"]."</a></li>
														<li><a href='../vista/menu_principal.php'><img class='ico_sub_menu' src='../imagen/icono_menu/i-2.png' alt='Icon'>  Start</a></li>
														<li><a href='../vista/gestionar_usuario.php'><img class='ico_sub_menu' src='../imagen/icono_menu/i-4.png' alt='Icon'>  Security</a></li>
														<li><a href='#' onClick='salir()'><img class='ico_sub_menu' src='../imagen/icono_menu/i-6.png' alt='Icon'>  Close Session</a></li>
													</ul>
												</li> ";
									  echo '
									  		</ul>';

	
					
					echo '
						</div>
						';
						return true;
	}					
}

function menuAdmin(){
	echo '
		<li>
			<a href="#" class="sub" tabindex="0">Users <img src="../imagen/icon/flecha.png" /></a>
			<ul>
				<li><a href="../vista/gestionar_docente.php" title="Option to manage the teacher´s records">Personal</a></li>
				<li><a href="../vista/gestionar_estudiante.php" title="Option to manage the student´s records">Student</a></li>
			</ul>	
		</li>
		<li>
			<a href="#" class="sub" tabindex="1">Assignments <img src="../imagen/icon/flecha.png" /></a>
			<ul>
				<li><a href="../vista/gestionar_asignacion_docente.php" title="Option to assign teacher to a section">Assign Teacher</a></li>
				<li><a href="../vista/gestionar_asignacion_estudiante.php" title="Option to assign student to a section">Assign Student</a></li>
			</ul>
		</li>
		<li>
			<a href="#"  class="sub" tabindex="1">Administration <img src="../imagen/icon/flecha.png" /></a>
			<ul>
				<li><a href="../vista/gestionar_codigo_telefonico.php">Telephone Code</a></li>
				<li><a href="../vista/gestionar_discapacidad.php">Discapacity</a></li>
				<li><a href="../vista/gestionar_grado.php">Grade</a></li>
				<li><a href="../vista/gestionar_seccion.php">Section</a></li>
				<li><a href="../vista/gestionar_anio_escolar.php">Academic Period</a></li>				
									
				<li><a href="../vista/gestionar_tipo_usuario.php">Type of User</a></li>
			</ul>
		</li>
		<li>
			<a href="#" class="sub" tabindex="1">Activity <img src="../imagen/icon/flecha.png" /> </a>
			<ul>
				<li><a href="../vista/gestionar_contenido.php">Theme</a></li>
				<li><a href="../vista/gestionar_agrupacion.php">Grouping</a></li>
				<li><a href="../vista/gestionar_imagen.php">Image</a></li>
			</ul>									
		</li>
		<li>
			<a href="#"  class="sub" tabindex="1">Reports <img src="../imagen/icon/flecha.png" /></a>
				<ul>
					<li><a href="../vista/reporte_estudiante.php">List of Student</a></li>
					<li><a href="../vista/reporte_docente.php">List of Teachers</a></li>
					<li><a href="../vista/reporte_asignacion.php">List of Assignments</a></li>
					<li><a href="../vista/reporte_desempeno_estudiantil.php">Student´s Performance</a></li>
					<li class="sub"><a href="#">Statistic</a>
						<ul>
							<li><a href="../vista/actividad_mas_ejecutada.php">Activities Most Executed</a></li>
						</ul>
					</li>
				</ul>
		</li>
		<li>
			<a href="#"  class="sub" tabindex="1">Maintenance <img src="../imagen/icon/flecha.png" /></a>
				<ul>
					<li><a href="../vista/generar_respaldo_bd.php">Back-up & Restore BD</a></li>
					<li><a href="../vista/bitacora.php">Auditory</a></li>
					<li><a href="../vista/log_sistema.php">System Log</a></li>
				</ul>
		</li>';
}

function menuDinamico(){
	$menu_asig = false;
	$menu_admi = false;
	$menu_repo = false;
	$menu_mant = false;

	for( $i = 0; $i < count($_SESSION["id_funcion_usuario"]); $i++ ){
		$id_funcion_usuario = $_SESSION["id_funcion_usuario"][$i];

		if($id_funcion_usuario == 1 && $id_funcion_usuario <= 4){
		echo '
			<li>
				<a href="#"  class="sub" tabindex="1">Users <img src="../imagen/icon/flecha.png" /></a>
					<ul>
						<li><a href="../vista/gestionar_estudiante.php">Student</a></li>
					</ul>
			';
		}
		else if($id_funcion_usuario == 2){
		echo '
				<ul>
					<li><a href="../vista/gestionar_docente.php">Personal</a></li>
				</ul>
			</li>
			';
		}
		else if( !$menu_asig && ($id_funcion_usuario == 3 || $id_funcion_usuario == 4) ){
			echo '
				<li>
					<a href="#" class="sub" tabindex="1">Assignment <img src="../imagen/icon/flecha.png" /></a>
						
					<ul>
				';
				for( $j = 0; $j < count($_SESSION["id_funcion_usuario"]); $j++ ){
					$id_funcion_usuario1 = $_SESSION["id_funcion_usuario"][$j];

					if($id_funcion_usuario1 == 3 || $id_funcion_usuario == 4){
						echo '<li><a href="../vista/gestionar_asignacion_docente.php">Assign Teacher</a></li>';
						echo '<li><a href="../vista/gestionar_asignacion_estudiante.php">Assign Student</a></li>';
					}
					
					}

			echo '
					</ul>
				</li>
				';

			$menu_asig = true;
		}
		else if( !$menu_admi && ($id_funcion_usuario == 3 || $id_funcion_usuario == 6 || $id_funcion_usuario == 7 || $id_funcion_usuario == 8 || $id_funcion_usuario == 9 || $id_funcion_usuario == 11 || $id_funcion_usuario == 12) ){
			echo '
					<li>
						<a href="#"  class="sub" tabindex="1">Administration <img src="../imagen/icon/flecha.png" /></a>
					
						<ul>
				';
						for( $j = 0; $j < count($_SESSION["id_funcion_usuario"]); $j++ ){
							$id_funcion_usuario1 = $_SESSION["id_funcion_usuario"][$j];
							if($id_funcion_usuario1 == 6){
									echo '<li><a href="../vista/gestionar_codigo_telefonico.php">Telephone Code</a></li>';
							}
							else if($id_funcion_usuario1 == 7){
									echo '<li><a href="../vista/gestionar_discapacidad.php">Discapacity</a></li>';
							}
							else if($id_funcion_usuario1 == 8){
									echo '<li><a href="../vista/gestionar_grado.php">Grade</a></li>';
							}
							else if($id_funcion_usuario1 == 9){
									echo '<li><a href="../vista/gestionar_seccion.php">Section</a></li>';
							}
							else if($id_funcion_usuario1 == 3){
									echo '<li><a href="../vista/gestionar_anio_escolar.php">Academic Period</a></li>';
							}
							else if($id_funcion_usuario1 == 12){
									echo '<li><a href="../vista/gestionar_tipo_usuario.php">Type of User</a></li>';
							}
						}

			echo '
										</ul>
								</li>
							
				';

			$menu_admi = true;
		}else if($id_funcion_usuario == 10){
					echo '<li><a href="#"  class="sub" tabindex="1">Activity <img src="../imagen/icon/flecha.png" /></a>
							<ul>
								<li><a href="../vista/gestionar_contenido.php">Theme</a></li>
								<li><a href="../vista/gestionar_agrupacion.php">Grouping</a></li>
								<li><a href="../vista/gestionar_imagen.php">Image</a></li>
							</ul>
						</li>';
		}else if( !$menu_repo && ($id_funcion_usuario == 13 || $id_funcion_usuario == 14)){
		echo '
					<li>
						<a href="#"  class="sub" tabindex="1">Reports <img src="../imagen/icon/flecha.png" /></a>
						<ul>
									<li><a href="../vista/reporte_estudiante.php">List of Students</a></li>
									<li><a href="../vista/reporte_docente.php">List of Teachers</a></li>
									<li><a href="../vista/reporte_asignacion.php">List of Assignment</a></li>
									<li><a href="../vista/reporte_desempeno_estudiantil.php">Student´s Performance</a></li>
									<li><a href="#" >Statistics</a>
										<ul>
											<li><a href="../vista/actividad_mas_ejecutada.php">Activities Most Executed</a></li>
										</ul>
									</li>
						</ul>
					</li>
				';

			$menu_repo = true;
		}else if( !$menu_mant && ($id_funcion_usuario == 15 || $id_funcion_usuario == 16 || $id_funcion_usuario == 17)){
				echo '
					<li>
						<a href="#"  class="sub" tabindex="1">Maintenance <img src="../imagen/icon/flecha.png" /></a>
					
						<ul>
				';
						for( $j = 0; $j < count($_SESSION["id_funcion_usuario"]); $j++ ){
							$id_funcion_usuario1 = $_SESSION["id_funcion_usuario"][$j];

							if($id_funcion_usuario1 == 15){
									echo '<li><a href="../vista/respaldo_bd.php">Back-up & Restore BD</a></li>';
							}
							else if($id_funcion_usuario1 == 16){
									echo '<li><a href="../vista/bitacora.php">Auditory</a></li>';
							}
							else if($id_funcion_usuario1 == 17){
									echo '<li><a href="../vista/log_sistema.php">System Log</a></li>';
							}
						}

			echo '
						</ul>
					</li>
				';

				$menu_mant = true;
		}
	}
}
?>

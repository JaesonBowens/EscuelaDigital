<?php
	session_start();

	//Incluimos al ModeloImagen.php
	include("../modelo/imagen.php");
	include("../modelo/bitacora.php");
	include("../modelo/actividad_imagen.php");
	include("../modelo/agrupacion_imagen.php");
	include("../modelo/contenido_imagen.php");
	include("../modelo/seccion_imagen.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		//Instanciamos la clase
		$modelo = new ModeloImagen;
		$modeloBitacora = new ModeloBitacora;
		$modeloActividadImagen = new ModeloActividadImagen;
		$modeloAgrupacionImagen = new ModeloAgrupacionImagen;
		$modeloContenidoImagen = new ModeloContenidoImagen;
		$modeloSeccionImagen = new ModeloSeccionImagen;

		//Verificamos si la opcion que se pulso fue la de incluir
		if(isset($_POST["incluir"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$palabra = mb_strtoupper(antiInjectionSql($_POST['palabra']), "utf-8");
			$numero  = antiInjectionSql($_POST["numero"]);
			$hora    = antiInjectionSql($_POST["hora"]);
			$extension_audio = $_POST["extension_audio"];
			$ext_lng_sign = $_POST["extension_lng_sign"];
			$contA   = antiInjectionSql($_POST["contActividad"]);
			$contC   = antiInjectionSql($_POST["contContenido"]);
			$contAg   = antiInjectionSql($_POST["contAgrupacion"]);
			$contSec   = antiInjectionSql($_POST["contSeccion"]);

			if($contA != 0 && $contC != 0 && $contSec != 0){
				//Guardamos en una nueva variable alguna información sobre el imagen seleccionado
				$nombre = $_FILES["miarchivo"] ["name"];
				$tipo   = $_FILES["miarchivo"] ["type"];
		        	$tamano = $_FILES["miarchivo"] ["size"];
		        	$temp   = $_FILES["miarchivo"] ["tmp_name"];
		         	$error  = $_FILES["miarchivo"]["error"];

				if ($error > 0){
					$_SESSION["mensaje"] = "¡Error uploading image!";
				}else{
					$resulUltimoId = $modelo -> consultarUltimoId();
					$id_imagen = $resulUltimoId + 1;
					$nombre = "imagen_".$id_imagen;
						
					move_uploaded_file($temp,"../imagen/galeria/".$nombre);
					$direccion_imagen = "../imagen/galeria/".$nombre;

					$nombre_audio = $_FILES["miarchivoaudio"] ["name"];
					$tipo_audio   = $_FILES["miarchivoaudio"] ["type"];
		        		$tamano_audio = $_FILES["miarchivoaudio"] ["size"];
		        		$temp_audio   = $_FILES["miarchivoaudio"] ["tmp_name"];
		        		$error_audio  = $_FILES["miarchivoaudio"]["error"];

					$nombre_lng_sign = $_FILES["lenguaje_signo"] ["name"];
					$tipo_lng_sign  = $_FILES["lenguaje_signo"] ["type"];
		        		$tamano_lng_sign = $_FILES["lenguaje_signo"] ["size"];
		        		$temp_lng_sign   = $_FILES["lenguaje_signo"] ["tmp_name"];
		        		$error_lng_sign  = $_FILES["lenguaje_signo"]["error"];

					if ($error_audio > 0){
						$direccion_audio = " ";
					}else{
						$nombre_audio = "audio_".$id_imagen;
						move_uploaded_file($temp_audio,"../audio/galeria/".$nombre_audio.".".$extension_audio);
						$direccion_audio = "../audio/galeria/".$nombre_audio.".".$extension_audio;
					}

					if ($error_lng_sign > 0){
						$lenguaje_sena = " ";
					}else{
						$nombre_lng_sign = "sena_".$id_imagen;
						move_uploaded_file($temp_lng_sign,"../lenguaje_sena/".$nombre_lng_sign.".".$ext_lng_sign);
						$lenguaje_sena = "../lenguaje_sena/".$nombre_lng_sign.".".$ext_lng_sign;
					}

						$id = $modelo -> incluir($direccion_imagen, $lenguaje_sena, $direccion_audio, $palabra, $numero, $hora);

						$id_contenido = $_POST["id_contenido"];

						for($i = 0; $i<$contC; $i++){
							$resulC = $modeloContenidoImagen -> insertar($id_contenido[$i], $id);
						}

						$id_actividad = $_POST["id_actividad"];

						for($i = 0; $i<$contA; $i++){
							$resulA = $modeloActividadImagen -> insertar($id_actividad[$i], $id);
						}

						if($contAg > 0){

							$id_agrupacion = $_POST["id_agrupacion"];

							for($i = 0; $i<$contAg; $i++){
								$resulAg = $modeloAgrupacionImagen -> insertar($id_agrupacion[$i], $id);
							}

						}

						if($contSec > 0){

							$id_seccion = $_POST["id_seccion"];

							for($i = 0; $i<$contSec; $i++){
								$resulSec = $modeloSeccionImagen -> insertar($id_seccion[$i], $id);
							}

						}

						//Dependiendo de si se incluyo o no ($resul = true o $resul = false se envian los mensajes)
						if($resulC && $resulA && $resulSec){
							$_SESSION["mensaje"] = "Image Registered Successfully";

							$tabla_bitacora = "image";
							$operacion_bitacora = "INCLUDE";
							$detalle_bitacora = $id.", ".$palabra.", ".$numero.", ".$hora;

							date_default_timezone_set('America/Caracas');

							$fecha_bitacora = date("Y-m-d"); 
							$hora_bitacora = date("H:i:s");
							$id_usuario = $_SESSION["ses_id_usuario"];

							$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);
						}

						else{
							$_SESSION["mensaje"] = "Error saving image, consult your Data Base Provider";
						}
					
				}
			}
			else{
				$_SESSION["mensaje"] = "Please revise that the image is assign to an activity, content and section";
			}

			//Redireccionamos
			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_imagen.php'>";
		}

		//Verificamos si la opcion que se pulso fue la de modificar
		else if(isset($_POST["modificar"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_imagen  = htmlentities($_POST["id_imagen"]);
			
			$contA      = antiInjectionSql($_POST["contActividad"]);
			$contC      = antiInjectionSql($_POST["contContenido"]);
			$contAg     = antiInjectionSql($_POST["contAgrupacion"]);
			$contSec    = antiInjectionSql($_POST["contSeccion"]);

			if(isset($_POST["palabra"]) == false){
					$palabra = "";
			}else{
					
					$palabra = mb_strtoupper(antiInjectionSql($_POST['palabra']), "utf-8");
			}

			if(isset($_POST["numero"]) == false){
					$numero = "";
			}else{
					$numero = antiInjectionSql($_POST["numero"]);
			}

			if(isset($_POST["hora"]) == false){
					$hora = "";
			}else{
					$hora = antiInjectionSql($_POST["hora"]);
			}

			$extension_audio = $_POST["extension_audio"];

			if($contA != 0 && $contC != 0 && $contSec != 0){
				//Guardamos en una nueva variable alguna información sobre el imagen seleccionado
				$nombre = $_FILES["miarchivo"] ["name"];
				$tipo   = $_FILES["miarchivo"] ["type"];
		        	$tamano = $_FILES["miarchivo"] ["size"];
		        	$temp   = $_FILES["miarchivo"] ["tmp_name"];
		        	$error  = $_FILES["miarchivo"]["error"];

				$nombre_audio = $_FILES["miarchivoaudio"] ["name"];
				$tipo_audio   = $_FILES["miarchivoaudio"] ["type"];
		        	$tamano_audio = $_FILES["miarchivoaudio"] ["size"];
		        	$temp_audio   = $_FILES["miarchivoaudio"] ["tmp_name"];
		        	$error_audio  = $_FILES["miarchivoaudio"]["error"];

				$nombre_lng_sign = $_FILES["lenguaje_signo"] ["name"];
				$tipo_lng_sign  = $_FILES["lenguaje_signo"] ["type"];
		        	$tamano_lng_sign = $_FILES["lenguaje_signo"] ["size"];
		        	$temp_lng_sign   = $_FILES["lenguaje_signo"] ["tmp_name"];
		        	$error_lng_sign  = $_FILES["lenguaje_signo"]["error"];


				if ($error_lng_sign > 0){
					$lenguaje_sena = $_POST["direccion_lng_sena"];;
				}else{
					$nombre_lng_sign = "sena_".$id_imagen;
					move_uploaded_file($temp_lng_sign,"../lenguaje_sena/".$nombre_lng_sign.".".$ext_lng_sign);
					$lenguaje_sena = "../lenguaje_sena/".$nombre__lng_sign.".".$ext_lng_sign;
				}

				if($error_audio > 0){
					$direccion_audio = " ";
				}else{
					$nombre_audio = "audio_".$id_imagen;
					move_uploaded_file($temp_audio,"../audio/galeria/".$nombre_audio.".".$extension_audio);
					$direccion_audio = "../audio/galeria/".$nombre_audio.".".$extension_audio;
				}

				if($error > 0){
					$direccion_imagen = $_POST["direccion_imagen"];
				}else{
					$nombre = "imagen_".$id_imagen;
					move_uploaded_file($temp,"../imagen/galeria/".$nombre);
					$direccion_imagen = "../imagen/galeria/".$nombre;
				}

				$id_contenido      = $_POST["id_contenido"];
				$id_actividad = $_POST["id_actividad"];
				$id_agrupacion = $_POST["id_agrupacion"];
				$id_seccion = $_POST["id_seccion"];

				//$numFila = $modelo -> consultarSiExiste($respuesta);

				//if(!$numFila){
					//Enviamos a modificar 
					$resul = $modelo -> modificar($id_imagen, $direccion_imagen, $lenguaje_sena, $direccion_audio, $palabra, $numero, $hora);

					//**************************************//
					//Modificamos la asignacion de los contenidos
					for($i = 0; $i<$contC; $i++){
						$resulC = $modeloContenidoImagen -> consultarIdImagen($id_imagen);
						$comparacionM = false;

						while($filaC = mysql_fetch_array($resulC)){
							if($id_contenido[$i] == $filaC["id_contenido"]){
								$comparacionM = true;
							}
						}

						if(!$comparacionM){
							$modeloContenidoImagen -> insertar($id_contenido[$i], $id_imagen);
						}
					}

					$resulC = $modeloContenidoImagen -> consultarIdImagen($id_imagen);

					while($filaC = mysql_fetch_array($resulC)){
						$comparacionE = false;

						for($i = 0; $i<$contC; $i++){
							if($id_contenido[$i] == $filaC["id_contenido"]){
								$comparacionE = true;
							}
						}

						if(!$comparacionE){
							$modeloContenidoImagen -> eliminarId($filaC["id_contenido_imagen"]);
						}
					}
					//**************************************//

					//**************************************//
					//Modificamos la asignacion de las Actividades
					for($i = 0; $i<$contA; $i++){
						$resulA = $modeloActividadImagen -> consultarPorIdImagen($id_imagen);
						$comparacionM = false;

						while($filaA = mysql_fetch_array($resulA)){
							if($id_actividad[$i] == $filaA["id_actividad"]){
								$comparacionM = true;
							}
						}

						if(!$comparacionM){
							$modeloActividadImagen -> insertar($id_actividad[$i], $id_imagen);
						}
					}

					$resulA = $modeloActividadImagen -> consultarPorIdImagen($id_imagen);

					while($filaA = mysql_fetch_array($resulA)){
						$comparacionE = false;

						for($i = 0; $i<$contA; $i++){
							if($id_actividad[$i] == $filaA["id_actividad"]){
								$comparacionE = true;
							}
						}

						if(!$comparacionE){
							$modeloActividadImagen -> eliminarPorId($filaA["id_actividad_imagen"]);
						}
					}
					//**************************************//

					//**************************************//
					//Modificamos la asignacion de las agrupaciones
					for($i = 0; $i<$contAg; $i++){
						$resulAg = $modeloAgrupacionImagen -> consultarPorIdImagen($id_imagen);
						$comparacionM = false;

						while($filaAg = mysql_fetch_array($resulAg)){
							if($id_agrupacion[$i] == $filaAg["id_agrupacion"]){
								$comparacionM = true;
							}
						}

						if(!$comparacionM){
							$modeloAgrupacionImagen -> insertar($id_agrupacion[$i], $id_imagen);
						}
					}

					$resulAg = $modeloAgrupacionImagen -> consultarPorIdImagen($id_imagen);

					while($filaAg = mysql_fetch_array($resulAg)){
						$comparacionE = false;

						for($i = 0; $i<$contAg; $i++){
							if($id_agrupacion[$i] == $filaAg["id_agrupacion"]){
								$comparacionE = true;
							}
						}

						if(!$comparacionE){
							$modeloAgrupacionImagen -> eliminarPorId($filaAg["id_agrupacion_imagen"]);
						}
					}


					//**************************************//

					//**************************************//
					//Modificamos la asignacion de las Secciones
					for($i = 0; $i<$contSec; $i++){
						$resulSec = $modeloSeccionImagen -> consultarPorIdImagen($id_imagen);
						$comparacionM = false;

						while($filaSec = mysql_fetch_array($resulSec)){
							if($id_seccion[$i] == $filaSec["id_seccion"]){
								$comparacionM = true;
							}
						}

						if(!$comparacionM){
							$modeloSeccionImagen -> insertar($id_seccion[$i], $id_imagen);
						}
					}

					$resulSec = $modeloSeccionImagen -> consultarPorIdImagen($id_imagen);

					while($filaSec = mysql_fetch_array($resulSec)){
						$comparacionE = false;

						for($i = 0; $i<$contSec; $i++){
							if($id_seccion[$i] == $filaSec["id_seccion"]){
								$comparacionE = true;
							}
						}

						if(!$comparacionE){
							$modeloSeccionImagen -> eliminarPorId($filaA["id_seccion_imagen"]);
						}
					}
					//**************************************//

					//Dependiendo de si se modifico o no ($resul = true o $resul = false se envian los mensajes)
					if($resul){
						$_SESSION["mensaje"] = "Image Updated Succesfully";

						$tabla_bitacora = "image";
						$operacion_bitacora = "UPDATE";
						$detalle_bitacora = $id_imagen.", ".$palabra.", ".$numero.", ".$hora;

						date_default_timezone_set('America/Caracas');

						$fecha_bitacora = date("Y-m-d"); 
						$hora_bitacora = date("H:i:s");
						$id_usuario = $_SESSION["ses_id_usuario"];

						$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);
					}

					else{
						$_SESSION["mensaje"] = "Error updating image, consult your Data Base Provider";
					}
				/*}
				else{
					$_SESSION["mensaje"] = "Ya posee una Imagen con ese Nombre";
				}*/
			}
			else{
				$_SESSION["mensaje"] = "Please revise that the image is assign to an activity, content and section";
			}

			//Redireccionamos
			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_imagen.php'>";
		}

		//Verificapos si la opcion que se pulso fue la de eliminar
		else if(isset($_POST["eliminar"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_imagen       = $_POST["id_imagen"];
			$direccion_imagen = $_POST["direccion_imagen"];
			$direccion_audio = $_POST["direccion_audio"];
			$direccion_sena = $_POST["direccion_sena"];
			$palabra = mb_strtoupper(antiInjectionSql($_POST['palabra']), "utf-8");
			$numero  = antiInjectionSql($_POST["numero"]);
			$hora    = antiInjectionSql($_POST["hora"]);

			$numFila = false;//$modelo -> consultarUso($id_imagen);

			if(!$numFila){
				unlink($direccion_imagen);

				if($direccion_audio != "" ){
						unlink($direccion_audio);
				}
		
				if($direccion_sena != "" ){
						unlink($direccion_sena);
				}

				$resul = $modelo -> eliminar($id_imagen);
				$resulC = $modeloContenidoImagen -> eliminarTodo($id_imagen);
				$resulA = $modeloActividadImagen -> eliminarTodo($id_imagen);
				$resulAg = $modeloAgrupacionImagen -> eliminarTodo($id_imagen);
				$resulSec = $modeloSeccionImagen -> eliminarTodo($id_imagen);

				if($resul && $resulC && $resulA && $resulSec){
					$_SESSION["mensaje"] = "Image Deleted Successfully";

					$tabla_bitacora = "image";
					$operacion_bitacora = "DELETE";
					$detalle_bitacora = $id_imagen.", ".$palabra.", ".$numero.", ".$hora;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);
				}
				else{
					$_SESSION["mensaje"] = "Error deleting image, consult your Data Base Provider";
				}
			}
			else{
				$_SESSION["mensaje"] = "Sorry, You can´t delete this image because it´s being used";
			}

			//Redireccionamos
			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_imagen.php'>";
		}

		//Verificapos si la opcion que se pulso fue la de consultar
		else if(isset($_GET["consultaAvanzada"])){

			if(isset($_GET["actividad"])){
				$id_actividad = $_GET["actividad"];
			}else{
				$id_actividad = NULL;
			}

			if(isset($_GET["contenido"])){
				$id_contenido = $_GET["contenido"];
			}else{
				$id_contenido = NULL;
			}

			if(isset($_GET["agrupacion"])){
				$id_agrupacion = $_GET["agrupacion"];
			}else{
				$id_agrupacion = NULL;
			}

			if(isset($_GET["seccion"])){
				$id_seccion = $_GET["seccion"];
			}else{
				$id_seccion = NULL;
			}

			if(isset($_GET["palabra"])){
				$palabra = mb_strtoupper($_GET["palabra"], "utf-8");
			}else{
				$palabra = NULL;
			}

			if(isset($_GET["numero"])){
				$numero = $_GET["numero"];
			}else{
				$numero = NULL;
			}

			if(isset($_GET["hora"])){
				$hora = $_GET["hora"];
			}else{
				$hora = NULL;
			}

			$resul = $modelo -> realizarConsultaAvanzada($palabra, $numero, $hora);

			$contador = 0;

			echo "
				<table class='tabla-maestro' align='center' frame='box' rules='*' cellpadding='7'>
												<thead class='cabecera-tabla-maestro'>
													<tr>
														<th width='160px'>Imagen</th>
														<th width='200px'>Palabra</th>
														<th width='90px'>Numero</th>
														<th width='100px'>Hora</th>
														<th width='150px'>Nº Actividad</th>
														<th width='110px'>Nº Contenido</th>
													</tr>
												</thead>

				<tbody class='cuerpo-tabla-maestro' id='cuerpo-tabla-maestro'>";

			if($resul){

				while($fila = mysql_fetch_array($resul)){

					$resulAG = $modeloActividadImagen -> consultarPorIdImagen($fila["id_imagen"]);
					$resulCG = $modeloContenidoImagen -> consultarIdImagen($fila["id_imagen"]);

					if($resulAG){
						$numAG = mysql_num_rows($resulAG);
					}
					else{
						$numAG = "0";
					}

					if($resulCG){
						$numCG = mysql_num_rows($resulCG);
					}
					else{
						$numCG = "0";
					}

					if($id_actividad == NULL && $id_contenido == NULL && $id_seccion == NULL){	

							if($id_agrupacion == NULL){
										++$contador;		

										echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
						<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
						<td width='200px' >".$fila["palabra"]."</td>
						<td width='100px' >".$fila["numero"]."</td>
						<td width='100px' >".$fila["hora"]."</td>
						<td width='150px' >".$numAG."</td>
						<td width='100px' >".$numCG."</td>
							</tr>";
							}else if($id_agrupacion != NULL){
									$resulAgru = $modeloAgrupacionImagen -> realizarConsultaAvanzada($id_agrupacion, $fila["id_imagen"]);
								
									if($resulAgru){
					
												++$contador;		

												echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
												<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
												<td width='200px' >".$fila["palabra"]."</td>
												<td width='100px' >".$fila["numero"]."</td>
												<td width='100px' >".$fila["hora"]."</td>
												<td width='150px' >".$numAG."</td>
												<td width='100px' >".$numCG."</td>
												</tr>";
									}
							}

					}else if($id_actividad == NULL &&  $id_contenido != NULL && $id_seccion == NULL){

								$resulCont = $modeloContenidoImagen -> realizarConsultaAvanzada($id_contenido, $fila["id_imagen"]);
								
								if($resulCont){
					
												if($id_agrupacion == NULL){
															++$contador;		

															echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
															<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
															<td width='200px' >".$fila["palabra"]."</td>
															<td width='100px' >".$fila["numero"]."</td>
															<td width='100px' >".$fila["hora"]."</td>
															<td width='150px' >".$numAG."</td>
															<td width='100px' >".$numCG."</td>
															</tr>";
												}else if($id_agrupacion != NULL){
																$resulAgru = $modeloAgrupacionImagen -> realizarConsultaAvanzada($id_agrupacion, $fila["id_imagen"]);
								
																if($resulAgru){
					
																		++$contador;		

																		echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
																		<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
																		<td width='200px' >".$fila["palabra"]."</td>
																		<td width='100px' >".$fila["numero"]."</td>
																		<td width='100px' >".$fila["hora"]."</td>
																		<td width='150px' >".$numAG."</td>
																		<td width='100px' >".$numCG."</td>
																		</tr>";
																}
												}
								}

					}else if($id_actividad != NULL && $id_contenido == NULL && $id_seccion == NULL){
								$resulAct = $modeloActividadImagen -> realizarConsultaAvanzada($id_actividad, $fila["id_imagen"]);
								
								if($resulAct){
					
												if($id_agrupacion == NULL){
															++$contador;		

															echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
															<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
															<td width='200px' >".$fila["palabra"]."</td>
															<td width='100px' >".$fila["numero"]."</td>
															<td width='100px' >".$fila["hora"]."</td>
															<td width='150px' >".$numAG."</td>
															<td width='100px' >".$numCG."</td>
															</tr>";
												}else if($id_agrupacion != NULL){
																$resulAgru = $modeloAgrupacionImagen -> realizarConsultaAvanzada($id_agrupacion, $fila["id_imagen"]);
								
																if($resulAgru){
					
																		++$contador;		

																		echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
																		<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
																		<td width='200px' >".$fila["palabra"]."</td>
																		<td width='100px' >".$fila["numero"]."</td>
																		<td width='100px' >".$fila["hora"]."</td>
																		<td width='150px' >".$numAG."</td>
																		<td width='100px' >".$numCG."</td>
																		</tr>";
																}
												}
								}

					}else if($id_actividad != NULL && $id_contenido != NULL  && $id_seccion == NULL){
								$resulCont = $modeloContImagen -> realizarConsultaAvanzada($id_contenido, $fila["id_imagen"]);
								$resulAct = $modeloActividadImagen -> realizarConsultaAvanzada($id_actividad, $fila["id_imagen"]);
								
								if($resulAct == true && $resulCont == true){
					
											if($id_agrupacion == NULL){
															++$contador;		

															echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
															<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
															<td width='200px' >".$fila["palabra"]."</td>
															<td width='100px' >".$fila["numero"]."</td>
															<td width='100px' >".$fila["hora"]."</td>
															<td width='150px' >".$numAG."</td>
															<td width='100px' >".$numCG."</td>
															</tr>";
												}else if($id_agrupacion != NULL){
																$resulAgru = $modeloAgrupacionImagen -> realizarConsultaAvanzada($id_agrupacion, $fila["id_imagen"]);
								
																if($resulAgru){
					
																		++$contador;		

																		echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
																		<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
																		<td width='200px' >".$fila["palabra"]."</td>
																		<td width='100px' >".$fila["numero"]."</td>
																		<td width='100px' >".$fila["hora"]."</td>
																		<td width='150px' >".$numAG."</td>
																		<td width='100px' >".$numCG."</td>
																		</tr>";
																}
												}
								}

					}else if($id_actividad != NULL && $id_contenido != NULL  && $id_seccion != NULL){
								$resulCont = $modeloContImagen -> realizarConsultaAvanzada($id_contenido, $fila["id_imagen"]);
								$resulAct = $modeloActividadImagen -> realizarConsultaAvanzada($id_actividad, $fila["id_imagen"]);
								$resulSec = $modeloSeccionImagen -> realizarConsultaAvanzada($id_seccion, $fila["id_imagen"]);
								
								if($resulAct == true && $resulCont == true && $resulSec == true){
					
											if($id_agrupacion == NULL){
															++$contador;		

															echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
															<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
															<td width='200px' >".$fila["palabra"]."</td>
															<td width='100px' >".$fila["numero"]."</td>
															<td width='100px' >".$fila["hora"]."</td>
															<td width='150px' >".$numAG."</td>
															<td width='100px' >".$numCG."</td>
															</tr>";
												}else if($id_agrupacion != NULL){
																$resulAgru = $modeloAgrupacionImagen -> realizarConsultaAvanzada($id_agrupacion, $fila["id_imagen"]);
								
																if($resulAgru){
					
																		++$contador;		

																		echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
																		<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
																		<td width='200px' >".$fila["palabra"]."</td>
																		<td width='100px' >".$fila["numero"]."</td>
																		<td width='100px' >".$fila["hora"]."</td>
																		<td width='150px' >".$numAG."</td>
																		<td width='100px' >".$numCG."</td>
																		</tr>";
																}
												}
								}

					}else if($id_actividad == NULL && $id_contenido != NULL  && $id_seccion != NULL){
								$resulCont = $modeloContImagen -> realizarConsultaAvanzada($id_contenido, $fila["id_imagen"]);
								$resulSec = $modeloSeccionImagen -> realizarConsultaAvanzada($id_seccion, $fila["id_imagen"]);
								
								if($resulCont == true && $resulSec == true){
					
											if($id_agrupacion == NULL){
															++$contador;		

															echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
															<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
															<td width='200px' >".$fila["palabra"]."</td>
															<td width='100px' >".$fila["numero"]."</td>
															<td width='100px' >".$fila["hora"]."</td>
															<td width='150px' >".$numAG."</td>
															<td width='100px' >".$numCG."</td>
															</tr>";
												}else if($id_agrupacion != NULL){
																$resulAgru = $modeloAgrupacionImagen -> realizarConsultaAvanzada($id_agrupacion, $fila["id_imagen"]);
								
																if($resulAgru){
					
																		++$contador;		

																		echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
																		<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
																		<td width='200px' >".$fila["palabra"]."</td>
																		<td width='100px' >".$fila["numero"]."</td>
																		<td width='100px' >".$fila["hora"]."</td>
																		<td width='150px' >".$numAG."</td>
																		<td width='100px' >".$numCG."</td>
																		</tr>";
																}
												}
								}

					}else if($id_actividad == NULL && $id_contenido == NULL  && $id_seccion != NULL){
								$resulSec = $modeloSeccionImagen -> realizarConsultaAvanzada($id_seccion, $fila["id_imagen"]);
								
								if($resulSec == true){
					
											if($id_agrupacion == NULL){
															++$contador;		

															echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
															<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
															<td width='200px' >".$fila["palabra"]."</td>
															<td width='100px' >".$fila["numero"]."</td>
															<td width='100px' >".$fila["hora"]."</td>
															<td width='150px' >".$numAG."</td>
															<td width='100px' >".$numCG."</td>
															</tr>";
												}else if($id_agrupacion != NULL){
																$resulAgru = $modeloAgrupacionImagen -> realizarConsultaAvanzada($id_agrupacion, $fila["id_imagen"]);
								
																if($resulAgru){
					
																		++$contador;		

																		echo "<tr title='Double Click on the image that you wish to modify' class='seleccionFila'>
																		<td width='160px'> <input type='hidden' name='id_imagen' value='".$fila["id_imagen"]."'/> <img src='".$fila["direccion_imagen"]."' width='40px' height='20px'></td>
																		<td width='200px' >".$fila["palabra"]."</td>
																		<td width='100px' >".$fila["numero"]."</td>
																		<td width='100px' >".$fila["hora"]."</td>
																		<td width='150px' >".$numAG."</td>
																		<td width='100px' >".$numCG."</td>
																		</tr>";
																}
												}
								}

					}
				}
			}

			if($contador > 1){
				echo "	</tbody>
					<tfoot class='pie-tabla-maestro'>
    						<tr>
      							<th width='160px'></th>
										<th width='200px'></th>
										<th width='100px'></th>
										<th width='100px'></th>
                    <th width='250px'>Total of ".$contador." Images Found</th>
    						</tr>
  			      		</tfoot>";
			}else{
				echo "	</tbody>
					<tfoot class='pie-tabla-maestro'>
    						<tr>
      							<th width='160px'></th>
										<th width='200px'></th>
										<th width='100px'></th>
										<th width='100px'></th>
                   	<th width='250px'>Total of ".$contador." Images Found</th>
    					 </tr>
  			      		</tfoot>
					</table>";
			}
		}
		
		else if(isset($_POST["actualizarVista"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_imagen = htmlentities($_POST["actualizarVista"]);

			//Consultamos por el Id que se selecciono
			$resul = $modelo -> consultarUnoPorId($id_imagen);
			if($resul){

				$filaG = mysql_fetch_array($resul);

				$resulAG = $modeloActividadImagen -> consultarPorIdImagen($filaG["id_imagen"]);
				$resulCG = $modeloContenidoImagen -> consultarIdImagen($filaG["id_imagen"]);
				$resulAGR = $modeloAgrupacionImagen -> consultarPorIdImagen($filaG["id_imagen"]);
				$resulSEC = $modeloSeccionImagen -> consultarPorIdImagen($filaG["id_imagen"]);

				$imagen[] = $filaG;

				while($filaAG = mysql_fetch_array($resulAG)){
					$actividad_imagen[] = $filaAG;
				}

				while($filaCG = mysql_fetch_array($resulCG)){
					$contenido_imagen[] = $filaCG;
				}
				
				$agrupacion_imagen[] = array();

				if($resulAGR){

					while($filaAGR = mysql_fetch_array($resulAGR)){
						$agrupacion_imagen[] = $filaAGR;
					}

				}

				while($filaSEC = mysql_fetch_array($resulSEC)){
					$seccion_imagen[] = $filaSEC;
				}

				$cadena = array(
					'imagen'    => $imagen,
					'actividad' => $actividad_imagen,
					'contenido' => $contenido_imagen,
					'agrupacion' => $agrupacion_imagen,
					'seccion' => $seccion_imagen
				);

				$cad = json_encode($cadena);
				echo $cad;
			}
		}

		//Si no se pulso ninguna opcion
		else{
			$_SESSION["mensaje"] = "Invalid Option";

			//Redireccionamos
			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_imagen.php'>";
		}
	}
?>

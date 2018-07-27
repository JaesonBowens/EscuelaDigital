<?php
	session_start();
	include("../modelo/conexion_bd.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){
		//Instanciamos el modelo
		$conectarBD = new conexionBD;

		//if(isset($_POST["respaldarBaseDato"])){
			$username = $conectarBD -> usuario;
			$password = $conectarBD -> contrasena;
			$hostname = $conectarBD -> servidor;
			$dbname   = $conectarBD -> base_dato;
			$nombre   = mb_strtoupper($_POST["nombre_respaldo"], "utf-8");

			$mensaje = array();

			$dumpfname = $dbname ."_".$nombre."_".date("d-m-Y_H:i:s").".sql";
			$command = "mysqldump --add-drop-table --host=$hostname --user=$username ";
			if ($password){
				$command.= "--password=".$password." ";
			}
			
			$command.= $dbname;
			$command.= " > " .$dumpfname;
			shell_exec($command);

			// zip the dump file
			$zipfname = $dbname ."_".$nombre."_".date("d-m-Y_H:i:s").".zip";
			$zip = new ZipArchive();

			if($zip->open($zipfname,ZIPARCHIVE::CREATE)){
			   $zip->addFile($dumpfname,$dumpfname);
			   $zip->close();
			}
			 
			// read zip file and send it to standard output
			if (file_exists($zipfname)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($zipfname));
				flush();
				readfile($zipfname);
				$commandDos = "rm -f -r $dumpfname";
				shell_exec($commandDos);
				$commandTres = "rm -f -r $zipfname";
				shell_exec($commandTres);
				exit;

				//$_SESSION["mensaje"] = "Base de Datos Respaldada con Exito";
				//echo "<meta http-equiv='refresh' content='0; url=../Vista/VistaGenerarRespaldo.php' />";
			}
			else{
				echo "<script>alert('Error generating the back-up of the DATA BASE')</script>";
				echo "<meta http-equiv='refresh' content='0; url=../vista/menu_principal.php' />";
			}

		//}
	}
	
?>

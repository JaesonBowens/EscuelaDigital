<?php
	session_start();

	include ("../modelo/conexion_bd.php");
	
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){
		$conectarBD = new conexionBD;

		$usuario  = $conectarBD -> usuario;
		$clave    = $conectarBD -> contrasena;
		$servidor = $conectarBD -> servidor;
		$bd       = $conectarBD -> base_dato;
		
		//if(isset($_FILES["archivo"])){
			$archivoRecibido = $_FILES["ficheroDeCopia"]["tmp_name"];
			$destino         ="../ficheroParaRestaurar.sql";

			if(!move_uploaded_file ($archivoRecibido, $destino)){
				$_SESSION["mensaje"] = "Error restoring Data Base";
				echo "<meta http-equiv='refresh' content='0; url=../vista/generar_respaldo_bd.php'/>";
			}
			
			$sistema = "show variables where variable_name= 'basedir'";
			$restore = mysql_query($sistema);
			$DirBase = mysql_result($restore,0,"value");
			$primero = substr($DirBase,0,1);
			
			/*if($primero == "/"){
				$DirBase .= "/bin/mysql";
			} 
			else{
				$DirBase .= "\bin\mysql";
			}*/

			$DirBase .= "mysql";

			$executa = "$DirBase -h $servidor -u $usuario --password=$clave  $bd < $destino";
			system($executa, $resultado);
		
			if($resultado){ 
				$_SESSION["mensaje"] = "Error restoring Data Base";
				echo "<meta http-equiv='refresh' content='0; url=../vista/generar_respaldo_bd.php'/>";
			} 
			else{
				$_SESSION["mensaje"] = "Data Base Restored Successfully";
				echo "<meta http-equiv='refresh' content='0; url=../vista/generar_respaldo_bd.php'/>";
			}

			unlink("../ficheroParaRestaurar.sql");

		//}
	}
?>


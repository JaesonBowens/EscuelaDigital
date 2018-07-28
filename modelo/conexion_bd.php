<?php
	class conexionBD{
		public $servidor   = "localhost";
		public $usuario    = "root";
		public $contrasena = "";
		public $base_dato  = "escuela_digital";

		function conexion(){
			global $conexion;
			$conexion=mysql_connect($this->servidor,$this->usuario,$this->contrasena);
				//or die("Problemas en la conexion");
				
			$db_encontrado = mysql_select_db($this->base_dato,$conexion);

			if ($db_encontrado) {

				//print "Database Found";

			}else{
				
				// Create database
				$sql = "CREATE DATABASE ".$this->base_dato;
				$resul_bd = mysql_query($sql);
				if ($resul_bd) {
    					//echo "Database created successfully";
					$usuario  = $this -> usuario;
					$clave    = $this -> contrasena;
					$servidor = $this -> servidor;
					$bd       = $this -> base_dato;
					$sistema = "show variables where variable_name= 'basedir'";
					$restore = mysql_query($sistema);
					$DirBase = mysql_result($restore,0,"value");
					$primero = substr($DirBase,0,1);
					$archivo_sql = "../BD/software_educativo_IMPLEMENTAR.sql";

					$DirBase .= "mysql";

					$executa = "$DirBase -h $servidor -u $usuario --password=$clave  $bd < $archivo_sql";
					system($executa,$resultado);
	
					if($resultado){ 
						$_SESSION["mensaje"] = "Error al Restaurar la Base de Datos";
					}else{
						$_SESSION["mensaje"] = "Base de Datos Restaurada con Éxito";
						$db_encontrado = mysql_select_db($this->base_dato,$conexion);
					}
				} else {
					$_SESSION["mensaje"] = "Error a crear base de dato: " . mysql_error($conexion);
				}

				$_SESSION["mensaje"] = "Problemas en la seleccion de la base de datos";
				//print "Database NOT Found";

			}
				//or die("Problemas en la seleccion de la base de datos");
	                mysql_query("SET NAMES 'utf8';", $conexion);

		}


		function cerrar_conexion(){
			$conexion=mysql_connect($this->servidor,$this->usuario,$this->contrasena)
				or die("Problemas en la conexion");
			mysql_close($conexion);
		
		}
		
	}
?>

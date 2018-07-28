<?php

	class ModeloLetra{
		private $id_letra;
		private $caracter;

		function incluir($caracter){
			$this->caracter = $caracter;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO letra (caracter) VALUES ('".$this->caracter."');";
			
			$resul = mysql_query($sql);
			$id = mysql_insert_id();

			$conexion_bd->cerrar_conexion();
			return $id;
		}

		function consultarLetra($caracter){
			$this->caracter = $caracter;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_letra FROM letra WHERE caracter = '".$this->caracter."';";
			
			$resul = mysql_query($sql);

			if($resul){

				$fila = mysql_fetch_array($resul);
				return $fila["id_letra"];
			}else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

	}
?>

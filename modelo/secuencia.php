<?php
	include("conexion_bd.php");

	class ModeloSecuencia{
		private $id_secuencia;
		private $ordenamiento;

		function incluir($ordenamiento){
			$this->ordenamiento = $ordenamiento;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO secuencia (ordenamiento) VALUES ('".$this->ordenamiento."');";
			
			$resul = mysql_query($sql);
			$id = mysql_insert_id();

			$conexion_bd->cerrar_conexion();
			return $id;
		}

		function consultarSecuencia($ordenamiento){
			$this->ordenamiento = $ordenamiento;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_secuencia FROM secuencia WHERE ordenamiento = '".$this->ordenamiento."';";
			
			$resul = mysql_query($sql);

			if($resul){

				$fila = mysql_fetch_array($resul);
				return $fila["id_secuencia"];
			}else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

	}
?>

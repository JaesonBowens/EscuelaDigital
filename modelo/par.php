<?php

	class ModeloPar{
		private $id_par;
		private $pareja;

		function incluir($pareja){
			$this->pareja = $pareja;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO par (pareja) VALUES ('".$this->pareja."');";
			
			$resul = mysql_query($sql);
			$id = mysql_insert_id();

			$conexion_bd->cerrar_conexion();
			return $id;
		}

		function eliminar($id_par){
			$this->id_par = $id_par;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			$sql = "DELETE FROM par WHERE id_par = '".$this->id_par."';";

			$resul = mysql_query($sql);

			$conexion_bd->cerrar_conexion();
			return $resul;
		}

		function contar(){

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT COUNT(*) FROM par;";

			$resul = mysql_query($sql);

			$conexion_bd->cerrar_conexion();
			return $resul;
		}

		function consultarAleatoria(){

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT * FROM par ORDER BY RAND();";

			$resul = mysql_query($sql);

			if($resul){
				$numFila = mysql_num_rows($resul);

				if($numFila){
					return $resul;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
			
			$conexion_bd->cerrar_conexion();

		}

	}
?>

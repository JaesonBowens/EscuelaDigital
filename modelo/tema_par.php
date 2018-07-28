<?php

	class ModeloTemaPar{
		private $id_tema_par;
		private $id_tema;
		private $id_par;

		function insertar($id_tema, $id_par){
			$this->id_par = $id_par;
			$this->id_tema = $id_tema;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO tema_par (id_tema, id_par) VALUES ('".$this->id_tema."', '".$this->id_par."');";
			
			$resul = mysql_query($sql);
			$id = mysql_insert_id();

			$conexion_bd->cerrar_conexion();
			return $id;
		}

		function eliminar($id_tema_par){
			$this->id_tema_par = $id_tema_par;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			$sql = "DELETE FROM tema_par WHERE id_tema_par = '".$this->id_tema_par."';";

			$resul = mysql_query($sql);

			$conexion_bd->cerrar_conexion();
			return $resul;
		}

		function consultarIdPar($id_par){
			$this->id_par = $id_par;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT * FROM tema_par JOIN tema USING(id_tema) WHERE id_par = '".$this->id_par."';";

			$resul = mysql_query($sql);

			$conexion->cerrar_conexion();

			return $resul;
		}

		function eliminarId($id_tema_par){
			$this->id_tema_par = $id_tema_par;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "DELETE FROM tema_par WHERE id_tema_par = '".$this->id_tema_par."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion->cerrar_conexion();
		}

		function eliminarTodo($id_par){
			$this->id_par = $id_par;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "DELETE FROM tema_par WHERE id_par = '".$this->id_par."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion->cerrar_conexion();
		}


	}
?>

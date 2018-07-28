<?php

	class ModeloParImagen{
		private $id_par_imagen;
		private $id_imagen;
 		private $id_par;

		function incluir($id_imagen, $id_par){
			$this->id_imagen = $id_imagen;
			$this->id_par = $id_par;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO par_imagen (id_imagen, id_par) VALUES ('".$this->id_imagen."', '".$this->id_par."');";
			
			$resul = mysql_query($sql);
			$id = mysql_insert_id();

			$conexion_bd->cerrar_conexion();
			return $id;
		}

		function modificar($id_par_imagen, $id_imagen){
			$this->id_par_imagen = $id_par_imagen;
			$this->id_imagen = $id_imagen;
			
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE par_imagen SET id_imagen = '".$this->id_imagen."' WHERE id_par_imagen = '".$this->id_par_imagen."';";
			
			$resul = mysql_query($sql);
			
			$conexion_bd->cerrar_conexion();
			return $resul;
		}

		function eliminar($id_par_imagen){
			$this->id_par_imagen = $id_par_imagen;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			$sql = "DELETE FROM par_imagen WHERE id_par_imagen = '".$this->id_par_imagen."';";

			$resul = mysql_query($sql);

			$conexion_bd->cerrar_conexion();
			return $resul;
		}

		function consultarPorIdPar($id_par){

			$this->id_par = $id_par;
			
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_imagen, direccion_imagen, numero, id_par_imagen, id_par FROM imagen JOIN par_imagen USING(id_imagen) WHERE id_par = '".$this->id_par."';";

			$resul = mysql_query($sql);

			$conexion_bd->cerrar_conexion();
			return $resul;
		}

	}
?>

<?php
	class ModeloActividadImagen{
		private $id_actividad_imagen;
		private $id_actividad;
		private $id_imagen;

		function insertar($id_actividad, $id_imagen){
			$this->id_imagen   = $id_imagen;
			$this->id_actividad = $id_actividad;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "INSERT INTO actividad_imagen (id_actividad, id_imagen) VALUES ('".$this->id_actividad."', '".$this->id_imagen."');";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion->cerrar_conexion();
		}

		function eliminarPorId($id_actividad_imagen){
			$this->id_actividad_imagen = $id_actividad_imagen;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "DELETE FROM actividad_imagen WHERE id_actividad_imagen = '".$this->id_actividad_imagen."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion->cerrar_conexion();
		}

		function eliminarTodo($id_imagen){
			$this->id_imagen = $id_imagen;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "DELETE FROM actividad_imagen WHERE id_imagen = '".$this->id_imagen."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion->cerrar_conexion();
		}

		function consultarPorIdImagen($id_imagen){
			$this->id_imagen = $id_imagen;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT * FROM actividad_imagen JOIN actividad USING(id_actividad) WHERE id_imagen = '".$this->id_imagen."';";
			
			$resul = mysql_query($sql);

			$conexion->cerrar_conexion();

			return $resul;
		}

		function realizarConsultaAvanzada($id_actividad, $id_imagen){

			$this->id_actividad = $id_actividad;
			$this->id_imagen = $id_imagen;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT * FROM actividad_imagen WHERE id_actividad = '".$this->id_actividad."' AND id_imagen = '".$this->id_imagen."';";

			$resul = mysql_query($sql);

			$num = mysql_num_rows($resul);

			if($num > 0){
				return true;
			}else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}
	}
?>

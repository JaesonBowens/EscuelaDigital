<?php
	class ModeloSeccionImagen{
		private $id_seccion_imagen;
		private $id_seccion;
		private $id_imagen;

		function insertar($id_seccion, $id_imagen){
			$this->id_imagen   = $id_imagen;
			$this->id_seccion = $id_seccion;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "INSERT INTO seccion_imagen (id_seccion, id_imagen) VALUES ('".$this->id_seccion."', '".$this->id_imagen."');";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion->cerrar_conexion();
		}

		function eliminarPorId($id_seccion_imagen){
			$this->id_seccion_imagen = $id_seccion_imagen;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "DELETE FROM seccion_imagen WHERE id_seccion_imagen = '".$this->id_seccion_imagen."';";

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

			$sql = "DELETE FROM seccion_imagen WHERE id_imagen = '".$this->id_imagen."';";

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

			$sql = "SELECT * FROM seccion_imagen JOIN seccion USING(id_seccion) JOIN grado USING(id_grado) WHERE id_imagen = '".$this->id_imagen."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion->cerrar_conexion();
		}

		function realizarConsultaAvanzada($id_seccion, $id_imagen){

			$this->id_seccion = $id_seccion;
			$this->id_imagen = $id_imagen;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT * FROM seccion_imagen WHERE id_seccion = '".$this->id_seccion."' AND id_imagen = '".$this->id_imagen."';";

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

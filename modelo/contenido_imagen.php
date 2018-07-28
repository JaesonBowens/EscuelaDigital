<?php
	class ModeloContenidoImagen{
		private $id_contenido_imagen;
		private $id_contenido;
		private $id_imagen;

		function insertar($id_contenido, $id_imagen){
			$this->id_imagen = $id_imagen;
			$this->id_contenido    = $id_contenido;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "INSERT INTO contenido_imagen (id_contenido, id_imagen) VALUES ('".$this->id_contenido."', '".$this->id_imagen."');";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion->cerrar_conexion();
		}

		function eliminarId($id_contenido_imagen){
			$this->id_contenido_imagen = $id_contenido_imagen;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "DELETE FROM contenido_imagen WHERE id_contenido_imagen = '".$this->id_contenido_imagen."';";

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

			$sql = "DELETE FROM contenido_imagen WHERE id_imagen = '".$this->id_imagen."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion->cerrar_conexion();
		}

		function consultarIdImagen($id_imagen){
			$this->id_imagen = $id_imagen;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT * FROM contenido_imagen JOIN contenido USING(id_contenido) WHERE id_imagen = '".$this->id_imagen."';";

			$resul = mysql_query($sql);

			$conexion->cerrar_conexion();

			return $resul;
		}

		function realizarConsultaAvanzada($id_contenido, $id_imagen){

			$this->id_contenido = $id_contenido;
			$this->id_imagen = $id_imagen;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM contenido_imagen WHERE id_contenido = '".$this->id_contenido."' AND id_imagen = '".$this->id_imagen."';";
			
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

<?php
	class ModeloAgrupacionImagen{
		private $id_agrupacion_imagen;
		private $id_agrupacion;
		private $id_imagen;

		function insertar($id_agrupacion, $id_imagen){
			$this->id_imagen   = $id_imagen;
			$this->id_agrupacion = $id_agrupacion;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "INSERT INTO agrupacion_imagen (id_agrupacion, id_imagen) VALUES ('".$this->id_agrupacion."', '".$this->id_imagen."');";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion->cerrar_conexion();
		}

		function eliminarPorId($id_agrupacion_imagen){
			$this->id_agrupacion_imagen = $id_agrupacion_imagen;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "DELETE FROM agrupacion_imagen WHERE id_agrupacion_imagen = '".$this->id_agrupacion_imagen."';";

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

			$sql = "DELETE FROM agrupacion_imagen WHERE id_imagen = '".$this->id_imagen."';";

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

			$sql = "SELECT * FROM agrupacion_imagen JOIN agrupacion USING(id_agrupacion) WHERE id_imagen = '".$this->id_imagen."';";
			
			$resul = mysql_query($sql);

			$conexion->cerrar_conexion();

			if($resul){
				return $resul;
			}
			else{
				return false;
			}
		}

		function realizarConsultaAvanzada($id_agrupacion, $id_imagen){

			$this->id_agrupacion = $id_agrupacion;
			$this->id_imagen = $id_imagen;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM agrupacion_imagen WHERE id_agrupacion = '".$this->id_agrupacion."' AND id_imagen = '".$this->id_imagen."';";
			
			$resul = mysql_query($sql);

			$num = mysql_num_rows($resul);

			if($num > 0){
				return true;
			}else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function consultarPorIdAgrupacion($id_agrupacion){

			$this->id_agrupacion = $id_agrupacion;
			
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_imagen, direccion_imagen, numero, id_agrupacion_imagen, id_agrupacion FROM imagen JOIN agrupacion_imagen USING(id_imagen) WHERE id_agrupacion = '".$this->id_agrupacion."' ORDER BY RAND() LIMIT 0,2 ;";

			$resul = mysql_query($sql);

			$conexion_bd->cerrar_conexion();
			return $resul;
		}
	}
?>

<?php

	class ModeloAsignacionFuncion{
		private $id_asignacion_funcion;
		private $id_funcion_usuario;
		private $id_tipo_usuario;

		
		function incluirAsigFuncion($id_funcion_usuario, $id_tipo_usuario){

			$this->id_tipo_usuario = $id_tipo_usuario;
			$this->id_funcion_usuario = $id_funcion_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO asignacion_funcion (id_tipo_usuario, id_funcion_usuario) VALUES ('".$this->id_tipo_usuario."', '".$this->id_funcion_usuario."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminarTodaAsigFuncion($id_tipo_usuario){

			$this->id_tipo_usuario = $id_tipo_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM asignacion_funcion WHERE id_tipo_usuario = '".$this->id_tipo_usuario."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminarAsigFuncion($id_funcion_usuario, $id_tipo_usuario){

			$this->id_tipo_usuario = $id_tipo_usuario;
			$this->id_funcion_usuario = $id_funcion_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM asignacion_funcion WHERE id_tipo_usuario = '".$this->id_tipo_usuario."' AND id_funcion_usuario = '".$this->id_funcion_usuario."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		
		function consultarSiExisteAsig($id_funcion_usuario, $id_tipo_usuario){

			$this->id_funcion_usuario = $id_funcion_usuario;
			$this->id_tipo_usuario = $id_tipo_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM asignacion_funcion WHERE id_tipo_usuario = '".$this->id_tipo_usuario."' AND id_funcion_usuario = '".$this->id_funcion_usuario."';";

			$resul = mysql_query($sql);

			if($resul){
				$numFila = mysql_num_rows($resul);
			}
			else{
				$numFila = false;
			}

			return $numFila;

			$conexion_bd->cerrar_conexion();
		}

		function consultarPorIdTipoUsuario($id_tipo_usuario){

			$this->id_tipo_usuario = $id_tipo_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_funcion_usuario FROM asignacion_funcion WHERE id_tipo_usuario = '".$this->id_tipo_usuario."';";

			$resul = mysql_query($sql);

			if($resul){
				if(mysql_num_rows($resul)){
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

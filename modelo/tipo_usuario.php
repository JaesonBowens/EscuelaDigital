<?php
	include("conexion_bd.php");

	class ModeloTipoUsuario{
		private $id_tipo_usuario;
		private $descripcion_tipo_usuario;

		function incluir($descripcion_tipo_usuario){

			$this->descripcion_tipo_usuario = $descripcion_tipo_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO tipo_usuario (descripcion_tipo_usuario) VALUES ('".$this->descripcion_tipo_usuario."');";
			
			$resul = mysql_query($sql);

			if($resul){
				return mysql_insert_id();
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_tipo_usuario, $descripcion_tipo_usuario){

			$this->id_tipo_usuario = $id_tipo_usuario;
			$this->descripcion_tipo_usuario = $descripcion_tipo_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE tipo_usuario SET descripcion_tipo_usuario = '".$this->descripcion_tipo_usuario."' WHERE id_tipo_usuario = '".$this->id_tipo_usuario."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_tipo_usuario){

			$this->id_tipo_usuario = $id_tipo_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM tipo_usuario WHERE id_tipo_usuario = '".$this->id_tipo_usuario."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarAvanzado($descripcion_tipo_usuario){

			$this->descripcion_tipo_usuario = $descripcion_tipo_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_tipo_usuario, descripcion_tipo_usuario FROM tipo_usuario WHERE descripcion_tipo_usuario LIKE '%".$this->descripcion_tipo_usuario."%';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarParaModificar($id_tipo_usuario){

			$this->id_tipo_usuario = $id_tipo_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT descripcion_tipo_usuario FROM tipo_usuario WHERE id_tipo_usuario = '".$this->id_tipo_usuario."';";

			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila["descripcion_tipo_usuario"];

			$conexion_bd->cerrar_conexion();
		}

		function consultarSiExiste($descripcion_tipo_usuario){

			$this->descripcion_tipo_usuario = $descripcion_tipo_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT descripcion_tipo_usuario, id_tipo_usuario FROM tipo_usuario WHERE descripcion_tipo_usuario = '".$this->descripcion_tipo_usuario."';";

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

		function consultarUso($id_tipo_usuario){

			$this->id_tipo_usuario = $id_tipo_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_tipo_usuario FROM tipo_usuario JOIN usuario USING(id_tipo_usuario) WHERE id_tipo_usuario = '".$this->id_tipo_usuario."';";

			$resul = mysql_query($sql);

			$numFila = mysql_num_rows($resul);

			return $numFila;

			$conexion_bd->cerrar_conexion();
		}

	}
?>

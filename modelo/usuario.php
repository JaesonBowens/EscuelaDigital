<?php
	class ModeloUsuario{
		private $id_usuario;
		private $nombre_usuario;
		private $clave_usuario;
		private $estatus_usuario;
		private $id_tipo_usuario;

		function incluir($nombre_usuario, $clave_usuario, $id_tipo_usuario){

			$this->nombre_usuario = $nombre_usuario;
			$this->clave_usuario = $clave_usuario;
			$this->id_tipo_usuario = $id_tipo_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO usuario (nombre_usuario, clave_usuario, id_tipo_usuario, estatus_usuario) VALUES ('".$this->nombre_usuario."', '".$this->clave_usuario."', '".$this->id_tipo_usuario."', 'A');";

			$resul = mysql_query($sql);

			if($resul){
				return mysql_insert_id();
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_usuario, $nombre_usuario, $clave_usuario){

			$this->id_usuario = $id_usuario;
			$this->nombre_usuario = $nombre_usuario;
			$this->clave_usuario = $clave_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE usuario SET nombre_usuario = '".$this->nombre_usuario."', clave_usuario = '".$this->clave_usuario."' WHERE id_usuario = '".$this->id_usuario."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function modificarD($id_usuario, $nombre_usuario, $clave_usuario, $id_tipo_usuario){

			$this->id_usuario = $id_usuario;
			$this->nombre_usuario = $nombre_usuario;
			$this->clave_usuario = $clave_usuario;
			$this->id_tipo_usuario = $id_tipo_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE usuario SET nombre_usuario = '".$this->nombre_usuario."', clave_usuario = '".$this->clave_usuario."', id_tipo_usuario = '".$this->id_tipo_usuario."' WHERE id_usuario = '".$this->id_usuario."';";

			$resul = mysql_query($sql);

			if($resul){
				return $id_usuario;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_usuario){

			$this->id_usuario = $id_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE usuario as u JOIN docente as d USING(id_usuario) SET u.estatus_usuario = 'I', d.estatus = 'I' WHERE id_usuario = '".$this->id_usuario."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function consultar($id_usuario){

			$this->id_usuario = $id_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_usuario, clave_usuario FROM usuario WHERE id_usuario = '".$this->id_usuario."';";
			
			$resul = mysql_query($sql);

			/*if($resul){
				return $resul;
			}
			else{
				return false;
			}*/

			if($resul){
				$numFila = mysql_num_rows($resul);
				$numFila = $resul;
			}
			else{
				$numFila = false;
			}

			return $numFila;

			$conexion_bd->cerrar_conexion();
		}

		function verificarNombreUsuario($id_usuario, $nombre_usuario){

			$this->id_usuario = $id_usuario;
			$this->nombre_usuario = $nombre_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->id_usuario != NULL){
				$buscar .= "AND id_usuario <> '".$this->id_usuario."' ";
			}

			$sql = "SELECT nombre_usuario FROM usuario WHERE nombre_usuario = '".$this->nombre_usuario."' ".$buscar.";";

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

		function verificarUsuario($nombre_usuario, $clave_usuario){

			$this->nombre_usuario = $nombre_usuario;
			$this->clave_usuario = $clave_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_usuario, descripcion_tipo_usuario, id_funcion_usuario FROM usuario JOIN tipo_usuario USING(id_tipo_usuario) JOIN asignacion_funcion USING(id_tipo_usuario) WHERE nombre_usuario = '".$this->nombre_usuario."' AND clave_usuario = '".$this->clave_usuario."' AND estatus_usuario = 'A' ORDER BY id_funcion_usuario;";
			
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

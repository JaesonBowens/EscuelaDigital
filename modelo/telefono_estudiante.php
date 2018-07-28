<?php
	class ModeloTelefonoEstudiante{
		private $id_telefono_estudiante;
		private $id_estudiante;
		private $id_telefono;
		
		function incluir($id_estudiante, $id_telefono){
			
			$this->id_estudiante = $id_estudiante;
			$this->id_telefono = $id_telefono;
			
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO telefono_estudiante (id_estudiante, id_telefono) VALUES ('".$this->id_estudiante."', '".$this->id_telefono."');";
					
			$resul = mysql_query($sql);

			if($resul){
				return mysql_insert_id();
			}
			else{
				return false;
			}
			
			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_estudiante, $id_telefono){

			$this->id_estudiante = $id_estudiante;
			$this->id_telefono = $id_telefono;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE telefono_estudiante SET id_telefono = '".$this->id_telefono."' WHERE id_estudiante = '".$this->id_estudiante."';";
		
			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function consultarPorIdEstudiante($id_estudiante){

			$this->id_estudiante = $id_estudiante;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM telefono_estudiante JOIN telefono USING(id_telefono) JOIN codigo_tele USING(id_codigo_tele) WHERE id_estudiante = '".$this->id_estudiante."' ;";
			
			$resul = mysql_query($sql);

			if($resul){

				$numFila = mysql_num_rows($resul);

				if($numFila){
					return $resul;
				}
				else{
					return false;
				}
				
			}else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function consultarPorIdTelefono($id_telefono){

			$this->id_telefono = $id_telefono;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM telefono_estudiante WHERE id_telefono = '".$this->id_telefono."' ;";
			
			$resul = mysql_query($sql);

			if($resul){

				$numFila = mysql_num_rows($resul);

				if($numFila){
					return $resul;
				}
				else{
					return false;
				}
				
			}else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function eliminarPorIdEstudiante($id_estudiante){

			$this->id_estudiante = $id_estudiante;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM telefono_estudiante WHERE id_estudiante = '".$this->id_estudiante."' ;";
			
			$resul = mysql_query($sql);

			if($resul){

				return true;
				
			}else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}
	}

?>

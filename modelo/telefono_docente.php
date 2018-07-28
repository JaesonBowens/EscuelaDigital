<?php
	class ModeloTelefonoDocente{
		private $id_telefono_docente;
		private $id_docente;
		private $id_telefono;
		
		function incluir($id_docente, $id_telefono){
			
			$this->id_docente = $id_docente;
			$this->id_telefono = $id_telefono;
			
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO telefono_docente (id_docente, id_telefono) VALUES ('".$this->id_docente."', '".$this->id_telefono."');";
					
			$resul = mysql_query($sql);

			if($resul){
				return mysql_insert_id();
			}
			else{
				return false;
			}
			
			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_docente, $id_telefono){

			$this->id_docente = $id_docente;
			$this->id_telefono = $id_telefono;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE telefono_docente SET id_telefono = '".$this->id_telefono."' WHERE id_docente = '".$this->id_docente."';";
		
			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function consultarPorIdDocente($id_docente){

			$this->id_docente = $id_docente;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM telefono_docente AS td JOIN telefono USING(id_telefono) JOIN codigo_tele USING(id_codigo_tele) WHERE td.id_docente = '".$this->id_docente."' ;";
			
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

			$sql = "SELECT * FROM telefono_docente WHERE id_telefono = '".$this->id_telefono."' ;";
			
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

		function eliminarPorIdDocente($id_docente){

			$this->id_docente = $id_docente;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM telefono_docente WHERE id_docente = '".$this->id_docente."' ;";
			
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

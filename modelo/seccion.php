<?php

	class ModeloSeccion{
		private $id_seccion;
		private $grupo;
		private $id_grado;

		function incluir($grupo, $id_grado){

			$this->grupo = $grupo;
			$this->id_grado = $id_grado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO seccion (id_grado, grupo) VALUES ('".$this->id_grado."', '".$this->grupo."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_seccion, $grupo, $id_grado){

			$this->id_seccion = $id_seccion;
			$this->grupo = $grupo;
			$this->id_grado = $id_grado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE seccion SET id_grado = '".$this->id_grado."', grupo = '".$this->grupo."' WHERE id_seccion = '".$this->id_seccion."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_seccion){

			$this->id_seccion = $id_seccion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM seccion WHERE id_seccion = '".$this->id_seccion."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function realizarConsultaAvanzada($grupo, $id_grado){

			$this->grupo = $grupo;
			$this->id_grado = $id_grado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$buscar = " ";

			if($this->id_grado != NULL){
				$buscar .= "seccion.id_grado = '".$this->id_grado."' AND";
			}

			$sql = "SELECT id_seccion, grupo, nivel, id_grado FROM seccion JOIN grado USING(id_grado) WHERE ".$buscar." grupo LIKE '%".$this->grupo."%' ORDER BY nivel_numero, grupo;";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarParaModificar($id_seccion){

			$this->id_seccion = $id_seccion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT grupo, id_grado FROM seccion WHERE id_seccion = '".$this->id_seccion."';";

			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila;

			$conexion_bd->cerrar_conexion();
		}

		function consultarSiExiste($grupo, $id_grado){

			$this->id_grado      = $id_grado;
			$this->grupo = $grupo;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT grupo FROM seccion WHERE id_grado = '".$this->id_grado."' AND grupo = '".$this->grupo."';";
			
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

		function verificarSeccion($id_seccion, $grupo, $id_grado){

			$this->id_seccion = $id_seccion;
			$this->id_grado = $id_grado;
			$this->grupo = $grupo;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";
			
			if($this->id_seccion != NULL){
				$buscar .= "AND id_seccion <> '".$this->id_seccion."' ";
			}

			$sql = "SELECT grupo FROM seccion WHERE id_grado = '".$this->id_grado."' AND grupo = '".$this->grupo."' ".$buscar.";";
			
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


		function consultarUso($id_seccion){

			$this->id_seccion = $id_seccion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_seccion FROM seccion JOIN docente_seccion USING(id_seccion) WHERE id_seccion = '".$this->id_seccion."';";

			$resul = mysql_query($sql);

			$numFila = mysql_num_rows($resul);

			return $numFila;

			$conexion_bd->cerrar_conexion();
		}

		function consultarSeccionAsignada($id_grado){

			$this->id_grado = $id_grado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM seccion WHERE id_grado = '".$this->id_grado."' ;";
			
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

		function consultarUnoPorId($id_seccion){

			$this->id_seccion = $id_seccion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_seccion, grupo, id_grado, nivel FROM seccion JOIN grado USING(id_grado) WHERE id_seccion = '".$this->id_seccion."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

	}
?>

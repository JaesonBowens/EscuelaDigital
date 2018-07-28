<?php

	class ModeloDocenteSeccion{
		private $id_docente_seccion;
		private $id_docente;
		private $id_seccion;
		private $id_ano_escolar;

		function incluir($id_docente, $id_seccion, $id_ano_escolar){
			
			$this->id_docente=$id_docente;
			$this->id_seccion=$id_seccion;
			$this->id_ano_escolar=$id_ano_escolar;
		
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO docente_seccion (id_ano_escolar, id_docente, id_seccion) VALUES ('".$this->id_ano_escolar."', '".$this->id_docente."', '".$this->id_seccion."')";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_docente, $id_seccion, $id_ano_escolar){
			
			$this->id_docente=$id_docente;
			$this->id_seccion=$id_seccion;
			$this->id_ano_escolar=$id_ano_escolar;
		
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE docente_seccion SET id_seccion = '".$this->id_seccion."' WHERE id_ano_escolar = '".$this->id_ano_escolar."' AND id_docente = '".$this->id_docente."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();			
		}

		function eliminar($id_docente, $id_ano_escolar){
			
			$this->id_docente=$id_docente;
			$this->id_ano_escolar=$id_ano_escolar;
		
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM docente_seccion WHERE id_docente = '".$this->id_docente."' AND id_ano_escolar = '".$this->id_ano_escolar."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();			
		}

		function realizarConsultaAvanzada($id_ano_escolar){

			$this->id_ano_escolar=$id_ano_escolar;
		
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_docente, cedula, nombre, apellido, id_seccion, grupo, nivel FROM docente JOIN docente_seccion USING(id_docente) JOIN seccion USING(id_seccion) JOIN grado USING(id_grado)  WHERE id_ano_escolar = '".$this->id_ano_escolar."' GROUP BY nivel_numero, grupo;";
			
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

		function consultarDocente($id_docente, $id_ano_escolar){

			$this->id_docente=$id_docente;
			$this->id_ano_escolar=$id_ano_escolar;
		
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM docente_seccion WHERE id_docente = '".$this->id_docente."' AND id_ano_escolar = '".$this->id_ano_escolar."'";
		
			$resul = mysql_query($sql);

			if($resul){
				$numFila = mysql_num_rows($resul);

				if($numFila){
					return true;
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

		function consultarModificar($nombre, $id_ano_escolar){

			$this->id_ano_escolar = $id_ano_escolar;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT * FROM docente_seccion as d_s JOIN docente USING(id_docente) WHERE id_ano_escolar = '".$this->id_ano_escolar."' AND nombre LIKE '%".$nombre."%';";
			
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

		function consultarGrupo($id_docente){

			$this->id_docente = $id_docente;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT DISTINCT g.nivel AS nivel, s.id_seccion, s.grupo AS grupo, d.nombre AS nombre_d, d.apellido AS apellido_d, est.id_estudiante AS id_estudiante_est, est.nombre AS nombre_est, est.apellido AS apellido_est FROM docente_seccion AS d_s JOIN docente AS d USING(id_docente) JOIN usuario USING(id_usuario) JOIN seccion AS s USING(id_seccion) JOIN grado AS g USING(id_grado) JOIN estudiante_seccion AS est_sec USING(id_seccion) JOIN estudiante AS est USING(id_estudiante) JOIN ano_escolar AS a_e ON est_sec.id_ano_escolar = a_e.id_ano_escolar WHERE id_docente = '".$this->id_docente."' AND est_sec.estatus = 'A' AND a_e.estatus = 'A';";

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
	
			$conexion->cerrar_conexion();
		}

		function consultarDocenteAsignado($id_docente, $id_ano_escolar){

			$this->id_docente = $id_docente;
			$this->id_ano_escolar = $id_ano_escolar;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT * FROM docente_seccion AS doc_sec JOIN seccion AS sec USING(id_seccion) JOIN grado AS grad USING(id_grado) JOIN ano_escolar AS ano_esc USING(id_ano_escolar) WHERE doc_sec.id_docente = '".$this->id_docente."' AND doc_sec.id_ano_escolar = '".$this->id_ano_escolar."' AND ano_esc.estatus = 'A';";
			
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

			$conexion->cerrar_conexion();
		}

		function consultarAvanzada($id_ano_escolar){

			$this->id_ano_escolar=$id_ano_escolar;
		
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_docente, nombre, apellido, id_seccion, grupo, nivel FROM docente JOIN docente_seccion USING(id_docente) JOIN seccion USING(id_seccion) JOIN grado USING(id_grado) WHERE id_ano_escolar = '".$this->id_ano_escolar."';";
			
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

		function consultarIdAnoEscolar($id_ano_escolar){

			$this->id_ano_escolar=$id_ano_escolar;
			
			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT * FROM docente JOIN docente_seccion AS doc_sec USING(id_docente) WHERE doc_sec.id_ano_escolar = '".$this->id_ano_escolar."';";

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
	
			$conexion->cerrar_conexion();
		}
	}
?>

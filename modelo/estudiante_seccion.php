<?php

	class ModeloEstudianteSeccion{
		private $id_estudiante_seccion;
		private $estatus;
		private $id_estudiante;
		private $id_seccion;
		private $id_ano_escolar;

		function incluir($estatus, $id_estudiante, $id_seccion, $id_ano_escolar){
	
			$this->id_ano_escolar=$id_ano_escolar;
			$this->id_estudiante=$id_estudiante;
			$this->id_seccion=$id_seccion;
			$this->estatus=$estatus;
		
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO estudiante_seccion (estatus, id_ano_escolar, id_estudiante, id_seccion) VALUES ('".$this->estatus."', '".$this->id_ano_escolar."', '".$this->id_estudiante."', '".$this->id_seccion."')";
			
			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function activarEstatus($id_estudiante, $id_seccion, $id_ano_escolar){

			$this->id_estudiante = $id_estudiante;
			$this->id_seccion = $id_seccion;
			$this->id_ano_escolar = $id_ano_escolar;

			$conexion = new conexionBD;
			$conexion->conexion();
		
			$sql = "UPDATE estudiante_seccion SET estatus = 'A' WHERE id_estudiante = '".$this->id_estudiante."' AND id_seccion = '".$this->id_seccion."' AND id_ano_escolar = '".$this->id_ano_escolar."' ;";
			
			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function inactivarTodoPorAnoEscolar($id_ano_escolar){

			$this->id_ano_escolar = $id_ano_escolar;

			$conexion = new conexionBD;
			$conexion->conexion();
		
			$sql = "UPDATE estudiante_seccion SET estatus = 'I' WHERE id_ano_escolar = '".$this->id_ano_escolar."' ;";
			
			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_estudiante, $id_seccion, $id_ano_escolar){

			$this->id_estudiante = $id_estudiante;
			$this->id_seccion = $id_seccion;
			$this->id_ano_escolar = $id_ano_escolar;
		
			$conexion = new conexionBD;
			$conexion->conexion();
					
			$sql = "UPDATE estudiante_seccion SET estatus = 'I' WHERE id_estudiante = '".$this->id_estudiante."' AND id_seccion = '".$this->id_seccion."' AND id_ano_escolar = '".$this->id_ano_escolar."' ;";
			
			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function consultarEstatusActivo($id_estudiante, $id_seccion, $id_ano_escolar){

			$this->id_estudiante = $id_estudiante;
			$this->id_seccion = $id_seccion;
			$this->id_ano_escolar = $id_ano_escolar;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT * FROM estudiante_seccion WHERE id_estudiante = '".$this->id_estudiante."' AND id_seccion = '".$this->id_seccion."' AND id_ano_escolar = '".$this->id_ano_escolar."' and estatus = 'A' ;";

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

		function consultarEstatusInactivo($id_estudiante, $id_seccion, $id_ano_escolar){

			$this->id_estudiante = $id_estudiante;
			$this->id_seccion = $id_seccion;
			$this->id_ano_escolar = $id_ano_escolar;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT * FROM estudiante_seccion WHERE id_estudiante = '".$this->id_estudiante."' AND id_seccion = '".$this->id_seccion."' AND id_ano_escolar = '".$this->id_ano_escolar."' and estatus = 'I' ;";

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

		function realizarConsultaAvanzada($id_ano_escolar){

			$this->id_ano_escolar = $id_ano_escolar;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT id_seccion, grupo, id_grado, nivel, id_ano_escolar, count(id_estudiante) as cantidad_estudiante FROM estudiante JOIN estudiante_seccion as est_sec USING(id_estudiante) JOIN seccion USING(id_seccion) JOIN grado USING(id_grado) WHERE id_ano_escolar = '".$this->id_ano_escolar."' AND est_sec.estatus = 'A' GROUP BY nivel_numero, grupo;";

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

		function consultarModificar($nombre, $id_seccion, $id_ano_escolar){

			$this->id_seccion = $id_seccion;
			$this->id_ano_escolar = $id_ano_escolar;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT id_estudiante, nombre, apellido FROM estudiante_seccion AS est_sec JOIN estudiante USING(id_estudiante) WHERE id_ano_escolar = '".$this->id_ano_escolar."' AND id_seccion = '".$this->id_seccion."' AND est_sec.estatus = 'A';";

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

		function consultarEstudianteInscrito($id_estudiante, $id_ano_escolar){

			$this->id_estudiante = $id_estudiante;
			$this->id_ano_escolar = $id_ano_escolar;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT * FROM estudiante_seccion JOIN seccion USING(id_seccion) JOIN grado USING(id_grado) WHERE id_estudiante = '".$this->id_estudiante."' AND id_ano_escolar = '".$this->id_ano_escolar."' AND estatus = 'A';";
			
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

		function consultarEstudiantePorSeccion($id_estudiante, $id_seccion, $id_ano_escolar){

			$this->id_estudiante = $id_estudiante;
			$this->id_seccion = $id_seccion;
			$this->id_ano_escolar = $id_ano_escolar;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT * FROM estudiante_seccion WHERE id_estudiante = '".$this->id_estudiante."' AND id_seccion = '".$this->id_seccion."' AND id_ano_escolar = '".$this->id_ano_escolar."';";
			
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

		function consultarIdAnoEscolar($id_ano_escolar){

			$this->id_ano_escolar=$id_ano_escolar;
			
			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT * FROM estudiante JOIN discapacidad USING(id_discapacidad) JOIN estudiante_seccion AS est_sec USING(id_estudiante) WHERE est_sec.id_ano_escolar = '".$this->id_ano_escolar."' AND est_sec.estatus = 'A';";

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

		function consultarGrupo($id_ano_escolar, $id_grado, $id_seccion){

			$this->id_ano_escolar=$id_ano_escolar;
			$this->id_grado=$id_grado;
			$this->id_seccion=$id_seccion;
			
			$conexion = new conexionBD;
			$conexion->conexion();

			$sql1 = " ";

			if($this->id_grado != 0){
				$sql1 .= "AND id_grado = '".$id_grado."' ";
			}

			if($this->id_seccion != 0){
				$sql1 .= "AND est_sec.id_seccion = '".$id_seccion."' ";
			}

			$sql = "SELECT est_sec.id_estudiante_seccion AS id_est_sec, id_grado, sec.id_seccion, nivel, grupo, est.nombre AS nombre_est, est.apellido AS apellido_est, est.sexo AS sexo_est, nombre_discapacidad, d.cedula AS cedula_d, d.nombre AS nombre_d, d.apellido AS apellido_d FROM estudiante AS est JOIN discapacidad_funcional USING(id_discapacidad) JOIN estudiante_seccion AS est_sec USING(id_estudiante) JOIN seccion AS sec USING(id_seccion) JOIN grado USING(id_grado) JOIN docente_seccion USING(id_seccion) JOIN docente AS d USING(id_docente) WHERE est_sec.id_ano_escolar = '".$this->id_ano_escolar."' ".$sql1." AND est_sec.estatus = 'A' ORDER BY grupo";

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

		function consultarSeccion($id_ano_escolar, $id_grado, $id_seccion){

			$this->id_ano_escolar=$id_ano_escolar;
			$this->id_grado=$id_grado;
			$this->id_seccion=$id_seccion;
			
			$conexion = new conexionBD;
			$conexion->conexion();

			$sql1 = " ";

			if($this->id_grado != 0){
				$sql1 .= "AND id_grado = '".$id_grado."' ";
			}

			if($this->id_seccion != 0){
				$sql1 .= "AND est_sec.id_seccion = '".$id_seccion."' ";
			}

			$sql = "SELECT est_sec.id_estudiante_seccion AS id_est_sec, id_grado, sec.id_seccion, nivel, grupo, est.id_estudiante, est.nombre AS nombre_est, est.apellido AS apellido_est, est.sexo AS sexo_est, nombre_discapacidad, d.cedula AS cedula_d, d.nombre AS nombre_d, d.apellido AS apellido_d FROM estudiante AS est JOIN discapacidad USING(id_discapacidad) JOIN estudiante_seccion AS est_sec USING(id_estudiante) JOIN seccion AS sec USING(id_seccion) JOIN grado USING(id_grado) JOIN docente_seccion AS doc_sec ON (doc_sec.id_ano_escolar = '".$this->id_ano_escolar."' AND doc_sec.id_seccion = sec.id_seccion) JOIN docente AS d USING(id_docente) WHERE est_sec.id_ano_escolar = '".$this->id_ano_escolar."' ".$sql1." AND est_sec.estatus = 'A' ORDER BY grupo";

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

		function consultarNivelNumero($id_grado){
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nivel_numero FROM grado WHERE id_grado = '".$id_grado."';";

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

		function consultarSiguienteGrado($nivel_numero){
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_grado, nivel FROM grado WHERE nivel_numero = '".$nivel_numero."';";

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

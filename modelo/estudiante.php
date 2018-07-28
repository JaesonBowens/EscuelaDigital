<?php
	include("conexion_bd.php");
	$conexion = new conexionBD;
	$conexion->conexion();

	class ModeloEstudiante{
		private $id_estudiante;
		private $nombre;
		private $apellido;
		private $fecha_nac;
		private $sexo;
		private $estatus;
		private $id_discapacidad;

		function incluir($nombre, $apellido, $fecha_nac, $sexo, $estatus, $id_discapacidad){
			
			$this->nombre=$nombre;
			$this->apellido=$apellido;
			$this->fecha_nac=$fecha_nac;
			$this->sexo=$sexo;
			$this->estatus=$estatus;
			$this->id_discapacidad=$id_discapacidad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO estudiante (nombre, apellido, fecha_nac, sexo, estatus, id_discapacidad) VALUES ('".$this->nombre."', '".$this->apellido."', '".$this->fecha_nac."', '".$this->sexo."', '".$this->estatus."', '".$this->id_discapacidad."');";

			$resul = mysql_query($sql);

			if($resul){
				return mysql_insert_id();
			}
			else{
				return false;
			}
			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_estudiante, $nombre, $apellido, $fecha_nac, $sexo, $id_discapacidad){
			
			$this->id_estudiante=$id_estudiante;
			
			$this->nombre=$nombre;
			$this->apellido=$apellido;
			$this->fecha_nac=$fecha_nac;
			$this->sexo=$sexo;
			$this->id_discapacidad=$id_discapacidad;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE estudiante SET nombre = '".$this->nombre."', apellido = '".$this->apellido."', fecha_nac = '".$this->fecha_nac."', sexo = '".$this->sexo."', id_discapacidad = '".$this->id_discapacidad."' WHERE id_estudiante = '".$this->id_estudiante."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function activarRegistroEstudiantil($id_estudiante){

			$this->id_estudiante=$id_estudiante;
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE estudiante SET estatus = 'A' WHERE id_estudiante = '".$this->id_estudiante."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}
			
			$conexion_bd->cerrar_conexion();
		}

		function desactivarRegistroEstudiantil($id_estudiante){

			$this->id_estudiante=$id_estudiante;
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE estudiante SET estatus = 'I' WHERE id_estudiante = '".$this->id_estudiante."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		/*function consultarPorNombreyApellido($nombre, $apellido){

			$this->nombre=$nombre;
			$this->apellido=$apellido;
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM estudiante JOIN discapacidad USING(id_discapacidad) WHERE nombre = '".$this->nombre."' AND apellido = '".$this->apellido."';";

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
		}*/

		function consultaAvanzadaUno($nombre, $apellido, $estatus){
			
			$this->nombre=$nombre;
			$this->apellido=$apellido;
			$this->estatus=$estatus;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->nombre != NULL){
				$buscar .= "nombre LIKE '%".$nombre."%' AND ";
			}

			if($this->apellido != NULL){
				$buscar .= "apellido LIKE '%".$apellido."%' AND ";
			}

			if($this->nombre != NULL && $this->apellido != NULL){
				$buscar .= " AND ";
			}

			if($this->estatus == 'A y I'){
				
				$sql = "SELECT * FROM estudiante WHERE ".$buscar." id_estudiante IS NOT null ORDER BY nombre";

				$resul = mysql_query($sql);

				if($resul){
					$numFila = mysql_num_rows($resul);

					if($numFila){
						return $resul;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else if($this->estatus == 'A'){
				$sql = "SELECT * FROM estudiante WHERE ".$buscar." estatus = 'A' ORDER BY nombre";

				$resul = mysql_query($sql);

				if($resul){
					$numFila = mysql_num_rows($resul);

					if($numFila){
						return $resul;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else if($this->estatus == 'I'){
				$sql = "SELECT * FROM estudiante WHERE ".$buscar." estatus = 'I' ORDER BY nombre";
			
				$resul = mysql_query($sql);

				if($resul){
					$numFila = mysql_num_rows($resul);

					if($numFila){
						return $resul;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}

			$conexion_bd->cerrar_conexion();
		}

		function consultarAvanzada($nombre, $apellido){
			
			$this->nombre=$nombre;
			$this->apellido=$apellido;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->nombre != NULL){
				$buscar .= "nombre LIKE '%".$nombre."%' AND ";
			}

			if($this->apellido != NULL){
				$buscar .= "apellido LIKE '%".$apellido."%' AND ";
			}

			if($this->nombre != NULL && $this->apellido != NULL){
				$buscar .= " AND ";
			}

			$sql = "SELECT * FROM estudiante WHERE ".$buscar." estatus = 'A'";


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

		function consultarPorId($id_estudiante){

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$this->id_estudiante=$id_estudiante;
			
			$sql = "SELECT * FROM estudiante JOIN discapacidad USING(id_discapacidad) WHERE id_estudiante = '".$this->id_estudiante."';";

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

		/*function consultarSoloCedula($cedula){

			$this->cedula=$cedula;
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT cedula FROM estudiante WHERE cedula LIKE '%".$this->cedula."%'";

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
		}*/

		function consultarAsignacion($id_estudiante){

			$this->id_estudiante = $id_estudiante;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT * FROM  estudiante_seccion WHERE estatus = 'A' AND id_estudiante = '".$this->id_estudiante."'";

			$resul = mysql_query($sql);

			if($resul){
				$numFila = mysql_num_rows($resul);

				if($numFila){
					return true;
				}
				else{
					return false;
				}
			}else{
				return false;
			}
			
			$conexion_bd->cerrar_conexion();
		}

	}
?>

<?php
	include("conexion_bd.php");

	class ModeloDocente{
		private $id_docente;
		private $cedula;
		private $nombre;
		private $apellido;
		private $estatus;
		private $id_usuario;

		function incluir($cedula, $nombre, $apellido, $estatus, $id_usuario){	
			
			$this->cedula=$cedula;
			$this->nombre=$nombre;
			$this->apellido=$apellido;
			$this->estatus=$estatus;
			$this->id_usuario=$id_usuario;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
		
			$sql = "INSERT INTO docente (cedula, nombre, apellido, estatus, id_usuario) VALUES ('".$this->cedula."', '".$this->nombre."', '".$this->apellido."', '".$this->estatus."', '".$this->id_usuario."');";

			$resul = mysql_query($sql);

			if($resul){
				return mysql_insert_id();
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_docente, $cedula, $nombre, $apellido, $estatus, $id_usuario){

			$this->id_docente = $id_docente;
			$this->cedula = $cedula;
			$this->nombre = $nombre;
			$this->apellido = $apellido;
			$this->estatus = $estatus;
			$this->id_usuario = $id_usuario;
			$this->id_sector = $id_sector;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE docente SET cedula = '".$this->cedula."', nombre = '".$this->nombre."', apellido = '".$this->apellido."', estatus = '".$this->estatus."', id_usuario = '".$this->id_usuario."', id_sector = '".$this->id_sector."' WHERE id_docente = '".$this->id_docente."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function activarDocente($id_docente){

			$this->id_docente=$id_docente;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE docente as d JOIN usuario as u USING(id_usuario) SET u.estatus_usuario = 'A', d.estatus = 'A' WHERE id_docente = '".$this->id_docente."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_docente){

			$this->id_docente=$id_docente;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE docente as d JOIN usuario as u USING(id_usuario) SET u.estatus_usuario = 'I', d.estatus = 'I' WHERE d.id_docente = '".$this->id_docente."';";

			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function consultar($cedula){

			$this->cedula=$cedula;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM docente JOIN usuario USING(id_usuario) WHERE cedula = '".$this->cedula."';";

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

		function realizarConsultaAvanzada($cedula, $nombre, $apellido, $estatus){
			
			$this->cedula 	= $cedula;
			$this->nombre 	= $nombre;
			$this->apellido = $apellido;
			$this->estatus	= $estatus;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->cedula != NULL){
				$buscar .= "cedula LIKE '".$cedula."%' AND ";
			}

			if($this->nombre != NULL){
				$buscar .= "nombre LIKE '%".$nombre."%' AND ";
			}

			if($this->apellido != NULL){
				$buscar .= "apellido LIKE '%".$apellido."%' AND ";
			}

			if($this->cedula != NULL && $this->nombre != NULL && $this->apellido != NULL){
				$buscar .= " AND ";
			}

			if($this->estatus == 'A y I'){
				
				$sql = "SELECT * FROM docente WHERE ".$buscar." id_docente IS NOT null ORDER BY nombre";

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
				$sql = "SELECT * FROM docente WHERE ".$buscar." estatus = 'A' ORDER BY nombre";

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
				$sql = "SELECT * FROM docente WHERE ".$buscar." estatus = 'I' ORDER BY nombre";
			
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

		function consultarPorId($id_docente){
			
			$this->id_docente=$id_docente;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM docente JOIN usuario USING(id_usuario) WHERE id_docente = '".$this->id_docente."';";

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

		function consultarCedula($cedula){

			$this->cedula=$cedula;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT cedula FROM docente WHERE cedula LIKE '%".$this->cedula."%'";

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

		function verificarAsignacion($id_docente){

			$this->id_docente=$id_docente;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM docente_seccion WHERE estatus = 'A' AND id_docente = '".$this->id_docente."'";

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

		function consultarDinamica($nombre){

			$this->nombre = strtoupper($nombre);
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM docente WHERE nombre LIKE '%".$this->nombre."%' ORDER BY id_docente DESC";

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

		function consultarPorIdUsuario($id_usuario){
			
			$this->id_usuario = $id_usuario;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM docente JOIN usuario USING(id_usuario) WHERE id_usuario = '".$this->id_usuario."';";

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

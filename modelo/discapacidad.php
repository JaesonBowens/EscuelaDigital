<?php
	include("conexion_bd.php");

	class ModeloDiscapacidad{
		private $id_discapacidad;
		private $nombre_discapacidad;

		function incluir($nombre_discapacidad){

			$this->nombre_discapacidad = $nombre_discapacidad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO discapacidad (nombre_discapacidad) VALUES ('".$this->nombre_discapacidad."');";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_discapacidad, $nombre_discapacidad){
	
			$this->id_discapacidad = $id_discapacidad;
			$this->nombre_discapacidad = $nombre_discapacidad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE discapacidad SET nombre_discapacidad = '".$this->nombre_discapacidad."' WHERE id_discapacidad = '".$this->id_discapacidad."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_discapacidad){

			$this->id_discapacidad = $id_discapacidad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM discapacidad WHERE id_discapacidad = '".$this->id_discapacidad."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function realizarConsultaAvanzada($nombre_discapacidad){

			$this->nombre_discapacidad = $nombre_discapacidad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_discapacidad, nombre_discapacidad FROM discapacidad WHERE nombre_discapacidad LIKE '%".$this->nombre_discapacidad."%';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarParaModificar($id_discapacidad){

			$this->id_discapacidad = $id_discapacidad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_discapacidad FROM discapacidad WHERE id_discapacidad = '".$this->id_discapacidad."';";

			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila["nombre_discapacidad"];

			$conexion_bd->cerrar_conexion();
		}

		function consultarSiExiste($nombre_discapacidad){

			$this->nombre_discapacidad = $nombre_discapacidad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_discapacidad FROM discapacidad WHERE nombre_discapacidad = '".$this->nombre_discapacidad."';";

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

		function consultarSiExisteUno($nombre_discapacidad){

			$this->nombre_discapacidad = $nombre_discapacidad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_discapacidad, nombre_discapacidad FROM discapacidad WHERE nombre_discapacidad = '".$this->nombre_discapacidad."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function verificarDiscapacidad($id_discapacidad, $nombre_discapacidad){

			$this->id_discapacidad = $id_discapacidad;
			$this->nombre_discapacidad = $nombre_discapacidad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->id_discapacidad != NULL){
				$buscar .= "AND id_discapacidad <> '".$this->id_discapacidad."' ";
			}

			$sql = "SELECT nombre_discapacidad FROM discapacidad WHERE nombre_discapacidad = '".$this->nombre_discapacidad."' ".$buscar.";";

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


		function consultarUso($id_discapacidad){

			$this->id_discapacidad = $id_discapacidad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_discapacidad FROM discapacidad JOIN estudiante USING(id_discapacidad) WHERE id_discapacidad = '".$this->id_discapacidad."';";

			$resul = mysql_query($sql);

			$numFila = mysql_num_rows($resul);

			return $numFila;

			$conexion_bd->cerrar_conexion();
		}
	}
?>

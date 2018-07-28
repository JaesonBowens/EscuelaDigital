<?php
	
	class ModeloSector{
		private $id_sector;
		private $nombre_sector;
		private $id_parroquia;

		function incluir($nombre_sector, $id_parroquia){

			$this->nombre_sector = $nombre_sector;
			$this->id_parroquia = $id_parroquia;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO sector (id_parroquia, nombre_sector) VALUES ('".$this->id_parroquia."', '".$this->nombre_sector."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_sector, $nombre_sector, $id_parroquia){

			$this->id_sector = $id_sector;
			$this->nombre_sector = $nombre_sector;
			$this->id_parroquia = $id_parroquia;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE sector SET id_parroquia = '".$this->id_parroquia."', nombre_sector = '".$this->nombre_sector."' WHERE id_sector = '".$this->id_sector."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_sector){

			$this->id_sector = $id_sector;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM sector WHERE id_sector = '".$this->id_sector."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function realizarConsultaAvanzada($nombre_sector, $id_parroquia){

			$this->nombre_sector = $nombre_sector;

			$this->id_parroquia = $id_parroquia;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->id_parroquia != NULL){
				$buscar .= "sector.id_parroquia = '".$this->id_parroquia."' AND";
			}

			$sql = "SELECT id_sector, nombre_sector, nombre_parroquia, id_parroquia, nombre_municipio, id_municipio, nombre_estado, id_estado FROM sector JOIN parroquia USING(id_parroquia) JOIN municipio USING(id_municipio) JOIN estado USING(id_estado) WHERE ".$buscar." nombre_sector LIKE '%".$this->nombre_sector."%';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarParaModificar($id_sector){

			$this->id_sector = $id_sector;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_sector, id_parroquia FROM sector WHERE id_sector = '".$this->id_sector."';";

			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila;

			$conexion_bd->cerrar_conexion();
		}

		function consultarSiExiste($nombre_sector, $id_parroquia){

			$this->nombre_sector = $nombre_sector;
			$this->id_parroquia = $id_parroquia;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_sector FROM sector WHERE id_parroquia = '".$this->id_parroquia."' AND nombre_sector = '".$this->nombre_sector."';";
			
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

		function verificarSector($id_sector, $nombre_sector, $id_parroquia){

			$this->id_sector = $id_sector;
			$this->nombre_sector = $nombre_sector;
			$this->id_parroquia = $id_parroquia;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->id_sector != NULL){
				$buscar .= "AND id_sector <> '".$this->id_sector."' ";
			}

			$sql = "SELECT nombre_sector FROM sector WHERE id_parroquia = '".$this->id_parroquia."' AND nombre_sector = '".$this->nombre_sector."' ".$buscar.";";

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


		function consultarUso($id_sector){

			$this->id_sector = $id_sector;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_sector FROM sector JOIN estudiante USING(id_sector) WHERE id_sector = '".$this->id_sector."';";

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

		function consultarUnoPorId($id_sector){

			$this->id_sector = $id_sector;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_sector, nombre_sector, id_parroquia, nombre_parroquia, id_municipio, nombre_municipio, id_estado, nombre_estado FROM sector JOIN parroquia USING(id_parroquia) JOIN municipio USING(id_municipio) JOIN estado USING(id_estado) WHERE id_sector = '".$this->id_sector."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

	}
?>

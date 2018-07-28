<?php

	class ModeloParroquia{
		private $id_parroquia;
		private $nombre_parroquia;
		private $id_municipio;

		function incluir($nombre_parroquia, $id_municipio){
			
			$this->nombre_parroquia = $nombre_parroquia;
			$this->id_municipio = $id_municipio;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO parroquia (id_municipio, nombre_parroquia) VALUES ('".$this->id_municipio."', '".$this->nombre_parroquia."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_parroquia, $nombre_parroquia, $id_municipio){

			$this->id_parroquia = $id_parroquia;
			$this->nombre_parroquia = $nombre_parroquia;
			$this->id_municipio = $id_municipio;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE parroquia SET id_municipio = '".$this->id_municipio."', nombre_parroquia = '".$this->nombre_parroquia."' WHERE id_parroquia = '".$this->id_parroquia."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_parroquia){

			$this->id_parroquia = $id_parroquia;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM parroquia WHERE id_parroquia = '".$this->id_parroquia."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function realizarConsultaAvanzada($nombre_parroquia, $id_municipio){

			$this->nombre_parroquia = $nombre_parroquia;
			$this->id_municipio = $id_municipio;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->id_municipio != NULL){
				$buscar .= "parroquia.id_municipio = '".$this->id_municipio."' AND";
			}

			$sql = "SELECT id_parroquia, nombre_parroquia, nombre_municipio, id_municipio, nombre_estado, id_estado FROM parroquia JOIN municipio USING(id_municipio) JOIN estado USING(id_estado) WHERE ".$buscar." nombre_parroquia LIKE '%".$this->nombre_parroquia."%' ORDER BY nombre_estado, nombre_municipio, nombre_parroquia;";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarParaModificar($id_parroquia){

			$this->id_parroquia = $id_parroquia;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_parroquia, id_municipio FROM parroquia WHERE id_parroquia = '".$this->id_parroquia."';";

			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila;

			$conexion_bd->cerrar_conexion();
		}

		function consultarSiExiste($nombre_parroquia, $id_municipio){

			$this->nombre_parroquia = $nombre_parroquia;
			$this->id_municipio = $id_municipio;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_parroquia FROM parroquia WHERE id_municipio = '".$this->id_municipio."' AND nombre_parroquia = '".$this->nombre_parroquia."';";

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

		function verificarParroquia($id_parroquia, $nombre_parroquia, $id_municipio){

			$this->id_parroquia = $id_parroquia;
			$this->nombre_parroquia = $nombre_parroquia;
			$this->id_municipio = $id_municipio;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->id_parroquia != NULL){
				$buscar .= "AND id_parroquia <> '".$this->id_parroquia."' ";
			}

			$sql = "SELECT nombre_parroquia FROM parroquia WHERE id_municipio = '".$this->id_municipio."' AND nombre_parroquia = '".$this->nombre_parroquia."' ".$buscar.";";

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


		function consultarUso($id_parroquia){

			$this->id_parroquia = $id_parroquia;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_parroquia FROM parroquia JOIN sector USING(id_parroquia) WHERE id_parroquia = '".$this->id_parroquia."';";

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

		function consultarUnoPorId($id_parroquia){

			$this->id_parroquia = $id_parroquia;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_parroquia, nombre_parroquia, id_municipio, nombre_municipio, id_estado, nombre_estado FROM parroquia JOIN municipio USING(id_municipio) JOIN estado USING(id_estado) WHERE id_parroquia = '".$this->id_parroquia."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarParroquia($id_municipio){

			$this->id_municipio = $id_municipio;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_parroquia, nombre_parroquia FROM parroquia WHERE id_municipio = '".$this->id_municipio."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

	}
?>

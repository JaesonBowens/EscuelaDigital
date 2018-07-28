<?php
	class ModeloMunicipio{
		private $id_municipio;
		private $nombre_municipio;
		private $id_estado;

		function incluir($nombre_municipio, $id_estado){

			$this->nombre_municipio = $nombre_municipio;
			$this->id_estado = $id_estado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO municipio (id_estado, nombre_municipio) VALUES ('".$this->id_estado."', '".$this->nombre_municipio."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_municipio, $nombre_municipio, $id_estado){

			$this->id_municipio = $id_municipio;
			$this->nombre_municipio = $nombre_municipio;
			$this->id_estado = $id_estado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE municipio SET id_estado = '".$this->id_estado."', nombre_municipio = '".$this->nombre_municipio."' WHERE id_municipio = '".$this->id_municipio."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_municipio){

			$this->id_municipio = $id_municipio;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM municipio WHERE id_municipio = '".$this->id_municipio."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function realizarConsultaAvanzada($nombre_municipio, $id_estado){

			$this->nombre_municipio = $nombre_municipio;
			$this->id_estado = $id_estado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->id_estado != NULL){
				$buscar .= "municipio.id_estado = '".$this->id_estado."' AND";
			}

			$sql = "SELECT id_municipio, nombre_municipio, nombre_estado, id_estado FROM municipio JOIN estado USING(id_estado) WHERE ".$buscar." nombre_municipio LIKE '%".$this->nombre_municipio."%' ORDER BY nombre_estado, nombre_municipio;";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarParaModificar($id_municipio){
			
			$this->id_municipio = $id_municipio;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_municipio, id_estado FROM municipio WHERE id_municipio = '".$this->id_municipio."';";

			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila;

			$conexion_bd->cerrar_conexion();
		}

		function consultarSiExiste($nombre_municipio, $id_estado){
			
			$this->nombre_municipio = $nombre_municipio;
			$this->id_estado = $id_estado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_municipio FROM municipio WHERE id_estado = '".$this->id_estado."' AND nombre_municipio = '".$this->nombre_municipio."';";

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

		function verificarMunicipio($id_municipio, $nombre_municipio, $id_estado){

			$this->id_municipio = $id_municipio;
			$this->nombre_municipio = $nombre_municipio;
			$this->id_estado = $id_estado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->id_municipio != NULL){
				$buscar .= "AND id_municipio <> '".$this->id_municipio."' ";
			}

			$sql = "SELECT nombre_municipio FROM municipio WHERE id_estado = '".$this->id_estado."' AND nombre_municipio = '".$this->nombre_municipio."' ".$buscar.";";

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


		function consultarUso($id_municipio){

			$this->id_municipio = $id_municipio;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_municipio FROM municipio JOIN parroquia USING(id_municipio) WHERE id_municipio = '".$this->id_municipio."';";

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

		function consultarUnoPorId($id_municipio){

			$this->id_municipio = $id_municipio;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_municipio, nombre_municipio, id_estado, nombre_estado FROM municipio JOIN estado USING(id_estado) WHERE id_municipio = '".$this->id_municipio."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarMunicipio($id_estado){

			$this->id_estado = $id_estado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_municipio, nombre_municipio FROM municipio WHERE id_estado = '".$this->id_estado."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

	}
?>

<?php
	include("conexion_bd.php");

	class ModeloEstado{
		private $id_estado;
		private $nombre_estado;

		function incluir($nombre_estado){

			$this->nombre_estado = $nombre_estado;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO estado (nombre_estado) VALUES ('".$this->nombre_estado."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_estado, $nombre_estado){

			$this->id_estado = $id_estado;
			$this->nombre_estado = $nombre_estado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE estado SET nombre_estado = '".$this->nombre_estado."' WHERE id_estado = '".$this->id_estado."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_estado){

			$this->id_estado = $id_estado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM estado WHERE id_estado = '".$this->id_estado."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function realizarConsultaAvanzada($nombre_estado){

			$this->nombre_estado = $nombre_estado;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_estado, nombre_estado FROM estado WHERE nombre_estado LIKE '%".$this->nombre_estado."%' ORDER BY nombre_estado;";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarParaModificar($id_estado){

			$this->id_estado = $id_estado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_estado FROM estado WHERE id_estado = '".$this->id_estado."';";

			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila["nombre_estado"];

			$conexion_bd->cerrar_conexion();
		}

		function consultarSiExiste($nombre_estado){

			$this->nombre_estado = $nombre_estado;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_estado FROM estado WHERE nombre_estado = '".$this->nombre_estado."';";

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

		function verificarEstado($id_estado, $nombre_estado){

			$this->id_estado = $id_estado;
			$this->nombre_estado = $nombre_estado;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->id_estado != NULL){
				$buscar .= "AND id_estado <> '".$this->id_estado."' ";
			}

			$sql = "SELECT nombre_estado FROM estado WHERE nombre_estado = '".$this->nombre_estado."' ".$buscar.";";

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


		function consultarUso($id_estado){

			$this->id_estado = $id_estado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_estado FROM estado JOIN municipio USING(id_estado) WHERE id_estado = '".$this->id_estado."';";

			$resul = mysql_query($sql);

			$numFila = mysql_num_rows($resul);

			return $numFila;

			$conexion_bd->cerrar_conexion();
		}

		function consultarEstado(){

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_estado, nombre_estado FROM estado;";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}
	}
?>

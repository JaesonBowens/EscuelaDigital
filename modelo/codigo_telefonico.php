<?php
	include("conexion_bd.php");

	class ModeloCodigoTelefonico{
		private $id_codigo_tele;
		private $opcion_codigo;

		function incluir($opcion_codigo){

			$this->opcion_codigo = $opcion_codigo;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "INSERT INTO codigo_tele (opcion_codigo) VALUES ('".$this->opcion_codigo."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_codigo_tele, $opcion_codigo){

			$this->id_codigo_tele = $id_codigo_tele;
			$this->opcion_codigo = $opcion_codigo;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE codigo_tele SET opcion_codigo = '".$this->opcion_codigo."' WHERE id_codigo_tele = '".$this->id_codigo_tele."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_codigo_tele){

			$this->id_codigo_tele = $id_codigo_tele;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM codigo_tele WHERE id_codigo_tele = '".$this->id_codigo_tele."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function realizarConsultaAvanzada($opcion_codigo){

			$this->opcion_codigo = $opcion_codigo;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_codigo_tele, opcion_codigo FROM codigo_tele WHERE opcion_codigo LIKE '%".$this->opcion_codigo."%';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarParaModificar($id_codigo_tele){

			$this->id_codigo_tele = $id_codigo_tele;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT opcion_codigo FROM codigo_tele WHERE id_codigo_tele = '".$this->id_codigo_tele."';";

			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila["opcion_codigo"];

			$conexion_bd->cerrar_conexion();
		}

		function consultarSiExiste($opcion_codigo){

			$this->opcion_codigo = $opcion_codigo;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT opcion_codigo FROM codigo_tele WHERE opcion_codigo = '".$this->opcion_codigo."';";

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

		function verificarCodigoTelefonico($id_codigo_tele, $opcion_codigo){

			$this->id_codigo_tele = $id_codigo_tele;
			$this->opcion_codigo = $opcion_codigo;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->id_codigo_tele != NULL){
				$buscar .= "AND id_codigo_tele <> '".$this->id_codigo_tele."' ";
			}

			$sql = "SELECT opcion_codigo FROM codigo_tele WHERE opcion_codigo = '".$this->opcion_codigo."' ".$buscar.";";

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


		function consultarUso($id_codigo_tele){

			$this->id_codigo_tele = $id_codigo_tele;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_codigo_tele FROM codigo_tele JOIN telefono USING(id_codigo_tele) WHERE id_codigo_tele = '".$this->id_codigo_tele."';";

			$resul = mysql_query($sql);

			$numFila = mysql_num_rows($resul);

			return $numFila;

			$conexion_bd->cerrar_conexion();
		}
	}
?>

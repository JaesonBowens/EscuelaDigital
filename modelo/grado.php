<?php
	include("conexion_bd.php");

	class ModeloGrado{
		private $id_grado;
		private $nivel;
		private $nivel_numero;

		function incluir($nivel, $nivel_numero){

			$this->nivel = $nivel;
			$this->nivel_numero = $nivel_numero;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO grado (nivel, nivel_numero) VALUES ('".$this->nivel."', '".$this->nivel_numero."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_grado, $nivel, $nivel_numero){

			$this->id_grado     = $id_grado;
			$this->nivel        = $nivel;
			$this->nivel_numero = $nivel_numero;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE grado SET nivel = '".$this->nivel."', nivel_numero = '".$this->nivel_numero."' WHERE id_grado = '".$this->id_grado."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_grado){

			$this->id_grado = $id_grado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "DELETE FROM grado WHERE id_grado = '".$this->id_grado."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function realizarConsultaAvanzada($nivel){

			$this->nivel = $nivel;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT id_grado, nivel, nivel_numero FROM grado WHERE nivel LIKE '%".$this->nivel."%' ORDER BY nivel_numero;";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarParaModificar($id_grado){

			$this->id_grado = $id_grado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nivel, nivel_numero FROM grado WHERE id_grado = '".$this->id_grado."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarSiExiste($nivel, $nivel_numero){

			$this->nivel        = $nivel;
			$this->nivel_numero = $nivel_numero;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nivel FROM grado WHERE nivel = '".$this->nivel."' OR nivel_numero = '".$this->nivel_numero."';";

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

		function consultarSiExisteM($id_grado, $nivel, $nivel_numero){
			$this->id_grado     = $id_grado;
			$this->nivel        = $nivel;
			$this->nivel_numero = $nivel_numero;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nivel FROM grado WHERE id_grado != '".$this->id_grado."' AND (nivel = '".$this->nivel."' OR nivel_numero = '".$this->nivel_numero."') ;";

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

		function consultarSiExisteNivel($nivel, $nivel_numero){
			$this->nivel = $nivel;
			$this->nivel_numero = $nivel_numero;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nivel FROM grado WHERE nivel = '".$this->nivel."' AND nivel_numero != '".$this->nivel_numero."';";

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

		function consultarSiExisteNivelNumero($nivel, $nivel_numero){
			$this->nivel = $nivel;
			$this->nivel_numero = $nivel_numero;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nivel FROM grado WHERE nivel_numero = '".$this->nivel_numero."' AND nivel != '".$this->nivel."';";

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

		function verificarGrado($id_grado, $nivel, $nivel_numero){

			$this->id_grado	    = $id_grado;
			$this->nivel        = $nivel;
			$this->nivel_numero = $nivel_numero;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";
		
			if($this->nivel_numero != NULL){
				$buscar .= " AND nivel_numero = '".$this->nivel_numero."' ";
			}

			if($this->id_grado != NULL){
				$buscar .= " AND id_grado <> '".$this->id_grado."' ";
			}

			$sql = "SELECT * FROM grado WHERE nivel = '".$this->nivel."'".$buscar.";";

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

		function consultarUso($id_grado){

			$this->id_grado = $id_grado;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_grado FROM grado JOIN seccion USING(id_grado) WHERE id_grado = '".$this->id_grado."';";

			$resul = mysql_query($sql);

			$numFila = mysql_num_rows($resul);

			return $numFila;

			$conexion_bd->cerrar_conexion();
		}

		
		function consultarGrado(){

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_grado, nivel FROM grado;";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		// function consultarNivelNumero($id_grado){
		// 	$this->id_grado = $id_grado;

		// 	$conexion_bd = new conexionBD;
		// 	$conexion_bd->conexion();

		// 	$sql = "SELECT nivel_numero FROM grado WHERE id_grado = '".$this->id_grado."';";

		// 	$resul = mysql_query($sql);

		// 	if($resul){
		// 		$numFila = mysql_num_rows($resul);

		// 		if($numFila){
		// 			return $resul;
		// 		}
		// 		else{
		// 			return false;
		// 		}
		// 	}
		// 	else{
		// 		return false;
		// 	}

		// 	$conexion_bd->cerrar_conexion();
		// }

		// function consultarSiguienteGrado($nivel_numero){
		// 	$this->nivel_numero = $nivel_numero;

		// 	$conexion_bd = new conexionBD;
		// 	$conexion_bd->conexion();

		// 	$sql = "SELECT id_grado, nivel FROM grado WHERE nivel_numero = '".$this->nivel_numero."';";

		// 	$resul = mysql_query($sql);

		// 	if($resul){
		// 		$numFila = mysql_num_rows($resul);

		// 		if($numFila){
		// 			return $resul;
		// 		}
		// 		else{
		// 			return false;
		// 		}
		// 	}
		// 	else{
		// 		return false;
		// 	}

		// 	$conexion_bd->cerrar_conexion();
		// }
	}
?>

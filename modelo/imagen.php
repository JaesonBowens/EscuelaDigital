<?php
	include("conexion_bd.php");

	class ModeloImagen{
		private $id_imagen;
		private $direccion_imagen;
		private $lenguaje_sena;
		private $direccion_audio;
		private $palabra;
		private $numero;
		private $hora;
		private $id_actividad;

		function incluir($direccion_imagen, $lenguaje_sena, $direccion_audio, $palabra, $numero, $hora){
			$this->direccion_imagen = $direccion_imagen;
			$this->lenguaje_sena = $lenguaje_sena;
			$this->direccion_audio = $direccion_audio;
			$this->palabra = $palabra;
			$this->numero = $numero;
			$this->hora = $hora;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO imagen (direccion_imagen, lenguaje_sena, direccion_audio, palabra, numero, hora) VALUES ('".$this->direccion_imagen."', '".$this->lenguaje_sena."', '".$this->direccion_audio."', '".$this->palabra."', '".$this->numero."', '".$this->hora."');";
			
			$resul = mysql_query($sql);
			$id = mysql_insert_id();

			$conexion_bd->cerrar_conexion();
			return $id;
		}

		function modificar($id_imagen, $direccion_imagen, $lenguaje_sena, $direccion_audio, $palabra, $numero, $hora){
			$this->id_imagen = $id_imagen;
			$this->direccion_imagen = $direccion_imagen;
			$this->lenguaje_sena = $lenguaje_sena;
			$this->direccion_audio = $direccion_audio;
			$this->palabra = $palabra;
			$this->numero = $numero;
			$this->hora = $hora;
			
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE imagen SET direccion_imagen = '".$this->direccion_imagen."', lenguaje_sena = '".$this->lenguaje_sena."', direccion_audio = '".$this->direccion_audio."', palabra = '".$this->palabra."', numero = '".$this->numero."', hora = '".$this->hora."' WHERE id_imagen = '".$this->id_imagen."';";
			
			$resul = mysql_query($sql);
			
			$conexion_bd->cerrar_conexion();
			return $resul;
		}

		function eliminar($id_imagen){
			$this->id_imagen=$id_imagen;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			$sql = "DELETE FROM imagen WHERE id_imagen = '".$this->id_imagen."';";

			$resul = mysql_query($sql);

			$conexion_bd->cerrar_conexion();
			return $resul;
		}

		function realizarConsultaAvanzada($palabra, $numero, $hora){
			$this->palabra = $palabra;
			$this->numero = $numero;
			$this->hora = $hora;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($palabra != NULL || $numero != NULL || $hora != NULL){
				$buscar .= " WHERE ";
			}

			if($palabra != NULL){
				$buscar .= "palabra LIKE '".$this->palabra."%'";
			}

			if($palabra != NULL && $numero != NULL){
				$buscar .= " AND ";
			}

			if($numero != NULL){
				$buscar .= "numero LIKE '%".$this->numero."%'";
			}

			if($numero != NULL && $hora != NULL){
				$buscar .= " AND ";
			}else if($palabra != NULL && $hora != NULL){
				$buscar .= " AND ";
			}

			if($hora != NULL){
				$buscar .= "hora LIKE '%".$this->hora."%'";
			}


			$sql = "SELECT DISTINCT(id_imagen), direccion_imagen, palabra, numero, hora FROM imagen JOIN actividad_imagen USING(id_imagen)".$buscar.";";
			
			$resul = mysql_query($sql);

			$conexion_bd->cerrar_conexion();
			return $resul;
		}

		function consultarUnoPorId($id_imagen){
			$this->id_imagen = $id_imagen;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_imagen, direccion_imagen, lenguaje_sena, direccion_audio, palabra, numero, hora FROM imagen WHERE id_imagen = '".$this->id_imagen."';";
			
			$resul = mysql_query($sql);
			
			$conexion_bd->cerrar_conexion();
			return $resul;
		}

		function consultar($palabra){

			$this->respuesta = $palabra;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_imagen, direccion_imagen, lenguaje_sena, direccion_audio, palabra FROM imagen WHERE palabra = '".$this->palabra."';";
			
			$resul = mysql_query($sql);

			$conexion_bd->cerrar_conexion();
			return $resul;
		}

		function consultarParaModificar($id_imagen){
			$this->id_imagen=$id_imagen;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_imagen FROM imagen WHERE id_imagen = '".$this->id_imagen."';";

			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			$conexion_bd->cerrar_conexion();
			return $fila["palabra"];
		}

		function consultarUso($id_imagen){

			$this->id_imagen = $id_imagen;
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM imagen JOIN par_imagen USING(id_imagen) WHERE id_imagen = '".$this->id_imagen."';";

			$resul = mysql_query($sql);

			if($resul){

				$numFila = mysql_num_rows($resul);

				return true;
			}else{

				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function consultarActividad(){
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_actividad, nombre FROM actividad ORDER BY id_actividad;";

			$resul = mysql_query($sql);		

			$conexion_bd->cerrar_conexion();
			return $resul;
		}

		function consultarImagen($id_imagen){

			$this->id_imagen = $id_imagen;
			
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM imagen WHERE id_imagen = '".$this->id_imagen."';";

			$resul = mysql_query($sql);
			$fila = mysql_fetch_array($resul);

			$conexion_bd->cerrar_conexion();
			return $fila;
		}

		function consultarUltimoId(){
			
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql_contador = "SELECT COUNT(*) AS contador FROM imagen;";

			$resul_contador = mysql_query($sql_contador);
			$fila_contador = mysql_fetch_array($resul_contador);

			if($fila_contador["contador"] == 0){
				return $fila_contador["contador"];
			}else if($fila_contador["contador"] != 0){

				$sql = "SELECT MAX(id_imagen) AS ultimo_id FROM imagen;";

				$resul = mysql_query($sql);
				$fila = mysql_fetch_array($resul);

				$conexion_bd->cerrar_conexion();
				return $fila["ultimo_id"];
			}
		}

		function consultarAvanzadaParImagen($numero_uno, $numero_dos){
			
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($numero_uno != NULL || $numero_dos != NULL){
				$buscar .= " WHERE ";
			}

			if($numero_uno != NULL){
				$buscar .= "numero LIKE '".$numero_uno."%'";
			}

			if($numero_uno != NULL && $numero_dos != NULL){
				$buscar .= " OR ";
			}

			if($numero_dos != NULL){
				$buscar .= "numero LIKE '%".$numero_dos."%'";
			}

			$sql = "SELECT * FROM par JOIN par_imagen USING(id_par) JOIN imagen USING(id_imagen)".$buscar.";";


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

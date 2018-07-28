<?php
	include("conexion_bd.php");

	class ModeloContenido{
		private $id_contenido;
		private $nombre_contenido;

		function incluir($nombre_contenido){

			$this->nombre_contenido = $nombre_contenido;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO contenido (nombre_contenido) VALUES ('".$this->nombre_contenido."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_contenido, $nombre_contenido){

			$this->id_contenido = $id_contenido;
			$this->nombre_contenido = $nombre_contenido;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE contenido SET nombre_contenido = '".$this->nombre_contenido."' WHERE id_contenido = '".$this->id_contenido."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_contenido){

			$this->id_contenido = $id_contenido;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "DELETE FROM contenido WHERE id_contenido = '".$this->id_contenido."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function realizarConsultaAvanzada($nombre_contenido){

			$this->nombre_contenido = $nombre_contenido;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT id_contenido, nombre_contenido FROM contenido WHERE nombre_contenido LIKE '%".$this->nombre_contenido."%' ORDER BY nombre_contenido;";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarParaModificar($id_contenido){

			$this->id_contenido = $id_contenido;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_contenido FROM contenido WHERE id_contenido = '".$this->id_contenido."';";

			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila["nombre_contenido"];

			$conexion_bd->cerrar_conexion();
		}

		function consultarSiExiste($nombre_contenido){

			$this->nombre_contenido = $nombre_contenido;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_contenido FROM contenido WHERE nombre_contenido = '".$this->nombre_contenido."';";

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

		function consultarNuevoContenido($nombre_contenido){

			$this->nombre_contenido = $nombre_contenido;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_contenido, nombre_contenido FROM contenido WHERE nombre_contenido = '".$this->nombre_contenido."';";

			$resul = mysql_query($sql);

			if($resul){
				$numFila = $resul;
			}
			else{
				$numFila = false;
			}

			return $numFila;

			$conexion_bd->cerrar_conexion();
		}

		function verificarContenido($id_contenido, $nombre_contenido){

			$this->id_contenido = $id_contenido;
			$this->nombre_contenido = $nombre_contenido;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->id_contenido != NULL){
				$buscar .= "AND id_contenido <> '".$this->id_contenido."' ";
			}

			$sql = "SELECT nombre_contenido FROM contenido WHERE nombre_contenido = '".$this->nombre_contenido."' ".$buscar.";";

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


		function consultarUso($id_contenido){

			$this->id_contenido = $id_contenido;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_contenido FROM contenido JOIN contenido_imagen USING(id_contenido) WHERE id_contenido = '".$this->id_contenido."';";

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
				$numFila = false;
			}

			return $numFila;

			$conexion_bd->cerrar_conexion();
		}

		
		function consultarContenido(){

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_contenido, nombre_contenido FROM contenido;";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}
	}
?>

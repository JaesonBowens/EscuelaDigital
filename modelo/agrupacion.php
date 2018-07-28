<?php

	class ModeloAgrupacion{
		private $id_agrupacion;
		private $nombre_agrupacion;

		function incluir($nombre_agrupacion){

			$this->nombre_agrupacion = $nombre_agrupacion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO agrupacion (nombre_agrupacion) VALUES ('".$this->nombre_agrupacion."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_agrupacion, $nombre_agrupacion){

			$this->id_agrupacion = $id_agrupacion;
			$this->nombre_agrupacion = $nombre_agrupacion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE agrupacion SET nombre_agrupacion = '".$this->nombre_agrupacion."' WHERE id_agrupacion = '".$this->id_agrupacion."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_agrupacion){

			$this->id_agrupacion = $id_agrupacion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "DELETE FROM agrupacion WHERE id_agrupacion = '".$this->id_agrupacion."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function realizarConsultaAvanzada($nombre_agrupacion){

			$this->nombre_agrupacion = $nombre_agrupacion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT id_agrupacion, nombre_agrupacion FROM agrupacion WHERE nombre_agrupacion LIKE '%".$this->nombre_agrupacion."%' ORDER BY nombre_agrupacion;";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarParaModificar($id_agrupacion){

			$this->id_agrupacion = $id_agrupacion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_agrupacion FROM agrupacion WHERE id_agrupacion = '".$this->id_agrupacion."';";

			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila["nombre_agrupacion"];

			$conexion_bd->cerrar_conexion();
		}

		function consultarSiExiste($nombre_agrupacion){

			$this->nombre_agrupacion = $nombre_agrupacion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT nombre_agrupacion FROM agrupacion WHERE nombre_agrupacion = '".$this->nombre_agrupacion."';";

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

		function consultarNuevoAgrupacion($nombre_agrupacion){

			$this->nombre_agrupacion = $nombre_agrupacion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_agrupacion, nombre_agrupacion FROM agrupacion WHERE nombre_agrupacion = '".$this->nombre_agrupacion."';";

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

		function verificarAgrupacion($id_agrupacion, $nombre_agrupacion){

			$this->id_agrupacion = $id_agrupacion;
			$this->nombre_agrupacion = $nombre_agrupacion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->id_agrupacion != NULL){
				$buscar .= "AND id_agrupacion <> '".$this->id_agrupacion."' ";
			}

			$sql = "SELECT nombre_agrupacion FROM agrupacion WHERE nombre_agrupacion = '".$this->nombre_agrupacion."' ".$buscar.";";

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


		function consultarUso($id_agrupacion){

			$this->id_agrupacion = $id_agrupacion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_agrupacion FROM agrupacion JOIN agrupacion_imagen USING(id_agrupacion) WHERE id_agrupacion = '".$this->id_agrupacion."';";

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

		
		function consultarAgrupacion(){

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_agrupacion, nombre_agrupacion FROM agrupacion;";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarAleatoria(){

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql_next = "AND ("; 

			for( $i = 0; $i < count($_SESSION["id_contenido"]); $i++ ){
				$sql_next .= "cont_img.id_contenido = '".$_SESSION["id_contenido"][$i]."'";

				$j = $i;
				$j++;

				if( $j < count($_SESSION["id_contenido"]) ){
					$sql_next .= " OR ";
				}

			}

			$sql_next .= ")";
			
			$sql = "SELECT * FROM agrupacion AS agr JOIN agrupacion_imagen AS agr_img USING(id_agrupacion) JOIN contenido_imagen AS cont_img USING(id_imagen) JOIN seccion_imagen AS sec_img USING(id_imagen) WHERE sec_img.id_seccion = '".$_SESSION["id_seccion"]."' ".$sql_next." ORDER BY RAND();";

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

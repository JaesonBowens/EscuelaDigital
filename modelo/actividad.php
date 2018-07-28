<?php

	class ModeloActividad{
		private $id_actividad;
		private $nombre_actividad;
		private $id_area;

		function consultarActividad($id_actividad){
			$this->id_actividad = $id_actividad;
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql_next = "AND ("; 

			for( $i = 0; $i < count($_SESSION["id_contenido"]); $i++ ){
				$sql_next .= "c_i.id_contenido = '".$_SESSION["id_contenido"][$i]."'";

				$j = $i;
				$j++;

				if( $j < count($_SESSION["id_contenido"]) ){
					$sql_next .= " OR ";
				}

			}

			$sql_next .= ")";
			
			$sql = "SELECT act_img.id_imagen AS id_img FROM actividad JOIN actividad_imagen AS act_img USING(id_actividad) JOIN imagen USING(id_imagen) JOIN contenido_imagen AS c_i USING(id_imagen) WHERE id_actividad = '".$this->id_actividad."' ".$sql_next." ORDER BY RAND();";
			
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

		function conseguirIdActividad($nombre_actividad){
			$this->nombre_actividad = $nombre_actividad;
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT id_actividad FROM actividad WHERE nombre_actividad = '".$this->nombre_actividad."' ;";

			$resul = mysql_query($sql);

			if($resul){
				$numFila = mysql_num_rows($resul);
		
				$fila = mysql_fetch_array($resul);

				if($numFila){
					return $fila["id_actividad"];
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

		function consultarActividadPorNombre($nombre_actividad){

			$this->nombre_actividad = $nombre_actividad;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql_next = "AND ("; 

			for( $i = 0; $i < count($_SESSION["id_contenido"]); $i++ ){
				$sql_next .= "c_i.id_contenido = '".$_SESSION["id_contenido"][$i]."'";

				$j = $i;
				$j++;

				if( $j < count($_SESSION["id_contenido"]) ){
					$sql_next .= " OR ";
				}

			}

			$sql_next .= ")";
			
			$sql = "SELECT DISTINCT(act_img.id_imagen) AS id_img FROM actividad_imagen AS act_img JOIN actividad AS act USING(id_actividad) JOIN imagen USING(id_imagen) JOIN contenido_imagen AS c_i USING(id_imagen) JOIN seccion_imagen AS sec_img USING(id_imagen) WHERE act.nombre_actividad = '".$this->nombre_actividad."' AND sec_img.id_seccion = '".$_SESSION["id_seccion"]."' ".$sql_next." ORDER BY RAND();";
			
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


		function consultarActividadVarias($id_actividad, $num){
			$this->id_actividad = $id_actividad;
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT * FROM actividad JOIN actividad_imagen USING(id_actividad) JOIN imagen USING(id_imagen) WHERE id_actividad = '".$this->id_actividad."' ORDER BY RAND() LIMIT 0,".$num." ;";

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

		function consultarSoloVocal($id_actividad){
			$this->id_actividad = $id_actividad;
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT * FROM actividad JOIN actividad_imagen USING(id_actividad) JOIN imagen AS img USING(id_imagen) WHERE id_actividad = '".$this->id_actividad."' AND img.palabra LIKE 'A%' OR img.palabra LIKE 'E%' OR img.palabra LIKE 'O%' OR img.palabra LIKE 'U%' OR img.palabra LIKE 'I%' ORDER BY RAND();";

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

		function consultarSoloConsonante($id_actividad){
			$this->id_actividad = $id_actividad;
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT * FROM actividad JOIN actividad_imagen USING(id_actividad) JOIN imagen AS img USING(id_imagen) WHERE id_actividad = '".$this->id_actividad."' AND img.palabra NOT LIKE 'A%' AND img.palabra NOT LIKE 'E%' AND img.palabra NOT LIKE 'O%' AND img.palabra NOT LIKE 'U%' AND img.palabra NOT LIKE 'I%' ORDER BY RAND();";

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

		function consultarVariasImagenes($nombre_actividad){
			$this->nombre_actividad = $nombre_actividad;
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql_next = "AND ("; 

			for( $i = 0; $i < count($_SESSION["id_contenido"]); $i++ ){
				$sql_next .= "c_i.id_contenido = '".$_SESSION["id_contenido"][$i]."'";

				$j = $i;
				$j++;

				if( $j < count($_SESSION["id_contenido"]) ){
					$sql_next .= " OR ";
				}

			}

			$sql_next .= ")";
			
			$sql = "SELECT DISTINCT(act_img.id_imagen) AS id_img FROM actividad_imagen AS act_img JOIN actividad AS act USING(id_actividad) JOIN imagen AS img USING(id_imagen) JOIN contenido_imagen AS c_i USING(id_imagen) JOIN seccion_imagen AS sec_img USING(id_imagen) WHERE nombre_actividad = '".$this->nombre_actividad."'  AND sec_img.id_seccion = '".$_SESSION["id_seccion"]."' ".$sql_next." ORDER BY RAND();";

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

		function consultarTodo(){
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();
			
			$sql = "SELECT id_actividad, nombre_actividad FROM actividad;";

			$resul = mysql_query($sql);
			
			$conexion_bd->cerrar_conexion();

			return $resul;
		}

		function consultarParaMenu($nombre_actividad, $id_contenido){

			$this->nombre_actividad = $nombre_actividad;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql_next = "AND ("; 

			for( $i = 0; $i < count($id_contenido); $i++ ){
				$sql_next .= "c_i.id_contenido = '".$id_contenido[$i]."'";

				$j = $i;
				$j++;

				if( $j < count($id_contenido) ){
					$sql_next .= " OR ";
				}

			}

			$sql_next .= ")";
			
			$sql = "SELECT DISTINCT(act_img.id_imagen) AS id_img FROM actividad_imagen AS act_img JOIN actividad AS act USING(id_actividad) JOIN imagen USING(id_imagen) JOIN contenido_imagen AS c_i USING(id_imagen) JOIN seccion_imagen AS sec_img USING(id_imagen) WHERE act.nombre_actividad = '".$this->nombre_actividad."'  AND sec_img.id_seccion = '".$_SESSION["id_seccion"]."' ".$sql_next." ORDER BY RAND();";

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



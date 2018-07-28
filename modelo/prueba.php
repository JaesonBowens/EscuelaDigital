 <?php

	class ModeloPrueba{
		private $id_prueba;
		private $fecha_prueba;
		private $iteracion;
		private $id_actividad;
		private $id_estudiante_seccion;

		function incluir($fecha_prueba, $iteracion, $id_actividad, $id_estudiante_seccion){

			$this->fecha_prueba = $fecha_prueba;
			$this->iteracion = $iteracion + 1;
			$this->id_actividad = $id_actividad;
			$this->id_estudiante_seccion = $id_estudiante_seccion;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO prueba (fecha_prueba, iteracion, id_actividad, id_estudiante_seccion) VALUES ('".$this->fecha_prueba."', '".$this->iteracion."', '".$this->id_actividad."', '".$this->id_estudiante_seccion."');";
			
			$resul = mysql_query($sql);

			return mysql_insert_id();

			$conexion_bd->cerrar_conexion();
		}

		function consultar($iteracion, $id_estudiante_seccion, $id_actividad){

			$this->iteracion = $iteracion;
			$this->id_estudiante_seccion = $id_estudiante_seccion;
			$this->id_actividad = $id_actividad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_prueba FROM prueba WHERE iteracion = '".$this->iteracion."' AND id_estudiante_seccion = '".$this->id_estudiante_seccion."' AND id_actividad = '".$this->id_actividad."';";
			
			$resul = mysql_query($sql);

			if($resul){
				$numFila = mysql_num_rows($resul);

				if($numFila){
					$fila = mysql_fetch_array($resul);

					return $fila["id_prueba"];
				}
			}
			else{
				return false;
			}
			$conexion_bd->cerrar_conexion();
		}

		function contar($id_estudiante_seccion, $id_actividad){

			$this->id_estudiante_seccion = $id_estudiante_seccion;
			$this->id_actividad = $id_actividad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT COUNT(*) AS iter FROM prueba WHERE id_estudiante_seccion = '".$this->id_estudiante_seccion."' AND id_actividad = '".$this->id_actividad."';";
			
			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila["iter"];

			$conexion_bd->cerrar_conexion();
		}

		function seleccionarMax($id_estudiante_seccion, $id_actividad){

			$this->id_estudiante_seccion = $id_estudiante_seccion;
			$this->id_actividad = $id_actividad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT MAX(iteracion) FROM prueba WHERE id_estudiante_seccion = '".$this->id_estudiante_seccion."' AND id_actividad = '".$this->id_actividad."';";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarPorDesempenoImagen($id_estudiante_seccion, $fecha_prueba, $id_actividad){

			$this->id_estudiante_seccion = $id_estudiante_seccion;
			$this->fecha_prueba = $fecha_prueba;
			$this->id_actividad = $id_actividad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql1 = " ";

			if($this->fecha_prueba != null){
				$sql1 .= "p.fecha_prueba = '".$fecha_prueba."' AND";
			}

			if($_SESSION["id_area"] != null){
				$sql1 .= "a.id_area = '".$_SESSION["id_area"]."' AND ";
			}

			if($this->id_actividad != null){
				$sql1 .= "p.id_actividad = '".$id_actividad."' AND";
			}

			$sql = "SELECT p.id_prueba, p.iteracion, p.fecha_prueba, act.id_actividad, act.nombre_actividad, ej.id_ejercicio, ej.intento_sin_exito, ej.tiempo_llevado, img.direccion_imagen, img.palabra, img.numero, img.hora, a.id_area, a.nombre_area, ano_esc.id_ano_escolar, ano_esc.denominacion, sec.id_seccion, sec.grupo, gdo.id_grado, gdo.nivel FROM prueba AS p JOIN actividad AS act USING (id_actividad) JOIN ejercicio AS ej USING (id_prueba) JOIN ejercicio_imagen USING (id_ejercicio) JOIN imagen AS img USING (id_imagen) JOIN area AS a USING (id_area) JOIN estudiante_seccion AS est_sec USING (id_estudiante_seccion) JOIN estudiante AS est USING (id_estudiante) JOIN ano_escolar AS ano_esc USING (id_ano_escolar) JOIN seccion AS sec USING (id_seccion) JOIN grado AS gdo USING (id_grado) WHERE ".$sql1." p.id_estudiante_seccion = '".$this->id_estudiante_seccion."' ORDER BY p.id_actividad, p.iteracion, ej.id_ejercicio;";
			
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

		function consultarPorDesempenoLetra($id_estudiante_seccion, $fecha_prueba, $id_actividad){

			$this->id_estudiante_seccion = $id_estudiante_seccion;
			$this->fecha_prueba = $fecha_prueba;
			$this->id_actividad = $id_actividad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql1 = " ";

			if($this->fecha_prueba != null){
				$sql1 .= "p.fecha_prueba = '".$fecha_prueba."' AND ";
			}

			if($_SESSION["id_area"] != null){
				$sql1 .= "a.id_area = '".$_SESSION["id_area"]."' AND ";
			}

			if($this->id_actividad != null){
				$sql1 .= "p.id_actividad = '".$id_actividad."' AND";
			}

			$sql = "SELECT p.id_prueba, p.iteracion, p.fecha_prueba, act.id_actividad, act.nombre_actividad, ej.intento_sin_exito, ej.tiempo_llevado, let.id_letra, let.caracter, a.id_area, a.nombre_area, ano_esc.id_ano_escolar, ano_esc.denominacion, sec.id_seccion, sec.grupo, gdo.id_grado, gdo.nivel FROM prueba AS p JOIN actividad AS act USING (id_actividad) JOIN ejercicio AS ej USING (id_prueba) JOIN ejercicio_letra USING (id_ejercicio) JOIN letra AS let USING (id_letra) JOIN area AS a USING (id_area) JOIN estudiante_seccion AS est_sec USING (id_estudiante_seccion) JOIN estudiante AS est USING (id_estudiante) JOIN ano_escolar AS ano_esc USING (id_ano_escolar) JOIN seccion AS sec USING (id_seccion) JOIN grado AS gdo USING (id_grado) WHERE ".$sql1." p.id_estudiante_seccion = '".$this->id_estudiante_seccion."' ORDER BY  p.id_actividad, p.iteracion, ej.id_ejercicio;";
			
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

		function consultarPorDesempenoSecuencia($id_estudiante_seccion, $fecha_prueba, $id_actividad){

			$this->id_estudiante_seccion = $id_estudiante_seccion;
			$this->fecha_prueba = $fecha_prueba;
			$this->id_actividad = $id_actividad;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql1 = " ";

			if($this->fecha_prueba != null){
				$sql1 .= "p.fecha_prueba = '".$fecha_prueba."' AND ";
			}

			if($_SESSION["id_area"] != null){
				$sql1 .= "a.id_area = '".$_SESSION["id_area"]."' AND ";
			}

			if($this->id_actividad != null){
				$sql1 .= "p.id_actividad = '".$this->id_actividad."' AND";
			}

			$sql = "SELECT p.id_prueba, p.iteracion, p.fecha_prueba, act.id_actividad, act.nombre_actividad, ej.intento_sin_exito, ej.tiempo_llevado, secuen.id_secuencia, secuen.ordenamiento, a.id_area, a.nombre_area, ano_esc.id_ano_escolar, ano_esc.denominacion, sec.id_seccion, sec.grupo, gdo.id_grado, gdo.nivel FROM prueba AS p JOIN actividad AS act USING (id_actividad) JOIN ejercicio AS ej USING (id_prueba) JOIN ejercicio_secuencia USING (id_ejercicio) JOIN secuencia AS secuen USING (id_secuencia) JOIN area AS a USING (id_area) JOIN estudiante_seccion AS est_sec USING (id_estudiante_seccion) JOIN estudiante AS est USING (id_estudiante) JOIN ano_escolar AS ano_esc USING (id_ano_escolar) JOIN seccion AS sec USING (id_seccion) JOIN grado AS gdo USING (id_grado) WHERE ".$sql1." p.id_estudiante_seccion = '".$this->id_estudiante_seccion."' ORDER BY  p.id_actividad, p.iteracion, ej.id_ejercicio;";
			
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

		

		function contarPruebas($fecha_prueba){

			$this->fecha_prueba = $fecha_prueba;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT COUNT(*) AS iter FROM prueba WHERE fecha_prueba = '".$this->fecha_prueba."';";
			
			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila["iter"];

			$conexion_bd->cerrar_conexion();
		}

		function consultarPorFechaPrueba($fecha_prueba){

			$this->fecha_prueba = $fecha_prueba;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();


			$sql = "SELECT act.id_actividad, act.nombre_actividad AS nombre_act, COUNT( * ) AS contador FROM actividad AS act
JOIN prueba AS pba USING ( id_actividad ) WHERE pba.fecha_prueba = '".$this->fecha_prueba."' GROUP BY act.nombre_actividad;";
			
			$resul = mysql_query($sql);

			//$fila = mysql_fetch_array($resul);

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

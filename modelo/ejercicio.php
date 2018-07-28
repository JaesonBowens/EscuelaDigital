<?php

	class ModeloEjercicio{
		private $id_ejercicio;
		private $intento_sin_exito;
		private $tiempo_llevado;
		private $id_prueba;
		

		function incluir($intento_sin_exito, $tiempo_llevado, $id_prueba){
			$this->intento_sin_exito = $intento_sin_exito;
			$this->tiempo_llevado = $tiempo_llevado;
			$this->id_prueba = $id_prueba;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO ejercicio (intento_sin_exito, tiempo_llevado, id_prueba) VALUES ('".$this->intento_sin_exito."', '".$this->tiempo_llevado."', '".$this->id_prueba."');";
			
			$resul = mysql_query($sql);

			return mysql_insert_id();

			$conexion_bd->cerrar_conexion();
		}

		function contar($id_prueba){

			$this->id_prueba = $id_prueba;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT COUNT(*) AS contado FROM ejercicio WHERE id_prueba = '".$this->id_prueba."';";
			
			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila["contado"];

			$conexion_bd->cerrar_conexion();
		}

	}
?>

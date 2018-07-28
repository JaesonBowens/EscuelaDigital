<?php

	class ModeloEjercicioLetra{
		private $id_ejercicio_letra;
		private $id_ejercicio;
		private $id_letra;
		
		function incluir($id_ejercicio, $id_letra){
			$this->id_ejercicio = $id_ejercicio;
			$this->id_letra = $id_letra;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO ejercicio_letra (id_ejercicio, id_letra) VALUES ('".$this->id_ejercicio."', '".$this->id_letra."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarLetra($id_ejercicio){

			$this->id_ejercicio = $id_ejercicio;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT caracter FROM letra JOIN ejercicio_letra USING (id_letra) WHERE id_ejercicio = '".$this->id_ejercicio."';";

			$resul = mysql_query($sql);

			$fila = mysql_fetch_array($resul);

			return $fila["caracter"];

			$conexion_bd->cerrar_conexion();
		}

	}
?>

<?php

	class ModeloEjercicioSecuencia{
		private $id_ejercicio_secuencia;
		private $id_ejercicio;
		private $id_secuencia;
		
		function incluir($id_ejercicio, $id_secuencia){
			$this->id_ejercicio = $id_ejercicio;
			$this->id_secuencia = $id_secuencia;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO ejercicio_secuencia (id_ejercicio, id_secuencia) VALUES ('".$this->id_ejercicio."', '".$this->id_secuencia."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

	}
?>

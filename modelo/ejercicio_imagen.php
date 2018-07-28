<?php

	class ModeloEjercicioImagen{
		private $id_ejercicio_imagen;
		private $id_ejercicio;
		private $id_imagen;
		
		function incluir($id_ejercicio, $id_imagen){
			$this->id_ejercicio = $id_ejercicio;
			$this->id_imagen = $id_imagen;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO ejercicio_imagen (id_ejercicio, id_imagen) VALUES ('".$this->id_ejercicio."', '".$this->id_imagen."');";
			
			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

		function consultarImagen($id_ejercicio){

			$this->id_ejercicio = $id_ejercicio;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT * FROM imagen JOIN ejercicio_imagen USING (id_imagen) WHERE id_ejercicio = '".$this->id_ejercicio."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();
		}

	}
?>

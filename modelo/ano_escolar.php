<?php

	class ModeloAnoEscolar{
		private $id_ano_escolar;
		private $fecha_inicio;
		private $fecha_fin;
		private $denominacion;
		private $estatus;

		function incluirAnoEscolar($fecha_inicio, $fecha_fin, $denominacion, $estatus){

			$this->fecha_inicio=$fecha_inicio;
			$this->fecha_fin=$fecha_fin;
			$this->denominacion=$denominacion;
			$this->estatus=$estatus;

			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "INSERT INTO ano_escolar (fecha_inicio, fecha_fin, denominacion, estatus) VALUES ('".$this->fecha_inicio."', '".$this->fecha_fin."', '".$this->denominacion."', '".$this->estatus."');";

			$resul = mysql_query($sql);

			return $resul;
		
			$conexion_bd->cerrar_conexion();
		}

		function consultarPorId($id_ano_escolar){

			$this->id_ano_escolar = $id_ano_escolar;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_ano_escolar, fecha_inicio, fecha_fin, denominacion, estatus FROM ano_escolar WHERE id_ano_escolar = '".$this->id_ano_escolar."';";
			
			$resul = mysql_query($sql);

			return $resul;
			
			$conexion_bd->cerrar_conexion();
			
		}

		function modificarAnoEscolar($id_ano_escolar, $fecha_inicio, $fecha_fin, $denominacion){
			$this->id_ano_escolar = $id_ano_escolar;
			$this->fecha_inicio = $fecha_inicio;
			$this->fecha_fin = $fecha_fin;
			$this->denominacion = $denominacion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE ano_escolar SET fecha_inicio = '".$this->fecha_inicio."', fecha_fin = '".$this->fecha_fin."', denominacion = '".$this->denominacion."' WHERE id_ano_escolar = '".$this->id_ano_escolar."';";
		
			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function desactivarAnoEscolar($id_ano_escolar){
			$this->id_ano_escolar = $id_ano_escolar;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE ano_escolar SET estatus = 'I' WHERE id_ano_escolar = '".$this->id_ano_escolar."';";
		
			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function eliminarAnoEscolar($id_ano_escolar){

			$this->id_ano_escolar = $id_ano_escolar;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM ano_escolar WHERE id_ano_escolar = '".$this->id_ano_escolar."';";

			$resul = mysql_query($sql);

			return $resul;

			$conexion_bd->cerrar_conexion();

		}

		function consultarActivo(){
			
			$conexion = new conexionBD;
			$conexion->conexion();

			$sql = "SELECT * FROM ano_escolar WHERE estatus = 'A';";

			$resul = mysql_query($sql);

			if($resul){
				return $resul;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function verificarUso($id_ano_escolar){

			$this->id_ano_escolar = $id_ano_escolar;
	
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_ano_escolar FROM ano_escolar JOIN alumno_seccion USING(id_ano_escolar) JOIN docente_seccion USING(id_ano_escolar) WHERE id_ano_escolar = '".$this->id_ano_escolar."';";

			$resul = mysql_query($sql);

			$numFila = mysql_num_rows($resul);

			return $numFila;

			$conexion_bd->cerrar_conexion();
		}

		function consultarAvanzada($denominacion){
			$this->denominacion = $denominacion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_ano_escolar, estatus, denominacion, fecha_inicio, fecha_fin FROM ano_escolar WHERE denominacion LIKE '%".$this->denominacion."%';";
			
			$resul = mysql_query($sql);

			$conexion_bd->cerrar_conexion();
			return $resul;
		}
	}
?>

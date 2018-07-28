<?php

	class ModeloBitacora{
		private $id_bitacora;
		private $tabla_bitacora;
		private $operacion_bitacora;
		private $fecha_bitacora;
		private $hora_bitacora;
		private $detalle_bitacora;
		private $id_usuario;

		function registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario){
			$this->tabla_bitacora = $tabla_bitacora;
			$this->operacion_bitacora = $operacion_bitacora;
			$this->fecha_bitacora = $fecha_bitacora;
			$this->hora_bitacora = $hora_bitacora;
			$this->detalle_bitacora = $detalle_bitacora;
			$this->id_usuario = $id_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO bitacora (tabla_bitacora, operacion_bitacora, fecha_bitacora, hora_bitacora, detalle_bitacora, id_usuario) VALUES ('".$this->tabla_bitacora."', '".$this->operacion_bitacora."', '".$this->fecha_bitacora."', '".$this->hora_bitacora."', '".$this->detalle_bitacora."', '".$this->id_usuario."');";
			
			$resul = mysql_query($sql);

			if($resul){
				return $resul;
			}
			else{
				return false;
			}
			
			$conexion_bd->cerrar_conexion();
		}
		
		function realizarConsultaAvanzada($tabla_bitacora, $operacion_bitacora, $fecha_bitacora){

			$this->tabla_bitacora = $tabla_bitacora;
			$this->operacion_bitacora = $operacion_bitacora;
			$this->fecha_bitacora = $fecha_bitacora;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->tabla_bitacora != NULL){
				$buscar .= "tabla_bitacora = '".$this->tabla_bitacora."' AND ";
			}

			if($this->operacion_bitacora != NULL){
				$buscar .= "operacion_bitacora = '".$this->operacion_bitacora."' AND ";
			}

			if($this->fecha_bitacora != NULL){
				$buscar .= "fecha_bitacora = '".$this->fecha_bitacora."' AND ";
			}

			$sql = "SELECT bita.tabla_bitacora, bita.operacion_bitacora, bita.fecha_bitacora, bita.hora_bitacora, bita.detalle_bitacora, us.nombre_usuario AS nombre_usuario FROM bitacora AS bita, usuario AS us WHERE ".$buscar."us.id_usuario = bita.id_usuario; ";
			
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

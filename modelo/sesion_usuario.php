<?php

	class ModeloSesionUsuario{
		private $id_sesion_usuario;
		private $hora_inicio;
		private $hora_fin;
		private $fecha_sesion;
		private $id_usuario;

		function iniciarSesion($hora_inicio, $fecha_sesion, $id_usuario){
			$this->hora_inicio = $hora_inicio;
			$this->fecha_sesion = $fecha_sesion;
			$this->id_usuario = $id_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO sesion_usuario (hora_inicio, fecha_sesion, id_usuario) VALUES ('".$this->hora_inicio."', '".$this->fecha_sesion."', '".$this->id_usuario."');";
			
			$resul = mysql_query($sql);

			if($resul){
				return $id_sesion_usuario = mysql_insert_id();
			}
			else{
				return false;
			}
			
			$conexion_bd->cerrar_conexion();
		}

		function cerrarSesion($hora_fin, $id_sesion_usuario){

			$this->hora_fin = $hora_fin;
			$this->id_sesion_usuario = $id_sesion_usuario;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE sesion_usuario SET hora_fin = '".$this->hora_fin."' WHERE id_sesion_usuario = '".$this->id_sesion_usuario."';";
		
			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		
		function realizarConsultaAvanzada($fecha_sesion){

			$this->fecha_sesion = $fecha_sesion;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$buscar = " ";

			if($this->fecha_sesion != NULL){
				$buscar .= "log.fecha_sesion = '".$this->fecha_sesion."' AND ";
			}

			$sql = "SELECT log.hora_inicio, log.hora_fin, log.fecha_sesion, us.nombre_usuario AS nombre_usuario FROM sesion_usuario AS log, usuario AS us WHERE ".$buscar."us.id_usuario = log.id_usuario ORDER BY log.fecha_sesion, hora_inicio DESC";

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

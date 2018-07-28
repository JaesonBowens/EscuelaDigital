<?php
	class ModeloTelefono{
		private $id_telefono;
		private $numero;
		private $id_codigo_tele;
		
		function incluir($numero, $id_codigo_tele){
			
			$this->numero = $numero;
			$this->id_codigo_tele = $id_codigo_tele;
			
			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "INSERT INTO telefono (numero, id_codigo_tele) VALUES ('".$this->numero."', '".$this->id_codigo_tele."');";
					
			$resul = mysql_query($sql);

			if($resul){
				return mysql_insert_id();
			}
			else{
				return false;
			}
			
			$conexion_bd->cerrar_conexion();
		}

		function modificar($id_telefono, $numero, $id_codigo_tele){

			$this->id_telefono = $id_telefono;
			$this->numero = $numero;
			$this->id_codigo_tele = $id_codigo_tele;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "UPDATE telefono SET numero = '".$this->numero."', id_codigo_tele = '".$this->id_codigo_tele."' WHERE id_telefono = '".$this->id_telefono."';";
		
			$resul = mysql_query($sql);

			if($resul){
				return true;
			}
			else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function consultar($numero, $id_codigo_tele){

			$this->numero = $numero;
			$this->id_codigo_tele = $id_codigo_tele;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "SELECT id_telefono FROM telefono WHERE id_codigo_tele = '".$this->id_codigo_tele."' AND numero = '".$this->numero."' ;";
			
			$resul = mysql_query($sql);

			if($resul){
				
				$fila = mysql_fetch_array($resul);

				return $fila["id_telefono"];
				
			}else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}

		function eliminar($id_telefono){

			$this->id_telefono = $id_telefono;

			$conexion_bd = new conexionBD;
			$conexion_bd->conexion();

			$sql = "DELETE FROM telefono WHERE id_telefono = '".$this->id_telefono."' ;";
			
			$resul = mysql_query($sql);

			if($resul){

				return true;
				
			}else{
				return false;
			}

			$conexion_bd->cerrar_conexion();
		}
	}

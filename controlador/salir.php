<?php
	session_start();

	include("../modelo/conexion_bd.php");

	include("../modelo/sesion_usuario.php");
	
	$modeloSesionUsuario = new ModeloSesionUsuario;
	
	date_default_timezone_set('America/Caracas');
	
	$hora_fin = date("H:i:s"); 
	$id_sesion_usuario = $_SESSION["id_sesion_usuario"];
	$modeloSesionUsuario -> cerrarSesion($hora_fin, $id_sesion_usuario);

	session_destroy();

	header("location:../index.php");
?>

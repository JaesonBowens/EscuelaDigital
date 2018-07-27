<?php
	session_start();

	include("../modelo/sesion_usuario.php");
	include("../modelo/usuario.php");
	include("../modelo/docente.php");
	include("../modelo/docente_seccion.php");
	include("../modelo/estudiante_seccion.php");
	include("../modelo/ano_escolar.php");
	include("seguridad_sql.php");

	$modelo = new ModeloUsuario;
	$modeloSesionUsuario = new ModeloSesionUsuario;
	$modeloAnoEscolar = new ModeloAnoEscolar;
	$modeloDocente = new ModeloDocente;
	$modeloDocenteSeccion = new ModeloDocenteSeccion;
	$modeloEstudianteSeccion = new ModeloEstudianteSeccion;

	if(isset($_POST["entrar"])){

		$nombre_usuario = mb_strtoupper(antiInjectionSql($_POST["nombre_usuario"]), "utf-8");
		$clave_usuario   = antiInjectionSql($_POST["clave_usuario"]);
		$asig_pc        = antiInjectionSql($_POST["asig_pc"]);

		$resul = $modelo -> verificarUsuario($nombre_usuario, $clave_usuario);

		if($resul){

			date_default_timezone_set('America/Caracas');
			$fecha       = date("Y-m-d");

			$resul_dos = $modeloAnoEscolar -> consultarActivo();

			if($resul_dos){
				$fila_dos = mysql_fetch_array($resul_dos);

				if($fila_dos["fecha_fin"] < $fecha){
					$id_ano_escolar = $fila_dos["id_ano_escolar"];
					$modeloAnoEscolar -> desactivarAnoEscolar($id_ano_escolar);
					//$modeloEstudianteSeccion -> inactivarTodoPorAnoEscolar($id_ano_escolar);
				}				
			}

			while($fila = mysql_fetch_array($resul)){
				$id_usuario   = $fila["id_usuario"];
				$tipo_usuario = $fila["descripcion_tipo_usuario"];
				$array[]      = $fila["id_funcion_usuario"];
			}

			$_SESSION["ses_id_usuario"] = $id_usuario;

			if($asig_pc == "NO"){
				$_SESSION["tipo_usuario"]       = $tipo_usuario;
				$_SESSION["id_funcion_usuario"] = $array;

				$_SESSION["tiempo"] = time();
				$_SESSION["funcion_usuario"] = $resul;
				$_SESSION['autenticado']     = 'YES';

				$hora_inicio = date("H:i:s"); 
				$fecha_sesion = $fecha;

				$id_sesion_usuario = $modeloSesionUsuario -> iniciarSesion($hora_inicio, $fecha_sesion, $id_usuario);

				if($id_sesion_usuario){
					$_SESSION["id_sesion_usuario"] = $id_sesion_usuario;
				}
				
				$_SESSION['ses_nombre_usuario'] = $nombre_usuario;
				echo "<meta http-equiv='refresh' content='0; url=../vista/menu_principal.php'/>";
			}
			else{
				$resulDocente = $modeloDocente -> consultarPorIdUsuario($id_usuario);

				while($filaDocente = mysql_fetch_array($resulDocente)){
					$id_docente   = $filaDocente["id_docente"];
				}

				$resul = $modeloDocenteSeccion -> consultarGrupo($id_docente);

				if($resul){
					while($fila = mysql_fetch_array($resul)){
						$_SESSION["nivel"]    = $fila["nivel"];
						$_SESSION["id_seccion"]    = $fila["id_seccion"];
						$_SESSION["grupo"]    = $fila["grupo"];
						$_SESSION["nombre_d"] = $fila["nombre_d"]." ".$fila["apellido_d"];

						$id_estudiante_est[] = $fila["id_estudiante_est"];
						$nombre_est[]    = $fila["nombre_est"]." ".$fila["apellido_est"];
					}

					$_SESSION["id_estudiante"] = $id_estudiante_est;
					$_SESSION["nombre_est"]  = $nombre_est;

					$_SESSION['autenticado']     = 'YES';

					echo "<meta http-equiv='refresh' content='0; url=../vista/asignacion_pc.php'/>";
				}
				else{
					$_SESSION["mensaje"] = "There´s no assigned section";

					echo "<meta http-equiv='refresh' content='0; url=../index.php'/>";
				}
			}			
		}
		else{
			$_SESSION["mensaje"] = "The user name or password is incorrect";

			echo "<meta http-equiv='refresh' content='0; url=../index.php'/>";
		}
	}
?>

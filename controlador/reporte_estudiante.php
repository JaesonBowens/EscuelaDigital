<?php
	session_start();

	include("../modelo/conexion_bd.php");
	include("../modelo/estudiante_seccion.php");
	include("../reporte/reporte_estudiante.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");
	

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		$modeloEstudianteSeccion = new ModeloEstudianteSeccion;
		$reporte = new ReporteEstudiante;

		if(isset($_REQUEST["id_ano_escolar"])){
			$id_ano_escolar = antiInjectionSql($_REQUEST["id_ano_escolar"]);
			$ano_escolar    = antiInjectionSql($_REQUEST["ano_escolar"]);

			$resul = $modeloEstudianteSeccion -> consultarIdAnoEscolar($id_ano_escolar);

			if($resul){
				$reporte -> reporte($resul, $ano_escolar);
			}
			else{
				echo "<script>alert('Students not found')</script>";
			}
		}
	}
?>

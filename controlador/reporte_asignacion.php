<?php
	session_start();

	include("../modelo/conexion_bd.php");
	include("../modelo/estudiante_seccion.php");
	include("../reporte/reporte_asignacion.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		$modeloEstudianteSeccion = new ModeloEstudianteSeccion;
		$reporte = new ReporteAsignacion;

		if(isset($_REQUEST["id_ano_escolar"])){
			$id_ano_escolar = antiInjectionSql($_REQUEST["id_ano_escolar"]);
			$ano_escolar    = antiInjectionSql($_REQUEST["ano_escolar"]);
			$id_grado       = antiInjectionSql($_REQUEST["id_grado"]);
			$id_seccion     = antiInjectionSql($_REQUEST["id_seccion"]);

			$resul = $modeloEstudianteSeccion -> consultarSeccion($id_ano_escolar, $id_grado, $id_seccion);

			if($resul){
				$reporte -> reporte($resul, $ano_escolar);
			}
			else{
				echo "<script>alert('The assignment can not be found ')</script>";
			}
		}
	}
?>

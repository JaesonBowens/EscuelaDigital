<?php
	session_start();

	include("../modelo/estudiante.php");
	include("../modelo/actividad.php");
	include("../modelo/ejercicio.php");
	include("../modelo/prueba.php");
	include("../modelo/estudiante_seccion.php");
	include("../reporte/reporte_desempeno_estudiantil.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	$modeloEstudiante = new ModeloEstudiante;
	$modeloActividad = new ModeloActividad;
	$modeloEjercicio = new ModeloEjercicio;
	$modeloPrueba = new ModeloPrueba;
	$modeloEstudianteSeccion = new ModeloEstudianteSeccion;
	$reporte = new ReporteDesempenoEstudiantil;

	if(isset($_REQUEST["id_est_rep"])){
		$id_estudiante = $_GET["id_est_rep"];
		$id_ano_escolar = $_GET["id_ano_escolar_rep"];
		$id_seccion = $_GET["id_seccion_rep"];
		
		if($_GET["fecha_consultar"] != "00/00/00"){
				$fecha = $_GET["fecha_consultar"];
				list($dia, $mes, $ano) = explode("/", $fecha);
				$fecha_prueba = $ano."-".$mes."-".$dia;
		}else{
				$fecha_prueba = null;
		}

		if($_GET["id_area_rep"] != " "){
				$_SESSION["id_area"] = $_GET["id_area_rep"];
		}else{
				$_SESSION["id_area"] = null;
		}

		if($_GET["id_actividad_rep"] != " "){
				$id_actividad = $_GET["id_actividad_rep"];
		}else{
				$id_actividad = null;
		}

		$resulA = $modeloEstudiante -> consultarPorId($id_estudiante);

		if($resulA){
			$fila = mysql_fetch_array($resulA);

			$id_estudiante       = $fila["id_estudiante"];
			$nombre_apellido = $fila["nombre"]." ".$fila["apellido"];

			$resulB = $modeloEstudianteSeccion -> consultarEstudiantePorSeccion($id_estudiante, $id_seccion, $id_ano_escolar);

			if($resulB){
				$filaB = mysql_fetch_array($resulB);

				$id_estudiante_seccion = $filaB["id_estudiante_seccion"];
				
				$resulC = $modeloPrueba -> consultarPorDesempenoImagen($id_estudiante_seccion, $fecha_prueba, $id_actividad);

				$resulD = $modeloPrueba -> consultarPorDesempenoLetra($id_estudiante_seccion, $fecha_prueba, $id_actividad);
				
				$resulE = $modeloPrueba -> consultarPorDesempenoSecuencia($id_estudiante_seccion, $fecha_prueba, $id_actividad);

				if($resulC || $resulD || $resulE){
					$reporte -> reporte($resulC, $resulD, $resulE, $cedula_escolar, $nombre_apellido);
				}else{
					echo "<script>alert('The student´s performance can not be found')</script>";
				}	
			}else{
				echo "<script>alert('Student is not inscribe in said school year')</script>";
			}	
		}

	}else if(isset($_GET["consultaAvanzada"])){
		$id_seccion = $_GET["consultaAvanzada"];
		$id_ano_escolar     = $_GET["ano_escolar"];
		$id_grado       = $_GET["grado"];

		$resul = $modeloEstudianteSeccion -> consultarSeccion($id_ano_escolar, $id_grado, $id_seccion);

		if($resul){
			while($fila = mysql_fetch_array($resul)){
				echo "<tr id='".$fila["id_estudiante"]."' class='id-est' title='Haz Double Click on the student whoose performance report you wish to generate' ondblclick='seleccionFilaCat(this)' />
						<td width='400px'><input type='hidden' name='nombre' value='".$fila["nombre_est"]."' />".$fila["nombre_est"]."</td>
						<td width='200px'><input type='hidden' name='apellido' value='".$fila["apellido_est"]."' />".$fila["apellido_est"]."</td>
						<td width='200px'><input type='hidden' name='sexo' value='".$fila["sexo_est"]."' />".$fila["sexo_est"]."</td>
					</tr>
				";
			}
		}
	}
?>

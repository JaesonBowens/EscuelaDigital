<?php
	include("reporte_cabecera_pie.php");

	class ReporteAsignacion{

		function reporte($resul, $ano_escolar){
			$pdf = new PDF('P', 'mm', 'letter');

			$pdf->AddPage();
			$pdf->AliasNbPages();
			$pdf->SetFont("Arial", "BU", 14);

			$titulo = "hola";
			$pdf->SetTitle($titulo);

			$pdf->Cell(200,10,utf8_decode('List of Assignment'),0,1,'C');

			$pdf->Ln(10);

			$pdf->SetFont("Arial", "B", 12);

			$pdf->Cell(30,10,utf8_decode('School Year:'), 0, 0, 'C');
			$pdf->SetFont("Arial", "I", 12);
			$pdf->Cell(50, 10, $ano_escolar, 0, 1, 'L');

			$grado   = "";
			$seccion = "";
			$contadorFila = 0;
			while($fila = mysql_fetch_array($resul)){
				$id_grado     = $fila["id_grado"];
				$nivel        = $fila["nivel"];
				$id_seccion   = $fila["id_seccion"];
				$grupo        = $fila["grupo"];
				$nombre_d     = $fila["nombre_d"]." ".$fila["apellido_d"];

				if($id_seccion != $seccion){
					$seccion = $id_seccion;

					$pdf->Ln(6);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(30, 10, utf8_decode('Grade'), 1, 0, 'C', true);

					$pdf->SetFont("Arial", "I", 12);
					$pdf->SetFillColor( 233, 235, 237 );
					$pdf->Cell(45, 10, utf8_decode($nivel), 1, 0, 'C', true);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(30, 10, utf8_decode('Section'), 1, 0, 'C', true);

					$pdf->SetFont("Arial", "I", 12);
					$pdf->SetFillColor( 233, 235, 237 );
					$pdf->Cell(15, 10, utf8_decode($grupo), 1, 1, 'C', true);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(30, 10, utf8_decode('Teacher'), 1, 0, 'C', true);

					$pdf->SetFont("Arial", "I", 12);
					$pdf->SetFillColor( 233, 235, 237 );
					$pdf->Cell(90, 10, utf8_decode($nombre_d), 1, 1, 'C', true);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(90, 10, utf8_decode('Name & Surname'), 1, 0, 'C', true);
					$pdf->Cell(15, 10, utf8_decode('Sex'), 1, 0, 'C', true);
					$pdf->Cell(60, 10, utf8_decode('Discapacity'), 1, 1, 'C', true);
				}

				$pdf->SetFont("Arial", "", 12);
				$nombre       = $fila["nombre_est"]." ".$fila["apellido_est"];
				$sexo         = $fila["sexo_est"];
				$discapacidad = $fila["nombre_discapacidad"];

				$contadorFila++;	

				if($contadorFila & 1){
					$pdf->Cell(90, 10, utf8_decode($nombre), 1, 0, 'C');
					$pdf->Cell(15, 10, utf8_decode($sexo), 1, 0, 'C');
					$pdf->Cell(60, 10, utf8_decode($discapacidad), 1, 1, 'C');
				}else{
					$pdf->SetFillColor( 233, 235, 237 );

					$pdf->Cell(90, 10, utf8_decode($nombre), 1, 0, 'C', true);
					//$pdf->Cell(15, 10, utf8_decode($edad), 1, 0, 'C', true);
					$pdf->Cell(15, 10, utf8_decode($sexo), 1, 0, 'C', true);
					$pdf->Cell(60, 10, utf8_decode($discapacidad), 1, 1, 'C', true);
				}
			}

			$pdf->Output('List of Assignment.pdf','i');
		}
	}
?>

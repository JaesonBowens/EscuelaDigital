<?php
	include("reporte_cabecera_pie.php");

	class ReporteEstudiante{

		function reporte($resul, $ano_escolar){

			$pdf = new PDF('P', 'mm', 'letter');

			$pdf->AddPage();
			$pdf->AliasNbPages();
			$pdf->SetFont("Arial", "BU", 14);

			$titulo = "hola";
			$pdf->SetTitle($titulo);

			$pdf->Cell(200,10,'List of Students', 0,1,'C');

			$pdf->Ln(10);

			$pdf->SetFont("Arial", "B", 12);

			$pdf->Cell(30,10,utf8_decode('School Year:'), 0, 0, 'C');

			$pdf->SetFont("Arial", "I", 12);
			$pdf->Cell(50, 10, $ano_escolar, 0, 1, 'L');

			$pdf->Ln(5);

			$pdf->SetFont("Arial", "B", 12);
			$pdf->SetFillColor( 111, 187, 245 );

			$pdf->Cell(120, 10, utf8_decode('Nombre y Apellido'), 1, 0, 'C', true);
			$pdf->Cell(15, 10, utf8_decode('Sexo'), 1, 0, 'C', true);
			$pdf->Cell(60, 10, utf8_decode('Discapacidad'), 1, 1, 'C', true);

			$pdf->SetFont("Arial", "", 12);

			$contadorFila = 0;

			while($fila = mysql_fetch_array($resul)){

				$nombre       = "  ".$fila["nombre"]." ".$fila["apellido"];
				$sexo         = $fila["sexo"];
				$discapacidad = $fila["nombre_discapacidad"];

				$contadorFila++;	

				if($contadorFila & 1){
					$pdf->Cell(120, 10, utf8_decode($nombre), 1, 0, 'L');
					$pdf->Cell(15, 10, utf8_decode($sexo), 1, 0, 'C');
					$pdf->Cell(60, 10, utf8_decode($discapacidad), 1, 1, 'C');
				}else{
					$pdf->SetFillColor( 233, 235, 237 );

					$pdf->Cell(120, 10, utf8_decode($nombre), 1, 0, 'L', true);
					$pdf->Cell(15, 10, utf8_decode($sexo), 1, 0, 'C', true);
					$pdf->Cell(60, 10, utf8_decode($discapacidad), 1, 1, 'C', true);
				}
			}

			$pdf->Output('List of Students.pdf','i');
				
			echo "<script language='javascript'>window.open('List of Students.pdf','','');</script>";//para ver el archivo pdf generado
			echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=../vista/reporte_estudiante.php'>";
			
			}
	}
?>

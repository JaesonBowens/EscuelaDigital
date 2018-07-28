<?php
	include("reporte_cabecera_pie_land_slide.php");

	class ReporteDocente{

		function reporte($resul, $ano_escolar){
			$pdf = new PDF('l', 'mm', 'letter');

			$pdf->AddPage();
			$pdf->AliasNbPages();
			$pdf->SetFont("Arial", "BU", 14);

			$titulo = "hola";
			$pdf->SetTitle($titulo);

			$pdf->Cell(260,10,'List of Teachers', 0,1,'C');

			$pdf->Ln(10);

			$pdf->SetFont("Arial", "B", 12);

			$pdf->Cell(30,10,utf8_decode('School Year:'), 0, 0, 'C');

			$pdf->SetFont("Arial", "I", 12);
			$pdf->Cell(50, 10, $ano_escolar, 0, 1, 'L');

			$pdf->Ln(5);

			$pdf->SetFont("Arial", "B", 12);
			$pdf->SetFillColor( 111, 187, 245 );

			$pdf->Cell(40, 10, utf8_decode('I.D. Number'), 1, 0, 'C', true);
			$pdf->Cell(220, 10, utf8_decode('Name & Surname'), 1, 1, 'C', true);

			$pdf->SetFont("Arial", "", 12);

			$contadorFila = 0;

			while($fila = mysql_fetch_array($resul)){

				$cedula    = $fila["cedula"];
				$nombre    = "  ".$fila["nombre"]." ".$fila["apellido"];

				$contadorFila++;	

				if($contadorFila & 1){
					$pdf->Cell(40, 10, utf8_decode($cedula), 1, 0, 'C');
					$pdf->Cell(220, 10, utf8_decode($nombre), 1, 1, 'L');
				}else{
					$pdf->SetFillColor( 233, 235, 237 );

					$pdf->Cell(40, 10, utf8_decode($cedula), 1, 0, 'C');
					$pdf->Cell(220, 10, utf8_decode($nombre), 1, 1, 'L');
				}
			}

			$pdf->Output('List of Teachers.pdf','i');
				
			echo "<script language='javascript'>window.open('List of Teachers.pdf','','');</script>";//para ver el archivo pdf generado
			echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=../vista/reporte_docente.php'>";
			
			}
	}
?>

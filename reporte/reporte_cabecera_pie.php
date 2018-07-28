<?php

include("../fpdf17/fpdf.php");

class PDF extends FPDF{
// Cabecera de página
	function Header(){
		global $titulo;

		$fecha=date("m/d/o");
		// Logo

		$this->Image('../imagen/logo_pdf.png',10,8,195,15);		
		$this->Ln(15);
		$this->Cell(14);
		$this->SetFont('Arial','',8);

		$this->SetFont('Arial','B',13);
		// Movernos a la derecha

		$this->Ln(10);
		$this->Cell(45);
		$this->Cell(100,10,$titulo,0,1,'C');

		// Salto de línea
	}

	// Pie de página
	function Footer(){
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Número de página
		$this->Cell(0,10,utf8_decode("Page ").$this->PageNo().'/{nb}',0,0,'C');
	}

}

?>

<?php
  
require "lib/fpdf.php";
require "lib/tcpdf/tcpdf.php";

class PdfWriter{
	public function __construct(){
		
	}
	
	public function createPageOLD($contents){
		//print($contents); exit;
		$pdf = new FPDF();
		
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		
		var_dump($contents); exit;
		$pdf->Cell(900,800,$matches);
		
		$pdf->Output();
	}
	
	public function createPage($contents){
		require_once('/var/www/ndev/master/public/lib/tcpdf/examples/example_065.php');	
	}
}
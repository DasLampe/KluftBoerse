<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2011 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
define('FPDF_FONTPATH',PATH_CORE_LIB."fpdf/font/");
include_once(PATH_CORE_LIB."fpdf/fpdf.php");
class pdf extends FPDF
{
	private $invoice_id;
	
	function setInvoiceId($invoice_id)
	{
		$this->invoice_id	= $invoice_id;	
	}
	
	//Better table
	function ImprovedTable($header,$data)
	{
		//Column widths
		$w=array(10,26,110,26,26);
		//Header
		$this->SetFillColor(192,192,192);
		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],0,0,'L',1);
		$this->Ln();
		//Data

		$cost	= 0;
		foreach($data as $row)
		{

		if($this->check_height($this->ln_height($row[2], $w[2])))
		{
			$this->SetFont('Arial', '', 12);
			//Closure line
			$this->SetFillColor(192,192,192);
			$this->Cell((array_sum($w)-$w[4]),6,'Zwischensumme','B',0,'L',1);
			$this->Cell($w[4],6,sprintf("%.2f",$cost).chr(128),'B',0,'R',1);
			$this->Ln();
		}
		$this->SetX(9.7);
		$y = $this->GetY();
		$x = $this->GetX();
		$this->SetFont('Arial', '', 12);

		$this->MultiCell($w[0],6,$row[0],0,'C',0);
		$x+=$w[0];
		$this->SetXY($x,$y);
		$this->MultiCell($w[1],6,$row[1],0);
		$x+=$w[1];
		$this->SetXY($x,$y);
		$this->MultiCell($w[2],5,utf8_decode($row[2]));
		$x+=$w[2];
		$this->SetXY($x,$y);
		$this->MultiCell($w[3],6,$row[3].chr(128),0,'R');
		$x+=$w[3];
		$this->SetXY($x,$y);
		$this->MultiCell($w[4],6,$row[4].chr(128),0,'R');
		$this->Ln($this->ln_height($row[2], $w[2]));
		$cost	+= $row[4];
		}
		
		$this->SetXY(9.7,$this->GetY());
		//Closure line
		$this->SetFillColor(192,192,192);
		$this->Cell((array_sum($w)-$w[4]),6,'Gesamtbetrag','T',0,'L',1);
		$this->Cell($w[4],6,sprintf("%.2f",$cost).chr(128),'T',0,'R',1);
	}
	
	function Header()
	{
		if($this->page != 1)
		{
			$this->SetX(9.7);
			$this->SetFont('Arial','B',20);
			$this->Write(0,'Rechnung - Seite '.$this->PageNo());
			$this->Ln(8);
			$this->SetFont('Arial','',12);
			$this->Write(0,'Rechnungsnummer: '.$this->invoice_id);
		}
		//Logo
		$this->Image(PATH_UPLOAD."logo.jpg", 120,0, 90, 50, 'JPG','http://nixmuss-design.de');
		$this->SetY(50);
	}
	
	function Footer()
	{
		// Über dem unteren Seitenrand positionieren
		$this->SetXY(9.7,-20);
		$this->Cell(0,0,'','T');
		$this->Ln();
		// Schriftart festlegen
		$this->SetFont('Arial','',8);
		// Zentrierte Ausgabe der Seitenzahl
		$this->MultiCell(100,5,utf8_decode("Bankverbindung\nAndré Flemming, Kontonummer 1096965\nBLZ 34250000, Stadtsparkasse Solingen"));
		
		$this->SetXY(-80,-20);
		$this->MultiCell(0,5,utf8_decode("Steuernummer: 129/5032/1929"));
	}
	
	function ln_height($text,$width_cell)
	{
		if(preg_match("!\n!", $text))
		{
			$min	= 5 * substr_count($text, "\n");
			$width	= $this->GetStringWidth($text);
			$height	= round($width / $width_cell);
			$height	= $height + $min + 5;
			
			return $height;
		}
		return $this->FontSize * 0.376;
	}
	
	function check_height($height)
	{
		if($this->GetY()+$height>$this->PageBreakTrigger)
		{
			$this->new_page();			
			return true;
		}
	}
	
	function new_page()
	{
		$this->SetFont('Arial', '', 16);
		// Hinweis auf Folgeseite
		$this->SetXY(9.7, 251);
		$this->SetAutoPageBreak(false);       // Seitenumbruch kurz raus
		$this->MultiCell(0, 0, utf8_decode("Fortsetzung der Rechnung auf der nächsten Seite"), 0, 'C', 0);
		$this->SetAutoPageBreak(true, 50);    // Seitenumbruch wieder rein
		// neue Seite
		$this->AddPage($this->CurOrientation);
		$this->SetX(9.7);
	}
}
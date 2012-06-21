<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2011 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
include_once(PATH_CORE_CLASS."pdf.class.php");
header("Content-type: application/pdf");

$invoice_id = $param[1];
$action		= 'I';
if(isset($param[2]) && $param[2] == "save")
{
	$action = 'D';
}

$client_id	= invoice::get_client($invoice_id);

$client		= clients::get_all_info($client_id);

$pdf=new PDF('P', 'mm', 'Letter');
$pdf->setInvoiceId($invoice_id);
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetMargins(20, 15);
$pdf->SetFont('Arial','U',10);
$pdf->SetAutoPageBreak(true, 30);

//Absender
$pdf->SetXY(20,46);
$pdf->Cell(0, 0, utf8_decode("André Flemming, Benratherstr. 26, 42697 Solingen"));

//Kunden Adresse
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY(20,51);
$pdf->MultiCell(0, 5, utf8_decode($client['address']));

//Kontaktblock
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(117.32,51);
$pdf->MultiCell(0,5, utf8_decode("Kontakt:\nAndre Flemming\nBenrather Straße 26\n42697 Solingen\nHandy: 0176 - 32 19 26 62\nEmail: info@nixmuss-design.de\n"));

$pdf->Ln(5);

$pdf->SetX(117.32);
$pdf->Cell(40,5,"Datum:");
$pdf->Cell(0,5,date("d.m.Y",invoice::get_invoice_date($invoice_id)));

$pdf->Ln();

$pdf->SetX(117.32);
$pdf->Cell(40,5,"Rechnungsnummer:");
$pdf->Cell(0,5,$invoice_id);

$pdf->Ln(8);

//Überschrift
$pdf->SetFont('Arial', 'B', 20);
$pdf->SetX($pdf->lMargin);
$pdf->Write(5, "Rechnung");

$pdf->Ln(8);

//Text
$pdf->SetFont('Arial', '', 11);
$pdf->Write(5, utf8_decode("Sehr geehrte Damen und Herren,\nich bedanke mich für die Inanspruchnahme meiner Leistungen und stelle wie folgt in Rechnung."));

$pdf->Ln(8);

//Tabelle
$header	= array("Pos.", "Anzahl", "Bezeichnung", "Einzelpreis", "Gesamtpreis");
$data	= invoice::get_invoice($invoice_id);
$pdf->ImprovedTable($header, $data);

$pdf->Ln();

$pdf->SetFont('Arial', '', 9);
$pdf->SetX(-96);
$pdf->Write(5, utf8_decode("Umsatzsteuer nicht ausweisbar gemäß § 19 UStG"));

$pdf->SetX($pdf->lMargin);
$pdf->Ln(8);
if($pdf->GetY()+65>$pdf->PageBreakTrigger)
{
	$pdf->new_page();
}
$pdf->SetFont('Arial', '', 12);
$pdf->Write(5,utf8_decode("Bitte begleichen Sie den Rechnungsbetrag innerhalb von 14 Tagen per Überweisung auf folgendes Bankkonto.\n\nKontoinhaber: André Flemming\nKontonummer: 1096965\nBLZ: 34250000\nStadtsparkasse Solingen\nVerwendungszweck: Rechnung ".$invoice_id."\n\n\nVielen Dank im Voraus und freundliche Grüße\nAndré Flemming"));


$pdf->Close();

$pdf->Output('rechnung-'.$invoice_id.'_'.date("d-m-Y",invoice::get_invoice_date($invoice_id)).'.pdf', $action);
?>
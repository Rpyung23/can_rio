<?php

header('Content-Type: text/html; charset=ISO-8859-1');

if(file_exists('fpdf.php'))
{

}else
{
    require('../fpdf.php');
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$pdf->Image("../img/logo.png",10,11,33);
$pdf->SetFont('Arial','B',15);
// Título
$pdf->Cell(190,20,'REPORTE DE ADOPTANTES',1,0,'C');
// Salto de línea
$pdf->Ln(25);

$pdf->Cell(30,10,'Dni',1,0,'C');
$pdf->Cell(50,10,'Nombres',1,0,'C');
$pdf->Cell(30,10,'Dir',1,0,'C');
$pdf->Cell(40,10,utf8_decode('Teléfono'),1,0,'C');
$pdf->Cell(40,10,'Email',1,0,'C');
$pdf->Ln(10);



$json = json_decode(file_get_contents("https://www.vigitrackecuador.com/can_rio/rest/adoptante.php"),true);

$pdf->SetFont('Arial','I',12);

if($json['status_code']==200)
{
    foreach ($json['datos'] as $value)
    {
        $name = utf8_decode($value["names"]. " ".$value["apes"]);

        $pdf->Cell(30,10,$value["dni_adoptante"],1,0,'C');
        $pdf->Cell(50,10,substr($name,0,18),1,0,'C');
        $pdf->Cell(30,10,substr(utf8_decode($value['dir']),0,12),1,0,'C');
        $pdf->Cell(40,10,$value["phone"],1,0,'C');
        $pdf->Cell(40,10,substr($value["email"],0,16),1,0,'C');
        $pdf->Ln(10);
    }
}


$pdf->Output();
?>
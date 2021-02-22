<?php

$fechaI = $_GET["fechaI"];
$fechaF = $_GET["fechaF"];


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
$pdf->Cell(190,20,'REPORTE DE ADOPCIONES',1,0,'C');
// Salto de línea
$pdf->Ln(25);

$pdf->Cell(20,10,'Id',1,0,'C');
$pdf->Cell(50,10,utf8_decode('Fecha Adopción'),1,0,'C');
$pdf->Cell(40,10,'Adoptante',1,0,'C');
$pdf->Cell(40,10,'Id Mascota',1,0,'C');
$pdf->Cell(40,10,'Nombre Mas.',1,0,'C');
$pdf->Ln(10);


$json = json_decode(file_get_contents("https://www.vigitrackecuador.com/can_rio/rest/adopcion_fechas.php?fecha_inicio=".$fechaI."&fecha_fin=".$fechaF),true);


$pdf->SetFont('Arial','I',12);

if($json['status_code']==200)
{
    foreach ($json['datos'] as $value)
    {

        $pdf->Cell(20,10,$value["id_adopcion"],1,0,'C');
        $pdf->Cell(50,10,$value["fecha_adoptacion"],1,0,'C');
        $pdf->Cell(40,10,$value["dni_adoptante"],1,0,'C');
        $pdf->Cell(40,10,$value["id_mascota"],1,0,'C');
        $pdf->Cell(40,10,utf8_decode($value["name_mascota"]),1,0,'C');
        $pdf->Ln(10);
    }
}

$pdf->Output();

?>

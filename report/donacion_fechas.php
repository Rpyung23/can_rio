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
$pdf->Cell(190,20,'REPORTE DE DONACIONES',1,0,'C');
// Salto de línea
$pdf->Ln(25);

$pdf->Cell(50,10,'Donante',1,0,'C');
$pdf->Cell(30,10,'Fecha Do.',1,0,'C');
$pdf->Cell(60,10,'Detalle',1,0,'C');
$pdf->Cell(30,10,'Tipo',1,0,'C');
$pdf->Cell(20,10,'Valor',1,0,'C');
$pdf->Ln(10);


$json = json_decode(file_get_contents("https://www.vigitrackecuador.com/can_rio/rest/donaciones_fechas.php?fecha_inicio=".$fechaI."&fecha_fin=".$fechaF),true);


$pdf->SetFont('Arial','I',12);

if($json['status_code']==200)
{
    foreach ($json['datos'] as $value)
    {

        $pdf->Cell(50,10,substr(utf8_decode($value['name_donante']),0,16),1,0,'C');
        $pdf->Cell(30,10,date_format(date_create($value["fecha_donante"]),"Y/m/d"),1,0,'C');
        $pdf->Cell(60,10,substr(utf8_decode($value['detalleDonacion']),0,20),1,0,'C');
        $pdf->Cell(30,10,substr(utf8_decode($value['detalleTipoDonacion']),0,14),1,0,'C');
        $pdf->Cell(20,10,$value['valor'],1,0,'C');

        $pdf->Ln(10);
    }
}

$pdf->Output();

?>
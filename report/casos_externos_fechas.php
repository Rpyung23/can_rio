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
$pdf->Cell(190,20,'REPORTE DE CASOS EXTERNOS',1,0,'C');
// Salto de línea
$pdf->Ln(25);

$pdf->Cell(30,10,'Fecha C.E',1,0,'C');
$pdf->Cell(30,10,utf8_decode('Direc P.S'),1,0,'C');
$pdf->Cell(75,10,'Detalle',1,0,'C');
$pdf->Cell(30,10,'Dni. V',1,0,'C');
$pdf->Cell(25,10,'E.S',1,0,'C');
$pdf->Ln(10);


$json = json_decode(file_get_contents("https://www.vigitrackecuador.com/can_rio/rest/casos_externos_fechas.php?fecha_ini=".$fechaI."&fecha_fin=".$fechaF),true);


$pdf->SetFont('Arial','I',12);

if($json['status_code']==200)
{
    foreach ($json['datos'] as $value)
    {

        $pdf->Cell(30,10,date_format(date_create($value["fecha_caso"]),"Y/m/d"),1,0,'C');
        $pdf->Cell(30,10,substr(utf8_decode($value["direc_principal"]." ".$value["direc_secundaria"]),0,15),1,0,'C');
        $pdf->Cell(75,10,substr(utf8_decode($value['detalle']),0,35),1,0,'C');
        $pdf->Cell(30,10,$value['fk_id_voluntario'],1,0,'C');
        $pdf->Cell(25,10,substr(utf8_decode($value['detalle_estado_salud']),0,12),1,0,'C');

        $pdf->Ln(10);
    }
}
$pdf->Output();

?>

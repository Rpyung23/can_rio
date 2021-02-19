<?php
if(file_exists('conn/conexion.php'))
{
    require_once('conn/conexion.php');
}else
{
    require_once('../conn/conexion.php');
}

if(file_exists('models/cMascota.php'))
{
    require_once('models/cMascota.php');
}else
{
    require_once('../models/cMascota.php');
}


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
$pdf->Cell(190,20,'REPORTE DE CANINOS',1,0,'C');
// Salto de línea
$pdf->Ln(25);

$pdf->Cell(20,10,'Id',1,0,'C');
$pdf->Cell(50,10,'Nombre',1,0,'C');
$pdf->Cell(40,10,'Fecha',1,0,'C');
$pdf->Cell(40,10,'Estado Salud',1,0,'C');
$pdf->Cell(40,10,'Tipo Raza',1,0,'C');
$pdf->Ln(10);



$json = json_decode(file_get_contents("https://www.vigitrackecuador.com/can_rio/rest/mascota.php/todas"),true);

$pdf->SetFont('Arial','I',12);

if($json['status_code']==200)
{
    foreach ($json['datos'] as $value)
    {

        $pdf->Cell(20,10,$value["idMascota"],1,0,'C');
        $pdf->Cell(50,10,$value["name"],1,0,'C');
        $pdf->Cell(40,10,date_format(date_create($value["fecha_ingreso"]),"Y/m/d"),1,0,'C');
        $pdf->Cell(40,10,$value["detalleEstadoSalud"],1,0,'C');
        $pdf->Cell(40,10,$value["detalleTipoRaza"],1,0,'C');
        $pdf->Ln(10);
    }
}


$pdf->Output();
?>

<?php 
require('../librerias/fpdf/fpdf.php');
include_once '../configuraciones/bd.php';
$conexionBD=BD::crearInstancia();

function agregarTexto($pdf,$texto,$x,$y,$align='L',$fuente,$size=10,$r=0,$g=0,$b=0){
    $pdf->SetFont('Arial',"",$size);
    $pdf->SetXY($x,$y);
    $pdf->SetTextColor($r,$g,$b);
    $pdf->Cell(0,10,$texto,0,0,$align);
    //$pdf->Text($x,$y,$texto);
}

function agregarImagen($pdf,$imagen,$x,$y){
    $pdf->Image($imagen,$x,$y,0);

}

$idcurso=isset($_GET['idcurso'])?$_GET['idcurso']:'';
$idalumno=isset($_GET['idalumno'])?$_GET['idalumno']:'';

$sql="SELECT alumnos.nombre, alumnos.apellidos,cursos.nombre_curso FROM alumnos, cursos WHERE alumnos.id=:idalumno AND cursos.id=:idcurso";

$consulta=$conexionBD->prepare($sql);
$consulta->bindParam(':idalumno', $idalumno);
$consulta->bindParam(':idcurso',$idcurso);
$consulta->execute();
$alumno=$consulta->fetch(PDO::FETCH_ASSOC);


$pdf=new FPDF("L", "mm", array(350,190));
$pdf->AddPage();
$pdf->setFont("Arial","B",16);
agregarImagen($pdf,"../src/certificadof.jpg",0,0);
agregarTexto($pdf,ucwords(utf8_decode($alumno['nombre']."".$alumno['apellidos'])),170,85,'L',"Helvetica",30,0,84,115);
agregarTexto($pdf,$alumno['nombre_curso'],170,130,'L',"Helvetica",25,0,84,115);
agregarTexto($pdf,date("d/m/y"),135,159,'L',"Helvetica",20,0,84,115);
$pdf->Output();






/*$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output()*/



?>
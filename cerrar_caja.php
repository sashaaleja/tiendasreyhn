<?php 
session_start();
include("functions.php");
$AperturaCaja = $_POST["AperturaCaja2"];
$VentasCaja = $_POST["VentasTotales2"];
$CierreCaja = $_POST["CierreTotal2"];
$FechaCierre = $_POST["FechaCaja2"];
$HoraCierre = $_POST["HoraCaja2"];
$sucursal = $_POST["SucursalUser"];
$Usuario = $_SESSION["UsuarioL"];
if($resultado2 = ConectarDB()->query("SELECT * FROM sucursales WHERE Nombre = '$sucursal'")){
    while($row = $resultado2->fetch_assoc()){
        $DireccionSucursal = $row["Direccion"];
        $Sucursal = $row["Nombre"];

        
    }
    }


    $EstadoCuadre = "";
    $SumaTotalCierre = $VentasCaja + $AperturaCaja;

    if($SumaTotalCierre = $CierreCaja){
        $EstadoCuadre = "¡Caja cuadra correctamente!";

    }else{
        $EstadoCuadre = "¡Caja no cuadra correctamentr!";
    }



    if($resultadocaja = ConectarDB()->query("SELECT * FROM caja")){
        $resultadocaja = ConectarDB()->query("UPDATE caja SET Ventas = '$VentasCaja',Cierre = '$CierreCaja', Hora = '$HoraCierre', Sucursal = '$sucursal' WHERE Fecha = '$FechaCierre'");
    }

$ListaCierre = array();

    # Incluyendo librerias necesarias #
require "print/code128.php";
 

$pdf = new PDF_Code128('P','mm',array(80,258));
$pdf->SetMargins(4,5,4);
$pdf->AddPage();

# Encabezado y datos de la empresa #
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,5,utf8_decode(""),0,'C',false);
$pdf->Image("img/tiendasrey.jpg",5,5,20,20);
$pdf->MultiCell(0,5,utf8_decode(""),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode(strtoupper("Tiendas Rey")),0,'C',false);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(0,5,utf8_decode("RTN: 0000000000"),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("$DireccionSucursal"),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Teléfono: +50494226120"),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Email: supertiendaselrey8@gmail.com"),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Sucursal: ".$sucursal),0,'C',false);

$pdf->Ln(1);
$pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
$pdf->Ln(5);

$pdf->MultiCell(0,5,utf8_decode("Fecha: ".$FechaCierre." - ".$HoraCierre),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Caja Nro: 1"),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Cajero: ".$Usuario),0,'C',false);
$pdf->SetFont('Arial','B',10);
//$pdf->MultiCell(0,5,utf8_decode(strtoupper("Factura Nro: $Factura")),0,'C',false);//
$pdf->SetFont('Arial','',9);

$pdf->Ln(1);
$pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
$pdf->Ln(5);

$pdf->MultiCell(0,5,utf8_decode("Cierres De Caja: ".$sucursal.""),0,'C',false);
 
 

$pdf->Ln(1);
$pdf->Cell(0,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
$pdf->Ln(3);

$pdf->Ln(5);

$pdf->Cell(18,5,utf8_decode(""),0,0,'C');
$pdf->Cell(22,5,utf8_decode("Apertura Caja"),0,0,'C');
$pdf->Cell(32,5,utf8_decode("L.".number_format($AperturaCaja,0).""),0,0,'C');

$pdf->Ln(5);

$pdf->Cell(18,5,utf8_decode(""),0,0,'C');
$pdf->Cell(22,5,utf8_decode("Total Ventas"),0,0,'C');
$pdf->Cell(32,5,utf8_decode("L.".number_format($VentasCaja,0)),0,0,'C');

$pdf->Ln(5);

$pdf->Cell(18,5,utf8_decode(""),0,0,'C');
$pdf->Cell(22,5,utf8_decode("Cierre Completo"),0,0,'C');
$pdf->Cell(32,5,utf8_decode("L.".number_format($CierreCaja,0)),0,0,'C');

$pdf->Ln(5);



$pdf->Ln(10);
$pdf->SetFont('Arial','B',16);
$pdf->MultiCell(0,5,utf8_decode("*** $EstadoCuadre ***"),0,'C',false);

$pdf->SetFont('Arial','B',9);

$pdf->Ln(9);

 

# Nombre del archivo PDF #
$pdf->Output("I","Cierre-de-caja".$Sucursal."_".fechaEs($FechaCierre).".pdf",true);

?>
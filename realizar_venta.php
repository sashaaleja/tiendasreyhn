<?php 
session_start();
include "functions.php";
ConectarDB();
date_default_timezone_set('America/Tegucigalpa');
$Nombre_Cliente = $_SESSION["Nombre_Cliente"];
$Apellido_Cliente = $_SESSION["Apellido_Cliente"];
$Nombre_Completo = $_SESSION["Nombre_Factura"];
$Celular_Cliente = $_SESSION["Celular_Cliente"];
$Domicilio_Cliente = $_SESSION["Domicilio_Cliente"];
$Usuario = $_SESSION['UsuarioL'];
$sucursal = $_POST["Sucursal"];
$Descuento = 0;
$Efectivo = $_POST["Efectivo"];
$Usuario = $_SESSION["UsuarioL"]; 

if($resultado2 = ConectarDB()->query("SELECT * FROM sucursales WHERE Nombre = '$sucursal'")){
while($row = $resultado2->fetch_assoc()){
    $DireccionSucursal = $row["Direccion"];
    
}
}

$Factura = $_POST["Factura"];
if(isset($_POST["submit"])) {
    // Check if any option is selected
 
$ListaCarrito = array();
if(isset($_SESSION["Nombre_Factura"])){
    $Nombre_Activo_Factura = $_SESSION["Nombre_Factura"];
    $QUERYFactura = "SELECT * FROM carrito WHERE Nombre_Cliente = '$Nombre_Activo_Factura'";
    $QUERYFactura2 = "WHERE Nombre_Cliente = '$Nombre_Activo_Factura'";

    if($resultadocarrito = ConectarDB()->query("$QUERYFactura")){
        while($row = $resultadocarrito->fetch_assoc()){
           $CodigoProducto = $row["Codigo_Producto"];
            $Precio = $row["Precio"];
            $CantidadVenta = $row["Cantidad"];
            $Nombre_Factura = $row["Nombre_Cliente"];
            $TotalPagar = $row["Total"];
            $Id = $row["Id"];
           
            if($resultadototalventa = ConectarDB()->query("SELECT SUM(Total) AS total
            FROM carrito $QUERYFactura2")){
                while($rowtotal = $resultadototalventa->fetch_assoc()){
                    $TotalVenta = $rowtotal["total"];
                
                }
            }
            $ListaCarrito[] = $row;
           
    }
    
    }
}else{
    $QUERYFactura = "";
    $QUERYFactura2 = "";
    $Carrito = "";
    $TotalVenta = "L.0";
}

}
$SQL = "SELECT * FROM stock WHERE Codigo = '$CodigoProducto'";
if($resultado = ConectarDB()->query($SQL)){

    while($row = $resultado->fetch_assoc()){
        $Precio_Venta = $row["Precio_Venta"];
    }
}

$TotalPago = $TotalVenta;
$Fecha_Venta = date("Y-m-d");
$Hora_Venta = date("h:i");

$arrayVentas = array_values($ListaCarrito);
 
// Recorres cada posición de productos insertas y a la vez insertar cada posición de cantidades

foreach ($ListaCarrito as $Ventas) {
    $Nombre_Venta_Cliente = $Ventas["Nombre_Cliente"];
    $Codigo_Venta_Producto = $Ventas["Codigo_Producto"];
    $Cantidad_Venta = $Ventas["Cantidad"];
    $Precio_Venta2 = $Ventas["Precio"];
    $Total_Venta_Pagar = $Ventas["Total"];
    $Id_Factura = rand(1,1000);
    $resultado2 = ConectarDB()->query("INSERT into ventas (Nombre_Cliente,Codigo_Producto,Cantidad,Precio_Venta,Total_A_Pagar,Fecha_Venta,Hora_Venta,Sucursal,Id_Factura,Cajero) VALUES('$Nombre_Venta_Cliente','$Codigo_Venta_Producto','$Cantidad_Venta','$Precio_Venta2','$Total_Venta_Pagar','$Fecha_Venta','$Hora_Venta','$sucursal','$Id_Factura','$Usuario')");
   
}
   

 if($resultadoactualizarstock = ConectarDB()->query("SELECT * FROM stock WHERE Codigo = '$Codigo_Venta_Producto'")){
    while($row = $resultadoactualizarstock->fetch_assoc()){
        $Stockactual = $row["Stock"];
        $Stocknew = $Stockactual - $Cantidad_Venta;
    }
    $resultadoactualizarstock = ConectarDB()->query("UPDATE stock SET Stock='$Stocknew' WHERE Codigo = '$Codigo_Venta_Producto'");
 }
 $Cambio = $Efectivo - $TotalPago;



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

$pdf->MultiCell(0,5,utf8_decode("Fecha: ".$Fecha_Venta." - ".date("h:i A")),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Caja Nro: 1"),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Cajero: ".$Usuario),0,'C',false);
$pdf->SetFont('Arial','B',10);
//$pdf->MultiCell(0,5,utf8_decode(strtoupper("Factura Nro: $Factura")),0,'C',false);//
$pdf->SetFont('Arial','',9);

$pdf->Ln(1);
$pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
$pdf->Ln(5);

$pdf->MultiCell(0,5,utf8_decode("Cliente: ".$Nombre_Completo.""),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Teléfono: ".$Celular_Cliente.""),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Dirección: ".$Domicilio_Cliente.""),0,'C',false);

$pdf->Ln(1);
$pdf->Cell(0,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
$pdf->Ln(3);

# Tabla de productos #
$pdf->Cell(12,7,utf8_decode("Cod."),0,0,'C');
$pdf->Cell(13,7,utf8_decode("Cant."),0,0,'C');
$pdf->Cell(20,7,utf8_decode("Precio"),0,0,'C');
$pdf->Cell(25,7,utf8_decode("Total"),0,0,'C');

$pdf->Ln(3);
$pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
$pdf->Ln(3);



 

 
/*----------  Detalles de la tabla  ----------*/
foreach($ListaCarrito as $Lista){
$pdf->MultiCell(0,4,utf8_decode(""),0,'C',false);
$pdf->Cell(13,9,utf8_decode($Lista["Codigo_Producto"]),0,0,'C');
$pdf->Cell(16,7,utf8_decode($Lista["Cantidad"]),0,0,'C');
$pdf->Cell(20,7,utf8_decode("L".number_format($Lista["Precio"],0)),0,0,'C');
$pdf->Cell(20,8,utf8_decode("L.".number_format($Lista["Total"],0)),0,0,'C');
$pdf->Ln(2);
$pdf->Ln(2);
}
/*----------  Fin Detalles de la tabla  ----------*/


$pdf->Ln(3);
$pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
$pdf->Ln(3);



 



$pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');

    $pdf->Ln(5);

# Impuestos & totales #
$pdf->Cell(18,5,utf8_decode(""),0,0,'C');
$pdf->Cell(22,5,utf8_decode("SUBTOTAL"),0,0,'C');
$pdf->Cell(32,5,utf8_decode("L".number_format($TotalPago,0)),0,0,'C');

$pdf->Ln(5);
$pdf->Cell(18,5,utf8_decode(""),0,0,'C');
$pdf->Cell(22,5,utf8_decode("DESCUENTO"),0,0,'C');
$pdf->Cell(32,5,utf8_decode("L.".number_format($Descuento,0)),0,0,'C');
$pdf->Ln(5);
$pdf->Cell(52,5,utf8_decode("ISV"),0,0,'C');
$pdf->Cell(11,5,utf8_decode("L.0.00"),0,0,'C');
$pdf->Ln(5);

$pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');

$pdf->Ln(5);

$pdf->Cell(18,5,utf8_decode(""),0,0,'C');
$pdf->Cell(22,5,utf8_decode("TOTAL A PAGAR"),0,0,'C');
$pdf->Cell(32,5,utf8_decode("L.".number_format($TotalPago,0).""),0,0,'C');

$pdf->Ln(5);

$pdf->Cell(18,5,utf8_decode(""),0,0,'C');
$pdf->Cell(22,5,utf8_decode("EFECTIVO"),0,0,'C');
$pdf->Cell(32,5,utf8_decode("L.".number_format($Efectivo,0)),0,0,'C');

$pdf->Ln(5);

$pdf->Cell(18,5,utf8_decode(""),0,0,'C');
$pdf->Cell(22,5,utf8_decode("CAMBIO"),0,0,'C');
$pdf->Cell(32,5,utf8_decode("L.".number_format($Cambio,0)),0,0,'C');

$pdf->Ln(5);



$pdf->Ln(10);

$pdf->MultiCell(0,5,utf8_decode("*** Esta factura no tiene valor comercial, solo es un comprobante de su compra, estamos trabajando para ofrecerle una factura electronica comercial. ***"),0,'C',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,7,utf8_decode("Gracias por su compra"),'',0,'C');

$pdf->Ln(9);

 
 
# Nombre del archivo PDF #
$pdf->Output("I","Ticket_Nro_1.pdf",true);




 
?>


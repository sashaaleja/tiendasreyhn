<?php 
session_start();
include "functions.php";
ConectarDB();
date_default_timezone_set('America/Tegucigalpa');
$Nombre_Cliente = $_POST["NombreCliente"];
$Celular_Cliente = $_POST["CelularCliente"];
$Domicilio_Cliente = $_POST["DomicilioCliente"];
$Producto = $_POST["Producto"];
$Cantidad = $_POST["Cantidad"];
$Usuario = $_SESSION['UsuarioL'];
$Sucursal = $_POST["Sucursal"];
$SQL = "SELECT * FROM stock WHERE Codigo = '$Producto'";
if($resultado = ConectarDB()->query($SQL)){

    while($row = $resultado->fetch_assoc()){
        $Precio_Venta = $row["Precio_Venta"];
    }
}

$TotalPago = $Cantidad * $Precio_Venta;
$Fecha_Venta = date("Y-m-d");
$Hora_Venta = date("h:i A");

$Carrito[] = array("$Nombre_Completo","$Producto","$Cantidad","$Precio_Venta","$TotalPago","$Fecha_Venta","$Hora_Venta");
$ClienteInfo[] = array($Nombre_Cliente,$Apellido_Cliente,$Celular_Cliente,$Domicilio_Cliente);

if($resultado = ConectarDB()->query("SELECT * FROM carrito")){
    $resultado = ConectarDB()->query("INSERT INTO carrito (Nombre_Cliente,Codigo_Producto,Cantidad,Precio,Total,Sucursal,Fecha_Carrito,Cajero) VALUES('$Nombre_Cliente','$Producto','$Cantidad','$Precio_Venta','$TotalPago','$Sucursal','$Fecha_Venta','$Usuario')");
    $resultado3 = ConectarDB()->query("INSERT INTO clientes (Nombre,Apellido,Celular,Domicilio,Tipo) VALUES('$Nombre_Cliente','$Apellido_Cliente','$Celular_Cliente','$Domicilio_Cliente','Consumidor Final')");
}

  
 
 $_SESSION["Nombre_Factura"] = $Nombre_Cliente;
 $_SESSION["Nombre_Cliente"] = $Nombre_Cliente;
 $_SESSION["Apellido_Cliente"] = $Apellido_Cliente;
 $_SESSION["Celular_Cliente"] = $Celular_Cliente;
 $_SESSION["Domicilio_Cliente"] = $Domicilio_Cliente;
 $_SESSION["Sucursal"] = $Sucursal;
 
header("location:vender.php");

?>
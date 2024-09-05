<?php session_start();?>
<?php
date_default_timezone_set('America/Tegucigalpa');
include "functions.php";
$Apertura_Caja = $_POST["AperturaCaja"];
ConectarDB();
$Hoy = date("Y-m-d");
$Hora = date("h:i A");
$Usuario = $_SESSION["UsuarioL"];
if($resultadosucursal = ConectarDB()->query("SELECT * FROM usuarios WHERE Usuario = '$Usuario'")){
    while($row = $resultadosucursal->fetch_assoc()){
        $Sucursal = $row["Sucursal"];
    }
}
if($resultado = ConectarDB()->query("SELECT * FROM caja")){
    $resultado = ConectarDB()->query("INSERT INTO caja (Inicio_Caja,Ventas,Cierre,Fecha,Hora,Sucursal) VALUES('$Apertura_Caja','0','0','$Hoy','$Hora','$Sucursal')");
    header("location:index.php");
}



?>
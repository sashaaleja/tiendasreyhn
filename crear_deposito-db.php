<?php session_start();?>
<?php
include "functions.php";
$Codigo_Ref = $_POST["CodigoRef"];
$Depositante = $_POST["Depositante"];
$Descripcion = $_POST["Descripcion"];
$ValorDepositado = $_POST["ValorDepositado"];
$Sucursal = $_POST["Sucursal"];
$FechaDeposito = $_POST["FechaDeposito"];
$HoraDeposito = $_POST["HoraDeposito"];
$Banco = $_POST["Banco"];

if($resultado = ConectarDB()->query("SELECT * FROM depositos")){
    $resultado = ConectarDB()->query("INSERT INTO depositos (Descripcion,Depositante,Codigo_Ref,Valor,Fecha_Deposito,Hora_Deposito,Banco,Sucursal) VALUES ('$Descripcion','$Depositante','$Codigo_Ref','$ValorDepositado','$FechaDeposito','$HoraDeposito','$Banco','$Sucursal')");
    echo "Datos correctamente insertados";
    header("location:depositos.php");
}
?>
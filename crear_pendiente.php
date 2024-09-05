<?php session_start();?>
<?php
include "functions.php";
$Pendiente = $_POST["Pendiente"];
$Fecha = date("Y-m-d");
$Hora = date("h:i A");
$Estado = "Activo";
$Usuario = $_SESSION["UsuarioL"];
$SucursalUsuario = ObtenerSucursalUsuario($Usuario);
 
CrearPendientes($Pendiente,$Fecha,$Hora,$Estado,$Usuario,$SucursalUsuario);
 

?>
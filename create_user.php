<?php
include "functions.php";
$Nombre = $_POST["Nombre"];
$Apellido = $_POST["Apellido"];
$Celular = $_POST["Celular"];
$Usuario = $_POST["Usuario"];
$Password = $_POST["Password"];
$Email = $_POST["Email"];
$Privilegios = $_POST["Privilegios"];
$Perfil = "tiendasrey.jpg";
$Sucursal = $_POST["Sucursal"];
ConectarDB();
 
$SQL = "SELECT * FROM usuarios";
 if(Query($SQL)){
    InsertarUsuario($Nombre,$Apellido,$Usuario,$Celular,$Password,$Email,$Privilegios,$Perfil,$Sucursal);
    header("location:users.php");
 }else{
    echo "Error al insertar datos";
 }
?>
<?php session_start();?>
<?php 

include "functions.php";

ConectarDB();

$Emisor = $_POST["Emisor"];
$Receptor = $_POST["Receptor"];
$Mensaje = $_POST["Mensaje"];
$Fecha = $_POST["Fecha_Mensaje"];
$Hora = $_POST["Hora_Mensaje"];

if($resultadousuario = ConectarDB()->query("SELECT * FROM usuarios WHERE Usuario = '$Emisor'")){
    while($row = $resultadousuario->fetch_Assoc()){
        $Perfil = $row["Perfil"];
    }
}

InsertarMensajes($Emisor,$Receptor,$Mensaje,$Fecha,$Hora,$Perfil);




?>
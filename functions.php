<?php
define("HOY", date("Y-m-d"));
date_default_timezone_set('America/Tegucigalpa');
function ConectarDB(){
    $host = "localhost:3370";
    $user = "root";
    $pass = "Filipenses413@";
    $db = "tiendasrey";
    $Mysqli = new mysqli($host,$user,$pass,$db) or die("Error al conectar la base de datos");

   return $Mysqli;
}


function Query($SQL){
$resultado = ConectarDB()->query($SQL);
return $resultado;
}
function InsertarUsuario($Nombre,$Apellido,$Usuario,$Celular,$Clave,$Email,$Privilegios,$Perfil,$Sucursal){
    if(ConectarDB()->query("INSERT INTO usuarios (Nombre,Apellido,Usuario,Celular,Clave,Email,Privilegios,Perfil,Sucursal) Values('$Nombre','$Apellido','$Usuario','$Celular','$Clave','$Email','$Privilegios','$Perfil','$Sucursal')")){
        echo "Datos Insertados Correctamente";
        header("users.php");
    }else{
        echo "Error al insertar datos";

    }

}
 

function ObtenerSucursalUsuario($Usuario){
if($resultado = ConectarDB()->query("SELECT * FROM usuarios WHERE Usuario='$Usuario'")){
    while($row  = $resultado->fetch_assoc()){
        $SucursalDBUser = $row["Sucursal"];

    }
}

return $SucursalDBUser;
 
}


function ObtenerVentasPorUsuario($Usuario){
    $table_ventas = "";
    if($resultadoventas = ConectarDB()->query("SELECT * FROM ventas WHERE Cajero = '$Usuario'")){
    while($row = $resultadoventas->fetch_Assoc()){
        $Fecha_V = $row["Fecha_Venta"];
        $Factura_Venta = $row["Id_Factura"];
        $Cliente_Venta = $row["Nombre_Cliente"];
        $Producto_Venta = $row["Codigo_Producto"];
        $Total_Venta = $row["Total_A_Pagar"];
        $Hora_Venta = $row["Hora_Venta"];
        $Cantidad = $row["Cantidad"];
        $Precio = $row["Precio_Venta"];
        $table_ventas .= " <tr>
                                    <td><input class='form-check-input'' type='checkbox'></td>
                                    <td>".fechaEs($Fecha_V)."</td>
                                     <td>$Hora_Venta</td>
                                    <td>$Factura_Venta</td>
                                    <td>$Cliente_Venta</td>
                                    <td>L. ".number_format($Total_Venta,0)."</td>
                                    <td>$Producto_Venta</td>
                                    <td>$Cantidad</td>
                                    <td>L. ".number_format($Precio,0)."</td>
                                </tr>";
    }
    }

    echo $table_ventas;
}


function ObtenerVentas(){
    $table_ventas2 = "";
    if($resultadoventa2 = ConectarDB()->query("SELECT * FROM ventas")){
    while($row = $resultadoventa2->fetch_Assoc()){
        $Fecha_V2 = $row["Fecha_Venta"];
        $Factura_Venta2 = $row["Id_Factura"];
        $Cliente_Venta2 = $row["Nombre_Cliente"];
        $Producto_Venta2 = $row["Codigo_Producto"];
        $Total_Venta2 = $row["Total_A_Pagar"];
        $Hora_Venta2 = $row["Hora_Venta"];
        $Cantidad2 = $row["Cantidad"];
        $Precio2 = $row["Precio_Venta"];
        $table_ventas2 .= " <tr>
                                    <td><input class='form-check-input'' type='checkbox'></td>
                                    <td>".fechaEs($Fecha_V2)."</td>
                                     <td>$Hora_Venta2</td>
                                    <td>$Factura_Venta2</td>
                                    <td>$Cliente_Venta2</td>
                                    <td>L. ".number_format($Total_Venta2,0)."</td>
                                    <td>$Producto_Venta2</td>
                                    <td>$Cantidad2</td>
                                    <td>L. ".number_format($Precio2,0)."</td>
                                </tr>";
    }
    }

    echo $table_ventas2;
}

 function ObtenerSumaVentas($Usuario){
    $Ventas = "";
    if($resultado = ConectarDB()->query("SELECT *   FROM ventas WHERE Cajero = '$Usuario'")){
        while($row = $resultado->fetch_assoc()){
            $Ventas .= $row["Total_A_Pagar"].",";

  


        }
    }
 
    echo $Ventas;
 
 }

 
function ObtenerPendientes($Sucursal,$Usuario){
    $PendientesTabla = "";
if($resultadopendientes = ConectarDB()->query("SELECT * FROM pendientes WHERE Sucursal = '$Sucursal' AND Usuario = '$Usuario'")){
    while($row = $resultadopendientes->fetch_assoc()){
      $PendienteDB = $row["Pendiente"];
      $FechaDB = $row["Fecha"];
      $HoraDB = $row["Hora"];
      $EstadoDB = $row["Estado"];
        


      $PendientesTabla .= "<div class='d-flex align-items-center border-bottom py-2'>
      <input class='form-check-input m-0' type='checkbox'>
      <div class='w-100 ms-3'>
          <div class='d-flex w-100 align-items-center justify-content-between'>
              <span>$PendienteDB</span>
                <span>".fechaES($FechaDB)."</span>
                  <span>$HoraDB</span>
              <button class='btn btn-sm'><i class='fa fa-times'></i></button>
          </div>
      </div>
      </div>";
    }


}
echo $PendientesTabla;
}


function CrearPendientes($Pendiente,$Fecha,$Hora,$Estado,$Usuario,$Sucursal){
    if($resultadopendientes = ConectarDB()->query("INSERT INTO pendientes(Pendiente,Fecha,Hora,Estado,Usuario,Sucursal) VALUES('$Pendiente','$Fecha','$Hora','$Estado','$Usuario','$Sucursal')")){
        echo "Datos insertados correctamente";
        header("location:index.php");
    }
}

function fechaEs($fecha) {
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
    }


    function ago($timestamp)
    {
    
        $today = new DateTime(date('Y-m-d h:i:s A')); // [2]
        //$thatDay = new DateTime('Sun, 10 Nov 2013 14:26:00 GMT');
        $thatDay = new DateTime($timestamp);
        $dt = $today->diff($thatDay);
 
        if ($dt->y > 0){
            $number = $dt->y;
            $unit = "año";
        } else if ($dt->m > 0) {
            $number = $dt->m;
            $unit = "mes";
        } else if ($dt->d > 0) {
            $number = $dt->d;
            $unit = "dia";
        } else if ($dt->h > 0) {
            $number = $dt->h;
            $unit = "hora";
        } else if ($dt->i > 0) {
            $number = $dt->i;
            $unit = "minuto";
        } else if ($dt->s > 0) {
            $number = $dt->s;
            $unit = "segundo";
        }
        
        $unit .= $number  > 1 ? "s" : "";
     
        $ret = "Hace ".$number." ".$unit.".";
        return $ret;
    }



    function ObtenerMensajes($Usuario){
        $MensajesTabla = "";
    if($resultadomensajes = ConectarDB()->query("SELECT * FROM mensajes WHERE Receptor = '$Usuario'")){
        while($row = $resultadomensajes->fetch_Assoc()){
            $Emisor = $row["Emisor"];
            $Receptor = $row["Receptor"];
            $Mensaje = $row["Mensaje"];
            $Fecha = $row["Fecha"];
            $Hora = $row["Hora"];
         $Perfil = $row["Perfil"];
         $FechaHoy = date("Y-m-d");
         $Hora_Actual = date("h:i A");

         $Fecha_Completa = $Fecha." ".$Hora;
       $Minutos = ago($Fecha_Completa);
 
        
            $MensajesTabla .= " <div class='d-flex align-items-center border-bottom py-3'>
                                <img class='rounded-circle flex-shrink-0' src='imgs_resources/$Perfil' alt='' style='width: 40px; height: 40px;'>
                                <div class='w-100 ms-3'>
                                    <div class='d-flex w-100 justify-content-between'>
                                        <h6 class='mb-0'>$Emisor</h6>
                                        <small>$Minutos</small>
                                    </div>
                                    <span>$Mensaje</span>
                                </div>
                            </div>";
        }
    }
    echo $MensajesTabla;
    }


    function ObtenerMensajesNavbar($Usuario){

        $MensajesTablaNavbar = "";
        if($resultadomensajesNavbar = ConectarDB()->query("SELECT * FROM mensajes WHERE Receptor = '$Usuario'")){
            while($row = $resultadomensajesNavbar->fetch_Assoc()){
                $Emisor = $row["Emisor"];
                $Receptor = $row["Receptor"];
                $Mensaje = $row["Mensaje"];
                $Fecha = $row["Fecha"];
                $Hora = $row["Hora"];
             $Perfil = $row["Perfil"];
             $FechaHoy = date("Y-m-d");
             $Hora_Actual = date("h:i A");
    
             $Fecha_Completa = $Fecha." ".$Hora;
           $Minutos = ago($Fecha_Completa);
     
            
                $MensajesTablaNavbar .=   "<div class='dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0'>
                <a href='#' class='dropdown-item'>
                    <div class='d-flex align-items-center'>
                        <img class='rounded-circle' src='imgs_resources/$Perfil' alt='' style='width: 40px; height: 40px;'>
                        <div class='ms-2'>
                            <h6 class='fw-normal mb-0'>$Emisor te ha enviado un mensaje.</h6>
                            <small>$Minutos</small>
                        </div>
                    </div>
                </a>
      
                <hr class='dropdown-divider'>";
            }
        }
        echo $MensajesTablaNavbar;
      
    }


    function InsertarMensajes($Emisor,$Receptor,$Mensaje,$Fecha,$Hora,$Perfil){
    if($resultadomensajesw = ConectarDB()->query("INSERT INTO mensajes(Emisor,Receptor,Mensaje,Fecha,Hora,Perfil) VALUES('$Emisor','$Receptor','$Mensaje','$Fecha','$Hora','$Perfil')")){
        echo "Datos insertados correctamente";
        header("location:index.php");
    }
    }



    function InsertarSalidaFardos($Codigo_Fardo,$Descripcion,$Precio_Fardo,$Cantidad,$Total,$Cliente_Sucursal,$Telefono,$Direccion,$Entregado_A,$Celular,$Fecha,$Hora){
        if($resultadosalidaf = ConectarDB()->query("INSERT INTO fardos(Codigo_Fardo,Descripcion,Precio_Fardo,Cantidad,Total,Cliente_Sucursal,Telefono,Direccion,Entregado_A,Celular,Fecha,Hora) VALUES('$Codigo_Fardo','$Descripcion','$Precio_Fardo','$Cantidad','$Total','$Cliente_Sucursal','$Telefono','$Direccion','$Entregado_A','$Celular','$Fecha','$Hora')")){ 
            echo "Datos insertados correctamente";
            header("location:salida_de_fardos/index.php");
        }

    }

    function ObtenerFardosSalida(){
        $table_fardos = "";
        if($resultadofardos = ConectarDB()->query("SELECT * FROM fardos")){
            while($row = $resultadofardos->fetch_Assoc()){
                $Codigo_Fardo = $row["Codigo_Fardo"];
                $Descripcion = $row["Descripcion"];
                $Precio_Fardo =  $row["Precio_Fardo"];
                $Cantidad = $row["Cantidad"];
                $Total = $row["Total"];
                $Cliente_Sucursal = $row["Cliente_Sucursal"];
                $Telefono = $row["Telefono"];
                $Direccion = $row["Direccion"];
                $EncargadoA = $row["Entregado_A"];
                $Celular = $row["Celular"];
                $Fecha = fechaEs($row["Fecha"]);
                $Hora = $row["Hora"];
                $table_fardos .= " <tr>
                <td><input class='form-check-input'' type='checkbox'></td>
                <td>$Codigo_Fardo</td>
                 <td>$Descripcion</td>
                <td>L. ".number_format($Precio_Fardo,0)."</td>
                <td>$Cantidad</td>
                <td>L. ".number_format($Total,0)."</td>
                <td>$Cliente_Sucursal</td>
                <td>$Telefono</td>
                <td>$Direccion</td>
                  <td>$EncargadoA</td>
                    <td>$Celular</td>
                      <td>$Fecha</td>
                        <td>$Hora</td>
            </tr>";

            }
        }

        echo $table_fardos;
    }
?>
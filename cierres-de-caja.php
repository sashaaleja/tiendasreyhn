<?php session_start();?>
<?php 
date_default_timezone_set('America/Tegucigalpa');
include "functions.php";
$Mysqli = new mysqli("localhost:3370","root","Filipenses413@","tiendasrey") or die("Error al  conectar con base de datos.");
if(!isset($_SESSION["State"])){
    header("location:login.php");
}else{
    $Usuario = $_SESSION["UsuarioL"];
    $Email = $_SESSION["EmailL"];

}
$SQL = "SELECT * FROM usuarios WHERE Usuario = '$Usuario' OR Email='$Email'";

if($resultado = $Mysqli->query($SQL)){
    while($row = $resultado->fetch_assoc()){
       $Usuario = $row["Usuario"];
       $Email = $row["Email"];
       $PasswordC = $row["Clave"];
       $Nombre = $row["Nombre"];
       $Apellido = $row["Apellido"];
       $Privilegios = $row["Privilegios"];
       $Nombre_Completo = $Nombre." ".$Apellido;
       $Profile = $row["Perfil"];
       $SucursalUser = $row["Sucursal"];
    }

}


if($Privilegios == "Admin"){
    $Navbar = "navbar_admin.php";
}else{
    $Navbar = "navbar_cajero.php";
}
 
$Codigo_Producto= "";
if($resultadoproductos = $Mysqli->query("SELECT * FROM stock")){
    while($row = $resultadoproductos->fetch_assoc()){
        $Codigo_Producto .= $row['Codigo'].",";
        $Precio_Venta = $row["Precio_Venta"];
      
    }
}

$Sucursales = "";
if($resultadosucursales = $Mysqli->query("SELECT * FROM sucursales")){
    while($row = $resultadosucursales->fetch_assoc()){
        $Sucursal = $row['Nombre'];
        $Sucursales .= "<option value='$Sucursal'>$Sucursal</option>";
      
    }
}

$Carrito = "";
if(isset($_SESSION["Nombre_Factura"])){
    $Nombre_Activo_Factura = $_SESSION["Nombre_Factura"];
    $QUERYFactura = "SELECT * FROM carrito WHERE Nombre_Cliente = '$Nombre_Activo_Factura'";
    $QUERYFactura2 = "WHERE Nombre_Cliente = '$Nombre_Activo_Factura'";

    if($resultadocarrito = $Mysqli->query("$QUERYFactura")){
        while($row = $resultadocarrito->fetch_assoc()){
           $CodigoProducto = $row["Codigo_Producto"];
            $Precio = $row["Precio"];
            $Cantidad = $row["Cantidad"];
            $Nombre_Factura = $row["Nombre_Cliente"];
            $TotalPagar = $row["Total"];
            $Id = $row["Id"];
            $Carrito .= "<option value='$Id'> Codigo Producto: $CodigoProducto  Nombre Cliente: $Nombre_Factura  Cantidad: $Cantidad Precio: L. $Precio Total: L. $TotalPagar</option>";
            if($resultadototalventa = $Mysqli->query("SELECT SUM(Total) AS total
            FROM carrito $QUERYFactura2")){
                while($rowtotal = $resultadototalventa->fetch_assoc()){
                    $TotalVenta = $rowtotal["total"];
                }
            }
               
    
    }
    
    }
}else{
    $QUERYFactura = "";
    $QUERYFactura2 = "";
    $Carrito = "";
    $TotalVenta = "L.0";
}

$Hoy = date("Y-m-d");
if($resultadoventas = $Mysqli->query("SELECT SUM(Total_A_Pagar) AS total
            FROM ventas WHERE Fecha_Venta ='$Hoy'")){
while($row = $resultadoventas->fetch_assoc()){
    $count = mysqli_num_rows($resultadoventas);

    if($count > 0 ){
        $TotalVentasHoy = $row["total"];
    }else{
        $TotalVentasHoy = "";
    }
    
 
}

}
if($resultadoventas2 = $Mysqli->query("SELECT SUM(Total_A_Pagar) AS totalventas
            FROM ventas")){
while($row = $resultadoventas2->fetch_assoc()){

$count = mysqli_num_rows($resultadoventas2);

if($count > 0 ){
    $TotalVentas = $row["totalventas"];
    $VentasCaja = $TotalVentasHoy;
}else{
    $TotalVentas = "";
    $VentasCaja = "";
}

 
}

}

if($resultadocarritoventas = $Mysqli->query("SELECT SUM(Total) AS totalcarrito
            FROM carrito")){
while($row = $resultadocarritoventas->fetch_assoc()){

$count = mysqli_num_rows($resultadocarritoventas);

if($count > 0 ){
    $TotalCarrito = $row["totalcarrito"];
}else{
    $TotalCarrito = "";
}

 
}

}

if($resultadocarritoventas2 = $Mysqli->query("SELECT SUM(Total) AS total
            FROM carrito WHERE Fecha_Carrito ='$Hoy'")){
while($row = $resultadocarritoventas2->fetch_assoc()){
    $count = mysqli_num_rows($resultadocarritoventas2);

    if($count > 0 ){
        $TotalCarritoHoy = $row["total"];
    }else{
        $TotalCarritoHoy = "";
    }
    
 
}
}


if($resultadocaja = $Mysqli->query("SELECT * FROM caja WHERE Fecha = '$Hoy'")){
    while($row = $resultadocaja->fetch_assoc()){
        $AperturaCaja = $row["Inicio_Caja"];
        $CierreCaja = $AperturaCaja + $VentasCaja;
        $FechaCaja = $Hoy;
        $HoraCaja = date("h:i A");
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MegaRey - <?php echo $Nombre_Completo;?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>MegaRey</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="imgs_resources/<?php echo $Profile;?>" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $Nombre_Completo;?></h6>
                        <span><?php echo $Privilegios;?></span>
                    </div>
                </div>
               <?php include($Navbar);?>
        <!-- Sidebar End -->


 <?php include("navbar.all.php");?>


 <?php include("sales_announcement.php");?>
            <!-- Sale & Revenue End -->


            <!-- Sales Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Worldwide Sales</h6>
                                <a href="">Show All</a>
                            </div>
                            <canvas id="worldwide-sales"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Salse & Revenue</h6>
                                <a href="">Show All</a>
                            </div>
                            <canvas id="salse-revenue"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sales Chart End -->


            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Cierres de Caja</h6>
                        <a href="ver-cierres-de-caja.php">Ver Cierres De Caja</a>
                    </div>
                    <form action="cerrar_caja.php" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Apertura:</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Apertura Caja" name="AperturaCaja" value="<?php echo $AperturaCaja?>" disabled>
    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Apertura Caja" name="AperturaCaja2" value="<?php echo $AperturaCaja?>">
    
    
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Ventas:</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ventas Totales" name="VentasTotales" value="<?php echo $VentasCaja?>" disabled>
    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Apertura Caja" name="VentasTotales2" value="<?php echo $VentasCaja?>">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Cierre Total:</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Cierre Total" name="CierreTotal" value="<?php echo $CierreCaja?>" disabled>
    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Apertura Caja" name="CierreTotal2" value="<?php echo $CierreCaja?>">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Fecha:</label>
    <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Fecha Caja" name="FechaCaja" value="<?php echo $FechaCaja?>" disabled>
    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Apertura Caja" name="FechaCaja2" value="<?php echo $FechaCaja?>">
  </div>
  <div class="form-group">
    <label for="Sucursal">Hora:</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Hora Caja" name="HoraCaja" value="<?php echo $HoraCaja?>" disabled>
    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Apertura Caja" name="HoraCaja2" value="<?php echo $HoraCaja?>">
  </div>

  <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Apertura Caja" name="SucursalUser" value="<?php echo $SucursalUser?>">
  <br>
  <button type="submit" class="btn btn-primary">Cerrar Caja</button> 

  
</form>
<br>

                </div>
            </div>
            <!-- Recent Sales End -->


            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-secondary rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0">Mensajes</h6>
                                <a href="escribir_mensaje.php" class="btn btn-success">Escribir Mensaje</a>
                            </div>
                            <?php ObtenerMensajes($Usuario);?>
                        </div>
              
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-secondary rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Calender</h6>
                              
                            </div>
                            <div id="calender"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-secondary rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">To Do List</h6>
                                <a href="pendientes.php">Mostrar todos</a>
                            </div>
                            <form action="crear_pendiente.php" method="post" Id="FormPendientes">
                            <div class="d-flex mb-2">
                                
                                <input class="form-control bg-dark border-0" type="text" placeholder="Ingrese el pendiente" name="Pendiente">
                               
                                <button type="button" class="btn btn-primary ms-2" onclick="SubmitForm();">Agregar</button>
                              
                            </div>
                            </form>
                           
                    <?php ObtenerPendientes($SucursalUser,$Usuario);?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Widgets End -->


            <?php include("footer.php");?>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
 $( function() {
    var availableTags = [<?php echo $Codigo_Producto;?> ];
    $("#Producto" ).autocomplete({
      source: availableTags
    });
  } );
 

 
</body>

</html>
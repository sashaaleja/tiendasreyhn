<?php session_start();?>
<?php 
date_default_timezone_set('America/Tegucigalpa');
 include "functions.php";
 ConectarDB();
if(!isset($_SESSION["State"])){
    header("location:login.php");
}else{
    $Usuario = $_SESSION["UsuarioL"];
    $Email = $_SESSION["EmailL"];

}
$SQL = "SELECT * FROM usuarios WHERE Usuario = '$Usuario' OR Email='$Email'";
$table_productos= "";
if($resultado = ConectarDB()->query($SQL)){
    while($row = $resultado->fetch_assoc()){
       $Usuario = $row["Usuario"];
       $Email = $row["Email"];
       $PasswordC = $row["Clave"];
       $Nombre = $row["Nombre"];
       $Apellido = $row["Apellido"];
       $Privilegios = $row["Privilegios"];
       $Nombre_Completo = $Nombre." ".$Apellido;
       $Profile = $row["Perfil"];
       $Celular = $row["Celular"];
       $SucursalUser = $row["Sucursal"];

       
    }

}

$SQL3 = "SELECT * FROM stock";
if($resultado3 = ConectarDB()->query($SQL3)){
    while($row = $resultado3->fetch_assoc()){
     $Codigo = $row["Codigo"];
     $Nombre_Producto = $row["Nombre_Producto"];
     $Descripcion = $row["Descripcion"];
     $Precio_Compra = $row["Precio_Compra"];
     $Precio_Venta = $row["Precio_Venta"];
     $Categoria = $row["Categoria"];
     $Stock = $row["Stock"];
     $Sucursal = $row["Sucursal"];

     $table_productos .= "<tr>
                                   
                                    <td>$Codigo</td>
                                    <td>$Nombre_Producto</td>
                                    <td>$Descripcion</td>
                                    <td>$Precio_Compra</td>
                                    <td>$Precio_Venta</td>
                                    <td>$Categoria</td>
                                    <td>$Stock</td>
                                    <td>$Sucursal</td>
                                </tr>";

       
    }

}
$SQL3 = "SELECT * FROM stock";
if($resultado3 = ConectarDB()->query($SQL3)){
    while($row = $resultado3->fetch_assoc()){
     $Codigo = $row["Codigo"];
     $Nombre_Producto = $row["Nombre_Producto"];
     $Descripcion = $row["Descripcion"];
     $Precio_Compra = $row["Precio_Compra"];
     $Precio_Venta = $row["Precio_Venta"];
     $Categoria = $row["Categoria"];
     $Stock = $row["Stock"];
     $Sucursal = $row["Sucursal"];

     $table_productos .= "<tr>
                                   
                                    <td>$Codigo</td>
                                    <td>$Nombre_Producto</td>
                                    <td>$Descripcion</td>
                                    <td>$Precio_Compra</td>
                                    <td>$Precio_Venta</td>
                                    <td>$Categoria</td>
                                    <td>$Stock</td>
                                    <td>$Sucursal</td>
                                </tr>";

       
    }

}
$table_depositos = "";
$SQL4 = "SELECT * FROM depositos";
if($resultado4 = ConectarDB()->query($SQL4)){
    while($row = $resultado4->fetch_assoc()){
     $Codigo = $row["Codigo_Ref"];
     $Descripcion = $row["Descripcion"];
     $ValorDepositado = $row["Valor"];
     $Fecha_Deposito = $row["Fecha_Deposito"];
     $Hora_Deposito = $row["Hora_Deposito"];
     $SucursalDeposito = $row["Sucursal"];
$Banco = $row["Banco"];
$Depositante = $row["Depositante"];
     $table_depositos .= "<tr>
                                   
                                    <td>$Codigo</td>
                                    <td>$Descripcion</td>
                                     <td>$Depositante</td>
                                    <td>$ValorDepositado</td>
                                    <td>$Fecha_Deposito</td>
                                    <td>$Hora_Deposito</td>
                                     <td>$Banco</td>
                                    <td>$SucursalDeposito</td>
                                </tr>";

       
    }

}
 

if($Privilegios == "Admin"){
    $Navbar = "navbar_admin.php";
}else{
    $Navbar = "navbar_cajero.php";
}



$Hoy = date("Y-m-d");
if($resultadoventas = ConectarDB()->query("SELECT SUM(Total_A_Pagar) AS total
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
if($resultadoventas2 = ConectarDB()->query("SELECT SUM(Total_A_Pagar) AS totalventas
            FROM ventas")){
while($row = $resultadoventas2->fetch_assoc()){

$count = mysqli_num_rows($resultadoventas2);

if($count > 0 ){
    $TotalVentas = $row["totalventas"];
}else{
    $TotalVentas = "";
}

 
}

}

if($resultadocarritoventas = ConectarDB()->query("SELECT SUM(Total) AS totalcarrito
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

if($resultadocarritoventas2 = ConectarDB()->query("SELECT SUM(Total) AS total
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


if($resultadototaldepositos = ConectarDB()->query("SELECT SUM(Valor) AS totalvalor
FROM depositos")){
    while($rowtotal2 = $resultadototaldepositos->fetch_assoc()){
        $TotalDepositos = $rowtotal2["totalvalor"];
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Customized Bootstrap Stylesheet -->
   
  

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

            <!-- Sale & Revenue Start -->
            <?php include("sales_announcement.php");?>
            <!-- Sale & Revenue End -->

 
            <!-- Sales Chart End -->


            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Depositos</h6>
                        <a href="depositos_subida.php"> <button class="btn btn-success">Subir Depositos</button></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th scope="col">Codigo_Ref</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Depositante</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Fecha Deposito</th>
                                    <th scope="col">Hora Deposito</th>
                                    <th scope="col">Banco / Medio</th>
                                    <th scope="col">Sucursal</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php echo $table_depositos;?>
                            </tbody>
                        </table>
                        <br><br>
           
                    </div>
                    <h2>Total Depositado: L. <?php echo number_format($TotalDepositos,0);?></h2>
                    <a href="crear_depositos.php"> <button class="btn btn-success">Crear Depositos</button></a>
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


            <!-- Footer Start -->
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

</body>

</html>
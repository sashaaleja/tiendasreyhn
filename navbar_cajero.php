<?php 
$URL_ACTUAL = $_SERVER['REQUEST_URI'];

 if($URL_ACTUAL == "/users.php"){
    $ACTIVEU = "active";
 }else{
   $ACTIVEU = "";
 }
 if($URL_ACTUAL == "/empleados.php"){
    $ACTIVEEE= "active";
 }else{
   $ACTIVEEE = "";
 }
 if($URL_ACTUAL == "/etiquetas.php"){
    $ACTIVEE = "active";
 }else{
   $ACTIVEE = "";
 }
 if($URL_ACTUAL == "/index.php"){
    $ACTIVEH = "active";
 }else{
   $ACTIVEH = "";
 }
 if($URL_ACTUAL == "/promociones.php"){
    $ACTIVEP = "active";
 }else{
   $ACTIVEP = "";
 }

 if($URL_ACTUAL == "/vender.php"){
   $ACTIVEV = "active";
}else{
   $ACTIVEV = "";
 }
if($URL_ACTUAL == "/clientes.php"){
   $ACTIVEC = "active";
}else{
   $ACTIVEC = "";
 }


?>


<div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link <?php echo $ACTIVEH;?>"><i class="fa fa-tachometer-alt me-2"></i>Inicio</a>
                    <div class="nav-item dropdown">
                        <a href="index.php" class="nav-link dropdown-toggle <?php echo $ACTIVEV;?>" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Ventas y Caja</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="vender.php" class="dropdown-item">Vender</a>
                            <a href="abrir-caja.php" class="dropdown-item">Abrir Caja</a>
                            <a href="stock.php" class="dropdown-item">Ver Stock</a>
                            <a href="depositos.php" class="dropdown-item">Depositos</a>
                            <a href="tickets.php" class="dropdown-item">Tickets</a>
                            <a href="facturas.php" class="dropdown-item">Facturas</a>
                            <a href="reportes-ventas.php" class="dropdown-item">Reporte de ventas</a>
                            <a href="cierres-de-caja.php" class="dropdown-item">Cierres de caja</a>
                        </div>
                    </div>
                    <a href="venta-zapatos.php" class="nav-item nav-link <?php echo $ACTIVEEE;?>"><i class="fa fa-shopping-basket me-2"></i>Zapatos</a>
                    <a href="etiquetas.php" class="nav-item nav-link <?php echo $ACTIVEE;?>"><i class="fa fa-tags me-2"></i>Etiquetado</a>
                    <a href="venta-ofertas.php" class="nav-item nav-link <?php echo $ACTIVEEE;?>"><i class="fa fa-shopping-bag me-2"></i>Ofertas</a>
                    <a href="promociones.php" class="nav-item nav-link <?php echo $ACTIVEP;?>"><i class="fa fa-percent me-2"></i>Promociones</a>
                    <a href="promociones.php" class="nav-item nav-link <?php echo $ACTIVEC;?>"><i class="fa fa-users me-2"></i>Clientes</a>
                </div>
            </nav>
        </div>
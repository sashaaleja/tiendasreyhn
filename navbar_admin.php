<?php 
$URL_ACTUAL = $_SERVER['REQUEST_URI'];

 if($URL_ACTUAL == "/users.php"){
    $ACTIVEU = "active";
 }
 if($URL_ACTUAL == "/empleados.php"){
    $ACTIVEEE= "active";
 }
 if($URL_ACTUAL == "/etiquetas.php"){
    $ACTIVEE = "active";
 }
 if($URL_ACTUAL == "/index.php"){
    $ACTIVEH = "active";
 }
 if($URL_ACTUAL == "/promociones.php"){
    $ACTIVEP = "active";
 }
 if($URL_ACTUAL == "/salida-fardos.php"){
   $ACTIVEF = "active";
}

if($URL_ACTUAL == "/reporte_ventas_admin.php"){
   $ACTIVER = "active";
}

if($URL_ACTUAL == "/reportes_depositos_admin.php"){
   $ACTIVER = "active";
}

 
?>


<div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link <?php echo $ACTIVEH;?>"><i class="fa fa-tachometer-alt me-2"></i>Inicio</a>
                    <div class="nav-item dropdown">
                        <a href="index.php" class="nav-link dropdown-toggle <?php echo $ACTIVER;?>" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Reportes</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="reporte_ventas_admin.php" class="dropdown-item">Ventas</a>
                            <a href="reporte_inventario_admin.php" class="dropdown-item">Inventario</a>
                            <a href="reporte_sucursales_admin.php" class="dropdown-item">Sucursales</a>
                            <a href="reportes_depositos_admin.php" class="dropdown-item">Depositos</a>
                            <a href="reporte_fardos_admin.php" class="dropdown-item">Fardos</a>
                            <a href="reportes_facturas_admin.php" class="dropdown-item">Facturas</a>
                            <a href="reportes_tickets_admin.php" class="dropdown-item">Tickets</a>
                            <a href="reportes_tickets_admin.php" class="dropdown-item">Cierres de caja</a>
                        </div>
                    </div>
                    <a href="users.php" class="nav-item nav-link <?php echo $ACTIVEU;?>" ><i class="fa fa-users me-2"></i>Usuarios</a>
                    <a href="etiquetas.php" class="nav-item nav-link <?php echo $ACTIVEE;?>"><i class="fa fa-tags me-2"></i>Etiquetado</a>
                    <a href="empleados.php" class="nav-item nav-link <?php echo $ACTIVEEE;?>"><i class="fa fa-male me-2"></i>Empleados</a>
                    <a href="salida-fardos.php" class="nav-item nav-link <?php echo $ACTIVEF;?>"><i class="fa fa-truck me-2"></i>Fardos</a>
                    <a href="promociones.php" class="nav-item nav-link <?php echo $ACTIVEP;?>"><i class="fa fa-shopping-bag me-2"></i>Promociones</a>
                  
                </div>
            </nav>
        </div>
<?php
 include  "functions.php";
 

  
$Producto = $_POST['CodigoProducto'];
$Cantidad = $_POST['CantidadE'];

$Mysqli = new mysqli("localhost:3370","root","Filipenses413@","tiendasrey");
 
 
 $Img = "";
if($resultado = $Mysqli->query("SELECT * FROM stock WHERE Codigo = '$Producto'")){
    while($row = $resultado->fetch_assoc()){
        $codigo = $row['Codigo'];
        $nombre = $row['Nombre_Producto'];
        $precio = $row['Precio_Venta'];
         $barcode = "<img alt='$nombre'
         src='https://barcode.tec-it.com/barcode.ashx?data=$codigo&code=Code128&translate-esc=on' width='120px;'/>";

       for($i = 1; $i < $Cantidad; $i++){
         $Img .= "<table class='table' style='color:black;'>
            
         <thead>
         <tr>
         
         <td><img src='img/tiendasrey.jpg' width='150px' style='margin-top:0px;'><br>$nombre <br>L.$precio<br> $barcode</td>
         <td><img src='img/tiendasrey.jpg' width='150px' style='margin-top:0px;'><br>$nombre <br>L.$precio<br> $barcode</td>
         <td><img src='img/tiendasrey.jpg' width='150px' style='margin-top:0px;'><br>$nombre <br>L.$precio<br> $barcode</td>
         <td><img src='img/tiendasrey.jpg' width='150px' style='margin-top:0px;'><br>$nombre <br>L.$precio<br> $barcode</td>
         <td><img src='img/tiendasrey.jpg' width='150px' style='margin-top:0px;'><br>$nombre <br>L.$precio<br> $barcode</td>
          
         </tr>
         
         </thead>
         
         
         </table>";
         echo $Img;
       } 
    

    }

    	
}




   
?>
 <head>
 
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/print_elements.js"></script>
 </head>
 <body style="background:white; color:black;" class="section" onload="PrintElements.print(document.getElementsByClassName('table'));">
 <button type="button" class="btn btn-success print">
Print PDF with Message
</button>

<script>
 
 
  function printMe(element) {
     var printContent = element.innerHTML;
     var originalContent = window.document.body.innerHTML;
     window.document.body.innerHTML = printContent;
     window.print();
     window.document.body.innerHTML = originalContent;
}
 
 
</script>
 </body>

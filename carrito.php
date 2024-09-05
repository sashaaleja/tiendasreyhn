<?php
session_start();

// Conectar a la base de datos
$servername = "localhost:3370";
$username = "root";
$password = "Filipenses413@";
$dbname = "tiendasrey";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejar la búsqueda de productos
$search_query = "";
if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
}

// Manejar la adición al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

// Manejar la eliminación del carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
}

// Manejar la finalización de la compra
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['finalize_invoice'])) {
    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Insertar una nueva venta
        $sql = "INSERT INTO ventas () VALUES ()";
        $conn->query($sql);
        $venta_id = $conn->insert_id;

        // Insertar detalles de la venta
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $sql = "SELECT precio FROM productos WHERE id = $product_id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $precio = $row['precio'];

            $sql = "INSERT INTO detalles_venta (venta_id, producto_id, cantidad, precio)
                    VALUES ($venta_id, $product_id, $quantity, $precio)";
            $conn->query($sql);
        }

        // Confirmar la transacción
        $conn->commit();

        // Vaciar el carrito
        unset($_SESSION['cart']);

        echo "<div class='alert alert-success'>Compra finalizada con éxito. ID de venta: " . $venta_id . "</div>";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Factura con Bootstrap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Buscar Productos y Añadir al Carrito</h1>
        
        <!-- Formulario de búsqueda -->
        <form method="post" action="">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="search_query" name="search_query" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Buscar productos" required>
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" name="search" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Resultados de búsqueda -->
        <h2 class="mt-4">Resultados de Búsqueda</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Agregar al Carrito</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM stock WHERE Codigo LIKE '%" . $conn->real_escape_string($search_query) . "%'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row["Id"] . "</td>
                            <td>" . $row["Nombre_Producto"] . "</td>
                            <td>" . $row["Precio_Venta"] . "</td>
                            <td>
                                <form method='post' action=''>
                                    <input type='hidden' name='product_id' value='" . $row["Id"] . "'>
                                    Cantidad: <input type='number' class='form-control' name='quantity' min='1' value='1' style='width: 80px; display: inline-block;'>
                                    <button type='submit' name='add_to_cart' class='btn btn-success'>Agregar</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No se encontraron productos</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Carrito de compras -->
        <h2 class="mt-4">Carrito de Compras</h2>
        <?php
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $total = 0;
            echo "<table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>";

            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $sql = "SELECT * FROM stock WHERE Id = '$product_id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $subtotal = $row['Precio_Venta'] * $quantity;
                    $total += $subtotal;

                    echo "<tr>
                        <td>" . $row["Id"] . "</td>
                        <td>" . $row["Nombre_Producto"] . "</td>
                        <td>" . $row["Precio_Venta"] . "</td>
                        <td>" . $quantity . "</td>
                        <td>" . $subtotal . "</td>
                    </tr>";
                }
            }

            echo "</tbody>
                <tfoot>
                    <tr>
                        <td colspan='4'>Total</td>
                        <td>" . $total . "</td>
                    </tr>
                </tfoot>
            </table>";

            echo "<form method='post' action=''>
                <button type='submit' name='clear_cart' class='btn btn-danger'>Vaciar Carrito</button>
                <button type='submit' name='finalize_invoice' class='btn btn-primary'>Finalizar Compra</button>
            </form>";
        } else {
            echo "<p>No hay productos en el carrito.</p>";
        }

        $conn->close();
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
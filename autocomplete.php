<?php
$servername = "localhost:3370";
$username = "root";
$password = "Filipenses413@";
$dbname = "tiendasrey";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['term'])) {
    $term = $conn->real_escape_string($_GET['term']);
    $sql = "SELECT Id, Codigo FROM stock WHERE Codigo LIKE '%$term%'";
    $result = $conn->query($sql);

    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = [
            'Id' => $row['Id'],
            'Codigo' => $row['Codigo']
        ];
    }

    echo json_encode($suggestions);
}

$conn->close();
?>
<?php 
// Database configuration 
$dbHost     = "localhost:3378"; 
$dbUsername = "root"; 
$dbPassword = "Filipenses413@"; 
$dbName     = "tiendasrey"; 
 
// Create database connection 
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
 
// Check connection 
if ($db->connect_error) { 
    die("Connection failed: " . $db->connect_error); 
} 
 
// Get search term 
$searchTerm = $_GET['term']; 
 
// Fetch matched data from the database 
$query = $db->query("SELECT * FROM stock WHERE Codigo LIKE '%".$searchTerm."%'  ORDER BY Codigo  ASC"); 
 
// Generate array with skills data 
$skillData = array(); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $data['id'] = $row['Id']; 
        $data['value'] = $row['Codigo']; 
        array_push($skillData, $data); 
    } 
} 
 
// Return results as json encoded array 
echo json_encode($skillData); 
?>
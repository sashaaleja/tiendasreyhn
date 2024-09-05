<?PHP
/* Set the correct header */
header('Content-type: application/json');

define("MySQL_HOST", "localhost:3370");
define("MySQL_DATABASE", "tiendasrey");
define("MySQL_TABLE", "stock");
define("MySQL_USER", "root");
define("MySQL_PASSWORD", "Filipenses413");
define("REQUEST", $_GET['q']);

$rows = array();

/* Connecting to the databse*/
$mysqli = mysqli_connect(MySQL_HOST, MySQL_USER, MySQL_PASSWORD, MySQL_DATABASE) or
    die('Could not connect: ' . mysql_error());

/* Select the correct row in the table according to the request*/
$result = $mysqli->query("SELECT Codigo FROM stock where (Codigo like '".REQUEST."%') OR (Nombre_Producto '".REQUEST."%') order by Codigo");

/* Stuff the records into an array to be used later by json_encode() */
while($r = mysqli_fetch_assoc($result)) 
  $rows[] = $r['Codigo'];

/* Print out a json verion of the array. */
print json_encode($rows);

/* Free result set */
$result->close();

/* Close MySQLi connection */
$mysqli->close();


?>
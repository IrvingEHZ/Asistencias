<?php
// Realizar la conexión a la base de datos (XAMPP)
$servername = "localhost";
$username = "root";
$password = "";
$database = "registros";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta para obtener los datos de la base de datos
$query = "SELECT * FROM registros";
$result = $conn->query($query);

// Encabezados para el archivo CSV
$headers = array("Numero de Control", "Hora de Entrada", "Hora de Salida");

// Abrir la salida como archivo CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="registros.csv"');

$output = fopen('php://output', 'w');

// Agregar encabezados al archivo CSV
fputcsv($output, $headers);

// Agregar los datos de la base de datos al archivo CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

// Eliminar los registros de la base de datos
$deleteQuery = "DELETE FROM registros";
$conn->query($deleteQuery);

// Cerrar la conexión a la base de datos
$conn->close();
?>

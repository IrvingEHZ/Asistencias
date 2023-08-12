<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_control = $_POST["numero_control"];
    $accion = $_POST["accion"]; // Obtener la acción (entrada o salida)

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

    try {
        if ($accion == "entrada") {
            // Verificar si ya existe un registro de entrada para el número de control
            $entrada_existente = "SELECT * FROM registros WHERE numero_control = '$numero_control' AND hora_salida IS NULL";
            $result = $conn->query($entrada_existente);

            if ($result->num_rows > 0) {
                header("Location: asistencias.html?mensaje=Ya%20se%20ha%20registrado%20una%20entrada%20para%20este%20número%20de%20control.&tipo=error");

            } else {
                // Registrar entrada
                $sql = "INSERT INTO registros (numero_control, hora_entrada) VALUES ('$numero_control', NOW())";
                $conn->query($sql);
                // Agrega un parámetro a la URL de redirección
                header("Location: asistencias.html?mensaje=Registro%20exitoso.%20Biemvenido%20Leon.&tipo=exito");
                exit(); // Asegura que el script se detenga después de la redirección
            }

        } elseif ($accion == "salida") {
            // Verificar si ya existe un registro de salida para el número de control
            $salida_existente = "SELECT * FROM registros WHERE numero_control = '$numero_control' AND hora_entrada IS NOT NULL";
            $result = $conn->query($salida_existente);

            if ($result->num_rows > 0) {
                // Registrar salida
                $sql = "UPDATE registros SET hora_salida = NOW() WHERE numero_control = '$numero_control' AND hora_salida IS NULL";
                $conn->query($sql);

                header("Location: asistencias.html?mensaje=Registro%20de%20salida%20exitoso.%20Hazta%20pronto%20:3.&tipo=exito");
            } else {
                header("Location: asistencias.html?mensaje=No%20se%20puede%20registrar%20la%20salida.%20No%20hay%20registro%20de%20entrada%20correspondiente%20>:v&tipo=error");

                echo "<div class='error-message'>No se puede registrar la salida. No hay registro de entrada correspondiente.</div>";
            }
        }
    } catch (mysqli_sql_exception $ex) {
        echo "<div class='error-message'>Error al registrar: " . $ex->getMessage() . "</div>";
    }

    // Cerrar la conexión
    $conn->close();
}
?>

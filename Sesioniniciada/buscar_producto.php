<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_query'])) {
    $search_query = $_POST['search_query'];

    require_once('Conexion.php'); // Reemplaza 'ConexionDB.php' con la ruta correcta

    $conexionDB = new ConexionDB();
    $conexion = $conexionDB->getConexion();

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Escapar caracteres especiales para prevenir SQL injection
    $search_query = $conexion->real_escape_string($search_query);

    // Consulta para buscar coincidencias en el nombre del producto
    $sql = "SELECT * FROM productos WHERE NombreProduct LIKE '%$search_query%'";
    $result = $conexion->query($sql);

    if ($result) {
        // Mostrar resultados
        while ($row = $result->fetch_assoc()) {
            // Aquí puedes mostrar los resultados como desees
            echo $row['NombreProduct'] . "<br>";
        }
    } else {
        echo "Error en la consulta: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexionDB->cerrarConexion();
}
?>

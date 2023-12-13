<?php
include('Conexion.php'); // Incluye el archivo de conexión

$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();

// Actualizar la columna 'activo' a 0
$sql = "UPDATE User SET activo = 0 WHERE activo = 1";
if ($conexion->query($sql) === TRUE) {
    // Redirigir al usuario a la página de inicio de sesión o a donde desees después de cerrar sesión
    header("Location: ../Sesionsininiciar/pregunta.html");
} else {
    echo "Error al cerrar sesión: " . $conexion->error;
}

$conexionDB->cerrarConexion(); // Cierra la conexión a la base de datos
?>

<?php
session_start();

echo"hola";
// Verificar si se recibe una solicitud POST para eliminar el carrito completo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Incluir el archivo de conexión
    require 'conexion.php';

    // Crear una instancia de la conexión
    $conexion = ConexionDB::getConexion();

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Preparar la consulta SQL para eliminar todo el contenido del carrito
    $consulta = $conexion->prepare("DELETE FROM Carrito");

    // Ejecutar la consulta
    if ($consulta->execute()) {
        // Éxito al vaciar el carrito
        http_response_code(200); // Indicar éxito
    } else {
        // Error al vaciar el carrito
        http_response_code(500); // Indicar error
    }

    // Cerrar la conexión y la consulta preparada
    $consulta->close();
    $conexion->close();
} else {
    http_response_code(405); // Si no es una solicitud POST, indicar método no permitido
}
?>

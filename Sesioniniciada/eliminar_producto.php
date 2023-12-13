<?php
session_start();

// Verificar si se recibe una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se envió el ID del producto a eliminar
    if (isset($_POST['idProducto'])) {
        $idProducto = $_POST['idProducto'];

        require 'conexion.php';

        // Crear una instancia de la conexión
        $conexion = ConexionDB::getConexion();
    
        // Verificar la conexión
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Preparar la consulta SQL para eliminar el producto del carrito
        $consulta = $conexion->prepare("DELETE FROM Carrito WHERE ID_Producto_Carrito = ?");
        $consulta->bind_param("i", $idProducto);

        // Ejecutar la consulta
        if ($consulta->execute()) {
            // Éxito al eliminar el producto
            http_response_code(200); // Indicar éxito
        } else {
            // Error al eliminar el producto
            http_response_code(500); // Indicar error
        }

        // Cerrar la conexión y la consulta preparada
        $consulta->close();
        $conexion->close();
    } else {
        http_response_code(400); // Si no se proporciona el ID del producto, indicar error
    }
} else {
    http_response_code(405); // Si no es una solicitud POST, indicar método no permitido
}
?>

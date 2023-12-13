<?php
// Verificar si se ha enviado un ID de producto
if (isset($_POST['idProducto'])) {
    // Tu lógica de conexión a la base de datos
    require 'Conexion.php';

    // Obtener el ID del producto a eliminar
    $idProducto = $_POST['idProducto'];

    // Crear una instancia de la clase de conexión
    $conexionDB = new ConexionDB();
    $conexion = $conexionDB->getConexion();

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta para eliminar el producto del carrito
    $query = "DELETE FROM Carrito WHERE ID_Carrito = $idProducto";
    $resultado = $conexion->query($query);

    // Cerrar la conexión
    $conexion->close();

    // Redirigir a la página del carrito después de eliminar
    header("Location: Carrito.php");
    exit();
}
?>

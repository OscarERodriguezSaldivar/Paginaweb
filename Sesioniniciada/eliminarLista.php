<?php
include 'conexion.php'; // Incluye tu archivo de conexión

$conexionDB = new ConexionDB();

// Verifica si se ha enviado un ID de lista a eliminar
if (isset($_GET['id_lista'])) {
    $id_lista = $_GET['id_lista'];

    // Eliminar productos asociados a la lista de la tabla productosLista
    $eliminar_productos_sql = "DELETE FROM productosLista WHERE Id_ListaMadre = $id_lista";
    if ($conexionDB->getConexion()->query($eliminar_productos_sql) === TRUE) {
        // Eliminar la lista de la tabla listas
        $eliminar_lista_sql = "DELETE FROM lista WHERE ID_Lista = $id_lista";
        if ($conexionDB->getConexion()->query($eliminar_lista_sql) === TRUE) {
            header("Location: Listas.php");
        } else {
            echo "Error al eliminar la lista: " . $conexionDB->getConexion()->error;
        }
    } else {
        echo "Error al eliminar los productos asociados a la lista: " . $conexionDB->getConexion()->error;
    }
} else {
    echo "No se proporcionó un ID de lista para eliminar.";
}

$conexionDB->cerrarConexion(); // Cerrar la conexión a la base de datos
?>

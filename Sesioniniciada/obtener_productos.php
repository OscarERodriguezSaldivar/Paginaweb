<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require('conexion.php'); // Incluye el archivo de conexión

$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();

// Obtener el ID del usuario activo
$usuario_activo_sql = "SELECT ID_User FROM User WHERE activo = 1";
$result_usuario_activo = $conexion->query($usuario_activo_sql);

if ($result_usuario_activo->num_rows === 1) {
    $row_usuario_activo = $result_usuario_activo->fetch_assoc();
    $rowIdUser = $row_usuario_activo['ID_User'];

    // Verifica el tipo de usuario (asegúrate de obtener el tipo de usuario de alguna manera)
    if (isset($_SESSION['user-tipe']) && $_SESSION['user-tipe'] == 1) {
        $productos_sql = "SELECT p.ID_Producto, p.NombreProduct, p.DescripcionProduct, p.Precio, p.CantDisponible, MAX(i.Imagen) AS Imagen
        FROM Productos p
        LEFT JOIN Imagenes i ON p.ID_Producto = i.ID_Producto
        WHERE p.RowIdUser = $rowIdUser AND i.video = 0 AND p.Eliminado =0
        GROUP BY p.ID_Producto";

        $result_productos = $conexion->query($productos_sql);

        // Ahora puedes recorrer los resultados y mostrar los productos y la primera imagen de cada producto.
        if ($result_productos->num_rows > 0) {
            while ($row_producto = $result_productos->fetch_assoc()){
              $ID_Producto= $row_producto['ID_Producto'];
                echo "<div class='col'>
                        <div class='card shadow-sm'>
                          <img src=".$row_producto['Imagen']." width='100%' height='225'>
                          <div class='card-body'>
                            <dt><p class='Nombre-producto'>" . $row_producto['NombreProduct'] . "</p></dt>
                            <p class='Descripcion-producto'>" . $row_producto['DescripcionProduct'] . "</p>
                            <p class='product__price'>$" . $row_producto['Precio'] . "</p>
                            <div class='d-flex justify-content-between align-items-center'>
                              
                            <a type='button' class='btn btn-sm btn-outline-secondary' href='eliminarproducto.php?id=". $row_producto['ID_Producto'] . "'>Eliminar</a>
                              
                            </div>
                          </div>
                        </div>
                      </div>";
            }
        } else {
            echo "No se encontraron productos para el usuario activo.";
        }
        $conexionDB->cerrarConexion();
    } else {
        echo "No tienes permiso para ver esta página.";
    }
} else {
    echo "Error: No se encontró un usuario activo.";
}
?>

<script>
function eliminarproducto(ID_Producto) {
  echo "entre";
    // Redireccionar a eliminarLista.php con el ID de la lista como parámetro
    window.location.href = `eliminarproducto.php?ID_Producto=${ID_Producto}`;
}
</script>
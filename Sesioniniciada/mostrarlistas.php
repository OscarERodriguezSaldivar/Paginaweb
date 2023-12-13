<?php
// Realiza la conexión a la base de datos (usando tu método preferido)
include 'conexion.php'; // Suponiendo que aquí se realiza la conexión

$conexionDB = new ConexionDB();

// Obtén el ID del usuario activo
$usuario_activo_sql = "SELECT ID_User FROM User WHERE activo = 1";
$result_usuario_activo = $conexionDB->getConexion()->query($usuario_activo_sql);

if ($result_usuario_activo->num_rows === 1) {
    $row_usuario_activo = $result_usuario_activo->fetch_assoc();
    $rowIdUser = $row_usuario_activo['ID_User'];
} else {
    echo "Error: No se encontró un usuario activo.";
    exit();
}
// Consulta para obtener las listas del usuario activo
$sql = "SELECT * FROM lista WHERE ID_User_Lista = $rowIdUser";
$result = $conexionDB->getConexion()->query($sql); // Updated variable name to use correct connection instance

// Verifica si hay resultados y muestra la información en HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ID_Lista = $row['ID_Lista'];
        $NombreLista = $row['NombreLista'];
        // Otras columnas que desees mostrar...

        // Aquí generas el HTML para cada lista con la información obtenida
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo "<dt><p class='Nombre-lista'>$NombreLista</p></dt>";
        echo '<div class="d-flex justify-content-between align-items-center">';
        echo '<div class="btn-group">';
        echo "<a type='button' class='btn btn-sm btn-outline-secondary' href='DetallesLista.php?id=$ID_Lista'>Ver</a>";
        echo "<button type='button' class='btn btn-sm btn-outline-secondary red' onclick='eliminarLista($ID_Lista)'>Eliminar</button>";
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No se encontraron listas para este usuario.";
}

// Cierra la conexión a la base de datos al terminar
$conexionDB->cerrarConexion(); // Use the correct method to close the connection
?>

<!-- Script JavaScript para redirigir al archivo eliminarLista.php con el ID_Lista -->
<script>
function eliminarLista(idLista) {
    // Redireccionar a eliminarLista.php con el ID de la lista como parámetro
    window.location.href = `eliminarLista.php?id_lista=${idLista}`;
}
</script>
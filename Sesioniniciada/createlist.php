<?php
include 'conexion.php';

// Crear una instancia de la clase ConexionDB
$conexionDB = new ConexionDB();

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene el ID del usuario activo (asumiendo que se trata del usuario con ID 1)
    $usuario_activo_sql = "SELECT ID_User FROM User WHERE activo = 1";
    $result_usuario_activo = $conexionDB->getConexion()->query($usuario_activo_sql);

    if ($result_usuario_activo->num_rows === 1) {
        $row_usuario_activo = $result_usuario_activo->fetch_assoc();
        $rowIdUser = $row_usuario_activo['ID_User'];
    } else {
        echo "Error: No se encontró un usuario activo.";
        exit();
    }

    // Procesamiento de la imagen (subir a servidor o almacenar la ruta en la base de datos)
    $nombreLista = $_POST['nombreLista'];
    $imagen = $_FILES['imagen']['tmp_name']; // Archivo de imagen temporal
    $nombreImagen = $_FILES['imagen']['name']; // Nombre original de la imagen

    // Ruta donde se guardará la imagen
    $directorio_destino = 'imgs/' . $nombreImagen;

    // Mueve la imagen a la carpeta destino
    if (move_uploaded_file($imagen, $directorio_destino)) {
        // Lee el contenido de la imagen y conviértelo a un formato adecuado para la base de datos
        $imagen_binaria = addslashes(file_get_contents($directorio_destino));

        // Inserta los datos en la tabla lista
        $sql = "INSERT INTO lista (NombreLista, ID_User_Lista, imagen) VALUES ('$nombreLista', '$rowIdUser', '$imagen_binaria')";

        if ($conexionDB->getConexion()->query($sql) === TRUE) {
            // echo "Datos insertados correctamente";
            header("Location: Home.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conexionDB->getConexion()->error;
        }
    } else {
        echo "Error al mover el archivo a la carpeta destino.";
    }
} else {
    echo "Error: El formulario no ha sido enviado correctamente.";
}

// Cerrar la conexión a la base de datos al terminar
$conexionDB->cerrarConexion();
?>

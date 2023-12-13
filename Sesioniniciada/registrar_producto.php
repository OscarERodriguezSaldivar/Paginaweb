<?php
session_start();

require('conexion.php'); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexionDB = new ConexionDB();
    $conexion = $conexionDB->getConexion();

    // Antes de la sección donde obtienes los datos del formulario y subes las imágenes y el video, realiza una consulta para obtener el valor de RowIdUser donde activo sea igual a 1.
    $usuario_activo_sql = "SELECT ID_User FROM User WHERE activo = 1";
    $result_usuario_activo = $conexion->query($usuario_activo_sql);

    if ($result_usuario_activo->num_rows === 1) {
        $row_usuario_activo = $result_usuario_activo->fetch_assoc();
        $rowIdUser = $row_usuario_activo['ID_User'];
    } else {
        echo "Error: No se encontró un usuario activo.";
        exit();
    }

    // Obtener los datos del formulario
    $nombre = $_POST['name'];
    $descripcion = $_POST['Descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $cantidad = $_POST['cantidad'];
    $ID_Proveedor = $_POST['proveedor'];
    $rowIdUser = $row_usuario_activo['ID_User'];
    $rating = $_POST['calificacion'];

    // Carpeta de destino para imágenes
    $carpeta_imagenes = "imgs/";
    $imagenes = [];

    for ($i = 0; $i < 3; $i++) {
        $imagen_tmp = $_FILES['imagenes']['tmp_name'][$i];
        $imagen_nombre = $_FILES['imagenes']['name'][$i];
        $ruta_imagen = $carpeta_imagenes . $imagen_nombre;

        if (move_uploaded_file($imagen_tmp, $ruta_imagen)) {
            $imagenes[] = $ruta_imagen;
        }
    }

    // Carpeta de destino para el video
    $carpeta_videos = "imgs/";
    $video_tmp = $_FILES['video']['tmp_name'];
    $video_nombre = $_FILES['video']['name'];
    $ruta_video = $carpeta_videos . $video_nombre;
    $videoF = 0;
    $videoT = 1;

    if (move_uploaded_file($video_tmp, $ruta_video)) {
        // Insertar datos en la tabla Productos
        $sql = "INSERT INTO Productos (NombreProduct, DescripcionProduct, Precio, RowDate, CantDisponible, Rating, RowIdUser, ID_Proveedor, ID_Categoria) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssiiiiii", $nombre, $descripcion, $precio, $cantidad, $rating, $rowIdUser, $ID_Proveedor, $categoria);

        if ($stmt->execute()) {
            $producto_id = $stmt->insert_id; // Obtener el ID del producto recién insertado

            // Insertar datos en la tabla Imagenes
            $sql_imagenes = "INSERT INTO Imagenes (ID_Producto, Imagen, video) VALUES (?, ?, ?)";
            $stmt_imagenes = $conexion->prepare($sql_imagenes);

            foreach ($imagenes as $imagen) {
                $stmt_imagenes->bind_param("isi", $producto_id, $imagen, $videoF);
                $stmt_imagenes->execute();
            }

            // Insertar el video en la tabla Imagenes
            $stmt_imagenes->bind_param("isi", $producto_id, $ruta_video, $videoT);
            $stmt_imagenes->execute();

            // Producto registrado con éxito
            header("Location: Home.php");
        } else {
            echo "Error al registrar el producto en la base de datos: " . $stmt->error;
        }

        $stmt->close();
        $stmt_imagenes->close();
    } else {
        echo "Error al mover el archivo de video.";
    }

    $conexionDB->cerrarConexion(); // Cierra la conexión utilizando el método de la clase
}
?>

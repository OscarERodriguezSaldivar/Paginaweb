<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateProfile'])) {
    // Verifica que los datos se hayan enviado correctamente a través del formulario POST
    if (isset($_POST['newUserName']) && isset($_FILES['newUserAvatar'])) {
        // Obtén los valores del formulario
        $newUserName = $_POST['newUserName'];
        $newUserAvatar = $_FILES['newUserAvatar'];

        // Conecta a la base de datos
        require_once('conexion.php');
        $conexionDB = new ConexionDB();
        $conexion = $conexionDB->getConexion();

        // Escapa los datos para evitar SQL Injection
        $newUserName = $conexion->real_escape_string($newUserName);

        // Obtén el nombre de usuario anterior de la sesión
        $oldUserName = $_SESSION['user-name'];

        // Procesa la imagen y súbela al servidor
        $uploadDir = './imgs/'; // Establece la ruta donde deseas guardar la imagen
        $newUserAvatarPath = $uploadDir . $newUserAvatar['name'];

        if (move_uploaded_file($newUserAvatar['tmp_name'], $newUserAvatarPath)) {
            // Actualiza la base de datos
            $sql = "UPDATE User SET Nombre = '$newUserName', imgperfil = '$newUserAvatarPath' WHERE NomUsuario = '$oldUserName'";

            if ($conexion->query($sql) === true) {
                // Actualiza la variable de sesión con el nuevo nombre
                $_SESSION['user-name'] = $newUserName;
                $_SESSION['user-avatar'] = $newUserAvatarPath;
                // Redirige al perfil actualizado
                header("Location: Home.php");
            } else {
                // Maneja el error, por ejemplo, muestra un mensaje de error o redirige a una página de error
                echo "Error en la actualización: " . $conexion->error;
                header("Location: Home.php");
            }
        } else {
            // Maneja el error de carga de la imagen, muestra un mensaje o realiza el manejo de errores que prefieras
            echo "Error al subir la imagen.";
        }

        // Cierra la conexión a la base de datos
        $conexionDB->cerrarConexion();
    }
} else {
    // Maneja el caso en que no se usó el método POST (debes decidir qué hacer en este caso)
}
?>

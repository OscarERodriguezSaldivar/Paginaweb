<?php
class ConexionDB {
    private $host = "";
    private $usuario = "";
    private $contrasena = "";
    private $base_datos = "";
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->contrasena, $this->base_datos);
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function insertarUsuario($nombre, $ApellidoP, $ApellidoM, $correo, $NomUsuario, $contra, $fechaNacimiento, $fechaIngreso, $ID_Rol, $ID_Proveedor, $imgperfil, $TipeUser, $activo) {
        // Convertir las fechas al formato 'YYYY-MM-DD'
        $fechaNacimiento = date("Y-m-d", strtotime($fechaNacimiento));
        $fechaIngreso = date("Y-m-d", strtotime($fechaIngreso));

        // Preparar la sentencia SQL para la inserción
        $sql = "INSERT INTO User (nombre, ApellidoP, ApellidoM, NomUsuario, FechaNacimiento, ID_Proveedor, ID_Rol, correo, contra, FechaIngreso, imgperfil, TipeUser, activo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia SQL
        $stmt = $this->conexion->prepare($sql);
        if ($stmt) {
            // Vincular los parámetros
            $stmt->bind_param("sssssiissssii", $nombre, $ApellidoP, $ApellidoM, $NomUsuario, $fechaNacimiento, $ID_Proveedor, $ID_Rol, $correo, $contra, $fechaIngreso, $imgperfil, $TipeUser, $activo);

            // Ejecutar la sentencia
            if ($stmt->execute()) {
                return true; // Éxito en la inserción
            } else {
                return false; // Error en la inserción
            }

            // Cerrar la sentencia
            $stmt->close();
        } else {
            return false; // Error en la preparación de la sentencia
        }
    }

    public function cerrarConexion() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}

// Crear una instancia de la ConexionDB class para establecer la conexión
$conexionDB = new ConexionDB();

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $nombre = $_POST["name"];
    $ApellidoP = $_POST["ApellidoP"];
    $ApellidoM = $_POST["ApellidoM"];
    $correo = $_POST["email"];
    $NomUsuario = $_POST["username"];
    $contra = $_POST["password"];
    $ID_Rol = $_POST["roltipe"];
    $fechaNacimiento = $_POST["nacimiento"];
    $fechaIngreso = $_POST["ingreso"];
    $ID_Proveedor = $_POST["Idproveedor"];
    $imgperfil = $_POST["avatar"];
    $TipeUser = $_POST["rolUs"];
    $activo = 0;

    // Validar la contraseña
    if (validarContraseña($contra)) {
        // Insertar el usuario en la base de datos
        if ($conexionDB->insertarUsuario($nombre, $ApellidoP, $ApellidoM, $correo, $NomUsuario, $contra, $fechaNacimiento, $fechaIngreso, $ID_Rol, $ID_Proveedor, $imgperfil, $TipeUser, $activo)) {
            echo "Registro exitoso. Redirigiendo...";
            header("Location: pregunta.html"); // Redirige a la página de inicio después del registro
            exit();
        } else {
            header("Location: registro.html");
        }
    } else {
        echo "La contraseña no cumple con los requisitos.";
        header("Location: registro.html");
    }
}

// Función para validar la contraseña
function validarContraseña($contraseña) {
    // Utiliza una expresión regular para validar la contraseña
    $patron = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!¿?.,:;-])\S{8,}$/";

    if (preg_match($patron, $contraseña)) {
        return true; // La contraseña cumple con los requisitos
    } else {
        return false; // La contraseña no cumple con los requisitos
    }
}



// Cerrar la conexión a la base de datos
$conexionDB->cerrarConexion();
?>


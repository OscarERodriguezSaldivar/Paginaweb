<?php
include('Conexion.php');

class VerificacionLogin {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function verificarCredenciales($usuario, $contrasena) {
        $sql = "SELECT NomUsuario, imgperfil, ID_Rol, TipeUser FROM User WHERE NomUsuario = ? AND contra = ?";
        $stmt = $this->conexion->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param("ss", $usuario, $contrasena);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows == 1) {
                // Credenciales correctas, obtén los resultados de la consulta
                $row = $result->fetch_assoc();
    
                session_start();
                $_SESSION['user-avatar'] = $row['imgperfil'];
                $_SESSION['user-name'] = $row['NomUsuario'];
                $_SESSION['user-rol'] = $row['ID_Rol'];
                $_SESSION['user-tipe'] = $row['TipeUser'];
    
                // Actualizar la columna 'activo' a 1
                $sql_update_activo = "UPDATE User SET activo = 1 WHERE NomUsuario = ?";
                $stmt_update_activo = $this->conexion->prepare($sql_update_activo);
                $stmt_update_activo->bind_param("s", $usuario);
                $stmt_update_activo->execute();
    
                // Redirigir a la página perfil.html
                header("Location: ../Sesioniniciada/Home.php");
                exit();
            } else {
                // Credenciales incorrectas, mostrar un mensaje de error
                header("Location: iniciosesion.html");
            }
    
            $stmt->close();
        } else {
            echo "Error en la preparación de la sentencia: " . $this->conexion->error;
        }
    }
    
    
}

// Crear una instancia de la clase VerificacionLogin
$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();
$verificacionLogin = new VerificacionLogin($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuarioVer = $_POST["username"];
    $contrasenaVer = $_POST["password"];

    // Llamar al método verificarCredenciales con los datos del formulario
    $verificacionLogin->verificarCredenciales($usuarioVer, $contrasenaVer);
}

// Cerrar la conexión a la base de datos
$conexionDB->cerrarConexion();
?>

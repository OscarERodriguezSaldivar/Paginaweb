<?php
session_start();

// Verificar si se proporciona un ID de producto en la URL
if (isset($_GET['id'])) {
  $idProducto = $_GET['id'];

  // Incluir el archivo de conexión
  require 'Conexion.php';

  // Crear una instancia de la clase de conexión
  $conexionDB = new ConexionDB();
  $conexion = $conexionDB->getConexion();

  // Verificar la conexión
  if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
  }

  // Query para obtener la información del producto por su ID
  $query = "UPDATE `bdm`.`productos` SET `Eliminado` = '1' WHERE (`ID_Producto` = '$idProducto');";




  $resultado = $conexion->query($query);

  header("Location: Listas.php");
  // Verificar si se obtuvieron resultados
  
  
} else {
  // Si no se proporciona un ID de producto, puedes mostrar un mensaje de error o redirigir a otra página.
  echo "ID de producto no proporcionado.";
}
?>
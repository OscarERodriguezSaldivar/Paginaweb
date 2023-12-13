<?php
// Verificar si se han enviado los datos del producto por GET
if (isset($_GET['id'], $_GET['nombre'], $_GET['precio'])) {
  // Obtener los datos del producto desde la URL
  $idProducto = $_GET['id'];
  $nombreProducto = $_GET['nombre'];
  $precioProducto = $_GET['precio'];
  $cantidad = 1; // Cantidad predeterminada al agregar al carrito, podrías ajustar esto según lo necesites

  // Tu lógica de conexión a la base de datos
  require 'Conexion.php';

  // Crear una instancia de la clase de conexión
  $conexionDB = new ConexionDB();
  $conexion = $conexionDB->getConexion();

  // Verificar la conexión
  if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
  }

  // Preparar la consulta para insertar el producto en la tabla Carrito
  $stmt = $conexion->prepare("INSERT INTO Carrito (ID_Producto_Carrito, NombreProduct, Precio, Cant) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("issi", $idProducto, $nombreProducto, $precioProducto, $cantidad);

  // Ejecutar la consulta
  if ($stmt->execute()) {
    // La inserción fue exitosa
    header("Location: Home.php"); // Redireccionar a la página del carrito o a donde desees
    exit();
  } else {
    // Error al insertar el producto
    echo "Error: No se pudo agregar el producto al carrito.";
  }

  // Cerrar la conexión y la declaración preparada
  $stmt->close();
  $conexion->close();
} else {
  // Si no se proporcionan todos los datos necesarios, mostrar un mensaje de error o redirigir a otra página
  echo "Error: Datos del producto no proporcionados correctamente.";
}
?>

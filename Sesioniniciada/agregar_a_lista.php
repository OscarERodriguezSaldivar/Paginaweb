<?php
// Incluye tu archivo de conexión
include 'conexion.php';
$conexionDB = new ConexionDB();
  

// Verifica si se han enviado los datos necesarios
if (
  isset($_POST['idLista'], $_POST['idProducto'], $_POST['nombreProducto'], $_POST['precioProducto'])
) {
  // Obtiene los datos del formulario
  $idLista = $_POST['idLista'];
  $idProducto = $_POST['idProducto'];
  $nombreProducto = $_POST['nombreProducto'];
  $precioProducto = $_POST['precioProducto'];

  // Inserta el producto en la tabla productosLista
  $sqlInsert = "INSERT INTO productosLista (Id_ListaMadre, Id_Producto, nombreProducto, precio) VALUES ('$idLista', '$idProducto', '$nombreProducto', '$precioProducto')";

  if ($conexionDB->getConexion()->query($sqlInsert) === TRUE) {
    header("Location: Home.php"); // Redirige a la página principal u otro destino deseado
  } else {
    echo "Error al agregar el producto a la lista: " . $conexionDB->getConexion()->error;
  }
} else {
  echo "Faltan datos para agregar el producto a la lista.";
}

// Cierra la conexión a la base de datos
$conexionDB->cerrarConexion();
?>

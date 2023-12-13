<?php
// Obtener el ID del usuario activo desde la base de datos
include 'conexion.php'; // Tu archivo de conexión
$conexionDB = new ConexionDB();
echo "entre";

// Procesar el formulario y realizar la inserción en la tabla Ord_Compra
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "entre2";
    
    $usuario_activo_sql = "SELECT ID_User FROM User WHERE activo = 1";
    $result_usuario_activo = $conexionDB->getConexion()->query($usuario_activo_sql);

    if ($result_usuario_activo->num_rows === 1) {
        $row_usuario_activo = $result_usuario_activo->fetch_assoc();
        $rowIdUser = $row_usuario_activo['ID_User'];
    } else {
        echo "Error: No se encontró un usuario activo.";
        exit();
    }

    $direccion = $_POST["address"];
    $nombreTarjeta = $_POST["cc-name"];
    $tarjeta = $_POST["cc-number"];
    $expdate = $_POST["cc-expiration"];
    $cvv = $_POST["cc-cvv"];
    $subtotal = $_POST["subtotal"]; // Recibiendo el subtotal del formulario

    // Realizar la inserción en la tabla Ord_Compra
    $conexionDB = new ConexionDB(); // Crear instancia de la conexión

    // Consulta SQL para insertar los datos en la tabla Ord_Compra
    $sql = "INSERT INTO Ord_Compra (subtotal, ID_Cliente_OrdCompra, direccion, nombretarjeta, tarjeta, cvv, expdate)
            VALUES ('$subtotal', $rowIdUser, '$direccion', '$nombreTarjeta', '$tarjeta', '$cvv', '$expdate')"; // Suponiendo ID_Cliente_OrdCompra = 1

    if ($conexionDB->getConexion()->query($sql) === TRUE) {
        // Obtener el ID_OrdCompra recién insertado
        $idCompraInsertado = $conexionDB->getConexion()->insert_id;

        // Consulta para insertar los productos de Carrito en productosComprados
        $insertarProductos = "INSERT INTO productosComprados (Id_Compra, NombreProducto, id_producto)
                              SELECT $idCompraInsertado, NombreProduct, ID_Producto_Carrito
                              FROM Carrito";

        if ($conexionDB->getConexion()->query($insertarProductos) === TRUE) {

            $actualizarProductos = "UPDATE Productos AS P 
                                INNER JOIN Carrito AS C ON P.ID_Producto = C.ID_Producto_Carrito
                                SET P.CantDisponible = P.CantDisponible - 1";
        if ($conexionDB->getConexion()->query($actualizarProductos) === TRUE) {
            echo "Cantidad disponible de productos actualizada.";
            header("Location: Home.php");
        }
        } else {
            echo "Error al crear la orden de compra: " . $conexionDB->getConexion()->error;
        }
    } else {
        echo "Error al crear la orden de compra: " . $conexionDB->getConexion()->error;
    }

    $conexionDB->cerrarConexion(); // Cerrar la conexión
}
?>

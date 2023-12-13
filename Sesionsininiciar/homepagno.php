<?php

require 'Conexion.php';

$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();

$ultimosProductosQuery = "SELECT p.ID_Producto, p.NombreProduct, p.Precio, p.CantDisponible, MAX(i.Imagen) AS Imagen
                          FROM Productos p
                          LEFT JOIN Imagenes i ON p.ID_Producto = i.ID_Producto
                          WHERE i.video = 0 AND p.Eliminado =0
                          GROUP BY p.ID_Producto
                          ORDER BY p.RowDate DESC
                          LIMIT 4";
$ultimosProductosResult = $conexion->query($ultimosProductosQuery);

?>


<section class="container-products" >
    <?php
    while ($row_producto = $ultimosProductosResult->fetch_assoc()) {
        echo "<div class='product'>
                <img src='../Sesioniniciada/" . $row_producto['Imagen'] . "' alt='' class='product__img'>
                <div class='product__description'>
                   <h3 class='product__title'>" . $row_producto['NombreProduct'] . "</h3>
                    <span class='product__price'>$" . $row_producto['Precio'] . "</span> 
                </div>
                <i class='product__icon fa-solid fa-cart-plus'></i>
            </div>";
    }
    echo "</section>";
    $conexion->close();
    ?>


</section>
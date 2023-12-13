<?php

require 'Conexion.php';

$conexion = (new ConexionDB())->getConexion();

$categoriaAccesoriosQuery = "SELECT p.ID_Producto, p.NombreProduct, p.Precio, p.CantDisponible, i.Imagen
                            FROM Productos p
                            LEFT JOIN Imagenes i ON p.ID_Producto = i.ID_Producto
                            WHERE p.ID_Categoria = 2";

$categoriaAccesoriosResult = $conexion->query($categoriaAccesoriosQuery);
?>

<h2 class="main-title">pantallas</h2>
<section class="container-products">
    <?php
    while ($row_producto = $categoriaAccesoriosResult->fetch_assoc()) {
        echo "<div class='product'>
                <img src='".$row_producto['Imagen']."' alt='' class='product__img'>
                <div class='product__description'>
                   <h3 class='product__title'>" . $row_producto['NombreProduct'] . "</h3>
                    <span class='product__price'>$" . $row_producto['Precio'] . "</span> 
                </div>
                <i class='product__icon fa-solid fa-cart-plus'></i>
                <p></p><a type='button' class='btn btn-sm btn-outline-secondary' href='Producto.php?id=" . $row_producto['ID_Producto'] . "'>Ver producto</a>
                    <p></p> <button type='button' class='btn btn-primary'>Agregar a lista</button>
            </div>";
    }
    $conexion->close();
    ?>
</section>